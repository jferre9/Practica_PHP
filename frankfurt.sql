-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-01-2017 a las 22:41:09
-- Versión del servidor: 5.7.11
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `frankfurt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comanda`
--

CREATE TABLE `comanda` (
  `id` int(11) NOT NULL,
  `taula_id` int(11) NOT NULL,
  `actiu` tinyint(1) NOT NULL DEFAULT '1',
  `preu_final` decimal(10,2) DEFAULT NULL,
  `data_pagament` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comanda`
--

INSERT INTO `comanda` (`id`, `taula_id`, `actiu`, `preu_final`, `data_pagament`) VALUES
(1, 1, 0, '20.00', '2017-01-06 12:43:01'),
(2, 3, 0, '23.50', '2017-01-06 20:30:32'),
(3, 2, 1, NULL, NULL),
(10, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detall`
--

CREATE TABLE `detall` (
  `id` int(11) NOT NULL,
  `producte_id` int(11) NOT NULL,
  `preu` decimal(10,2) NOT NULL,
  `comanda_id` int(11) NOT NULL,
  `estat` tinyint(4) NOT NULL DEFAULT '0'COMMENT
) ;

--
-- Volcado de datos para la tabla `detall`
--

INSERT INTO `detall` (`id`, `producte_id`, `preu`, `comanda_id`, `estat`) VALUES
(3, 1, '3.00', 1, 2),
(4, 1, '3.00', 1, 2),
(5, 2, '4.00', 2, 0),
(6, 3, '1.00', 1, 2),
(10, 2, '5.50', 1, 2),
(11, 1, '3.50', 1, 2),
(12, 5, '2.00', 1, 2),
(13, 6, '2.00', 1, 2),
(14, 1, '5.50', 2, 2),
(15, 1, '3.50', 2, 2),
(16, 1, '3.50', 2, 2),
(17, 1, '3.50', 2, 2),
(18, 1, '3.50', 2, 2),
(22, 1, '3.50', 10, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordre`
--

CREATE TABLE `ordre` (
  `detall_id` int(11) NOT NULL,
  `ordre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ordre`
--

INSERT INTO `ordre` (`detall_id`, `ordre`) VALUES
(5, 1),
(22, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuari`
--

CREATE TABLE `usuari` (
  `id` int(11) NOT NULL,
  `email` varchar(32) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `cognoms` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `cambrer` tinyint(1) NOT NULL DEFAULT '0',
  `cuiner` tinyint(1) NOT NULL DEFAULT '0',
  `cobrar` tinyint(1) NOT NULL DEFAULT '0',
  `recuperar` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuari`
--

INSERT INTO `usuari` (`id`, `email`, `nom`, `cognoms`, `pass`, `cambrer`, `cuiner`, `cobrar`, `recuperar`) VALUES
(1, 'admin', 'admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0, 0, NULL),
(2, 'w2.jferre@infomila.info', 'Joan', 'Ferré', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 1, NULL),
(3, 'jofe93@gmail.com', 'asd', 'qwe', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0, 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordre`
--
ALTER TABLE `ordre`
  ADD PRIMARY KEY (`detall_id`);

--
-- Indices de la tabla `usuari`
--
ALTER TABLE `usuari`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `detall`
--
ALTER TABLE `detall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuari`
--
ALTER TABLE `usuari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ordre`
--
ALTER TABLE `ordre`
  ADD CONSTRAINT `ordre_ibfk_1` FOREIGN KEY (`detall_id`) REFERENCES `detall` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
