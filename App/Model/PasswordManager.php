<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\User;
use PDOException;

class PasswordManager extends PdoFactory
{
    public function emailIsValid($email){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT id_user FROM user WHERE email_user LIKE :email_user");
            if($request->execute(array(':email_user' => $email))){
                if($request->rowCount() > 0){
                    $result = $request->fetch();
                    $response = ["success" => 1, "id_user" => $result["id_user"]];
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }
}