-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 27 jan. 2021 à 11:54
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
-- Base de données : `todov2`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `processCheckToken`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `processCheckToken` (IN `p_token` VARCHAR(255), IN `p_idUser` INT(11))  BEGIN
    DECLARE _flag integer default NULL;

    DECLARE _expirationdate_token TIMESTAMP;
    DECLARE _id_permission INT(10);
    DECLARE _id_todo INT(10);
    -- Cursor qui récupère les informations de la token.
    DECLARE cursor_selectToken CURSOR FOR SELECT expirationdate_token, id_permission, id_todo FROM todo_token WHERE token = p_token;

    -- Verification de la validité de la token.
    set _flag = (SELECT 1 FROM todo_token WHERE token = p_token);
    IF(_flag = 1 AND _flag IS NOT NULL) THEN
        set _flag = NULL;
        OPEN cursor_selectToken;
        FETCH cursor_selectToken INTO _expirationdate_token, _id_permission, _id_todo;
        CLOSE cursor_selectToken;

        -- Verification de la date d'expiration du token.
        IF(_expirationdate_token <= NOW()) THEN
            -- Suppresion du token
            DELETE FROM todo_token WHERE token = p_token;
            -- Message d'erreur : Le token a expirée.
            SIGNAL SQLSTATE '45000' 
		    SET MYSQL_ERRNO = 10005, MESSAGE_TEXT = "Le token a expirée.";
        ELSE
            -- Verification que la personne ne contribue pas déjà à cette TODO.
            set _flag = (SELECT 1 FROM contribute WHERE id_user = p_idUser and id_todo = _id_todo);
            SELECT _flag;
            -- Si c'est le cas :
            IF(_flag = 1) THEN
                -- Verification que le user existe bien, dans le cas contraire c'est que l'on participe déjà à la TODO
                set _flag = (SELECT 1 FROM user WHERE id_user = p_idUser);
                IF(_flag = 1) THEN
                    -- Message d'erreur : Vous participer déjà à cette todo
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10003, MESSAGE_TEXT = "Vous participez déjà à cette todo.";
                ELSE
                    -- Message d'erreur : Le user n'existe pas.
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10003, MESSAGE_TEXT = "Le user n'existe pas.";
                END IF;
            ELSE
                SET _flag = NULL;
                -- La personne ne contribue pas dèjà à la TODO, alors on verifie qu'elle n'est pas propriétaire
                SET _flag = (SELECT 1 FROM todo WHERE id_user = p_idUser and id_todo = _id_todo);
                IF(_flag = 1) THEN
                    -- Message d'erreur : Vous êtes le propriétaire de cette todo
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10004, MESSAGE_TEXT = "Vous êtes le propriétaire de cette todo.";
                ELSE
                    -- Ajout dans la table contribute de la nouvelle ligne de contribution
                    INSERT INTO contribute (id_user, id_permission, id_todo) VALUES (p_idUser, _id_permission, _id_todo);
                    -- Suppression du token.
                    DELETE FROM todo_token WHERE token = p_token;
                    -- Message de réussite : Succès de la procédure.
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10001, MESSAGE_TEXT = "Succès de la procédure.";
                END IF;
            END IF;
        END IF;
    ELSE
        -- Message d'erreur : Le token n'est pas valide
        SIGNAL SQLSTATE '45000' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Le token n'est pas valide.";
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `contribute`
--

DROP TABLE IF EXISTS `contribute`;
CREATE TABLE IF NOT EXISTS `contribute` (
  `accepted_participer` tinyint NOT NULL DEFAULT '0',
  `joindate_participer` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  `id_permission` int NOT NULL,
  `id_todo` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_permission`,`id_todo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contribute`
--

INSERT INTO `contribute` (`accepted_participer`, `joindate_participer`, `id_user`, `id_permission`, `id_todo`) VALUES
(0, '2021-01-26 23:12:25', 2, 2, 2),
(0, '2021-01-26 23:10:27', 2, 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id_permission` int NOT NULL AUTO_INCREMENT,
  `libelle_permission` varchar(255) NOT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id_task` int NOT NULL AUTO_INCREMENT,
  `title_task` varchar(255) NOT NULL,
  `content_task` text NOT NULL,
  `achieve_task` tinyint NOT NULL DEFAULT '0',
  `enddate_task` datetime NOT NULL,
  `createdate_task` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_todo` int NOT NULL,
  PRIMARY KEY (`id_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `taskarchive_date`
--

DROP TABLE IF EXISTS `taskarchive_date`;
CREATE TABLE IF NOT EXISTS `taskarchive_date` (
  `id_date` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `taskcreate_date`
--

DROP TABLE IF EXISTS `taskcreate_date`;
CREATE TABLE IF NOT EXISTS `taskcreate_date` (
  `id_date` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `taskupdate_date`
--

DROP TABLE IF EXISTS `taskupdate_date`;
CREATE TABLE IF NOT EXISTS `taskupdate_date` (
  `id_date` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task_archive`
--

DROP TABLE IF EXISTS `task_archive`;
CREATE TABLE IF NOT EXISTS `task_archive` (
  `id_date` int NOT NULL,
  `id_task` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task_create`
--

DROP TABLE IF EXISTS `task_create`;
CREATE TABLE IF NOT EXISTS `task_create` (
  `id_date` int NOT NULL,
  `id_task` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task_update`
--

DROP TABLE IF EXISTS `task_update`;
CREATE TABLE IF NOT EXISTS `task_update` (
  `id_date` int NOT NULL,
  `id_task` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id_todo` int NOT NULL AUTO_INCREMENT,
  `title_todo` varchar(255) NOT NULL,
  `description_todo` text NOT NULL,
  `enddate_todo` datetime NOT NULL,
  `createdate_todo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  `id_icon` int NOT NULL,
  PRIMARY KEY (`id_todo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo_icon`
--

DROP TABLE IF EXISTS `todo_icon`;
CREATE TABLE IF NOT EXISTS `todo_icon` (
  `id_icon` int NOT NULL AUTO_INCREMENT,
  `libelle_icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id_icon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `todo_token`
--

DROP TABLE IF EXISTS `todo_token`;
CREATE TABLE IF NOT EXISTS `todo_token` (
  `token` varchar(255) NOT NULL,
  `expirationdate_token` datetime NOT NULL,
  `id_permission` int NOT NULL,
  `id_todo` int NOT NULL,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name_user` varchar(255) NOT NULL,
  `firstname_user` varchar(255) NOT NULL,
  `email_user` varchar(500) NOT NULL,
  `password_user` varchar(500) NOT NULL,
  `createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `firstname_user`, `email_user`, `password_user`, `createdate`) VALUES
(3, 'qsdqsd', 'qsdqsd', 'qsdqsd', 'qsdqsdqsd', '2021-01-26 23:13:25');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
