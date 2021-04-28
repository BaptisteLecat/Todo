<?php

use App\Model\PendingContributeManager;

$list_pendingContribute = PendingContributeManager::loadPendingContribute($this->user);

include "../view/social/social.php";