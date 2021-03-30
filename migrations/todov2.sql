-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 29 mars 2021 à 22:14
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
CREATE PROCEDURE `achieveTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11))  BEGIN

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
CREATE PROCEDURE `archiveTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11))  BEGIN

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
CREATE PROCEDURE `createTask` (IN `p_idUser` INT(11), IN `p_idTodo` INT(11), IN `p_titleTask` VARCHAR(255), IN `p_contentTask` VARCHAR(255), IN `p_enddateTask` DATE, IN `p_idPriority` INT(11))  BEGIN

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
CREATE PROCEDURE `deleteTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11))  BEGIN

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
CREATE PROCEDURE `processCheckToken` (IN `p_token` VARCHAR(255), IN `p_idUser` INT(11))  BEGIN
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
CREATE PROCEDURE `selectTodo` (IN `p_idUser` INT(11))  BEGIN
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
CREATE PROCEDURE `selectTodoContribute` (IN `p_idUser` INT(11))  BEGIN 

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
CREATE PROCEDURE `updateTask` (IN `p_idUser` INT(11), IN `p_idTask` INT(11), IN `p_value` VARCHAR(255), IN `p_updateLabel` VARCHAR(255))  BEGIN

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
  PRIMARY KEY (`id_user`,`id_todo`,`id_permission`),
  KEY `constraint_idContributeTodo` (`id_todo`),
  KEY `constraint_idContributePermission` (`id_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contribute`
--

INSERT INTO `contribute` (`accepted_contribute`, `joindate_contribute`, `id_user`, `id_todo`, `id_permission`) VALUES
(0, '2021-03-16 15:08:13', 1, 3, 4),
(0, '2021-03-28 23:28:54', 3, 1, 2),
(0, '2021-03-28 23:28:32', 4, 1, 1),
(0, '2021-03-16 15:08:13', 4, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id_permission` int(11) NOT NULL AUTO_INCREMENT,
  `label_permission` varchar(255) NOT NULL,
  `content_permission` text NOT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`id_permission`, `label_permission`, `content_permission`) VALUES
(1, 'ACHIEVED_UPDATE', 'Réaliser une tâche'),
(2, 'INFO_UPDATE', 'Modifier les informations d\'une tâche'),
(3, 'CREATE', 'Ajouter une nouvelle tâche'),
(4, 'ARCHIVE', 'Archiver une tâche');

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
  PRIMARY KEY (`id_task`),
  KEY `constraint_idPriority` (`id_priority`),
  KEY `constraint_idArchived` (`id_archived`),
  KEY `constraint_idTaskTodo` (`id_todo`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id_task`, `title_task`, `content_task`, `achieved_task`, `enddate_task`, `id_todo`, `id_priority`, `id_archived`) VALUES
(8, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 3, 56),
(9, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-27', 1, 3, NULL),
(10, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 3, NULL),
(11, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, 54),
(12, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-26', 3, 1, 55),
(13, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(14, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(15, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(16, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(17, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 3, NULL),
(18, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 3, NULL),
(19, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 3, NULL),
(20, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(21, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(22, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(23, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(24, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(25, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(26, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 3, NULL),
(27, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 3, NULL),
(28, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(29, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(30, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(31, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(32, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(33, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(34, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(35, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, NULL),
(36, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(37, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(38, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(39, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(40, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(41, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(42, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(43, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(44, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, NULL),
(45, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(46, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(47, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(48, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(49, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(50, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(51, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(52, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(53, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, NULL),
(54, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(55, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(56, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(57, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(58, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(59, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(60, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(61, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(62, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, NULL),
(63, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(64, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(65, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(66, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(67, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(68, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(69, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, NULL),
(70, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(71, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(72, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(73, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(74, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(75, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(76, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(77, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(78, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, NULL),
(79, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(80, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(81, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(82, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(83, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(84, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(85, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(86, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(87, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-10', 1, 1, NULL),
(88, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(89, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 1, 1, NULL),
(90, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL),
(91, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-03-21', 3, 1, NULL),
(92, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 1, NULL),
(93, 'Faire les courses', 'Acheter du beurre, du jambon et du pain', 0, '2021-02-28', 3, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `taskachieve_date`
--

DROP TABLE IF EXISTS `taskachieve_date`;
CREATE TABLE IF NOT EXISTS `taskachieve_date` (
  `id_achieve` int(11) NOT NULL AUTO_INCREMENT,
  `date_achieve` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_achieve`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taskachieve_date`
--

INSERT INTO `taskachieve_date` (`id_achieve`, `date_achieve`) VALUES
(1, '2021-03-25 23:43:45'),
(2, '2021-03-25 23:44:20'),
(3, '2021-03-25 23:44:21'),
(4, '2021-03-27 00:03:03'),
(5, '2021-03-27 00:03:05'),
(6, '2021-03-27 00:03:05'),
(7, '2021-03-27 00:03:06'),
(8, '2021-03-27 00:03:07'),
(9, '2021-03-27 00:03:11'),
(10, '2021-03-27 00:03:16'),
(11, '2021-03-27 00:03:25'),
(12, '2021-03-27 00:50:51'),
(13, '2021-03-27 00:50:52'),
(14, '2021-03-27 15:25:09'),
(15, '2021-03-27 15:25:15');

-- --------------------------------------------------------

--
-- Structure de la table `taskarchive_date`
--

DROP TABLE IF EXISTS `taskarchive_date`;
CREATE TABLE IF NOT EXISTS `taskarchive_date` (
  `id_archive` int(11) NOT NULL AUTO_INCREMENT,
  `date_archive` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_archive`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

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
(24, '2021-03-15 00:26:23'),
(25, '2021-03-20 20:59:43'),
(26, '2021-03-22 23:09:46'),
(27, '2021-03-22 23:10:19'),
(28, '2021-03-22 23:10:43'),
(29, '2021-03-22 23:15:33'),
(30, '2021-03-22 23:19:10'),
(31, '2021-03-22 23:20:50'),
(32, '2021-03-22 23:21:16'),
(33, '2021-03-22 23:22:24'),
(34, '2021-03-22 23:24:27'),
(35, '2021-03-22 23:24:45'),
(36, '2021-03-22 23:24:49'),
(37, '2021-03-22 23:25:26'),
(38, '2021-03-22 23:25:33'),
(39, '2021-03-22 23:25:40'),
(40, '2021-03-22 23:26:46'),
(41, '2021-03-22 23:29:49'),
(42, '2021-03-22 23:30:02'),
(43, '2021-03-22 23:32:40'),
(44, '2021-03-22 23:33:30'),
(45, '2021-03-22 23:40:16'),
(46, '2021-03-22 23:45:12'),
(47, '2021-03-22 23:46:27'),
(48, '2021-03-22 23:46:33'),
(49, '2021-03-22 23:46:33'),
(50, '2021-03-22 23:54:53'),
(51, '2021-03-23 22:38:56'),
(52, '2021-03-23 23:08:25'),
(53, '2021-03-25 23:58:01'),
(54, '2021-03-27 00:50:44'),
(55, '2021-03-27 15:25:29'),
(56, '2021-03-28 22:19:43');

-- --------------------------------------------------------

--
-- Structure de la table `taskcreate_date`
--

DROP TABLE IF EXISTS `taskcreate_date`;
CREATE TABLE IF NOT EXISTS `taskcreate_date` (
  `id_create` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_create`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id_date`,`id_task`,`id_user`),
  KEY `constraint_idAchieveUser` (`id_user`),
  KEY `constraint_idAchieveTask` (`id_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task_achieve`
--

INSERT INTO `task_achieve` (`id_date`, `id_task`, `id_user`) VALUES
(5, 19, 1),
(7, 26, 1),
(9, 17, 1),
(11, 27, 1),
(12, 8, 1),
(13, 9, 1),
(14, 10, 1),
(15, 18, 1);

-- --------------------------------------------------------

--
-- Structure de la table `task_archive`
--

DROP TABLE IF EXISTS `task_archive`;
CREATE TABLE IF NOT EXISTS `task_archive` (
  `id_date` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_date`,`id_task`,`id_user`),
  KEY `constraint_idArchiveTask` (`id_task`),
  KEY `constraint_idArchiveUser` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `task_archive`
--

INSERT INTO `task_archive` (`id_date`, `id_task`, `id_user`) VALUES
(56, 8, 1),
(54, 11, 1),
(55, 12, 1),
(53, 16, 1);

-- --------------------------------------------------------

--
-- Structure de la table `task_create`
--

DROP TABLE IF EXISTS `task_create`;
CREATE TABLE IF NOT EXISTS `task_create` (
  `id_date` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_date`,`id_task`,`id_user`),
  KEY `constraint_idCreateUser` (`id_user`),
  KEY `constraint_idCreateTask` (`id_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `task_update`
--

DROP TABLE IF EXISTS `task_update`;
CREATE TABLE IF NOT EXISTS `task_update` (
  `id_date` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_date`,`id_task`,`id_user`),
  KEY `constraint_idUpdateTask` (`id_task`),
  KEY `constraint_idUpdateUser` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id_todo`),
  KEY `constraint_idUser` (`id_user`),
  KEY `constraint_idTodoIcon` (`id_icon`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `todo`
--

INSERT INTO `todo` (`id_todo`, `title_todo`, `description_todo`, `createdate_todo`, `id_user`, `id_icon`) VALUES
(1, 'Anniv', 'Groupe de gestion des anniversaires.', '2021-02-14 23:56:54', 1, 2),
(3, 'rgrg', 'fdgdfgdfgdfg', '2021-02-24 16:27:01', 2, 2),
(4, 'Coursesrtrt', 'Faire les courses', '2021-03-16 14:52:21', 1, 2),
(5, 'Devoirs', 'Revision', '2021-03-16 14:52:21', 1, 2),
(6, 'Devoirs', 'Revision', '2021-03-16 14:52:21', 1, 2);

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
  PRIMARY KEY (`token`),
  KEY `constraint_idTodo` (`id_todo`),
  KEY `constraint_idPermission` (`id_permission`)
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `firstname_user`, `email_user`, `password_user`, `createdate_user`) VALUES
(1, 'Testeur', 'Le Test', 'testEmail@gmail.com', 'test', '2021-02-16 22:55:31'),
(2, 'Lecat', 'Baptiste', 'baptiste.lecat44@gmail.com', 'baptiste24', '2021-02-16 22:55:31'),
(3, 'Lecat', 'Baptiste', 'baptiste.lecat44@gmail.com', 'baptiste24', '2021-02-16 22:55:31'),
(4, 'Lecat', 'Baptiste', 'baptiste.lecat44@gmail.com', 'baptiste24', '2021-02-16 22:55:31');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contribute`
--
ALTER TABLE `contribute`
  ADD CONSTRAINT `constraint_idContributePermission` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idContributeTodo` FOREIGN KEY (`id_todo`) REFERENCES `todo` (`id_todo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idContributeUser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `constraint_idArchived` FOREIGN KEY (`id_archived`) REFERENCES `taskarchive_date` (`id_archive`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idPriority` FOREIGN KEY (`id_priority`) REFERENCES `taskpriority` (`id_priority`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idTaskTodo` FOREIGN KEY (`id_todo`) REFERENCES `todo` (`id_todo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `task_achieve`
--
ALTER TABLE `task_achieve`
  ADD CONSTRAINT `constraint_idAchieveDate` FOREIGN KEY (`id_date`) REFERENCES `taskachieve_date` (`id_achieve`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idAchieveTask` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idAchieveUser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `task_archive`
--
ALTER TABLE `task_archive`
  ADD CONSTRAINT `constraint_idArchiveDate` FOREIGN KEY (`id_date`) REFERENCES `taskarchive_date` (`id_archive`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idArchiveTask` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idArchiveUser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `task_create`
--
ALTER TABLE `task_create`
  ADD CONSTRAINT `constraint_idCreateDate` FOREIGN KEY (`id_date`) REFERENCES `taskcreate_date` (`id_create`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idCreateTask` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idCreateUser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `task_update`
--
ALTER TABLE `task_update`
  ADD CONSTRAINT `constraint_idUpdateDate` FOREIGN KEY (`id_date`) REFERENCES `taskupdate_date` (`id_update`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idUpdateTask` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idUpdateUser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `constraint_idTodoIcon` FOREIGN KEY (`id_icon`) REFERENCES `todo_icon` (`id_icon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idUser` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `todo_token`
--
ALTER TABLE `todo_token`
  ADD CONSTRAINT `constraint_idPermission` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_idTodo` FOREIGN KEY (`id_todo`) REFERENCES `todo` (`id_todo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
