DROP PROCEDURE IF EXISTS archiveTask;
DELIMITER |
CREATE PROCEDURE archiveTask(IN p_idUser INT(11), IN p_idTask INT(11))
BEGIN

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

                loop_cursor_userPermission : LOOP
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

END |
DELIMITER ;

call archiveTask(1, 3);