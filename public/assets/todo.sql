-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 01 déc. 2020 à 21:12
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `todo`
--

-- --------------------------------------------------------

--
-- Structure de la table `modifpassword`
--

DROP TABLE IF EXISTS `modifpassword`;
CREATE TABLE IF NOT EXISTS `modifpassword` (
  `idModif` int NOT NULL AUTO_INCREMENT,
  `idUser` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`idModif`),
  KEY `constraint_idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modifpassword`
--

INSERT INTO `modifpassword` (`idModif`, `idUser`, `token`, `active`) VALUES
(38, 4, 'MKYQ5R', 0),
(39, 4, 'BZZRUW', 0);

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

DROP TABLE IF EXISTS `participer`;
CREATE TABLE IF NOT EXISTS `participer` (
  `iduser_participer` int NOT NULL,
  `idtodo_participer` int NOT NULL,
  PRIMARY KEY (`iduser_participer`,`idtodo_participer`),
  KEY `iduser_participer` (`idtodo_participer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id_task` int NOT NULL AUTO_INCREMENT,
  `content_task` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `enddate_task` date DEFAULT NULL,
  `endtime_task` time DEFAULT NULL,
  `active_task` int DEFAULT '1',
  `iduser_task` int DEFAULT NULL,
  `idtodo_task` int DEFAULT NULL,
  PRIMARY KEY (`id_task`),
  KEY `iduser_task` (`iduser_task`),
  KEY `idtodo_task` (`idtodo_task`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id_task`, `content_task`, `enddate_task`, `endtime_task`, `active_task`, `iduser_task`, `idtodo_task`) VALUES
(106, 'Sortir le chien', '2020-11-26', '18:29:00', 1, 2, 10),
(107, 'Ne s\'affiche pas aujourd\'hui', '2020-11-26', '18:29:00', 0, 2, 10),
(108, 'Dire bonjour à Orlane', '2020-11-27', NULL, 1, 2, 10),
(109, 'Faire le controle de SI7', '2020-11-27', NULL, 1, 2, 10),
(110, 'Ne s\'affiche pas demain', '2020-11-27', NULL, 0, 2, 10),
(111, 'Faire le controle de SI7', '2020-11-30', NULL, 1, 2, 10);

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id_todo` int NOT NULL AUTO_INCREMENT,
  `title_todo` varchar(255) DEFAULT NULL,
  `active_todo` int DEFAULT NULL,
  `status_todo` varchar(100) NOT NULL,
  `createdate_todo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser_todo` int DEFAULT NULL,
  PRIMARY KEY (`id_todo`),
  KEY `iduser_todo` (`iduser_todo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `todo`
--

INSERT INTO `todo` (`id_todo`, `title_todo`, `active_todo`, `status_todo`, `createdate_todo`, `iduser_todo`) VALUES
(5, 'coucou', 1, 'sdfsdf', '2020-11-17 00:16:12', 1),
(10, 'Hello', 1, 'private', '2020-11-20 22:42:08', 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name_user` varchar(100) DEFAULT NULL,
  `firstname_user` varchar(100) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `password_user` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `firstname_user`, `email_user`, `password_user`) VALUES
(2, 'testName', 'testFirstName', 'testEmail@gmail.com', 'test'),
(4, 'dfgdfgdfg', 'dfgdfgdfg', 'craffteur.tech@gmail.com', 'test'),
(5, 'sdfsdfsdf', 'sdfsdqfqsdf', 'sdf@gmail.com', 'sdf');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `modifpassword`
--
ALTER TABLE `modifpassword`
  ADD CONSTRAINT `constraint_idUser` FOREIGN KEY (`idUser`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
