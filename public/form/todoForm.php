<?php

if (isset($_POST["title"])) {
    $resultNbTodo = $todoManager->countTodoRow($user->getId());
    if ($resultNbTodo["nbrow"] < 5) {
        $resultInsertTodo = $todoManager->insertTodo($_POST["title"], $_POST["description"], $_POST["icon"], $_POST["date"], $_POST["time"], $user);
        //Affichage de la messageBox success ou error.
        if ($resultInsertTodo["success"] == 1) {
            $messageBox = new MessageBox("Félicitation, vous avez désormais une tâche supplémentaire à effectuer !", "validate");
        } else {
            $messageBox = new MessageBox("Ohoh, il semblerait qu'un problème soit survenue !", "error");
        }
    } else {
        $messageBox = new MessageBox("Désole, vous avez atteint le nombre maximum de Todo ! Veuillez en supprimer et recommencer.", "error");
    }
}
include("../view/form/todoForm.php");