<?php

use App\Model\Utils\MessageBox;

if (isset($_POST["title"])) {
    $resultNbTodo = $this->todoManager->countTodoRow($this->user->getId());
    if ($resultNbTodo["nbrow"] < 5) {
        $resultInsertTodo = $this->todoManager->insertTodo($_POST["title"], $_POST["description"], $_POST["icon"], $_POST["date"], $_POST["time"], $this->user);
        //Affichage de la messageBox success ou error.
        if ($resultInsertTodo["success"] == 1) {
            $this->messageBox = new MessageBox("Félicitation, vous avez désormais une tâche supplémentaire à effectuer !", "validate");
        } else {
            $this->messageBox = new MessageBox("Ohoh, il semblerait qu'un problème soit survenue !", "error");
        }
    } else {
        $this->messageBox = new MessageBox("Désole, vous avez atteint le nombre maximum de Todo ! Veuillez en supprimer et recommencer.", "error");
    }
}
include("../view/form/todoForm.php");