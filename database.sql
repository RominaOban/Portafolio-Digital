-- ──BASE DE DATOS ───────────────────────────────────
 
CREATE DATABASE IF NOT EXISTS portfolio_studio
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
 
USE portfolio_studio;
 
 
-- ──TABLAS ──────────────────────────────────────────
 
CREATE TABLE IF NOT EXISTS coleccion (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    titulo      VARCHAR(150) NOT NULL,
    categoria   VARCHAR(80)  NOT NULL DEFAULT 'General',
    imagen_url  VARCHAR(500) DEFAULT NULL,
    descripcion TEXT,
    fuente      VARCHAR(150) DEFAULT 'Pinterest',
    destacado   TINYINT(1)   NOT NULL DEFAULT 0,
    creado_en   DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
CREATE TABLE IF NOT EXISTS mensajes (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    nombre   VARCHAR(100) NOT NULL,
    correo   VARCHAR(150) NOT NULL,
    mensaje  TEXT         NOT NULL,
    fecha    DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
 
-- ──  INSERTAR DATOS ────────────────────────────────────────
--  Aclaración: todos los datos dentro del catálogo son tomados
--  como ejemplo para el APE. Las imágenes son de Pinterest.
 
INSERT INTO coleccion (titulo, categoria, imagen_url, descripcion, fuente, destacado) VALUES
 
-- ARTE DIGITAL
('Soft girl illustration — pastel tones', 'Arte Digital',
 'https://i1-c.pinimg.com/736x/2d/3f/52/2d3f5297096b1cb3b7531b62b6a20bc6.jpg',
 'Ilustración digital con paleta pastel suave.', 'Pinterest', 1),
 
('Pixel art room — cozy setup', 'Arte Digital',
 'https://i.pinimg.com/736x/87/65/ed/8765edc41f758453d2c288bea7af631a.jpg',
 'Habitación en pixel art con iluminación cálida, libros apilados y pantallas brillando.', 'Pinterest', 0),
 
('Y2K graphic elements pack', 'Arte Digital',
 'https://i1-c.pinimg.com/736x/bd/7a/34/bd7a340c0b75a70a05517c881bd1ce0d.jpg',
 'Set de elementos gráficos Y2K.', 'Pinterest', 0),
 
-- FOTOGRAFÍA
('Aesthetic desk setup — dark academia', 'Fotografía',
 'https://i.pinimg.com/736x/22/e3/e6/22e3e653b44294b0f8c2e56eefef2a0f.jpg',
 'Setup de escritorio con velas, libros viejos y luz de lámpara.', 'Pinterest', 0),
 
('Night city reflections', 'Fotografía',
 'https://i1-c.pinimg.com/736x/eb/e2/38/ebe238b4e3f34a4aaff7c132b49bd894.jpg',
 'Reflejos de luces de ciudad en charcos después de lluvia.', 'Pinterest', 0),
 
('Matcha latte art close-up', 'Fotografía',
 'https://i.pinimg.com/736x/48/8b/65/488b657beda2f6453f647bd2afa51869.jpg',
 'Fotografía macro de latte art en matcha.', 'Pinterest', 0),
 
-- DISEÑO
('Soft UI — mobile app concept', 'Diseño',
 'https://i.pinimg.com/736x/84/a6/5f/84a65f41bd34534e8e439de974196cd6.jpg',
 'Concepto de app móvil con estética soft. Referencia directa.', 'Pinterest', 1),
 
('Color palette — rose & lavender', 'Diseño',
 'https://i1-c.pinimg.com/736x/2a/b3/94/2ab394dbe57426a7c1b5fc7e708fc98c.jpg',
 'Paleta de 5 colores: rosa empolvado, lavanda, crema, gris cálido y casi-negro.', 'Pinterest', 0),
 
-- CÓDIGO
('CSS Grid layout — editorial', 'Código',
 'https://i1-c.pinimg.com/736x/b0/49/71/b0497132782b56d9af0b80f55e971c84.jpg',
 'Layout editorial construido solo con CSS Grid.', 'Pinterest', 0),
 
('PHP MVC folder structure', 'Código',
 'https://i1-c.pinimg.com/736x/51/22/d7/5122d7dc2d01f97de804e356899b9e5c.jpg',
 'Esquema de carpetas para un proyecto PHP con patrón MVC básico.', 'Pinterest', 0);