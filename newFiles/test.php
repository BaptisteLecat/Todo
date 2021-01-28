<?php 

require("User.php");

$user = new User(14, "Lecat", "Baptiste", "baptiste@gmail.com", "14/12/2002");

echo ($user->getId());
echo ($user->getName());
echo ($user->getFirstname());
echo ($user->getEmail());
echo ($user->getCreateDate());
var_dump ($user->getList_Task());
var_dump ($user->getList_Todo());
var_dump ($user->getList_Contribute());
var_dump ($user->getList_TaskUpdate());
var_dump ($user->getList_TaskCreate());
var_dump ($user->getList_TaskArchive());


var_dump($user->jsonSerialize());