-- Qui update la tâche:
-- - Est il propriétaire de la todo ?
-- - Autrement à t'il les droits de le faire?

-- Quel tâche doit on update:
-- - De quelle todo fait elle partie?
-- - La tâche est elle archivé?

-- Que doit on modifier:
-- - title
-- - content
-- - achieved
-- - enddate

/*


la tache existe t'elle?

récupération du id_todo

    Est elle archivé?

        Que doit on Modifier

        - title:
            Est propriétaire -> modification -> Création d'une date dans update_date, ajout de l'id_date id_user et id_task dans modifier
            Sinon vérification du droit:
                A le droit -> modification -> Création d'une date dans update_date, ajout de l'id_date id_user et id_task dans modifier
                ERREUR DE DROIT

        Si modification inconnue -> ERREUR D'INTITULE DE MODIFICATION

    ERREUR LA TACHE EST ARCHIVE

ERREUR TACHE INCONNUE
*/

call updateTask(2, 1, 2, "priority");

DROP PROCEDURE IF EXISTS updateTask;
DELIMITER |
CREATE PROCEDURE updateTask(IN p_idUser INT(11), IN p_idTask INT(11), IN p_value VARCHAR(255), IN p_updateLabel VARCHAR(255))
BEGIN

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

                            loop_cursor_userPermission : LOOP
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

                            loop_cursor_userPermission : LOOP
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

                            loop_cursor_userPermission : LOOP
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

                            loop_cursor_userPermission : LOOP
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

                            loop_cursor_userPermission : LOOP
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

END |
DELIMITER ;