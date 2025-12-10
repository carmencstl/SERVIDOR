-- Base de datos BLOGIFY
CREATE DATABASE IF NOT EXISTS blogify CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blogify;

-- Tabla Usuario
CREATE TABLE IF NOT EXISTS usuario (
    idUsu INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Articulo
CREATE TABLE IF NOT EXISTS articulo (
    idArt INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    texto TEXT NOT NULL,
    positivos INT DEFAULT 0,
    negativos INT DEFAULT 0,
    fecha DATE NOT NULL,
    idAut INT NOT NULL,
    FOREIGN KEY (idAut) REFERENCES usuario(idUsu) ON DELETE CASCADE,
    INDEX idx_autor (idAut),
    INDEX idx_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Comentario
CREATE TABLE IF NOT EXISTS comentario (
    idCom INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    texto TEXT NOT NULL,
    idUsu INT NOT NULL,
    idArt INT NOT NULL,
    idPadre INT NULL,
    FOREIGN KEY (idUsu) REFERENCES usuario(idUsu) ON DELETE CASCADE,
    FOREIGN KEY (idArt) REFERENCES articulo(idArt) ON DELETE CASCADE,
    FOREIGN KEY (idPadre) REFERENCES comentario(idCom) ON DELETE CASCADE,
    INDEX idx_articulo (idArt),
    INDEX idx_usuario (idUsu),
    INDEX idx_padre (idPadre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuarios de prueba
INSERT INTO usuario (email, nombre, clave, apellido) VALUES
('carmen@test.com', 'Carmen', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'García'),
('juan@test.com', 'Juan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pérez'),
('maria@test.com', 'María', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'López');
-- Contraseña para todos: password

-- Insertar artículos de prueba
INSERT INTO articulo (titulo, texto, positivos, negativos, fecha, idAut) VALUES
('Review: The Last of Us', 'Una obra maestra del videojuego que combina narrativa y gameplay de forma magistral...', 15, 2, '2024-12-01', 1),
('Oppenheimer: Una reflexión sobre la ciencia', 'Christopher Nolan nos presenta una película biográfica que nos hace reflexionar...', 23, 5, '2024-12-02', 2),
('El problema de las secuelas', 'Cada vez más vemos como las secuelas no aportan nada nuevo al medio...', 8, 12, '2024-12-03', 1),
('Libros que cambiaron mi vida', 'Hay ciertos libros que marcan un antes y un después en nuestra forma de ver el mundo...', 31, 1, '2024-12-04', 3);

-- Insertar comentarios de prueba
INSERT INTO comentario (fecha, texto, idUsu, idArt, idPadre) VALUES
('2024-12-01', 'Totalmente de acuerdo, una joya del gaming', 2, 1, NULL),
('2024-12-02', 'No puedo estar más de acuerdo con tu análisis', 3, 1, NULL),
('2024-12-02', 'Gracias por tu opinión, es exactamente lo que pensaba', 1, 1, 1),
('2024-12-03', 'Nolan siempre entrega calidad', 1, 2, NULL),
('2024-12-05', 'Interesante punto de vista sobre las secuelas', 3, 3, NULL);
