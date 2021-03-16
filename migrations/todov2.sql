-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 16 mars 2021 à 15:47
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

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `achieveTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `achieveTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11))  BEGIN

    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE is_allowed BOOLEAN DEFAULT FALSE;
    DECLARE _flag  integer          default null;
    DECLARE _id_permission INT(11);
    DECLARE is_achieve BOOLEAN;

        -- La tâche existe?
    SET _flag = (SELECT 1 FROM task WHERE id_task = p_idTask);
    IF (_flag = 1) THEN
        SET _flag = NULL;
        -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
        SET _flag = (SELECT 1 FROM todo, task WHERE task.id_todo = todo.id_todo and id_task = p_idTask and id_user = p_idUser);
        IF(_flag = 1) THEN
            SET _flag = NULL;
            -- La tâche est elle déjà achevée?
            SET _flag = (SELECT 1 FROM task_achieve WHERE id_task = p_idTask);
            IF(_flag = 1) THEN
                -- La tâche est déjà achevée, on la remet en inachevée.
                SET _flag = NULL;
                -- Suppression de la log task_achieve.
                DELETE FROM task_achieve WHERE id_task = p_idTask;
                -- Changement de la priority pour A FAIRE
                UPDATE task SET id_priority = 1 WHERE id_task = p_idTask;
                -- Message succes : Inachevage de la tâche réussi.
                SET is_achieve = FALSE;
                SELECT is_achieve;
            ELSE
                -- Ajout d'une date dans taskachieve_date.
                INSERT INTO taskachieve_date VALUES ();
                -- Ajout dans la table de log des achieve.
                INSERT INTO task_achieve VALUES(last_insert_id(), p_idTask, p_idUser);
                -- Changement de la priority pour TERMINE
                UPDATE task SET id_priority = 3 WHERE id_task = p_idTask; 
                -- Message succes : Achevage de la tâche réussi.
                SET is_achieve = TRUE;
                SELECT is_achieve;
            END IF;
        ELSE
            -- Le user n'est pas propriétaire.
                    
            -- A t'il les droits en achieve? - 1
            BEGIN
                DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = (SELECT task.id_todo FROM task, todo WHERE task.id_todo = todo.id_todo and id_task = p_idTask);
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                OPEN cursor_userPermission;

                loop_cursor_userPermission :LOOP
                    FETCH cursor_userPermission INTO _id_permission;
                    IF fin THEN
			            LEAVE loop_cursor_userPermission;
		            END IF;
                    -- Si l'_id_permission == 4 -> il a le droit en achieve.
                    IF (_id_permission = 1) THEN
                        SET _flag = NULL;
                        -- La tâche est elle déjà achevée?
                        SET _flag = (SELECT 1 FROM task_achieve WHERE id_task = p_idTask);
                        IF(_flag = 1) THEN
                            -- La tâche est déjà achevée, on la rétablie.
                            SET _flag = NULL;
                            -- Suppression de la log task_achieve.
                            DELETE FROM task_achieve WHERE id_task = p_idTask;
                            -- Changement de la priority pour A FAIRE
                            UPDATE task SET id_priority = 1 WHERE id_task = p_idTask;
                            -- Message succes : Inachevage de la tâche réussi.
                            SET is_achieve = FALSE;
                            SELECT is_achieve;
                        ELSE
                            -- Ajout d'une date dans taskachieve_date.
                            INSERT INTO taskachieve_date VALUES ();
                            -- Ajout dans la table de log des achieve.
                            INSERT INTO task_achieve VALUES(last_insert_id(), p_idTask, p_idUser);
                            -- Changement de la priority pour TERMINE
                            UPDATE task SET id_priority = 3 WHERE id_task = p_idTask;          
                            -- Message succes : Achevage de la tâche réussi.
                            SET is_achieve = TRUE;
                            SELECT is_achieve;
                        END IF;
                    END IF;

                END LOOP;

                CLOSE cursor_userPermission;

                IF(is_allowed = FALSE) THEN
                    -- Message d'erreur : Vous n'avez pas l'autorisation.
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation d'achever une tâche.";
                END IF;

            END ;
        END IF;
    ELSE
        -- Message d'erreur : La todo n'existe pas.
        SIGNAL SQLSTATE '45000' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche n'existe pas.";
    END IF;

END$$

DROP PROCEDURE IF EXISTS `archiveTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `archiveTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11))  BEGIN

    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE is_allowed BOOLEAN DEFAULT FALSE;
    DECLARE _flag  integer          default null;
    DECLARE _id_permission INT(11);
    DECLARE is_archived BOOLEAN;

        -- La tâche existe?
    SET _flag = (SELECT 1 FROM task WHERE id_task = p_idTask);
    IF (_flag = 1) THEN
        SET _flag = NULL;
        -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
        SET _flag = (SELECT 1 FROM todo, task WHERE task.id_todo = todo.id_todo and id_task = p_idTask and id_user = p_idUser);
        IF(_flag = 1) THEN
            SET _flag = NULL;
            -- La tâche est elle déjà archivée?
            SET _flag = (SELECT 1 FROM task_archive WHERE id_task = p_idTask);
            IF(_flag = 1) THEN
                -- La tâche est déjà archivée, on la rétablie.
                SET _flag = NULL;
                -- Suppression de la log task_archive.
                DELETE FROM task_archive WHERE id_task = p_idTask;
                -- Mise a jour de l'état archive de la tâche.
                UPDATE task SET id_archived = NULL WHERE id_task = p_idTask;
                -- Message succes : Rétablissement de la tâche réussi.
                SET is_archived = FALSE;
                SELECT is_archived;
            ELSE
                -- Ajout d'une date dans taskarchive_date.
                INSERT INTO taskarchive_date VALUES ();
                -- Ajout dans la table de log des archive.
                INSERT INTO task_archive VALUES(last_insert_id(), p_idTask, p_idUser);
                -- Mise a jour de l'état archive de la tâche.
                UPDATE task SET id_archived = last_insert_id() WHERE id_task = p_idTask;
                -- Message succes : Archivage de la tâche réussi.
                SET is_archived = TRUE;
                SELECT is_archived;
            END IF;
        ELSE
            -- Le user n'est pas propriétaire.
                    
            -- A t'il les droits en archivage? - 4
            BEGIN
                DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = (SELECT task.id_todo FROM task, todo WHERE task.id_todo = todo.id_todo and id_task = p_idTask);
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                OPEN cursor_userPermission;

                loop_cursor_userPermission :LOOP
                    FETCH cursor_userPermission INTO _id_permission;
                    IF fin THEN
			            LEAVE loop_cursor_userPermission;
		            END IF;
                    -- Si l'_id_permission == 4 -> il a le droit en archive.
                    IF (_id_permission = 4) THEN
                        SET _flag = NULL;
                        -- La tâche est elle déjà archivée?
                        SET _flag = (SELECT 1 FROM task_archive WHERE id_task = p_idTask);
                        IF(_flag = 1) THEN
                            -- La tâche est déjà archivée, on la rétablie.
                            SET _flag = NULL;
                            -- Suppression de la log task_archive.
                            DELETE FROM task_archive WHERE id_task = p_idTask;
                            -- Mise a jour de l'état archive de la tâche.
                            UPDATE task SET id_archived = NULL WHERE id_task = p_idTask;
                            -- Message succes : Rétablissement de la tâche réussi.
                            SET is_archived = FALSE;
                            SELECT is_archived;
                        ELSE
                            -- Ajout d'une date dans taskarchive_date.
                            INSERT INTO taskarchive_date VALUES ();
                            -- Ajout dans la table de log des archive.
                            INSERT INTO task_archive VALUES(last_insert_id(), p_idTask, p_idUser);            
                            -- Mise a jour de l'état archive de la tâche.
                            UPDATE task SET id_archived = last_insert_id() WHERE id_task = p_idTask;
                            -- Message succes : Archivage de la tâche réussi.
                            SET is_archived = TRUE;
                            SELECT is_archived;
                        END IF;
                    END IF;

                END LOOP;

                CLOSE cursor_userPermission;

                IF(is_allowed = FALSE) THEN
                    -- Message d'erreur : Vous n'avez pas l'autorisation.
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation d'archiver une tâche.";
                END IF;

            END ;
        END IF;
    ELSE
        -- Message d'erreur : La todo n'existe pas.
        SIGNAL SQLSTATE '45000' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche n'existe pas.";
    END IF;

END$$

DROP PROCEDURE IF EXISTS `createTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `createTask` (IN `p_idUser` INT(11), IN `p_idTodo` INT(11), IN `p_titleTask` VARCHAR(255), IN `p_contentTask` VARCHAR(255), IN `p_enddateTask` DATE, IN `p_idPriority` INT(11))  BEGIN

    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE is_allowed BOOLEAN DEFAULT FALSE;
    DECLARE _flag  integer          default null;
    DECLARE _id_permission INT(11);
    DECLARE _id_task INT(11);

        -- La tâche existe?
    SET _flag = (SELECT 1 FROM todo WHERE id_todo = p_idTodo);
    IF (_flag = 1) THEN
        SET _flag = NULL;
        -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
        SET _flag = (SELECT 1 FROM todo WHERE id_todo = p_idTodo and id_user = p_idUser);
        IF(_flag = 1) THEN
            SET _flag = NULL;
            -- Il est propriétaire on effectue le create.
            INSERT INTO task (title_task, content_task, enddate_task, id_todo, id_priority) VALUES (p_titleTask, p_contentTask, p_enddateTask, p_idTodo, p_idPriority);
            SET _id_task = last_insert_id();
            -- Ajout d'une date dans taskcreate_date.
            INSERT INTO taskcreate_date VALUES ();
            -- Ajout dans la table de log des updates.
            INSERT INTO task_create VALUES(last_insert_id(), _id_task, p_idUser);
            -- Message succes : Création réussie.
        ELSE
            -- Le user n'est pas propriétaire.
                    
            -- A t'il les droits en creation? - 3
            BEGIN
                DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = p_idTodo;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                OPEN cursor_userPermission;

                loop_cursor_userPermission :LOOP
                    FETCH cursor_userPermission INTO _id_permission;
                    IF fin THEN
			            LEAVE loop_cursor_userPermission;
		            END IF;
                    -- Si l'_id_permission == 3 -> il a le droit en create.
                    IF (_id_permission = 3) THEN
                        -- Il a le droit : on effectue le create.
                        INSERT INTO task (title_task, content_task, enddate_task, id_todo, id_priority) VALUES (p_titleTask, p_contentTask, p_enddateTask, p_idTodo, p_idPriority);
                        SET _id_task = last_insert_id();
                        -- Ajout d'une date dans taskcreate_date.
                        INSERT INTO taskcreate_date VALUES ();
                        -- Ajout dans la table de log des updates.
                        INSERT INTO task_create VALUES(last_insert_id(), _id_task, p_idUser);
                        SET is_allowed = TRUE;
                        -- Message succes : Création réussie.
                    END IF;

                END LOOP;

                CLOSE cursor_userPermission;

                IF(is_allowed = FALSE) THEN
                    -- Message d'erreur : Vous n'avez pas l'autorisation.
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de créer une tâche.";
                END IF;
            END ;
            
        END IF;
    ELSE
        -- Message d'erreur : La todo n'existe pas.
        SIGNAL SQLSTATE '45000' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La todo n'existe pas.";
    END IF;

END$$

DROP PROCEDURE IF EXISTS `deleteTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11))  BEGIN

    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE is_allowed BOOLEAN DEFAULT FALSE;
    DECLARE _flag  integer          default null;

    -- La tâche existe?
    SET _flag = (SELECT 1 FROM task WHERE id_task = p_idTask);
    IF (_flag = 1) THEN
        SET _flag = NULL;
        -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
        SET _flag = (SELECT 1 FROM todo, task WHERE task.id_todo = todo.id_todo and id_task = p_idTask and id_user = p_idUser);
        IF(_flag = 1) THEN
            SET _flag = NULL;
            -- La tâche est elle déjà archivée?
            SET _flag = (SELECT 1 FROM task_archive WHERE id_task = p_idTask);
            IF(_flag = 1) THEN
                -- La tâche est déjà archivée, on la supprime.
                SET _flag = NULL;
                -- Suppression de la tâche.
                DELETE FROM task WHERE id_task = p_idTask;
                -- Message succes : Suppression de la tâche réussie.
            ELSE
                -- Message d'erreur : La tâche n'est pas archivée.
                SIGNAL SQLSTATE '45000' 
		        SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche n'est pas archivée.";
            END IF;
        ELSE
            -- Message d'erreur : Vous n'avez pas l'autorisation de supprimer une tâche.
            SIGNAL SQLSTATE '45000' 
		    SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de supprimer une tâche.";
        END IF;
    ELSE
        -- Message d'erreur : La todo n'existe pas.
        SIGNAL SQLSTATE '45000' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche n'existe pas.";
    END IF;

END$$

DROP PROCEDURE IF EXISTS `processCheckToken`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `processCheckToken` (IN `p_token` VARCHAR(255), IN `p_idUser` INT(11))  BEGIN
    DECLARE _flag integer default NULL;

    DECLARE _expirationdate_token TIMESTAMP;
    DECLARE _id_permission INT(10);
    DECLARE _id_todo INT(10);
    -- Cursor qui récupère les informations de la token.
    DECLARE cursor_selectToken CURSOR FOR SELECT expirationdate, id_permission, id_todo FROM todo_token WHERE token = p_token;

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
		    SET MYSQL_ERRNO = 10003, MESSAGE_TEXT = "Le token a expirée.";
        ELSE
            -- Verification que la personne ne contribue pas déjà à cette TODO.
            set _flag = (SELECT 1 FROM contribute WHERE id_user = p_idUser and id_todo = _id_todo and id_permission = _id_permission);
            -- Si c'est le cas :
            IF(_flag = 1) THEN
                -- Verification que le user existe bien
                set _flag = (SELECT 1 FROM user WHERE id_user = p_idUser);
                IF(_flag = 1) THEN
                    -- Message d'erreur : Vous participer déjà à cette todo
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10004, MESSAGE_TEXT = "Vous participez déjà à cette todo avec cette permission.";
                ELSE
                    -- Message d'erreur : Le user n'existe pas.
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10005, MESSAGE_TEXT = "Le user n'existe pas.";
                END IF;
            ELSE
                SET _flag = NULL;
                -- La personne ne contribue pas dèjà à la TODO, alors on verifie qu'elle n'est pas propriétaire
                SET _flag = (SELECT 1 FROM todo WHERE id_user = p_idUser and id_todo = _id_todo);
                IF(_flag = 1) THEN
                    -- Message d'erreur : Vous êtes le propriétaire de cette todo
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10006, MESSAGE_TEXT = "Vous êtes le propriétaire de cette todo.";
                ELSE
                    -- Ajout dans la table contribute de la nouvelle ligne de contribution
                    INSERT INTO contribute (id_user, id_permission, id_todo) VALUES (p_idUser, _id_permission, _id_todo);
                    -- Suppression du token.
                    DELETE FROM todo_token WHERE token = p_token;
                    -- Message de réussite : Succès de la procédure.
                END IF;
            END IF;
        END IF;
    ELSE
        -- Message d'erreur : Le token n'est pas valide
        SIGNAL SQLSTATE '45000' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Le token n'est pas valide.";
    END IF;
END$$

DROP PROCEDURE IF EXISTS `selectTodo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `selectTodo` (IN `p_idUser` INT(11))  BEGIN
    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE _id_todo INT(11);
    DECLARE _title_todo VARCHAR(255);
    DECLARE _description_todo TEXT;
    DECLARE _createdate_todo DATETIME;
    DECLARE _id_icon INT(11);

    DECLARE cursor_selectTodoUser CURSOR FOR SELECT id_todo, title_todo, description_todo, createdate_todo, id_icon FROM todo WHERE id_user = p_idUser;
    DECLARE cursor_selectTodoContribute CURSOR FOR SELECT todo.id_todo, title_todo, description_todo, createdate_todo, id_icon FROM contribute, todo WHERE todo.id_todo = contribute.id_todo and accepted_contribute = 1 and contribute.id_user = p_idUser;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 

    DROP TEMPORARY TABLE IF EXISTS TMP_TODO;
	CREATE TEMPORARY TABLE TMP_TODO(
		id_todo INT PRIMARY KEY,
		title_todo VARCHAR(255),
		description_todo VARCHAR(255),
		createdate_todo DATETIME,
		id_icon INT
	); 

    OPEN cursor_selectTodoUser;

    loop_cursor_selectTodoUser:LOOP
        FETCH cursor_selectTodoUser INTO _id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon;
        IF fin THEN
			LEAVE loop_cursor_selectTodoUser;
		END IF;
        INSERT INTO TMP_TODO VALUES(_id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon);
    END LOOP;

    SET fin = FALSE;
    CLOSE cursor_selectTodoUser;

    OPEN cursor_selectTodoContribute;

    cursor_selectTodoContribute:LOOP
        FETCH cursor_selectTodoContribute INTO _id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon;
        IF fin THEN
			LEAVE cursor_selectTodoContribute;
		END IF;
        INSERT INTO TMP_TODO VALUES(_id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon);
    END LOOP;

    CLOSE cursor_selectTodoContribute;

    SELECT * FROM TMP_TODO;

END$$

DROP PROCEDURE IF EXISTS `selectTodoContribute`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `selectTodoContribute` (IN `p_idUser` INT(11))  BEGIN 

    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE flag integer default null;
    DECLARE _id_todo integer;
    DECLARE _accepted_contribute TINYINT;
    DECLARE _joindate_contribute DATETIME;
    DECLARE _id_permission integer;
    DECLARE cursor_selectContribute CURSOR FOR SELECT id_todo, accepted_contribute, joindate_contribute, id_permission FROM contribute WHERE id_user = p_idUser;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE;

    DROP TEMPORARY TABLE IF EXISTS TMP_TODOCONTRIBUTE;
	CREATE TEMPORARY TABLE TMP_TODOCONTRIBUTE(
		_id_todo INT,
        _accepted_contribute TINYINT,
        _joindate_contribute DATETIME,
        _id_permission INT
	); 

    OPEN cursor_selectContribute;

    loop_cursor_selectContribute:LOOP
        FETCH cursor_selectContribute INTO _id_todo, _accepted_contribute, _joindate_contribute, _id_permission;
        IF fin THEN
            LEAVE loop_cursor_selectContribute;
        END IF;

        INSERT INTO TMP_TODOCONTRIBUTE VALUES(_id_todo, _accepted_contribute, _joindate_contribute, _id_permission);
    END LOOP;

    CLOSE cursor_selectContribute;

END$$

DROP PROCEDURE IF EXISTS `updateTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11), IN `p_value` VARCHAR(255), IN `p_updateLabel` VARCHAR(255))  BEGIN

    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE is_allowed BOOLEAN DEFAULT FALSE;
    DECLARE _flag  integer          default null;
    DECLARE _id_permission INT(11);
    DECLARE _id_todo INT(11);

    -- La tâche existe?
    SET _flag = (SELECT 1 FROM task WHERE id_task = p_idTask);
    IF (_flag = 1) THEN
        SET _flag = NULL;
        -- La tâche est elle archivé?
        SET _flag = (SELECT 1 FROM task_archive WHERE id_task = p_idTask);
        IF (_flag = 1) THEN
            -- Message d'erreur : La tâche est archivé.
            SIGNAL SQLSTATE '45000' 
		    SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche est archivée.";
        ELSE
            SET _flag = NULL;
            -- La tâche n'est pas archivé
            -- Récupération de l'_id_todo   
            SET _id_todo = (SELECT id_todo FROM task WHERE id_task = p_idTask);

            -- Que doit on modifier?
            CASE p_updateLabel
                WHEN 'title' THEN
                    -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
                    SET _flag = (SELECT 1 FROM todo WHERE id_todo = _id_todo and id_user = p_idUser);
                    IF(_flag = 1) THEN
                        -- Il est propriétaire on effectue l'update.
                        -- Ajout d'une date dans taskupdate_date.
                        INSERT INTO taskupdate_date VALUES ();
                        -- Ajout dans la table de log des updates.
                        INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                        UPDATE task SET title_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                        -- Message succes : Modification réussie.
                    ELSE
                        -- Le user n'est pas propriétaire.
                    
                        -- A t'il les droits en modification? - 2
                        BEGIN
                            DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = _id_todo;
                            DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                            OPEN cursor_userPermission;

                            loop_cursor_userPermission :LOOP
                                FETCH cursor_userPermission INTO _id_permission;
                                IF fin THEN
			                        LEAVE loop_cursor_userPermission;
		                        END IF;
                                -- Si l'_id_permission == 2 -> il a le droit en update.
                                IF (_id_permission = 2) THEN
                                    -- Il a le droit : on effectue l'update.
                                    -- Ajout d'une date dans taskupdate_date.
                                    INSERT INTO taskupdate_date VALUES ();
                                    -- Ajout dans la table de log des updates.
                                    INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                                    UPDATE task SET title_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                                    SET is_allowed = TRUE;
                                    -- Message succes : Modification réussie.
                                END IF;

                            END LOOP;

                            IF(is_allowed = FALSE) THEN
                                -- Message d'erreur : Vous n'avez pas l'autorisation.
                                SIGNAL SQLSTATE '45000' 
		                        SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de modifier une tâche.";
                            END IF;

                        END ;

                    END IF;

                WHEN 'content' THEN
                                    -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
                    SET _flag = (SELECT 1 FROM todo WHERE id_todo = _id_todo and id_user = p_idUser);
                    IF(_flag = 1) THEN
                        -- Il est propriétaire on effectue l'update.
                        -- Ajout d'une date dans taskupdate_date.
                        INSERT INTO taskupdate_date VALUES ();
                        -- Ajout dans la table de log des updates.
                        INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                        UPDATE task SET content_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                        -- Message succes : Modification réussie.
                    ELSE
                        -- Le user n'est pas propriétaire.
                    
                        -- A t'il les droits en modification? - 2
                        BEGIN
                            DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = _id_todo;
                            DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                            OPEN cursor_userPermission;

                            loop_cursor_userPermission :LOOP
                                FETCH cursor_userPermission INTO _id_permission;
                                IF fin THEN
			                        LEAVE loop_cursor_userPermission;
		                        END IF;
                                -- Si l'_id_permission == 2 -> il a le droit en update.
                                IF (_id_permission = 2) THEN
                                    -- Il a le droit : on effectue l'update.
                                    -- Ajout d'une date dans taskupdate_date.
                                    INSERT INTO taskupdate_date VALUES ();
                                    -- Ajout dans la table de log des updates.
                                    INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                                    UPDATE task SET content_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                                    SET is_allowed = TRUE;
                                    -- Message succes : Modification réussie.
                                END IF;

                            END LOOP;

                            IF(is_allowed = FALSE) THEN
                                -- Message d'erreur : Vous n'avez pas l'autorisation.
                                SIGNAL SQLSTATE '45000' 
		                        SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de modifier une tâche.";
                            END IF;

                        END ;
                    END IF;

                WHEN 'achieved' THEN
                                    -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
                    SET _flag = (SELECT 1 FROM todo WHERE id_todo = _id_todo and id_user = p_idUser);
                    IF(_flag = 1) THEN
                        -- Il est propriétaire on effectue l'update.
                        -- Ajout d'une date dans taskupdate_date.
                        INSERT INTO taskupdate_date VALUES ();
                        -- Ajout dans la table de log des updates.
                        INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                        UPDATE task SET achieved_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                        -- Message succes : Modification réussie.
                    ELSE
                        -- Le user n'est pas propriétaire.
                    
                        -- A t'il les droits en modification? - 2
                        BEGIN

                            DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = _id_todo;
                            DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                            OPEN cursor_userPermission;

                            loop_cursor_userPermission :LOOP
                                FETCH cursor_userPermission INTO _id_permission;
                                IF fin THEN
			                        LEAVE loop_cursor_userPermission;
		                        END IF;
                                -- Si l'_id_permission == 1 -> il a le droit en update_achieved.
                                IF (_id_permission = 1) THEN
                                    -- Il a le droit : on effectue l'update.
                                    -- Ajout d'une date dans taskupdate_date.
                                    INSERT INTO taskupdate_date VALUES ();
                                    -- Ajout dans la table de log des updates.
                                    INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                                    UPDATE task SET achieved_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                                    SET is_allowed = TRUE;
                                    -- Message succes : Modification réussie.
                                END IF;

                            END LOOP;

                            IF(is_allowed = FALSE) THEN
                                -- Message d'erreur : Vous n'avez pas l'autorisation.
                                SIGNAL SQLSTATE '45000' 
		                        SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de modifier une tâche.";
                            END IF;

                        END ;
                    END IF;

                WHEN 'enddate' THEN
                                    -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
                    SET _flag = (SELECT 1 FROM todo WHERE id_todo = _id_todo and id_user = p_idUser);
                    IF(_flag = 1) THEN
                        -- Il est propriétaire on effectue l'update.
                        -- Ajout d'une date dans taskupdate_date.
                        INSERT INTO taskupdate_date VALUES ();
                        -- Ajout dans la table de log des updates.
                        INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                        UPDATE task SET enddate_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                        -- Message succes : Modification réussie.
                    ELSE
                        -- Le user n'est pas propriétaire.
                    
                        -- A t'il les droits en modification? - 2
                        BEGIN

                            DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = _id_todo;
                            DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                            OPEN cursor_userPermission;

                            loop_cursor_userPermission :LOOP
                                FETCH cursor_userPermission INTO _id_permission;
                                IF fin THEN
			                        LEAVE loop_cursor_userPermission;
		                        END IF;
                                -- Si l'_id_permission == 1 -> il a le droit en update_achieved.
                                IF (_id_permission = 1) THEN
                                    -- Il a le droit : on effectue l'update.
                                    -- Ajout d'une date dans taskupdate_date.
                                    INSERT INTO taskupdate_date VALUES ();
                                    -- Ajout dans la table de log des updates.
                                    INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                                    UPDATE task SET enddate_task = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                                    SET is_allowed = TRUE;
                                    -- Message succes : Modification réussie.
                                END IF;

                            END LOOP;

                            IF(is_allowed = FALSE) THEN
                                -- Message d'erreur : Vous n'avez pas l'autorisation.
                                SIGNAL SQLSTATE '45000' 
		                        SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de modifier une tâche.";
                            END IF;

                        END ;
                    END IF;

                WHEN 'priority' THEN
                    -- Est il propriétaire? -> Pour la todo donné le id_user lié est il == à celui du user.
                    SET _flag = (SELECT 1 FROM todo WHERE id_todo = _id_todo and id_user = p_idUser);
                    IF(_flag = 1) THEN
                        -- Il est propriétaire on effectue l'update.
                        -- Ajout d'une date dans taskupdate_date.
                        INSERT INTO taskupdate_date VALUES ();
                        -- Ajout dans la table de log des updates.
                        INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                        UPDATE task SET id_priority = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                        -- Message succes : Modification réussie.
                    ELSE
                        -- Le user n'est pas propriétaire.
                    
                        -- A t'il les droits en modification? - 2
                        BEGIN

                            DECLARE cursor_userPermission CURSOR FOR SELECT id_permission FROM contribute WHERE id_user = p_idUser and id_todo = _id_todo;
                            DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 
                            OPEN cursor_userPermission;

                            loop_cursor_userPermission :LOOP
                                FETCH cursor_userPermission INTO _id_permission;
                                IF fin THEN
			                        LEAVE loop_cursor_userPermission;
		                        END IF;
                                -- Si l'_id_permission == 1 -> il a le droit en update_achieved.
                                IF (_id_permission = 1) THEN
                                    -- Il a le droit : on effectue l'update.
                                    -- Ajout d'une date dans taskupdate_date.
                                    INSERT INTO taskupdate_date VALUES ();
                                    -- Ajout dans la table de log des updates.
                                    INSERT INTO task_update VALUES(last_insert_id(), p_idTask, p_idUser);
                                    UPDATE task SET id_priority = p_value WHERE id_todo = _id_todo and id_task = p_idTask;
                                    SET is_allowed = TRUE;
                                    -- Message succes : Modification réussie.
                                END IF;

                            END LOOP;

                            CLOSE cursor_userPermission;

                            IF(is_allowed = FALSE) THEN
                                -- Message d'erreur : Vous n'avez pas l'autorisation.
                                SIGNAL SQLSTATE '45000' 
		                        SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de modifier une tâche.";
                            END IF;

                        END ;
                    END IF;
                ELSE
                    -- Message d'erreur : L'attribut est inconnu.
                    SIGNAL SQLSTATE '45000' 
		            SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "L'attribut est inconnu.";
            END CASE;
        END IF;
    ELSE
        -- Message d'erreur : La tâche est inconnue.
        SIGNAL SQLSTATE '45000' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche est inconnue.";
    END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `contribute`
--

DROP TABLE IF EXISTS `contribute`;
CREATE TABLE IF NOT EXISTS `contribute` (
  `accepted_contribute` tinyint(4) NOT NULL DEFAULT '0',
  `joindate_contribute` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_todo` int(11) NOT NULL,
  `id_permission` int(11) NOT NULL,
  PRIMARY KEY (`id_user`,`id_todo`,`id_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contribute`
--

INSERT INTO `contribute` (`accepted_contribute`, `joindate_contribute`, `id_user`, `id_todo`, `id_permission`) VALUES
(0, '2021-03-16 15:08:13', 1, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id_permission` int(11) NOT NULL AUTO_INCREMENT,
  `label_permission` varchar(255) NOT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`id_permission`, `label_permission`) VALUES
(1, 'ACHIEVED_UPDATE'),
(2, 'INFO_UPDATE'),
(3, 'CREATE'),
(4, 'ARCHIVE');

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id_task` int(11) NOT NULL AUTO_INCREMENT,
  `title_task` varchar(255) NOT NULL,
  `content_task` text NOT NULL,
  `achieved_task` tinyint(4) NOT NULL DEFAULT '0',
  `enddate_task` date NOT NULL,
  `id_todo` int(11) NOT NULL,
  `id_priority` int(11) NOT NULL,
  `id_archived` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_task`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id_task`, `title_task`, `content_task`, `achieved_task`, `enddate_task`, `id_todo`, `id_priority`, `id_archived`) VALUES
(8, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, 24),
(9, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 1, 1, NULL),
(10, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `taskachieve_date`
--

DROP TABLE IF EXISTS `taskachieve_date`;
CREATE TABLE IF NOT EXISTS `taskachieve_date` (
  `id_achieve` int(11) NOT NULL AUTO_INCREMENT,
  `date_achieve` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_achieve`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taskachieve_date`
--

INSERT INTO `taskachieve_date` (`id_achieve`, `date_achieve`) VALUES
(1, '2021-03-09 23:43:20'),
(2, '2021-03-10 19:22:14'),
(3, '2021-03-10 19:22:24'),
(4, '2021-03-10 19:30:00'),
(5, '2021-03-10 19:30:17'),
(6, '2021-03-10 20:28:29'),
(7, '2021-03-10 20:30:49'),
(8, '2021-03-10 20:32:07'),
(9, '2021-03-10 20:35:28'),
(10, '2021-03-10 20:36:17'),
(11, '2021-03-10 20:37:25'),
(12, '2021-03-10 20:38:07'),
(13, '2021-03-10 20:38:58'),
(14, '2021-03-10 20:40:45'),
(15, '2021-03-10 20:42:18'),
(16, '2021-03-10 20:44:34'),
(17, '2021-03-10 20:44:38'),
(18, '2021-03-10 20:47:00'),
(19, '2021-03-10 20:47:14'),
(20, '2021-03-10 20:47:51'),
(21, '2021-03-10 20:48:06'),
(22, '2021-03-10 20:48:27'),
(23, '2021-03-10 20:48:29'),
(24, '2021-03-10 20:48:30'),
(25, '2021-03-10 21:51:42'),
(26, '2021-03-10 21:51:59'),
(27, '2021-03-10 21:52:59'),
(28, '2021-03-10 21:53:58'),
(29, '2021-03-10 21:54:03'),
(30, '2021-03-10 21:54:07'),
(31, '2021-03-10 21:54:08'),
(32, '2021-03-10 21:54:11'),
(33, '2021-03-10 21:54:18'),
(34, '2021-03-10 21:54:24'),
(35, '2021-03-10 21:54:44'),
(36, '2021-03-14 21:58:30'),
(37, '2021-03-14 21:58:34'),
(38, '2021-03-14 21:58:38'),
(39, '2021-03-14 21:59:01'),
(40, '2021-03-14 21:59:03'),
(41, '2021-03-14 21:59:08'),
(42, '2021-03-14 21:59:44'),
(43, '2021-03-14 21:59:45'),
(44, '2021-03-14 21:59:47'),
(45, '2021-03-14 21:59:52'),
(46, '2021-03-14 21:59:53'),
(47, '2021-03-14 22:00:54'),
(48, '2021-03-14 22:00:59'),
(49, '2021-03-14 22:01:06'),
(50, '2021-03-14 22:59:52'),
(51, '2021-03-14 23:19:27'),
(52, '2021-03-14 23:19:30'),
(53, '2021-03-14 23:19:30'),
(54, '2021-03-14 23:23:30'),
(55, '2021-03-14 23:25:00'),
(56, '2021-03-14 23:25:07'),
(57, '2021-03-14 23:25:12'),
(58, '2021-03-14 23:25:22'),
(59, '2021-03-14 23:25:31'),
(60, '2021-03-14 23:26:19'),
(61, '2021-03-14 23:26:47'),
(62, '2021-03-14 23:26:50'),
(63, '2021-03-14 23:26:51'),
(64, '2021-03-14 23:26:52'),
(65, '2021-03-14 23:26:53'),
(66, '2021-03-14 23:26:54'),
(67, '2021-03-14 23:26:54'),
(68, '2021-03-14 23:26:55'),
(69, '2021-03-14 23:27:01'),
(70, '2021-03-14 23:27:03'),
(71, '2021-03-14 23:27:03'),
(72, '2021-03-14 23:27:04'),
(73, '2021-03-14 23:27:05'),
(74, '2021-03-14 23:27:06'),
(75, '2021-03-14 23:27:06'),
(76, '2021-03-14 23:27:07'),
(77, '2021-03-14 23:27:08'),
(78, '2021-03-14 23:27:09'),
(79, '2021-03-14 23:27:10'),
(80, '2021-03-14 23:27:11'),
(81, '2021-03-14 23:27:11'),
(82, '2021-03-14 23:27:12'),
(83, '2021-03-14 23:27:14'),
(84, '2021-03-14 23:27:14'),
(85, '2021-03-14 23:27:14'),
(86, '2021-03-14 23:27:15'),
(87, '2021-03-14 23:27:16'),
(88, '2021-03-14 23:27:16'),
(89, '2021-03-14 23:27:17'),
(90, '2021-03-14 23:27:17'),
(91, '2021-03-14 23:27:19'),
(92, '2021-03-14 23:27:19'),
(93, '2021-03-14 23:27:19'),
(94, '2021-03-14 23:27:20'),
(95, '2021-03-14 23:27:21'),
(96, '2021-03-14 23:27:21'),
(97, '2021-03-14 23:27:21'),
(98, '2021-03-14 23:27:22'),
(99, '2021-03-14 23:27:25'),
(100, '2021-03-14 23:27:26'),
(101, '2021-03-14 23:27:26'),
(102, '2021-03-14 23:27:26'),
(103, '2021-03-14 23:27:27'),
(104, '2021-03-14 23:27:29'),
(105, '2021-03-14 23:27:29'),
(106, '2021-03-14 23:28:18'),
(107, '2021-03-14 23:28:18'),
(108, '2021-03-14 23:28:18'),
(109, '2021-03-14 23:28:19'),
(110, '2021-03-14 23:28:19'),
(111, '2021-03-14 23:28:19'),
(112, '2021-03-14 23:28:20'),
(113, '2021-03-14 23:28:20'),
(114, '2021-03-14 23:28:20'),
(115, '2021-03-14 23:28:21'),
(116, '2021-03-14 23:28:21'),
(117, '2021-03-14 23:28:21'),
(118, '2021-03-14 23:28:22'),
(119, '2021-03-14 23:28:22'),
(120, '2021-03-14 23:28:22'),
(121, '2021-03-14 23:28:23'),
(122, '2021-03-14 23:28:23'),
(123, '2021-03-14 23:28:23'),
(124, '2021-03-14 23:28:24'),
(125, '2021-03-14 23:28:25'),
(126, '2021-03-14 23:28:25'),
(127, '2021-03-14 23:28:26'),
(128, '2021-03-14 23:36:42'),
(129, '2021-03-14 23:37:03'),
(130, '2021-03-14 23:37:20'),
(131, '2021-03-14 23:40:54'),
(132, '2021-03-14 23:42:08'),
(133, '2021-03-14 23:46:42'),
(134, '2021-03-14 23:48:17'),
(135, '2021-03-14 23:48:18'),
(136, '2021-03-14 23:48:19'),
(137, '2021-03-14 23:48:21'),
(138, '2021-03-14 23:48:23'),
(139, '2021-03-14 23:48:23'),
(140, '2021-03-15 00:04:46'),
(141, '2021-03-15 00:04:47'),
(142, '2021-03-15 00:05:10'),
(143, '2021-03-15 00:05:13'),
(144, '2021-03-15 00:05:14'),
(145, '2021-03-15 00:05:15'),
(146, '2021-03-15 00:23:45'),
(147, '2021-03-15 00:24:15'),
(148, '2021-03-15 00:24:22'),
(149, '2021-03-15 00:24:37'),
(150, '2021-03-15 00:24:39'),
(151, '2021-03-15 00:24:44'),
(152, '2021-03-15 00:25:46'),
(153, '2021-03-15 00:25:47'),
(154, '2021-03-15 00:25:50'),
(155, '2021-03-15 00:25:52'),
(156, '2021-03-15 00:25:54'),
(157, '2021-03-15 00:25:56'),
(158, '2021-03-15 00:25:57'),
(159, '2021-03-15 00:26:00'),
(160, '2021-03-15 00:26:00'),
(161, '2021-03-15 00:26:01'),
(162, '2021-03-15 00:26:02'),
(163, '2021-03-15 00:26:06'),
(164, '2021-03-15 11:45:18'),
(165, '2021-03-15 11:45:21');

-- --------------------------------------------------------

--
-- Structure de la table `taskarchive_date`
--

DROP TABLE IF EXISTS `taskarchive_date`;
CREATE TABLE IF NOT EXISTS `taskarchive_date` (
  `id_archive` int(11) NOT NULL AUTO_INCREMENT,
  `date_archive` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_archive`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taskarchive_date`
--

INSERT INTO `taskarchive_date` (`id_archive`, `date_archive`) VALUES
(1, '2021-02-24 11:45:50'),
(2, '2021-02-13 16:26:39'),
(3, '2021-02-24 19:30:32'),
(4, '2021-02-24 19:31:59'),
(5, '2021-02-24 19:32:56'),
(6, '2021-02-24 19:33:35'),
(7, '2021-02-24 19:35:36'),
(8, '2021-02-24 19:35:40'),
(9, '2021-02-24 19:36:53'),
(10, '2021-02-24 22:06:59'),
(11, '2021-02-24 22:07:28'),
(12, '2021-02-24 22:08:21'),
(13, '2021-02-24 22:09:06'),
(14, '2021-02-24 22:09:39'),
(15, '2021-02-24 22:11:05'),
(16, '2021-02-24 22:11:28'),
(17, '2021-02-24 22:13:18'),
(18, '2021-02-24 22:14:03'),
(19, '2021-02-24 22:16:21'),
(20, '2021-02-24 22:16:26'),
(21, '2021-02-24 22:16:46'),
(22, '2021-02-24 22:17:02'),
(23, '2021-03-10 21:52:43'),
(24, '2021-03-15 00:26:23');

-- --------------------------------------------------------

--
-- Structure de la table `taskcreate_date`
--

DROP TABLE IF EXISTS `taskcreate_date`;
CREATE TABLE IF NOT EXISTS `taskcreate_date` (
  `id_create` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_create`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taskcreate_date`
--

INSERT INTO `taskcreate_date` (`id_create`, `date_create`) VALUES
(1, '2021-02-22 13:16:38'),
(2, '2021-02-22 13:20:48'),
(3, '2021-02-22 13:21:48'),
(4, '2021-02-24 11:51:14'),
(5, '2021-02-24 11:52:02'),
(6, '2021-02-24 11:53:24'),
(7, '2021-02-24 12:00:04'),
(8, '2021-02-26 16:54:29');

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
(1, 'A FAIRE', '#5C7AFF'),
(2, 'URGENT', '#F25F5C'),
(3, 'TERMINE', '#FFFFFF');

-- --------------------------------------------------------

--
-- Structure de la table `taskupdate_date`
--

DROP TABLE IF EXISTS `taskupdate_date`;
CREATE TABLE IF NOT EXISTS `taskupdate_date` (
  `id_update` int(11) NOT NULL AUTO_INCREMENT,
  `date_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_update`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taskupdate_date`
--

INSERT INTO `taskupdate_date` (`id_update`, `date_update`) VALUES
(1, '2021-02-16 22:32:49'),
(2, '2021-02-16 22:34:54'),
(3, '2021-02-16 22:35:21'),
(4, '2021-02-16 22:37:40'),
(5, '2021-02-16 22:37:46'),
(6, '2021-02-16 22:37:58'),
(7, '2021-02-16 22:44:38'),
(8, '2021-02-16 22:45:24'),
(9, '2021-02-24 11:37:37'),
(10, '2021-02-24 11:38:18'),
(11, '2021-02-24 11:38:36'),
(12, '2021-02-24 11:38:51'),
(13, '2021-02-24 11:46:57'),
(14, '2021-02-24 12:59:51'),
(15, '2021-02-24 12:59:57'),
(16, '2021-02-24 16:02:31'),
(17, '2021-02-24 16:03:09'),
(18, '2021-02-24 16:03:27'),
(19, '2021-02-24 16:04:14'),
(20, '2021-02-24 16:04:22'),
(21, '2021-03-08 13:31:02'),
(22, '2021-03-08 13:31:11');

-- --------------------------------------------------------

--
-- Structure de la table `task_achieve`
--

DROP TABLE IF EXISTS `task_achieve`;
CREATE TABLE IF NOT EXISTS `task_achieve` (
  `id_date` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_date`,`id_task`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task_archive`
--

DROP TABLE IF EXISTS `task_archive`;
CREATE TABLE IF NOT EXISTS `task_archive` (
  `id_date` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_date`,`id_task`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task_archive`
--

INSERT INTO `task_archive` (`id_date`, `id_task`, `id_user`) VALUES
(24, 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `task_create`
--

DROP TABLE IF EXISTS `task_create`;
CREATE TABLE IF NOT EXISTS `task_create` (
  `id_date` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_date`,`id_task`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task_create`
--

INSERT INTO `task_create` (`id_date`, `id_task`, `id_user`) VALUES
(2, 2, 1),
(3, 3, 2),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `task_update`
--

DROP TABLE IF EXISTS `task_update`;
CREATE TABLE IF NOT EXISTS `task_update` (
  `id_date` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_date`,`id_task`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task_update`
--

INSERT INTO `task_update` (`id_date`, `id_task`, `id_user`) VALUES
(1, 1, 2),
(2, 1, 2),
(3, 1, 2),
(4, 1, 2),
(5, 1, 2),
(6, 1, 2),
(7, 1, 2),
(8, 1, 2),
(9, 3, 1),
(10, 3, 1),
(11, 3, 1),
(12, 3, 1),
(13, 3, 1),
(14, 3, 2),
(15, 3, 2),
(16, 3, 2),
(17, 3, 2),
(18, 3, 2),
(19, 3, 2),
(20, 3, 2),
(21, 8, 2),
(22, 8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `todo`
--

DROP TABLE IF EXISTS `todo`;
CREATE TABLE IF NOT EXISTS `todo` (
  `id_todo` int(11) NOT NULL AUTO_INCREMENT,
  `title_todo` varchar(255) NOT NULL,
  `description_todo` text NOT NULL,
  `createdate_todo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_icon` int(11) NOT NULL,
  PRIMARY KEY (`id_todo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `todo`
--

INSERT INTO `todo` (`id_todo`, `title_todo`, `description_todo`, `createdate_todo`, `id_user`, `id_icon`) VALUES
(1, 'coucou', 'sdfsdfsdf', '2021-02-14 23:56:54', 1, 2),
(3, 'rgrg', 'fdgdfgdfgdfg', '2021-02-24 16:27:01', 2, 2),
(4, 'Courses', 'Faire les courses', '2021-03-16 14:52:21', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `todo_icon`
--

DROP TABLE IF EXISTS `todo_icon`;
CREATE TABLE IF NOT EXISTS `todo_icon` (
  `id_icon` int(11) NOT NULL AUTO_INCREMENT,
  `label_icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id_icon`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `todo_icon`
--

INSERT INTO `todo_icon` (`id_icon`, `label_icon`) VALUES
(1, 'home'),
(2, 'party'),
(3, 'personal'),
(4, 'shopping'),
(5, 'travel'),
(6, 'work');

-- --------------------------------------------------------

--
-- Structure de la table `todo_token`
--

DROP TABLE IF EXISTS `todo_token`;
CREATE TABLE IF NOT EXISTS `todo_token` (
  `token` varchar(500) NOT NULL,
  `expirationdate` datetime NOT NULL,
  `id_permission` int(11) NOT NULL,
  `id_todo` int(11) NOT NULL,
  PRIMARY KEY (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `todo_token`
--

INSERT INTO `todo_token` (`token`, `expirationdate`, `id_permission`, `id_todo`) VALUES
('YqzNDM', '2021-03-08 00:35:54', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(255) NOT NULL,
  `firstname_user` varchar(255) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `createdate_user` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `firstname_user`, `email_user`, `password_user`, `createdate_user`) VALUES
(1, 'Testeur', 'Le Test', 'testEmail@gmail.com', 'test', '2021-02-16 22:55:31'),
(2, 'Lecat', 'Baptiste', 'baptiste.lecat44@gmail.com', 'baptiste24', '2021-02-16 22:55:31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
