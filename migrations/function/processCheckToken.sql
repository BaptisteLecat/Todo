DROP PROCEDURE IF EXISTS processCheckToken;
DELIMITER |
CREATE PROCEDURE processCheckToken(IN p_token VARCHAR(255), IN p_idUser INT(11))
BEGIN
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
            -- Suppression du token
            DELETE FROM todo_token WHERE token = p_token;
            -- Message d'erreur : Le token a expiré.
            SIGNAL SQLSTATE '45000' 
		    SET MYSQL_ERRNO = 10003, MESSAGE_TEXT = "Le token a expiré.";
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
END |
DELIMITER ;

call processCheckToken("ypTazg", 1);