<?php

namespace App\Model\Entity;

use App\Model\Entity\User;
use App\Model\Entity\TodoIcon;

class TodoOwner extends Todo
{
    function __construct(int $id, string $title, string $description, string $createDate, User $user, TodoIcon $todoIcon)
    {
        parent::__construct($id, $title, $description, $createDate, $user, $todoIcon);
    }
}
