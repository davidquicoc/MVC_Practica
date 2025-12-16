-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-12-2025 a las 18:48:42
-- Versión del servidor: 8.0.44
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--
CREATE DATABASE IF NOT EXISTS `biblioteca` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `biblioteca`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE IF NOT EXISTS `libro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `autor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `editorial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `genero` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `año_publicacion` int NOT NULL,
  `n_paginas` int NOT NULL,
  `disponibilidad` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id`, `titulo`, `autor`, `editorial`, `genero`, `año_publicacion`, `n_paginas`, `disponibilidad`) VALUES
(1, 'El viaje de la mente', 'Ana López', 'Planeta', 'Ensayo', 2023, 210, 1),
(2, 'El hombre de tiza', 'C.J. Tudor', 'Plaza & Janés', 'Thriller psicológico de misterio y suspense', 2018, 352, 1),
(3, 'Don Juan Tenorio', 'José Zorrilla', 'Clásicos de siempre', 'Drama romántico', 1844, 289, 1),
(4, 'Fahrenheit 451', 'Ray Bradbury', 'Ballantine Books', 'Novela distópica de ciencia ficción', 1953, 192, 1),
(5, 'Cien años de soledad', 'Gabriel García Márquez', 'Sudamericana', 'Novela de realismo mágico', 1967, 471, 1),
(6, 'La sombra del viento', 'Carlos Ruiz Zafón', 'Planeta', 'Novela de misterio y romance', 2001, 565, 1),
(7, '1984', 'George Orwell', 'Secker & Warburg', 'Novela distópica y política', 1949, 328, 1),
(8, 'Don Quijote de la Mancha 1º Parte', 'Miguel de Cervantes Saavedra', 'Juan de la Cuesta', 'Novela de aventuras con parodia caballeresca y realismo', 1605, 863, 1),
(9, 'Rebelión en la granja', 'George Orwell', 'Secker & Warburg', 'Fábula satírica distópica', 1945, 233, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE IF NOT EXISTS `prestamo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `libro_id` int NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `fecha_devolucion_limite` date NOT NULL,
  `fecha_devuelto` date DEFAULT NULL,
  `multa` decimal(7,2) NOT NULL,
  `devuelto` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `libro_id` (`libro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dni` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `contraseña` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email-unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

-- 
--  Credenciales de los usuarios
-- 
-- davidqc@gmail.com            davidqc
-- mariolopez@gmail.com         mario
-- luis.andres@gmail.com        luis
-- maripazflores1@gmail.com     maripaz1
-- jaimeperez4@gmail.com        jaimep
-- pablomartnz@gmail.com        pablom
-- 

INSERT INTO `usuario` (`id`, `dni`, `nombre`, `apellido`, `email`, `contraseña`) VALUES
(1, '11111111A', 'David', 'Quico', 'davidqc@gmail.com', '$2y$10$Ancs5Bo5yIpuJOWdegnCc.cBH3jxGs2emgale4MYpl7TgRf/C.IsO'),
(2, '87654321P', 'Mario', 'López', 'mariolopez@gmail.com', '$2y$10$BXGHd8OK2a74SRFLy9gzL.hI8D4Y1BoCETS6uzEEXdMWZTa9DAHXW'),
(3, '66666666Y', 'Luis', 'Andrés', 'luis.andres@gmail.com', '$2y$10$d31d5t8w4bpOi1OESqf96eMyAr.huWeQEOKMkr/Xvm3L0ksywt9Na'),
(4, '81818181H', 'Maripaz', 'Flores', 'maripazflores1@gmail.com', '$2y$10$w1k/E.sTbxK7FGzKR0XfVe23kyLpd959fNfKVU2NZqmYDfXzyS3Zq'),
(5, '87382221A', 'Jaime', 'Pérez', 'jaimeperez4@gmail.com', '$2y$10$UAUmPUwAq0uMMRBcr47MSOk9k2R/YDGt6TcYOwPh72l1tT92YHx6C'),
(6, '78129819A', 'Pablo', 'Martínez', 'pablomartnz@gmail.com', '$2y$10$qC7vNbVP16ajVfjkR90fDO0WVhBgBS9J6Mh4ROuT0W1Ao.bvOV6Be');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`libro_id`) REFERENCES `libro` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
