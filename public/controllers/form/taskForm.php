<?php

use App\Model\Utils\MessageBox;

if (isset($_POST["todo-selector"])) { //Si le formulaire a été soumis.
    $errorId = true; //Variable permettant de verifier que l'id du todo-selector existe bien.
    foreach ($this->user->getList_Todo() as $todo) {

        if ($todo->getId() == $_POST["todo-selector"]) { //L'id est valide.
            $errorId = false;
            $resultInsertTask = $this->taskManager->insertTask($_POST["title"], $_POST["content"], $_POST["date"], $_POST["time"], $todo);

            //Affichage de la messageBox success ou error.
            if ($resultInsertTask["success"] == 1) {
                $this->messageBox = new MessageBox("Félicitation, vous avez désormais une tâche supplémentaire à effectuer !", "validate");
            } else {
                $this->messageBox = new MessageBox("Ohoh, il semblerait qu'un problème soit survenue !", "error");
            }
            break;
        }
    }

    //L'id du todo-selector n'existe pas.
    if ($errorId == true) {
        $this->messageBox = new MessageBox("Ohoh, le Todo sélectionné est inconnu !", "error");
    }
}
include("../view/form/taskForm.php");