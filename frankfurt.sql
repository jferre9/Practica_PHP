-- phpMyAdmin SQL Dump
-- version 3.3.5
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Temps de generació: 20-01-2017 a les 16:35:07
-- Versió del servidor: 5.1.49
-- Versió de PHP : 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de dades: `frankfurt`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `comanda`
--

CREATE TABLE IF NOT EXISTS `comanda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taula_id` int(11) NOT NULL,
  `actiu` tinyint(1) NOT NULL DEFAULT '1',
  `preu_final` decimal(10,2) DEFAULT NULL,
  `data_pagament` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Bolcant dades de la taula `comanda`
--

INSERT INTO `comanda` (`id`, `taula_id`, `actiu`, `preu_final`, `data_pagament`) VALUES
(1, 1, 0, 20.00, '2017-01-06 12:43:01'),
(2, 3, 0, 23.50, '2017-01-06 20:30:32'),
(3, 2, 0, 3.50, '2017-01-12 15:39:07'),
(10, 1, 0, 17.00, '2017-01-11 17:44:18'),
(11, 1, 0, 2.00, '2017-01-12 15:39:15'),
(12, 3, 0, 3.50, '2017-01-12 15:39:19'),
(13, 4, 0, 3.50, '2017-01-12 15:39:23'),
(14, 5, 0, 3.50, '2017-01-12 15:39:27'),
(15, 6, 0, 3.50, '2017-01-12 15:39:31'),
(16, 1, 0, 3.50, '2017-01-12 15:40:01'),
(17, 2, 0, 3.50, '2017-01-12 15:40:05'),
(18, 1, 0, 3.50, '2017-01-12 15:43:45'),
(19, 2, 0, 25.50, '2017-01-13 16:33:25'),
(20, 5, 0, 18.50, '2017-01-18 16:42:53'),
(21, 1, 1, NULL, NULL),
(22, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de la taula `detall`
--

CREATE TABLE IF NOT EXISTS `detall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producte_id` int(11) NOT NULL,
  `preu` decimal(10,2) NOT NULL,
  `comanda_id` int(11) NOT NULL,
  `estat` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Bolcant dades de la taula `detall`
--

INSERT INTO `detall` (`id`, `producte_id`, `preu`, `comanda_id`, `estat`) VALUES
(3, 1, 3.00, 1, 2),
(4, 1, 3.00, 1, 2),
(5, 2, 4.00, 2, 2),
(6, 3, 1.00, 1, 2),
(10, 2, 5.50, 1, 2),
(11, 1, 3.50, 1, 2),
(12, 5, 2.00, 1, 2),
(13, 6, 2.00, 1, 2),
(14, 1, 5.50, 2, 2),
(15, 1, 3.50, 2, 2),
(16, 1, 3.50, 2, 2),
(17, 1, 3.50, 2, 2),
(18, 1, 3.50, 2, 2),
(25, 1, 3.50, 10, 2),
(26, 1, 3.50, 10, 2),
(29, 1, 3.50, 10, 2),
(30, 2, 5.50, 10, 2),
(31, 3, 1.00, 10, 2),
(32, 6, 2.00, 11, 2),
(33, 1, 3.50, 3, 2),
(34, 1, 3.50, 12, 2),
(35, 1, 3.50, 13, 2),
(36, 1, 3.50, 14, 2),
(37, 1, 3.50, 15, 2),
(38, 1, 3.50, 16, 2),
(39, 1, 3.50, 17, 2),
(40, 1, 3.50, 18, 2),
(41, 1, 3.50, 19, 2),
(42, 1, 3.50, 19, 2),
(43, 1, 3.50, 19, 2),
(44, 5, 2.00, 20, 2),
(45, 5, 2.00, 20, 2),
(46, 5, 2.00, 20, 2),
(47, 6, 2.00, 20, 2),
(48, 2, 5.50, 19, 2),
(49, 2, 5.50, 19, 2),
(50, 6, 2.00, 19, 2),
(51, 6, 2.00, 19, 2),
(52, 1, 3.50, 20, 2),
(53, 1, 3.50, 20, 2),
(54, 1, 3.50, 20, 2),
(55, 1, 3.50, 21, 1),
(56, 1, 3.50, 21, 1),
(57, 1, 3.50, 22, 1),
(58, 5, 2.00, 22, 0),
(59, 1, 3.50, 21, 1),
(60, 3, 1.00, 21, 2),
(61, 1, 3.50, 21, 0),
(62, 1, 3.50, 21, 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `ordre`
--

CREATE TABLE IF NOT EXISTS `ordre` (
  `detall_id` int(11) NOT NULL,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY (`detall_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Bolcant dades de la taula `ordre`
--

INSERT INTO `ordre` (`detall_id`, `ordre`) VALUES
(58, 3),
(61, 1),
(62, 2);

-- --------------------------------------------------------

--
-- Estructura de la taula `usuari`
--

CREATE TABLE IF NOT EXISTS `usuari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `cognoms` varchar(32) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `cambrer` tinyint(1) NOT NULL DEFAULT '0',
  `cuiner` tinyint(1) NOT NULL DEFAULT '0',
  `cobrar` tinyint(1) NOT NULL DEFAULT '0',
  `recuperar` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Bolcant dades de la taula `usuari`
--

INSERT INTO `usuari` (`id`, `email`, `nom`, `cognoms`, `pass`, `cambrer`, `cuiner`, `cobrar`, `recuperar`) VALUES
(1, 'admin', 'admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0, 0, NULL),
(2, 'w2.jferre@infomila.info', 'Joan', 'Ferré', '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, 1, '67d3d4c4dd0b82eee951af73f9f33e3c'),
(3, 'jofe93@gmail.com', 'asd', 'qwe', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0, 1, '7a680364b943137b7042d68fa3b2e687');
