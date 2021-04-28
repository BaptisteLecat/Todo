DROP PROCEDURE IF EXISTS deleteTask;
DELIMITER |
CREATE PROCEDURE deleteTask(IN p_idUser INT(11), IN p_idTask INT(11))
BEGIN

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
                SIGNAL SQLSTATE '45106' 
		        SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche n'est pas archivée.";
            END IF;
        ELSE
            -- Message d'erreur : Vous n'avez pas l'autorisation de supprimer une tâche.
            SIGNAL SQLSTATE '45104' 
		    SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "Vous n'avez pas l'autorisation de supprimer une tâche.";
        END IF;
    ELSE
        -- Message d'erreur : La todo n'existe pas.
        SIGNAL SQLSTATE '45100' 
		SET MYSQL_ERRNO = 10002, MESSAGE_TEXT = "La tâche n'existe pas.";
    END IF;

END |
DELIMITER ;

call deleteTask(1, 3);