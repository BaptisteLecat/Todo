<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\User;
use App\Model\MailerManager;

class PasswordManager extends PdoFactory
{
    private $idUser;
    private $idModif;
    private $token;

    //Permet de verifier si l'email est existant.
    //Renvoie 0 => error PDO, 1 & idUser => Success.
    public function emailIsValid($email){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT id_user FROM user WHERE email_user LIKE :email_user");
            if($request->execute(array(':email_user' => $email))){
                if($request->rowCount() > 0){
                    $result = $request->fetch();
                    $this->idUser = $result["id_user"];
                    $response = ["success" => 1];
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }

    //Permet d'envoyer un token par mail à l'utilisateur.
    public function sendEmail($email){
        $mailer = new MailerManager();
        $resultSendToken = $this->sendToken();
        if($resultSendToken["success"] == 2){
            $subject = "Demande de Modification de mot de passe";
            $content = "Bonjour, vous avez effectuez une demande de changement de mot de passe.<br>
            Le TodoBot vous a généré un code à saisir afin de vérifier votre identité:<br> ".$this->token;
            if($mailer->setEmailInfo($email, $subject, $content) == 1){
                $response = ["success" => 1];
            }else{
                $response = ["success" => 0, "typeError" => "EmailSend"];
            }
        }else{
            $response = ["success" => 0, "typeError" => $resultSendToken["typeError"]];
        }
        return $response;
    }

    //Permet de générer un token aléatoire composé de lettre et de chiffre.
    private function generateToken($nbChar){
        $string = "";
        $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        srand((double)microtime()*1000000);
        for($i=0; $i<$nbChar; $i++){
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }

    //Permet l'insertion du token dans la BDD.
    //Renvoie 0 => erreur PDO, 1 => Erreur NbReset, 2 => Success.
    private function sendToken(){
        $response = ["success" => 0, "typeError" => "System"];
        $this->token = $this->generateToken(5);

        try{
            //Verification préalable du nombre de Rest effectuer sur le compte.
            $request = $this->pdo->prepare("SELECT idModif FROM modifpassword WHERE idUser = :idUser");
            if($request->execute(array(":idUser" => $this->idUser))){
                $nbModif = $request->rowCount();
                //3 Reset maximum.
                if($nbModif < 3){
                    //Insertion du token et de l'id dans la table modifpassword.
                    $request = $this->pdo->prepare("INSERT INTO modifpassword (idUser, token) VALUES (:idUser, :token)");
                    if($request->execute(array(':idUser' => $this->idUser, 'token' => $this->token))){
                        $this->idModif = $this->pdo->lastInsertId();
                        $response = ["success" => 2];
                    }
                }else{
                    //Cas ou nbReset > 3.
                    $response = ["success" => 1, "typeError" => "ResetLimit"];
                }
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $response;
    }
}