/* Récuperer les todos pour lesquels le user est participants

Parmis tout les contribute ou le user_id == celui du user
On récupere que ceux ou il y a accepted a 1
On group by id todos

Pour chacune des todos on récupere les infos et on les insert dans une table virtuelle
En PHP On Select la table virtuelle et on instancie des objets todo puis contribute. 

*/

DROP PROCEDURE IF EXISTS selectTodoContribute;
DELIMITER |
CREATE PROCEDURE selectTodoContribute(IN p_idUser INT(11))
BEGIN 

    DECLARE fin BOOLEAN DEFAULT FALSE;
    DECLARE flag integer default null;
    DECLARE _id_todo integer;
    DECLARE _accepted_contribute TINYINT;
    DECLARE _joindate_contribute DATETIME;
    DECLARE _id_permission integer;
    DECLARE cursor_selectContribute CURSOR FOR SELECT id_todo, accepted_contribute, joindate_contribute, id_permission FROM contribute WHERE id_user = p_idUser AND accepted_contribute = 1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE;

    DROP TEMPORARY TABLE IF EXISTS TMP_TODOCONTRIBUTE;
	CREATE TEMPORARY TABLE TMP_TODOCONTRIBUTE(
		_id_todo INT,
        _accepted_contribute TINYINT,
        _joindate_contribute DATETIME,
        _id_permission INT
	); 

    OPEN cursor_selectContribute;

    loop_cursor_selectContribute: LOOP
        FETCH cursor_selectContribute INTO _id_todo, _accepted_contribute, _joindate_contribute, _id_permission;
        IF fin THEN
            LEAVE loop_cursor_selectContribute;
        END IF;

        INSERT INTO TMP_TODOCONTRIBUTE VALUES(_id_todo, _accepted_contribute, _joindate_contribute, _id_permission);
    END LOOP;

    CLOSE cursor_selectContribute;

END |
DELIMITER ;

call selectTodoContribute(2);

SELECT * FROM TMP_TODOCONTRIBUTE;