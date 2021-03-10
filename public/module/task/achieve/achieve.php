<?php

require_once '../../../../vendor/autoload.php';

use App\Module\ModuleTaskManager;

$idTask = $_POST["idTask"];
$idTodo = $_POST["idTodo"];

echo json_encode(ModuleTaskManager::achieveTask($idTask, $idTodo));

