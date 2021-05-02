<?php

/*
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
}*/


use App\Model\Form\CreateForm\FormTodo;
use App\Model\Exceptions\SuccessManager;

const INPUT_ARGS = array(
    'title' => FILTER_SANITIZE_STRING,
    'description' => FILTER_SANITIZE_STRING,
    'icon_id' => array(
        'filter' => FILTER_VALIDATE_INT,
        'options' => array('min_range' => 0)
    )
);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filtered_input = filter_input_array(INPUT_POST, INPUT_ARGS);
    if (!is_null($filtered_input) && $filtered_input == true) {
        try {
            $formTask = new FormTodo($filtered_input["title"], $filtered_input["description"], $filtered_input["icon_id"], $this->user, $this->app);
            $formTask->submitForm();
            $successMessage = new SuccessManager("La Todo à été ajoutée. ", "success");
            $this->messageBox = $successMessage;
        } catch (Exception $e) {
            $this->messageBox = $e;
        }
    }
}
include("../view/form/todoForm.php");