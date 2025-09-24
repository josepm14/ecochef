-- ======================================================
-- Seeds: Datos de prueba para EcoChef (versión piloto)
-- ======================================================
USE ecochef_db_piloto;

-- Limpieza de tablas (por si se ejecuta varias veces)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE logs;
TRUNCATE TABLE inscripciones;
TRUNCATE TABLE class_assignments;
TRUNCATE TABLE clases;
TRUNCATE TABLE shopping_items;
TRUNCATE TABLE shopping_lists;
TRUNCATE TABLE pedido_detalle;
TRUNCATE TABLE pedidos;
TRUNCATE TABLE productos;
TRUNCATE TABLE recetas;
TRUNCATE TABLE usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- ====================================
-- Usuarios de prueba
-- ====================================
INSERT INTO usuarios (nombre, email, password, telefono, whatsapp, direccion, rol, estado)
VALUES
-- Admin
('Admin EcoChef', 'admin@ecochef.com', 'admin123', '900000001', '900000001', 'Oficina Central', 'admin', 'activo'),

-- Estudiantes
('Juan Pérez', 'juan@ecochef.com', '123456', '900000002', '900000002', 'Av. Los Alamos 123', 'estudiante', 'activo'),
('María López', 'maria@ecochef.com', '123456', '900000003', '900000003', 'Jr. Las Rosas 456', 'estudiante', 'activo'),
('Carlos Ramos', 'carlos@ecochef.com', '123456', '900000004', '900000004', 'Calle Comercio 789', 'estudiante', 'activo'),

-- Docentes
('Prof. Ana Torres', 'ana@ecochef.com', '123456', '900000005', '900000005', 'Av. Universitaria 321', 'docente', 'activo'),

-- Productores
('Granja Verde', 'granja@ecochef.com', '123456', '900000006', '900000006', 'Comunidad Santa Rosa', 'productor', 'activo'),
('Huerto Orgánico', 'huerto@ecochef.com', '123456', '900000007', '900000007', 'Sector Pampa Baja', 'productor', 'activo'),

-- Beneficiarios
('Lucía Gómez', 'lucia@ecochef.com', '123456', '900000008', '900000008', 'Jr. Progreso 555', 'beneficiario', 'activo'),
('Pedro Castillo', 'pedro@ecochef.com', '123456', '900000009', '900000009', 'Av. Libertad 222', 'beneficiario', 'activo');

-- ====================================
-- Recetas de prueba (2 estudiantes + 1 docente)
-- ====================================
INSERT INTO recetas (titulo, descripcion, ingredientes, pasos, id_autor, estado, categoria)
VALUES
('Ensalada Andina', 'Receta saludable con quinua y verduras locales.', 'Quinua, Tomate, Lechuga, Queso fresco', '1. Hervir la quinua\n2. Cortar verduras\n3. Mezclar y servir', 2, 'published', 'Saludable'),
('Sopa de Quinua', 'Sopa tradicional con quinua y vegetales.', 'Quinua, Zanahoria, Papa, Apio', '1. Sofreír verduras\n2. Agregar agua y quinua\n3. Hervir y sazonar', 3, 'pending', 'Tradicional'),
('Taller de Pastas', 'Receta docente para práctica de pasta fresca.', 'Harina, Huevo, Sal', '1. Hacer masa\n2. Estirar\n3. Cortar y hervir', 5, 'published', 'Internacional');

-- ====================================
-- Productos de prueba (productores)
-- ====================================
INSERT INTO productos (nombre, descripcion, unidad_venta, precio, stock, id_productor, estado)
VALUES
('Papa Nativa', 'Papa de variedad local, ideal para sopas.', 'kg', 2.50, 100, 6, 'disponible'),
('Zanahoria Orgánica', 'Zanahoria fresca sin químicos.', 'kg', 3.00, 50, 7, 'disponible'),
('Lechuga Hidropónica', 'Lechuga fresca cultivada en agua.', 'unidad', 1.20, 30, 6, 'disponible');

-- ====================================
-- Pedidos de prueba (beneficiarios a productores)
-- ====================================
INSERT INTO pedidos (id_beneficiario, id_productor, total, estado, direccion_envio, referencia_pago)
VALUES
(8, 6, 12.50, 'pendiente', 'Jr. Progreso 555', 'PAY123'),
(9, 7, 6.00, 'confirmado', 'Av. Libertad 222', 'PAY456');

INSERT INTO pedido_detalle (id_pedido, id_producto, cantidad, precio_unitario)
VALUES
(1, 1, 5, 2.50),   -- 5kg de Papa Nativa
(1, 3, 2, 1.20),   -- 2 Lechugas
(2, 2, 2, 3.00);   -- 2kg Zanahoria

-- ====================================
-- Listas de compras (para WhatsApp)
-- ====================================
INSERT INTO shopping_lists (id_beneficiario, id_productor, titulo, nota, enviado_whatsapp)
VALUES
(8, 6, 'Compra Semanal', 'Enviar el sábado en la mañana', 0);

INSERT INTO shopping_items (id_shopping_list, id_producto, descripcion, cantidad, unidad)
VALUES
(1, 1, 'Papa Nativa', 4, 'kg'),
(1, 3, 'Lechuga Hidropónica', 3, 'unidad');

-- ====================================
-- Clases (talleres)
-- ====================================
INSERT INTO clases (titulo, descripcion, fecha_evento, id_docente, estado)
VALUES
('Taller de Recetas Saludables', 'Clase práctica con ensaladas y sopas.', '2025-10-01 10:00:00', 5, 'abierta');

-- Asignación de estudiantes a clase (mínimo 2, máximo 3)
INSERT INTO class_assignments (id_clase, id_estudiante, role)
VALUES
(1, 2, 'expositor'),   -- Juan Pérez
(1, 3, 'expositor');   -- María López

-- Inscripciones como asistentes
INSERT INTO inscripciones (id_clase, id_usuario)
VALUES
(1, 8), -- Beneficiario Lucía
(1, 9); -- Beneficiario Pedro

-- ====================================
-- Logs iniciales
-- ====================================
INSERT INTO logs (id_usuario, accion, detalles, ip, user_agent)
VALUES
(1, 'CREAR_USUARIO', 'Se creó el usuario admin@ecochef.com', '127.0.0.1', 'SeedScript'),
(5, 'CREAR_CLASE', 'Se creó el taller de recetas saludables', '127.0.0.1', 'SeedScript');
