<?php

use App\Model\Form\CreateForm\FormTask;
use App\Model\Exceptions\SuccessManager;

const INPUT_ARGS = array(
    'title' => FILTER_SANITIZE_STRING,
    'content' => FILTER_SANITIZE_STRING,
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
            $formTask = new FormTask($filtered_input["title"], $filtered_input["content"], $filtered_input["endDate"], $filtered_input["todo-selector"], $filtered_input["priority-selector"], $this->user, $this->app);
            $formTask->submitForm();
            $successMessage = new SuccessManager("La tâche à été ajoutée. ", "success");
            $this->messageBox = $successMessage;
        } catch (Exception $e) {
            $this->messageBox = $e;
        }
    }
}


include("../view/form/taskForm.php");
