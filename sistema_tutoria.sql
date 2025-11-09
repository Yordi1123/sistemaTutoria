-- =====================================================
-- SISTEMA DE TUTORIA Y CONSEJERIA - UNS
-- Base de Datos Simplificada para MySQL
-- =====================================================

CREATE DATABASE IF NOT EXISTS sistema_tutoria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_tutoria;

-- =====================================================
-- 1. TABLA: usuarios
-- =====================================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('estudiante', 'docente', 'coordinador', 'consejero') NOT NULL,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- 2. TABLA: estudiantes
-- =====================================================
CREATE TABLE estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    ciclo INT,
    escuela VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- 3. TABLA: docentes
-- =====================================================
CREATE TABLE docentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    especialidad VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- 4. TABLA: consejeros
-- =====================================================
CREATE TABLE consejeros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    especialidad VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- 5. TABLA: tutorias
-- =====================================================
CREATE TABLE tutorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    docente_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo TEXT,
    estado ENUM('pendiente', 'confirmada', 'realizada', 'cancelada') DEFAULT 'pendiente',
    observaciones TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id),
    FOREIGN KEY (docente_id) REFERENCES docentes(id)
) ENGINE=InnoDB;

-- =====================================================
-- 6. TABLA: consejerias
-- =====================================================
CREATE TABLE consejerias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    consejero_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo TEXT,
    estado ENUM('pendiente', 'confirmada', 'realizada', 'cancelada') DEFAULT 'pendiente',
    observaciones TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id),
    FOREIGN KEY (consejero_id) REFERENCES consejeros(id)
) ENGINE=InnoDB;

-- =====================================================
-- 7. TABLA: fichas_tutoria
-- =====================================================
CREATE TABLE fichas_tutoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tutoria_id INT NOT NULL,
    problematica TEXT,
    acciones TEXT,
    conclusiones TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutoria_id) REFERENCES tutorias(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- 8. TABLA: fichas_consejeria
-- =====================================================
CREATE TABLE fichas_consejeria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consejeria_id INT NOT NULL,
    situacion TEXT,
    intervencion TEXT,
    conclusiones TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consejeria_id) REFERENCES consejerias(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- DATOS DE PRUEBA
-- =====================================================

-- Usuario coordinador (password: admin123)
INSERT INTO usuarios (username, password, rol) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'coordinador');

-- Usuarios docentes (password: doc123)
INSERT INTO usuarios (username, password, rol) VALUES 
('DOC001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente'),
('DOC002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente');

-- Usuario consejero (password: cons123)
INSERT INTO usuarios (username, password, rol) VALUES 
('CONS001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'consejero');

-- Usuarios estudiantes (password: est123)
INSERT INTO usuarios (username, password, rol) VALUES 
('0201910001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'estudiante'),
('0201910002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'estudiante');

-- Datos de docentes
INSERT INTO docentes (usuario_id, codigo, nombres, apellidos, email, especialidad) VALUES 
(2, 'DOC001', 'Juan Carlos', 'Perez Rodriguez', 'jperez@uns.edu.pe', 'Sistemas'),
(3, 'DOC002', 'Maria Elena', 'Garcia Lopez', 'mgarcia@uns.edu.pe', 'Base de Datos');

-- Datos de consejero
INSERT INTO consejeros (usuario_id, codigo, nombres, apellidos, email, especialidad) VALUES 
(4, 'CONS001', 'Patricia', 'Lopez Martinez', 'plopez@uns.edu.pe', 'Psicologia');

-- Datos de estudiantes
INSERT INTO estudiantes (usuario_id, codigo, nombres, apellidos, email, ciclo, escuela) VALUES 
(5, '0201910001', 'Carlos', 'Ramirez Santos', 'cramirez@uns.edu.pe', 6, 'Ingenieria de Sistemas'),
(6, '0201910002', 'Ana Maria', 'Torres Diaz', 'atorres@uns.edu.pe', 5, 'Ingenieria de Sistemas');

-- =====================================================
-- USUARIOS DE PRUEBA
-- =====================================================
-- Usuario: admin | Password: admin123 | Rol: coordinador
-- Usuario: DOC001 | Password: doc123 | Rol: docente
-- Usuario: DOC002 | Password: doc123 | Rol: docente
-- Usuario: CONS001 | Password: cons123 | Rol: consejero
-- Usuario: 0201910001 | Password: est123 | Rol: estudiante
-- Usuario: 0201910002 | Password: est123 | Rol: estudiante
-- =====================================================