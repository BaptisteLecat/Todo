<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\User;
use PDOException;

class UserManager extends PdoFactory
{

    public function verifLogin($email, $password){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT id_user FROM user WHERE email_user = :email_user and password_user = :password_user");
            if ($request->execute(array(':email_user'=>$email,':password_user'=>$password))) {
                if ($request->rowCount() > 0) {
                    $result = $request->fetch();
                    $response = ["success" => 1, "id_user" => $result["id_user"]];
                }
            }
        }catch(PDOException $e){
            
            echo $e->getMessage();
        }

        return $response;
    }

    public function emailIsValid($email){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT id_user FROM user WHERE email_user = :email_user");
            if($request->execute(array(':email_user' => $email))){
                if($request->rowCount() > 0){
                    $response = ["success" => 1, "isValid" => false];
                }else{
                    $response = ["success" => 1, "isValid" => true];
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $response;
    }

    public function createAccount($name, $firstname, $email, $password){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("INSERT INTO user (name_user, firstname_user, email_user, password_user) VALUES (:name_user, :firstname_user, :email_user, :password_user)");
            if($request->execute(array(':name_user' => $name, ':firstname_user' => $firstname, ':email_user' => $email, ':password_user' => $password))){
                $id = $this->pdo->lastInsertId();
                $user = new User($id, $name, $firstname, $email);
                $response = ["success" => 1, "user" => $user];
            }
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $response;
    }

    public function loadUser($idUser){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT name_user, firstname_user, email_user FROM user WHERE id_user LIKE :id_user");
            if($request->execute(array(':id_user' => $idUser))){
                if($request->rowCount() > 0){
                    $result = $request->fetch();
                    $user = new User($idUser, $result["name_user"], $result["firstname_user"], $result["email_user"]);
                    $response = ["success" => 1, "userObject" => $user];
                }
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }




}


