<?php

require_once '../../../vendor/autoload.php';

use App\Module\ModuleTaskManager;

$list_idTask = json_decode($_POST["list_idTask"], true);
$idTodo = $_POST["idTodo"];

echo json_encode(ModuleTaskManager::archiveTask($list_idTask, $idTodo));

