DROP PROCEDURE IF EXISTS achieveTask;
DELIMITER |
CREATE PROCEDURE achieveTask(IN p_idUser INT(11), IN p_idTask INT(11))
BEGIN

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
                UPDATE task SET id_priority = 2 WHERE id_task = p_idTask;
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

                loop_cursor_userPermission : LOOP
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
                            UPDATE task SET id_priority = 2 WHERE id_task = p_idTask;
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

END |
DELIMITER ;

call achieveTask(1, 3);