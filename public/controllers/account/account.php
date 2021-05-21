<?php

use App\Model\Form\Sign\Cookies;

switch ($action) {
    case "disconnect":
        $cookie = new Cookies();
        $cookie->deleteCookie();
        session_destroy();
        header("Location: signIn");
        break;
}

include "../view/account/account.php";
