DROP PROCEDURE IF EXISTS selectTodo;
DELIMITER |
CREATE PROCEDURE selectTodo(IN p_idUser INT(11))
BEGIN
    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE _id_todo INT(11);
    DECLARE _title_todo VARCHAR(255);
    DECLARE _description_todo TEXT;
    DECLARE _createdate_todo DATETIME;
    DECLARE _id_icon INT(11);

    DECLARE cursor_selectTodoUser CURSOR FOR SELECT id_todo, title_todo, description_todo, createdate_todo, id_icon FROM todo WHERE id_user = p_idUser;
    DECLARE cursor_selectTodoContribute CURSOR FOR SELECT todo.id_todo, title_todo, description_todo, createdate_todo, id_icon FROM contribute, todo WHERE todo.id_todo = contribute.id_todo and accepted_participer = 1 and contribute.id_user = p_idUser;
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

    loop_cursor_selectTodoUser: LOOP
        FETCH cursor_selectTodoUser INTO _id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon;
        IF fin THEN
			LEAVE loop_cursor_selectTodoUser;
		END IF;
        INSERT INTO TMP_TODO VALUES(_id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon);
    END LOOP;

    SET fin = FALSE;
    CLOSE cursor_selectTodoUser;

    OPEN cursor_selectTodoContribute;

    cursor_selectTodoContribute: LOOP
        FETCH cursor_selectTodoContribute INTO _id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon;
        IF fin THEN
			LEAVE cursor_selectTodoContribute;
		END IF;
        INSERT INTO TMP_TODO VALUES(_id_todo, _title_todo, _description_todo, _createdate_todo, _id_icon);
    END LOOP;

    CLOSE cursor_selectTodoContribute;

    SELECT * FROM TMP_TODO;

END |
DELIMITER ;

call selectTodo(15);