-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-02-2021 a las 22:41:21
-- Versión del servidor: 8.0.23-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `etienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cod_cliente` int NOT NULL DEFAULT '0',
  `nombre` varchar(10) DEFAULT NULL,
  `clave` varchar(10) DEFAULT NULL,
  `veces` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`cod_cliente`, `nombre`, `clave`, `veces`) VALUES
(1001, 'miguel', '123456', 10),
(1002, 'eva', 'secretoeva', 14),
(1003, 'luis33', 'luis34', 1),
(1004, 'silviam', 'sm2323', 3),
(2000, 'jesus', 'jesus', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `numped` int NOT NULL DEFAULT '0',
  `cod_cliente` int DEFAULT NULL,
  `producto` varchar(20) DEFAULT NULL,
  `precio` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`numped`, `cod_cliente`, `producto`, `precio`) VALUES
(1, 1001, 'Zapatilla s23', 30),
(2, 1002, 'Camisa sport', 20),
(3, 1002, 'Camisa green', 25),
(4, 1002, 'Pantalón sport', 20),
(5, 1001, 'Camisa sport', 20),
(6, 1003, 'Camisa sport', 20),
(7, 1003, 'Zapatilla sport', 10),
(8, 1004, 'Camisa sport', 20),
(9, 1004, 'Forro polar', 60),
(10, 1003, 'Gorro color', 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cod_cliente`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`numped`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;