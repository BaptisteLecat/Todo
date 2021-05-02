<?php

use App\Model\Utils\MessageBox;
use App\Model\Form\CreateForm\FormTask;
use App\Model\Exceptions\SuccessManager;
/*
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
}*/

const INPUT_ARGS = array(
    'title' => FILTER_SANITIZE_STRING,
    'description' => FILTER_SANITIZE_STRING,
    'endDate' => FILTER_SANITIZE_STRING,
    'todo-selector' => array(
        'filter' => FILTER_VALIDATE_INT,
        'options' => array('min_range' => 0)
    ),
    'priority-selector' => array(
        'filter' => FILTER_VALIDATE_INT,
        'options' => array('min_range' => 0)
    )
);


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $filtered_input = filter_input_array(INPUT_POST, INPUT_ARGS);
    if(!is_null($filtered_input) && $filtered_input == true){
        try {
            $formTask = new FormTask($filtered_input["title"], $filtered_input["description"], $filtered_input["endDate"], $filtered_input["todo-selector"], $filtered_input["priority-selector"], $this->user, $this->app);
            $formTask->submitForm();
            $successMessage = new SuccessManager("La tâche à été ajoutée. ", "success");
            $this->messageBox = $successMessage;
        } catch (Exception $e) {
            $this->messageBox = $e;
        }
    }
}


include("../view/form/taskForm.php");
