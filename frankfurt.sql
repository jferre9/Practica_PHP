-- phpMyAdmin SQL Dump
-- version 3.3.5
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Temps de generació: 21-12-2016 a les 18:31:02
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Bolcant dades de la taula `usuari`
--

INSERT INTO `usuari` (`id`, `email`, `nom`, `cognoms`, `pass`, `cambrer`, `cuiner`, `cobrar`) VALUES
(1, 'admin', 'admin', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 0, 0, 0);
