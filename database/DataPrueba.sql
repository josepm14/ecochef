-- ======================================================
-- Seeds: Datos de prueba para EcoChef (versión piloto)
-- ======================================================

USE ecochef_v1;

-- ====================================
-- Limpieza de tablas (orden correcto por FK)
-- ====================================
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM logs;
DELETE FROM inscripciones;
DELETE FROM class_assignments;
DELETE FROM clases;
DELETE FROM shopping_items;
DELETE FROM shopping_lists;
DELETE FROM pedido_detalle;
DELETE FROM pedidos;
DELETE FROM productos;
DELETE FROM recetas;
DELETE FROM usuarios;
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
('Sofía Herrera', 'sofia@ecochef.com', '123456', '900000010', '900000010', 'Av. Primavera 111', 'estudiante', 'activo'),

-- Docentes
('Prof. Ana Torres', 'ana@ecochef.com', '123456', '900000005', '900000005', 'Av. Universitaria 321', 'docente', 'activo'),
('Chef Luis Mejía', 'luis@ecochef.com', '123456', '900000011', '900000011', 'Calle Gourmet 888', 'docente', 'activo'),

-- Productores
('Granja Verde', 'granja@ecochef.com', '123456', '900000006', '900000006', 'Comunidad Santa Rosa', 'productor', 'activo'),
('Huerto Orgánico', 'huerto@ecochef.com', '123456', '900000007', '900000007', 'Sector Pampa Baja', 'productor', 'activo'),
('Cooperativa AgroAndes', 'agroandes@ecochef.com', '123456', '900000012', '900000012', 'Parcela San Pedro', 'productor', 'activo'),

-- Beneficiarios
('Lucía Gómez', 'lucia@ecochef.com', '123456', '900000008', '900000008', 'Jr. Progreso 555', 'beneficiario', 'activo'),
('Pedro Castillo', 'pedro@ecochef.com', '123456', '900000009', '900000009', 'Av. Libertad 222', 'beneficiario', 'activo'),
('Rosa Martínez', 'rosa@ecochef.com', '123456', '900000013', '900000013', 'Av. Esperanza 789', 'beneficiario', 'activo');

-- ====================================
-- Recetas de prueba
-- ====================================
INSERT INTO recetas (titulo, descripcion, ingredientes, pasos, id_autor, estado, categoria)
VALUES
('Ensalada Andina', 'Receta saludable con quinua y verduras locales.', 'Quinua, Tomate, Lechuga, Queso fresco', '1. Hervir la quinua\n2. Cortar verduras\n3. Mezclar y servir', 2, 'published', 'Saludable'),
('Sopa de Quinua', 'Sopa tradicional con quinua y vegetales.', 'Quinua, Zanahoria, Papa, Apio', '1. Sofreír verduras\n2. Agregar agua y quinua\n3. Hervir y sazonar', 3, 'pending', 'Tradicional'),
('Taller de Pastas', 'Receta docente para práctica de pasta fresca.', 'Harina, Huevo, Sal', '1. Hacer masa\n2. Estirar\n3. Cortar y hervir', 6, 'published', 'Internacional'),
('Jugos Energéticos', 'Bebida nutritiva para estudiantes.', 'Plátano, Naranja, Avena, Miel', '1. Licuar todos los ingredientes\n2. Servir frío', 4, 'published', 'Bebidas');

-- ====================================
-- Productos de prueba
-- ====================================
INSERT INTO productos (nombre, descripcion, unidad_venta, precio, stock, id_productor, estado)
VALUES
('Papa Nativa', 'Papa de variedad local, ideal para sopas.', 'kg', 2.50, 100, 8, 'disponible'),
('Zanahoria Orgánica', 'Zanahoria fresca sin químicos.', 'kg', 3.00, 50, 9, 'disponible'),
('Lechuga Hidropónica', 'Lechuga fresca cultivada en agua.', 'unidad', 1.20, 30, 8, 'disponible'),
('Tomate de Huerta', 'Tomates rojos frescos.', 'kg', 2.80, 80, 9, 'disponible'),
('Quinua Real', 'Quinua producida en la sierra.', 'kg', 6.50, 40, 10, 'disponible');

-- ====================================
-- Pedidos de prueba
-- ====================================
INSERT INTO pedidos (id_beneficiario, id_productor, total, estado, direccion_envio, referencia_pago)
VALUES
(11, 8, 12.50, 'pendiente', 'Jr. Progreso 555', 'PAY123'),
(12, 9, 6.00, 'confirmado', 'Av. Libertad 222', 'PAY456'),
(13, 10, 20.00, 'pendiente', 'Av. Esperanza 789', 'PAY789');

INSERT INTO pedido_detalle (id_pedido, id_producto, cantidad, precio_unitario)
VALUES
(1, 1, 5, 2.50),   -- Papa Nativa
(1, 3, 2, 1.20),   -- Lechuga
(2, 2, 2, 3.00),   -- Zanahoria
(3, 5, 3, 6.50),   -- Quinua
(3, 4, 2, 2.80);   -- Tomate

-- ====================================
-- Listas de compras
-- ====================================
INSERT INTO shopping_lists (id_beneficiario, id_productor, titulo, nota, enviado_whatsapp)
VALUES
(11, 8, 'Compra Semanal', 'Enviar el sábado en la mañana', 0),
(12, 9, 'Canasta Familiar', 'Incluir más verduras verdes', 1);

INSERT INTO shopping_items (id_shopping_list, id_producto, descripcion, cantidad, unidad)
VALUES
(1, 1, 'Papa Nativa', 4, 'kg'),
(1, 3, 'Lechuga Hidropónica', 3, 'unidad'),
(2, 2, 'Zanahoria Orgánica', 5, 'kg'),
(2, 4, 'Tomate de Huerta', 2, 'kg');

-- ====================================
-- Clases (talleres)
-- ====================================
INSERT INTO clases (titulo, descripcion, fecha_evento, id_docente, estado)
VALUES
('Taller de Recetas Saludables', 'Clase práctica con ensaladas y sopas.', '2025-10-01 10:00:00', 6, 'abierta'),
('Panadería Artesanal', 'Aprende a preparar pan casero con masa madre.', '2025-10-05 15:00:00', 7, 'abierta');

-- Asignación de estudiantes
INSERT INTO class_assignments (id_clase, id_estudiante, role)
VALUES
(1, 2, 'expositor'),
(1, 3, 'expositor'),
(2, 4, 'participante'),
(2, 5, 'expositor');

-- Inscripciones de beneficiarios
INSERT INTO inscripciones (id_clase, id_usuario)
VALUES
(1, 11),
(1, 12),
(2, 13);

-- ====================================
-- Logs
-- ====================================
INSERT INTO logs (id_usuario, accion, detalles, ip, user_agent)
VALUES
(1, 'CREAR_USUARIO', 'Se creó el usuario admin@ecochef.com', '127.0.0.1', 'SeedScript'),
(6, 'CREAR_CLASE', 'Se creó el taller de recetas saludables', '127.0.0.1', 'SeedScript'),
(7, 'CREAR_CLASE', 'Se creó el taller de panadería artesanal', '127.0.0.1', 'SeedScript');
