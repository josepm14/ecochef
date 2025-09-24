-- ecochef_db_piloto.sql
-- Base de datos piloto para EcoChef (versión funcional)
-- NOTA: ejecutar con un usuario que tenga permisos CREATE/DROP DATABASE

DROP DATABASE IF EXISTS ecochef_v1;
CREATE DATABASE ecochef_v1
  DEFAULT CHARACTER SET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;
USE ecochef_v1;

-- =====================================================================
-- Tabla: usuarios (todos los actores en una sola tabla)
-- roles permitidos: estudiante, docente, productor, beneficiario, admin
-- =====================================================================
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,               -- almacenar hash de contraseña
  telefono VARCHAR(30),
  whatsapp VARCHAR(30),                          -- número para envíos por WhatsApp
  direccion VARCHAR(255),
  rol ENUM('estudiante','docente','productor','beneficiario','admin') NOT NULL DEFAULT 'beneficiario',
  estado ENUM('activo','inactivo','pendiente') NOT NULL DEFAULT 'pendiente',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  last_login TIMESTAMP NULL DEFAULT NULL,
  descripcion TEXT,
  INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Tabla: recetas (creadas por estudiantes y docentes)
-- workflow: draft -> pending -> published -> archived
-- =====================================================================
CREATE TABLE recetas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(200) NOT NULL,
  descripcion TEXT,
  ingredientes TEXT,                     -- JSON o texto estructurado (ej: "2 tomates; 1 lechuga")
  pasos TEXT,                            -- pasos de preparación
  imagen VARCHAR(255),
  id_autor INT NOT NULL,                 -- referencia a usuarios.id
  estado ENUM('draft','pending','published','rejected','archived') DEFAULT 'pending',
  categoria VARCHAR(100),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (id_autor) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_recetas_autor ON recetas(id_autor);
CREATE INDEX idx_recetas_estado ON recetas(estado);

-- =====================================================================
-- Tabla: productos (ofrecidos por productores locales)
-- unidad_venta: ej. 'kg', 'unidad', 'bulto'
-- estado: disponible / sin_stock / no_publicado
-- =====================================================================
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT,
  unidad_venta VARCHAR(50) NOT NULL,     -- ej. 'kg', 'unidad'
  precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  stock INT DEFAULT 0,
  imagen VARCHAR(255),
  id_productor INT NOT NULL,
  estado ENUM('disponible','sin_stock','no_publicado') DEFAULT 'no_publicado',
  publicado_en TIMESTAMP NULL DEFAULT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (id_productor) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_productos_productor ON productos(id_productor);
CREATE INDEX idx_productos_estado ON productos(estado);

-- Trigger: actualizar estado a 'sin_stock' si stock = 0 (on update)
DELIMITER $$
CREATE TRIGGER trg_productos_stock_update
BEFORE UPDATE ON productos
FOR EACH ROW
BEGIN
  IF NEW.stock <= 0 THEN
    SET NEW.estado = 'sin_stock';
  ELSE
    -- si se actualiza a stock > 0 y estaba sin_stock, mantener 'disponible' sólo si se desea
    IF OLD.estado = 'sin_stock' THEN
      SET NEW.estado = 'disponible';
    END IF;
  END IF;
END$$
DELIMITER ;

-- =====================================================================
-- Tabla: pedidos (beneficiarios piden productos a productores)
-- cada pedido corresponde a un proveedor (productor)
-- =====================================================================
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_beneficiario INT NOT NULL,            -- usuario que hace el pedido
  id_productor INT NOT NULL,               -- proveedor al que se dirige el pedido
  total DECIMAL(12,2) DEFAULT 0.00,
  estado ENUM('pendiente','confirmado','enviado','entregado','cancelado') DEFAULT 'pendiente',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NULL DEFAULT NULL,
  direccion_envio VARCHAR(255),
  referencia_pago VARCHAR(100),
  FOREIGN KEY (id_beneficiario) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (id_productor) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_pedidos_productor ON pedidos(id_productor);
CREATE INDEX idx_pedidos_beneficiario ON pedidos(id_beneficiario);

-- Detalle de pedido
CREATE TABLE pedido_detalle (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_pedido INT NOT NULL,
  id_producto INT NOT NULL,
  cantidad INT NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  subtotal DECIMAL(12,2) GENERATED ALWAYS AS (cantidad * precio_unitario) VIRTUAL,
  FOREIGN KEY (id_pedido) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_pedido_detalle_pedido ON pedido_detalle(id_pedido);

-- =====================================================================
-- Tabla: shopping_lists (lista de compras que el beneficiario genera)
-- Se puede usar la información para construir el mensaje que se envía por WhatsApp al productor
-- =====================================================================
CREATE TABLE shopping_lists (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_beneficiario INT NOT NULL,
  id_productor INT NOT NULL,
  titulo VARCHAR(150),
  nota TEXT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  enviado_whatsapp TINYINT(1) DEFAULT 0,
  whatsapp_text TEXT,            -- almacenamos el texto que se envió por whatsapp (opcional)
  whatsapp_sent_at TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (id_beneficiario) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (id_productor) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Items de la lista de compras
CREATE TABLE shopping_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_shopping_list INT NOT NULL,
  id_producto INT NULL,          -- si está ligado a un producto del catálogo
  descripcion VARCHAR(255) NOT NULL,
  cantidad DECIMAL(10,3) DEFAULT 1,
  unidad VARCHAR(50) DEFAULT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_shopping_list) REFERENCES shopping_lists(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_shopping_list_productor ON shopping_lists(id_productor);

-- =====================================================================
-- Tabla: clases (talleres) creadas por docentes
-- Un docente crea la clase y luego asigna estudiantes para exponer (min 2, max 3)
-- =====================================================================
CREATE TABLE clases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(200) NOT NULL,
  descripcion TEXT,
  fecha_evento DATETIME NOT NULL,
  id_docente INT NOT NULL,
  cupos_total INT DEFAULT 10,       -- cupos generales para público
  estado ENUM('borrador','abierta','confirmada','finalizada','cancelada') DEFAULT 'borrador',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (id_docente) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_clases_docente ON clases(id_docente);
CREATE INDEX idx_clases_estado ON clases(estado);

-- Asignación de estudiantes a clase (para expositores)
CREATE TABLE class_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_clase INT NOT NULL,
  id_estudiante INT NOT NULL,
  role ENUM('expositor','ayudante') DEFAULT 'expositor',  -- tipo de participación
  asignado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_clase) REFERENCES clases(id) ON DELETE CASCADE,
  FOREIGN KEY (id_estudiante) REFERENCES usuarios(id) ON DELETE CASCADE,
  UNIQUE KEY uq_clase_estudiante (id_clase, id_estudiante)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_assignments_clase ON class_assignments(id_clase);

-- Trigger: impedir asignar más de 3 estudiantes por clase
DELIMITER $$
CREATE TRIGGER trg_class_assignments_before_insert
BEFORE INSERT ON class_assignments
FOR EACH ROW
BEGIN
  DECLARE cnt INT;
  SELECT COUNT(*) INTO cnt FROM class_assignments WHERE id_clase = NEW.id_clase;
  IF cnt >= 3 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se pueden asignar más de 3 estudiantes a una clase.';
  END IF;

  -- Opcional: verificar que el usuario asignado sea rol 'estudiante'
  DECLARE rol_usuario VARCHAR(50);
  SELECT rol INTO rol_usuario FROM usuarios WHERE id = NEW.id_estudiante;
  IF rol_usuario IS NULL OR rol_usuario != 'estudiante' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Solo se pueden asignar usuarios con rol estudiante.';
  END IF;
END$$
DELIMITER ;

-- Trigger: antes de actualizar la clase a estado 'confirmada' verificar que tenga al menos 2 asignados
DELIMITER $$
CREATE TRIGGER trg_clases_before_update
BEFORE UPDATE ON clases
FOR EACH ROW
BEGIN
  IF NEW.estado = 'confirmada' AND OLD.estado <> 'confirmada' THEN
    DECLARE cnt INT;
    SELECT COUNT(*) INTO cnt FROM class_assignments WHERE id_clase = NEW.id;
    IF cnt < 2 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Para confirmar la clase debe haber al menos 2 estudiantes asignados como expositores.';
    END IF;
  END IF;
END$$
DELIMITER ;

-- =====================================================================
-- Tabla: inscripciones (usuarios inscritos en clases como asistentes)
-- =====================================================================
CREATE TABLE inscripciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_clase INT NOT NULL,
  id_usuario INT NOT NULL,
  fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_clase) REFERENCES clases(id) ON DELETE CASCADE,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_inscripciones_clase ON inscripciones(id_clase);
CREATE INDEX idx_inscripciones_usuario ON inscripciones(id_usuario);

-- =====================================================================
-- Tabla: logs (auditoría)
-- =====================================================================
CREATE TABLE logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NULL,
  accion VARCHAR(255) NOT NULL,
  detalles TEXT,
  ip VARCHAR(45),
  user_agent VARCHAR(255),
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- VISTAS / PROCEDIMIENTOS (opcionales) para facilitar integraciones:
-- 1) Vista con resumen de pedido para construir mensaje WhatsApp
-- =====================================================================

-- Vista: resumen lista de compras (concatenación simple)
CREATE VIEW vw_shopping_list_summary AS
SELECT
  sl.id AS shopping_list_id,
  sl.id_beneficiario,
  sl.id_productor,
  u_benef.nombre AS beneficiario_nombre,
  u_prod.nombre AS productor_nombre,
  sl.titulo,
  sl.nota,
  sl.creado_en
FROM shopping_lists sl
LEFT JOIN usuarios u_benef ON u_benef.id = sl.id_beneficiario
LEFT JOIN usuarios u_prod ON u_prod.id = sl.id_productor;

-- =====================================================================
-- RECOMENDACIONES:
-- - Validar en la capa de aplicación (PHP) que las operaciones críticas cumplan reglas adicionales.
-- - Mantener hashing fuerte para password (bcrypt/argon2).
-- - Implementar endpoints /api/me que devuelvan rol y permisos para que frontend renderice menú.
-- =====================================================================

-- FIN DEL SCRIPT
