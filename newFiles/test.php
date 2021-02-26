<?php 

session_start();

require("Model/Entity/User.php");
require("Model/Entity/Todo.php");
require("Model/Entity/TodoToken.php");
require("Model/Entity/TodoIcon.php");
require("Model/Entity/Task.php");
require("Model/Entity/TaskUpdated.php");
require("Model/Entity/TaskArchived.php");
require("Model/Entity/Permission.php");
require("Model/Entity/Contribute.php");

require("PdoFactory.php");

require("Model/TaskManager.php");
require("Model/PriorityManager.php");
require("Model/TaskArchivedManager.php");
require("Model/TodoTokenManager.php");
require("Model/PermissionManager.php");

use Model\Entity\ {User, Todo, TodoToken, Task, TaskUpdated, TaskArchived, Permission, Contribute, TodoIcon};
use Model\ {PermissionManager, TaskManager, PriorityManager, TaskArchivedManager, TodoTokenManager};
use NewFiles\PdoFactory;

PdoFactory::initConnection();

$user = new User(2, "Lecat", "Baptiste", "baptiste@gmail.com", "14/12/2002");

$todoIcon = new TodoIcon(1, "Voyage");

$todo = new Todo(1, "Course", "Liste de course", "19-02-2018", $user, $todoIcon);

$list_priority = PriorityManager::loadPriority();

TaskManager::loadTask($todo, $list_priority);

$list_permission = PermissionManager::loadPermission();

//TodoTokenManager::createToken($user, $list_permission[0], $todo);
TodoTokenManager::submitToken("QaYfuX", $user);

var_dump($todo->getlist_todoToken());