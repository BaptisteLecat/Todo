<?php 

namespace App\Model;

use Exception;
use App\PdoFactory;
use App\Model\Entity\Todo;
use App\Model\Entity\Contribute;
use App\Model\Entity\User;

class ContributeManager
{
    public static function loadTodoContribute(User $userObject, $list_TodoIcon)
    {

        try {
            $request = PdoFactory::getPdo()->prepare("call selectTodoContribute(:id_user)");
            $request->execute(array(':id_user' => $userObject->getId()));
            $request = PdoFactory::getPdo()->prepare("SELECT * FROM TMP_TODOCONTRIBUTE");
            while ($result = $request->fetch()) {
                foreach ($list_TodoIcon as $todoIconObject) {
                    if ($todoIconObject->getId() == $result["_id_icon"]) {
                        $todo = new Todo($result["_id_todo"], $result["_title_todo"], $result["_description_todo"], $result["_createdate_todo"], $userObject, $todoIconObject);
                        $contribute = new Contribute($result["_accepted_contribute"], $result["_joindate_contribute"], $userObject, $todo);
                        break;
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
