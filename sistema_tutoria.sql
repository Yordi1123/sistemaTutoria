-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--  
-- Host: localhost:3306
-- Generation Time: Nov 10, 2025 at 01:26 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_tutoria`
--

-- --------------------------------------------------------

--
-- Table structure for table `consejerias`
--

CREATE TABLE `consejerias` (
  `id` int NOT NULL,
  `estudiante_id` int NOT NULL,
  `consejero_id` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('pendiente','confirmada','realizada','cancelada') COLLATE utf8mb4_unicode_ci DEFAULT 'pendiente',
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asignaciones_tutoria`
--

CREATE TABLE `asignaciones_tutoria` (
  `id` int NOT NULL,
  `estudiante_id` int NOT NULL,
  `docente_id` int NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `motivo_reasignacion` text COLLATE utf8mb4_unicode_ci,
  `fecha_reasignacion` date DEFAULT NULL,
  `docente_anterior_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asignaciones_tutoria`
--

INSERT INTO `asignaciones_tutoria` (`id`, `estudiante_id`, `docente_id`, `fecha_asignacion`, `activo`) VALUES
(1, 1, 1, '2025-01-15', 1),
(2, 2, 2, '2025-01-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `consejeros`
--

CREATE TABLE `consejeros` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `especialidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consejeros`
--

INSERT INTO `consejeros` (`id`, `usuario_id`, `codigo`, `nombres`, `apellidos`, `email`, `especialidad`) VALUES
(1, 4, 'CONS001', 'Patricia', 'Lopez Martinez', 'plopez@uns.edu.pe', 'Psicologia'),
(2, 7, 'CONS002', 'Roberto', 'Fernandez Diaz', 'rfernandez@uns.edu.pe', 'Orientacion Vocacional'),
(3, 8, 'CONS003', 'Carmen', 'Vargas Ruiz', 'cvargas@uns.edu.pe', 'Trabajo Social');

-- --------------------------------------------------------

--
-- Table structure for table `docentes`
--

CREATE TABLE `docentes` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `especialidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `docentes`
--

INSERT INTO `docentes` (`id`, `usuario_id`, `codigo`, `nombres`, `apellidos`, `email`, `especialidad`) VALUES
(1, 2, 'DOC001', 'Juan Carlos', 'Perez Rodriguez', 'jperez@uns.edu.pe', 'Sistemas'),
(2, 3, 'DOC002', 'Maria Elena', 'Garcia Lopez', 'mgarcia@uns.edu.pe', 'Base de Datos');

-- --------------------------------------------------------

--
-- Table structure for table `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ciclo` int DEFAULT NULL,
  `escuela` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `usuario_id`, `codigo`, `nombres`, `apellidos`, `email`, `ciclo`, `escuela`) VALUES
(1, 5, '0201910001', 'Carlos', 'Ramirez Santos', 'cramirez@uns.edu.pe', 6, 'Ingenieria de Sistemas'),
(2, 6, '0201910002', 'Ana Maria', 'Torres Diaz', 'atorres@uns.edu.pe', 5, 'Ingenieria de Sistemas');

-- --------------------------------------------------------

--
-- Table structure for table `fichas_consejeria`
--

CREATE TABLE `fichas_consejeria` (
  `id` int NOT NULL,
  `consejeria_id` int NOT NULL,
  `situacion` text COLLATE utf8mb4_unicode_ci,
  `intervencion` text COLLATE utf8mb4_unicode_ci,
  `conclusiones` text COLLATE utf8mb4_unicode_ci,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fichas_tutoria`
--

CREATE TABLE `fichas_tutoria` (
  `id` int NOT NULL,
  `tutoria_id` int NOT NULL,
  `problematica` text COLLATE utf8mb4_unicode_ci,
  `acciones` text COLLATE utf8mb4_unicode_ci,
  `conclusiones` text COLLATE utf8mb4_unicode_ci,
  `recomendaciones` text COLLATE utf8mb4_unicode_ci,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `horarios_docente`
--

CREATE TABLE `horarios_docente` (
  `id` int NOT NULL,
  `docente_id` int NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci DEFAULT 'activo',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `horarios_docente`
--

INSERT INTO `horarios_docente` (`id`, `docente_id`, `dia_semana`, `hora_inicio`, `hora_fin`, `estado`, `fecha_registro`) VALUES
(1, 1, 'Lunes', '08:00:00', '10:00:00', 'activo', '2025-11-10 00:58:20'),
(2, 1, 'Lunes', '14:00:00', '16:00:00', 'activo', '2025-11-10 00:58:20'),
(3, 1, 'Miércoles', '08:00:00', '10:00:00', 'activo', '2025-11-10 00:58:20'),
(4, 1, 'Miércoles', '14:00:00', '16:00:00', 'activo', '2025-11-10 00:58:20'),
(5, 1, 'Viernes', '10:00:00', '12:00:00', 'activo', '2025-11-10 00:58:20'),
(6, 2, 'Martes', '09:00:00', '11:00:00', 'inactivo', '2025-11-10 00:58:20'),
(7, 2, 'Martes', '15:00:00', '17:00:00', 'activo', '2025-11-10 00:58:20'),
(8, 2, 'Jueves', '09:00:00', '11:00:00', 'activo', '2025-11-10 00:58:20'),
(9, 2, 'Jueves', '15:00:00', '17:00:00', 'activo', '2025-11-10 00:58:20'),
(10, 2, 'Viernes', '14:00:00', '16:00:00', 'activo', '2025-11-10 00:58:20');

-- --------------------------------------------------------

--
-- Table structure for table `seguimientos`
--

CREATE TABLE `seguimientos` (
  `id` int NOT NULL,
  `estudiante_id` int NOT NULL,
  `docente_id` int NOT NULL,
  `fecha` date NOT NULL,
  `tipo` enum('academico','personal','conductual','general') COLLATE utf8mb4_unicode_ci DEFAULT 'general',
  `observaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recomendaciones` text COLLATE utf8mb4_unicode_ci,
  `estado_animo` enum('muy_bajo','bajo','normal','bueno','muy_bueno') COLLATE utf8mb4_unicode_ci DEFAULT 'normal',
  `nivel_avance` enum('deficiente','insuficiente','satisfactorio','destacado') COLLATE utf8mb4_unicode_ci DEFAULT 'satisfactorio',
  `requiere_atencion` tinyint(1) DEFAULT '0',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seguimientos`
--

INSERT INTO `seguimientos` (`id`, `estudiante_id`, `docente_id`, `fecha`, `tipo`, `observaciones`, `recomendaciones`, `estado_animo`, `nivel_avance`, `requiere_atencion`, `fecha_registro`) VALUES
(1, 1, 1, '2024-11-05', 'academico', 'El estudiante muestra interés en mejorar sus calificaciones en el curso de Base de Datos. Ha asistido a todas las tutorías programadas.', 'Continuar con las sesiones semanales y proporcionar ejercicios adicionales.', 'bueno', 'satisfactorio', 0, '2025-11-10 01:00:44'),
(2, 1, 1, '2024-10-28', 'personal', 'El estudiante manifestó dificultades para gestionar su tiempo debido a trabajo part-time.', 'Elaborar un horario de estudio flexible y priorizar las actividades académicas más importantes.', 'bajo', 'insuficiente', 1, '2025-11-10 01:00:44'),
(3, 2, 2, '2024-11-08', 'academico', 'Excelente desempeño en el curso de Programación. Muestra habilidades destacadas en resolución de problemas.', 'Incentivar a participar en competencias de programación y proyectos de investigación.', 'muy_bueno', 'destacado', 0, '2025-11-10 01:00:44'),
(4, 2, 2, '2024-10-30', 'general', 'Primera sesión de seguimiento. Estudiante muestra motivación y compromiso con sus estudios.', 'Mantener el ritmo de estudio actual y explorar áreas de especialización.', 'bueno', 'satisfactorio', 0, '2025-11-10 01:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `tutorias`
--

CREATE TABLE `tutorias` (
  `id` int NOT NULL,
  `estudiante_id` int NOT NULL,
  `docente_id` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('pendiente','confirmada','realizada','cancelada') COLLATE utf8mb4_unicode_ci DEFAULT 'pendiente',
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `asistencia_confirmada` tinyint(1) DEFAULT '0',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tutorias`
--

INSERT INTO `tutorias` (`id`, `estudiante_id`, `docente_id`, `fecha`, `hora`, `motivo`, `estado`, `observaciones`, `asistencia_confirmada`, `fecha_registro`) VALUES
(1, 1, 2, '2025-11-10', '14:00:00', 'ella no me ama', 'cancelada', NULL, 0, '2025-11-10 00:30:29'),
(2, 1, 2, '2025-11-10', '14:00:00', 'jaleme profe', 'confirmada', NULL, 0, '2025-11-10 00:33:15'),
(3, 1, 2, '2025-11-10', '17:00:00', 'me va mal', 'pendiente', NULL, 0, '2025-11-10 01:10:11');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('estudiante','docente','coordinador','consejero') COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci DEFAULT 'activo',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `rol`, `estado`, `fecha_creacion`) VALUES
(1, 'admin', '$2y$10$eFdKUnR0Kv1XW28C/PflKOsgGsXPLIZGz62XuXPfn/G.QDJNFih/.', 'coordinador', 'activo', '2025-11-09 21:09:00'),
(2, 'DOC001', '$2y$10$dZIvZsAGtTrn2nY5H/icQu118X4GkaeC.Bg17ukelfJ098mWE1OUS', 'docente', 'activo', '2025-11-09 21:09:00'),
(3, 'DOC002', '$2y$10$dZIvZsAGtTrn2nY5H/icQu118X4GkaeC.Bg17ukelfJ098mWE1OUS', 'docente', 'activo', '2025-11-09 21:09:00'),
(4, 'CONS001', '$2y$10$dZIvZsAGtTrn2nY5H/icQu118X4GkaeC.Bg17ukelfJ098mWE1OUS', 'consejero', 'activo', '2025-11-09 21:09:00'),
(5, '0201910001', '$2y$10$PJAYkwb8yM4XtfnfIZHMAOpmn1.YyYfCvGqEQiUlRRF3IzEuq0uvq', 'estudiante', 'activo', '2025-11-09 21:09:00'),
(6, '0201910002', '$2y$10$PJAYkwb8yM4XtfnfIZHMAOpmn1.YyYfCvGqEQiUlRRF3IzEuq0uvq', 'estudiante', 'activo', '2025-11-09 21:09:00'),
(7, 'CONS002', '$2y$10$dZIvZsAGtTrn2nY5H/icQu118X4GkaeC.Bg17ukelfJ098mWE1OUS', 'consejero', 'activo', '2025-11-09 21:09:00'),
(8, 'CONS003', '$2y$10$dZIvZsAGtTrn2nY5H/icQu118X4GkaeC.Bg17ukelfJ098mWE1OUS', 'consejero', 'activo', '2025-11-09 21:09:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asignaciones_tutoria`
--
ALTER TABLE `asignaciones_tutoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_estudiante` (`estudiante_id`),
  ADD KEY `idx_docente` (`docente_id`),
  ADD KEY `idx_activo` (`activo`);

--
-- Indexes for table `consejerias`
--
ALTER TABLE `consejerias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `consejero_id` (`consejero_id`);

--
-- Indexes for table `consejeros`
--
ALTER TABLE `consejeros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `fichas_consejeria`
--
ALTER TABLE `fichas_consejeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consejeria_id` (`consejeria_id`);

--
-- Indexes for table `fichas_tutoria`
--
ALTER TABLE `fichas_tutoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tutoria_id` (`tutoria_id`);

--
-- Indexes for table `horarios_docente`
--
ALTER TABLE `horarios_docente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_horario` (`docente_id`,`dia_semana`,`hora_inicio`),
  ADD KEY `idx_docente_estado` (`docente_id`,`estado`),
  ADD KEY `idx_dia_semana` (`dia_semana`);

--
-- Indexes for table `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_estudiante` (`estudiante_id`),
  ADD KEY `idx_docente` (`docente_id`),
  ADD KEY `idx_fecha` (`fecha`),
  ADD KEY `idx_requiere_atencion` (`requiere_atencion`);

--
-- Indexes for table `tutorias`
--
ALTER TABLE `tutorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asignaciones_tutoria`
--
ALTER TABLE `asignaciones_tutoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `consejerias`
--
ALTER TABLE `consejerias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consejeros`
--
ALTER TABLE `consejeros`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fichas_consejeria`
--
ALTER TABLE `fichas_consejeria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fichas_tutoria`
--
ALTER TABLE `fichas_tutoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `horarios_docente`
--
ALTER TABLE `horarios_docente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seguimientos`
--
ALTER TABLE `seguimientos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tutorias`
--
ALTER TABLE `tutorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asignaciones_tutoria`
--
ALTER TABLE `asignaciones_tutoria`
  ADD CONSTRAINT `asignaciones_estudiante_fk` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaciones_docente_fk` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `consejerias`
--
ALTER TABLE `consejerias`
  ADD CONSTRAINT `consejerias_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`),
  ADD CONSTRAINT `consejerias_ibfk_2` FOREIGN KEY (`consejero_id`) REFERENCES `consejeros` (`id`);

--
-- Constraints for table `consejeros`
--
ALTER TABLE `consejeros`
  ADD CONSTRAINT `consejeros_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fichas_consejeria`
--
ALTER TABLE `fichas_consejeria`
  ADD CONSTRAINT `fichas_consejeria_ibfk_1` FOREIGN KEY (`consejeria_id`) REFERENCES `consejerias` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fichas_tutoria`
--
ALTER TABLE `fichas_tutoria`
  ADD CONSTRAINT `fichas_tutoria_ibfk_1` FOREIGN KEY (`tutoria_id`) REFERENCES `tutorias` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `horarios_docente`
--
ALTER TABLE `horarios_docente`
  ADD CONSTRAINT `horarios_docente_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `seguimientos_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seguimientos_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tutorias`
--
ALTER TABLE `tutorias`
  ADD CONSTRAINT `tutorias_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`),
  ADD CONSTRAINT `tutorias_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
