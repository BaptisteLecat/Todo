DROP PROCEDURE IF EXISTS createTask;
DELIMITER |
CREATE PROCEDURE createTask(IN p_idUser INT(11), IN p_idTodo INT(11), IN p_titleTask VARCHAR(255), IN p_contentTask VARCHAR(255), IN p_enddateTask DATE, IN p_idPriority INT(11))
BEGIN

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

                loop_cursor_userPermission : LOOP
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
                    SIGNAL SQLSTATE '45103' 
		            SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de créer une tâche.";
                END IF;
            END ;
            
        END IF;
    ELSE
        -- Message d'erreur : La todo n'existe pas.
        SIGNAL SQLSTATE '45200' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La todo n'existe pas.";
    END IF;

END |
DELIMITER ;

call createTask(2, 1, "montitle", "moncontent", "date", 1);