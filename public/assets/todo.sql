-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 déc. 2020 à 02:05
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modifpassword`
--

INSERT INTO `modifpassword` (`idModif`, `idUser`, `token`, `active`) VALUES
(38, 4, 'MKYQ5R', 0),
(39, 4, 'BZZRUW', 0),
(40, 4, '9FM4RM', 0);

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
  `active_task` int DEFAULT '0',
  `createdate_task` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser_task` int DEFAULT NULL,
  `idtodo_task` int DEFAULT NULL,
  PRIMARY KEY (`id_task`),
  KEY `constraint_idUserTask` (`iduser_task`),
  KEY `constraint_idTodoTask` (`idtodo_task`)
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id_task`, `content_task`, `enddate_task`, `endtime_task`, `active_task`, `createdate_task`, `iduser_task`, `idtodo_task`) VALUES
(209, 'Acheter de la viande', '2020-12-25', '19:32:00', 1, '2020-12-25 17:32:17', 2, 17),
(225, 'Djejrjrbr', '2020-12-27', NULL, 1, '2020-12-27 19:12:56', 2, 17),
(226, 'Eurkejrrj', '2020-12-27', NULL, 1, '2020-12-27 19:13:01', 2, 17),
(227, 'sdfsdfsdfsdf', '2020-12-28', NULL, 1, '2020-12-28 01:22:33', 2, 17),
(228, 'sdfsdfsdfsdf', '2020-12-28', NULL, 0, '2020-12-28 01:22:35', 2, 17),
(229, 'send nude', '2020-12-29', NULL, 0, '2020-12-28 02:51:12', 2, 17);

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id_todo` int NOT NULL AUTO_INCREMENT,
  `title_todo` varchar(255) DEFAULT NULL,
  `description_todo` text,
  `active_todo` int DEFAULT '0',
  `status_todo` varchar(100) NOT NULL,
  `enddate_todo` date NOT NULL,
  `endtime_todo` date DEFAULT NULL,
  `createdate_todo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser_todo` int DEFAULT NULL,
  PRIMARY KEY (`id_todo`),
  KEY `constraint_idUserTodo` (`iduser_todo`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `todo`
--

INSERT INTO `todo` (`id_todo`, `title_todo`, `description_todo`, `active_todo`, `status_todo`, `enddate_todo`, `endtime_todo`, `createdate_todo`, `iduser_todo`) VALUES
(17, 'Course', 'Groupe de tâches concernant les courses.', 0, 'private', '2020-12-31', NULL, '2020-12-22 18:50:54', 2),
(19, 'qsdqsdqsd', 'aqsdqsdqsdqsdqsd', 0, 'private', '2020-12-24', '0000-00-00', '2020-12-24 19:30:48', 2),
(20, 'qsdqsdqsdqs', 'qsdqsdqsdqsd', 0, 'private', '2020-12-24', '0000-00-00', '2020-12-24 19:30:51', 2),
(21, 'qsdqsdqsd', 'qsdqsdqsdqsd', 0, 'private', '2020-12-24', '0000-00-00', '2020-12-24 19:30:55', 2),
(22, 'qsdqsdqsdqsd', 'qsdqsdqsd', 0, 'private', '2020-12-24', '0000-00-00', '2020-12-24 19:30:59', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `firstname_user`, `email_user`, `password_user`) VALUES
(2, 'testName', 'testFirstName', 'testEmail@gmail.com', 'test'),
(4, 'dfgdfgdfg', 'dfgdfgdfg', 'craffteur.tech@gmail.com', 'test'),
(5, 'sdfsdfsdf', 'sdfsdqfqsdf', 'sdf@gmail.com', 'sdf'),
(7, NULL, NULL, 'poubelleman24@gmail.com', 'Azertyuiop_89');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `modifpassword`
--
ALTER TABLE `modifpassword`
  ADD CONSTRAINT `constraint_idUser` FOREIGN KEY (`idUser`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `constraint_idTodoTask` FOREIGN KEY (`idtodo_task`) REFERENCES `todo` (`id_todo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idUserTask` FOREIGN KEY (`iduser_task`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `constraint_idUserTodo` FOREIGN KEY (`iduser_todo`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
