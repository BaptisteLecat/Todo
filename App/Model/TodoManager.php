<?php

namespace App\Model;

use App\Model\Entity\Todo;
use App\Model\Entity\TodoIcon;
use App\Model\Entity\User;
use App\PdoFactory;
use Exception;

/**
 * TodoManager
 * Static class for CRUD Todo requests.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class TodoManager
{
    /**
     * loadTodo
     * Select todo informations and create TodoObject.
     *
     * @param  User $userObject
     * @param  array $list_TodoIcon
     * @return void
     */
    public static function loadTodo(User $userObject, $list_TodoIcon)
    {

        try {
            $request = PdoFactory::getPdo()->prepare("SELECT id_todo, title_todo, description_todo, createdate_todo, id_icon FROM todo WHERE id_user = :id_user");
            $request->execute(array(':id_user' => $userObject->getId()));

            while ($result = $request->fetch()) {
                foreach ($list_TodoIcon as $todoIconObject) {
                    if ($todoIconObject->getId() == $result["id_icon"]) {
                        $todo = new Todo($result["id_todo"], $result["title_todo"], $result["description_todo"], $result["createdate_todo"], $userObject, $todoIconObject, true);
                        break;
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * loadTodoFromId
     * Private function call after an insert to add the new Todo.
     *
     * @param  int $idTodo
     * @param  User $userObject
     * @param  TodoIcon $todoIconObject
     * @return void
     */
    private static function loadTodoFromId(int $idTodo, User $userObject, TodoIcon $todoIconObject)
    {

        try {
            $request = PdoFactory::getPdo()->prepare("SELECT title_todo, description_todo, createdate_todo FROM todo WHERE id_todo = :id_todo");
            $request->execute(array(':id_todo' => $idTodo));

            $result = $request->fetch();
            $todo = new Todo($idTodo, $result["title_todo"], $result["description_todo"], $result["createdate_todo"], $userObject, $todoIconObject, true);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * insertTodo
     * Insert a new Todo in database.
     *
     * @param  string $title
     * @param  string $description
     * @param  User $userObject
     * @param  TodoIcon $todoIconObject
     * @return void
     */
    public static function insertTodo(string $title, string $description, User $userObject, TodoIcon $todoIconObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("INSERT INTO todo (title_todo, description_todo, id_user, id_icon) VALUES (:title_todo, :description_todo, :id_user, :id_icon)");
            $request->execute(array(':title_todo' => $title, ':description_todo' => $description, ':id_user' => $userObject->getId(), ':id_icon' => $todoIconObject->getId()));
            self::loadTodoFromId(PdoFactory::getPdo()->lastInsertId(), $userObject, $todoIconObject);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * updateTodo
     * Update the value of a specified attribute.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @param  Todo $todoObject
     * @return void
     */
    public static function updateTodo(string $attribute, $value, Todo $todoObject)
    {
        try {
            switch ($attribute) {
                case 'title':
                    $request = PdoFactory::getPdo()->prepare("UPDATE todo SET title_todo = :title_todo WHERE id_todo = :id_todo");
                    $request->execute(array(':title_todo' => $value, ':id_todo' => $todoObject->getId()));
                    $todoObject->setTitle($value);
                    break;

                case 'description':
                    $request = PdoFactory::getPdo()->prepare("UPDATE todo SET description_todo = :description_todo WHERE id_todo = :id_todo");
                    $request->execute(array(':description_todo' => $value, ':id_todo' => $todoObject->getId()));
                    $todoObject->setDescription($value);
                    break;

                case 'id_icon':
                    $request = PdoFactory::getPdo()->prepare("UPDATE todo SET id_icon = :id_icon WHERE id_todo = :id_todo");
                    $request->execute(array(':id_icon' => $value->getId(), ':id_todo' => $todoObject->getId()));
                    $todoObject->setTodoIconObject($value);
                    break;

                default:
                    # code...
                    break;
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $todoObject;
    }

    /**
     * deleteTodo
     * Delete a todo from database.
     *
     * @param  Todo $todoObject
     * @return void
     */
    public static function deleteTodo(Todo $todoObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("DELETE FROM todo WHERE id_todo = :id_todo");
            $request->execute(array(':id_todo' => $todoObject->getId()));
            $todoObject->delete();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * countTodo
     * Count number of todo for a user.
     *
     * @param  Todo $todoObject
     * @return void
     */
    public static function countTodo(User $userObject)
    {
        $nbTodo = 0;
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT id_todo FROM todo WHERE id_user = :id_user");
            $request->execute(array(':id_user' => $userObject->getId()));
            $nbTodo = $request->rowCount();
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $nbTodo;
    }
}
