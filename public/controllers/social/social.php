<?php

use App\Module\Social\ModuleSocial;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\DatabaseException;
use App\Model\PendingContributeManager;

try {
    $list_pendingContribute = null;
    
    if (isset($_GET["token"]) && !is_null($_GET["token"])) {
        $token = $_GET["token"];
        $list_pendingContribute = ModuleSocial::submitToken($token);
    }
    
    
    $success = new SuccessManager("Votre demande est désormais en attente.", "success");
    $this->messageBox = $success->__toString();
} catch (PDOException $e) {
    $this->messageBox = $e->__toString();
} catch (DatabaseException $e) {
    $this->messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$list_pendingContribute = PendingContributeManager::loadPendingContribute($this->user);

include "../view/social/social.php";
