-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 10 mars 2021 à 23:10
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `todov2`
--

-- --------------------------------------------------------

--
-- Structure de la table `taskpriority`
--

DROP TABLE IF EXISTS `taskpriority`;
CREATE TABLE IF NOT EXISTS `taskpriority` (
  `id_priority` int(11) NOT NULL AUTO_INCREMENT,
  `label_priority` varchar(255) NOT NULL,
  `color_priority` varchar(25) NOT NULL,
  PRIMARY KEY (`id_priority`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taskpriority`
--

INSERT INTO `taskpriority` (`id_priority`, `label_priority`, `color_priority`) VALUES
(1, 'URGENT', '#F25F5C'),
(2, 'A FAIRE', '#5C7AFF'),
(3, 'TERMINE', '#FFFFFF');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
