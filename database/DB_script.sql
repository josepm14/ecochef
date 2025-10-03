-- ecochef_db_piloto_corregido.sql
-- Base de datos piloto para EcoChef (versión corregida para MySQL 8.x)
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
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  last_login DATETIME DEFAULT NULL,
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
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  publicado_en DATETIME DEFAULT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_productor) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_productos_productor ON productos(id_productor);
CREATE INDEX idx_productos_estado ON productos(estado);

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
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  subtotal DECIMAL(12,2) GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
  FOREIGN KEY (id_pedido) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_pedido_detalle_pedido ON pedido_detalle(id_pedido);
CREATE INDEX idx_pedido_detalle_producto ON pedido_detalle(id_producto);

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
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  enviado_whatsapp TINYINT(1) DEFAULT 0,
  whatsapp_text TEXT,            -- almacenamos el texto que se envió por whatsapp (opcional)
  whatsapp_sent_at DATETIME DEFAULT NULL,
  FOREIGN KEY (id_beneficiario) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (id_productor) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_shopping_list_productor ON shopping_lists(id_productor);

-- Items de la lista de compras
CREATE TABLE shopping_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_shopping_list INT NOT NULL,
  id_producto INT NULL,          -- si está ligado a un producto del catálogo
  descripcion VARCHAR(255) NOT NULL,
  cantidad DECIMAL(10,3) DEFAULT 1,
  unidad VARCHAR(50) DEFAULT NULL,
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_shopping_list) REFERENCES shopping_lists(id) ON DELETE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_shopping_items_producto ON shopping_items(id_producto);

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
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
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
  asignado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_clase) REFERENCES clases(id) ON DELETE CASCADE,
  FOREIGN KEY (id_estudiante) REFERENCES usuarios(id) ON DELETE CASCADE,
  UNIQUE KEY uq_clase_estudiante (id_clase, id_estudiante)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_assignments_clase ON class_assignments(id_clase);

-- =====================================================================
-- Tabla: inscripciones (usuarios inscritos en clases como asistentes)
-- =====================================================================
CREATE TABLE inscripciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_clase INT NOT NULL,
  id_usuario INT NOT NULL,
  fecha_inscripcion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- TRIGGERS
-- Eliminamos triggers antiguos (si existen) y creamos versiones corregidas.
-- IMPORTANTE: los DECLARE deben ir al inicio de cada bloque BEGIN...END.
-- =====================================================================

DROP TRIGGER IF EXISTS trg_productos_stock_update;
DROP TRIGGER IF EXISTS trg_class_assignments_before_insert;
DROP TRIGGER IF EXISTS trg_clases_before_update;

DELIMITER $$

-- Trigger: actualizar estado a 'sin_stock' si stock = 0 (on update)
CREATE TRIGGER trg_productos_stock_update
BEFORE UPDATE ON productos
FOR EACH ROW
BEGIN
  -- Si el stock es nulo o <= 0 => sin_stock
  IF NEW.stock IS NULL OR NEW.stock <= 0 THEN
    SET NEW.estado = 'sin_stock';
  ELSE
    -- Si antes estaba 'sin_stock' y ahora hay stock, poner 'disponible'
    IF OLD.estado = 'sin_stock' THEN
      SET NEW.estado = 'disponible';
    END IF;
  END IF;
END$$

-- Trigger: impedir asignar más de 3 estudiantes por clase y validar rol
CREATE TRIGGER trg_class_assignments_before_insert
BEFORE INSERT ON class_assignments
FOR EACH ROW
BEGIN
  DECLARE cnt INT DEFAULT 0;
  DECLARE rol_usuario VARCHAR(20);

  SELECT COUNT(*) INTO cnt FROM class_assignments WHERE id_clase = NEW.id_clase;
  IF cnt >= 3 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se pueden asignar más de 3 estudiantes a una clase.';
  END IF;

  SELECT rol INTO rol_usuario FROM usuarios WHERE id = NEW.id_estudiante;
  IF rol_usuario IS NULL OR rol_usuario != 'estudiante' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Solo se pueden asignar usuarios con rol estudiante.';
  END IF;
END$$

-- Trigger: antes de actualizar la clase a estado 'confirmada' verificar que tenga al menos 2 asignados como 'expositor'
CREATE TRIGGER trg_clases_before_update
BEFORE UPDATE ON clases
FOR EACH ROW
BEGIN
  DECLARE cnt INT DEFAULT 0;
  IF NEW.estado = 'confirmada' AND OLD.estado <> 'confirmada' THEN
    SELECT COUNT(*) INTO cnt FROM class_assignments WHERE id_clase = NEW.id AND role = 'expositor';
    IF cnt < 2 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Para confirmar la clase debe haber al menos 2 estudiantes asignados como expositores.';
    END IF;
  END IF;
END$$

DELIMITER ;

-- =====================================================================
-- VISTA: resumen lista de compras (concatenación de items)
-- Se usa GROUP_CONCAT para armar el texto que puede enviarse por WhatsApp
-- =====================================================================
CREATE OR REPLACE VIEW vw_shopping_list_summary AS
SELECT
  sl.id AS shopping_list_id,
  sl.id_beneficiario,
  sl.id_productor,
  u_benef.nombre AS beneficiario_nombre,
  u_prod.nombre AS productor_nombre,
  sl.titulo,
  sl.nota,
  sl.creado_en,
  GROUP_CONCAT(CONCAT(si.descripcion, ' (', si.cantidad, IFNULL(CONCAT(' ', si.unidad), ''), ')') SEPARATOR ', ') AS items
FROM shopping_lists sl
LEFT JOIN usuarios u_benef ON u_benef.id = sl.id_beneficiario
LEFT JOIN usuarios u_prod ON u_prod.id = sl.id_productor
LEFT JOIN shopping_items si ON si.id_shopping_list = sl.id
GROUP BY sl.id, sl.id_beneficiario, sl.id_productor, u_benef.nombre, u_prod.nombre, sl.titulo, sl.nota, sl.creado_en;

-- =====================================================================
-- RECOMENDACIONES FINALES:
-- 1) Manejar transacciones al crear pedidos (BEGIN/COMMIT) desde la aplicación para evitar condiciones de carrera
-- 2) Validar reglas adicionales en la capa de aplicación (e.g. permisos, límites, precios)
-- 3) Hash fuerte para password (bcrypt/argon2). No confiar en triggers para lógica de seguridad.
-- 4) Si esperas gran volumen, considera usar BIGINT para los PKs y revisar índices.
-- =====================================================================

-- FIN DEL SCRIPT
