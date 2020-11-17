<?php 

namespace App\Model;
use \PHPMailer;

class MailerManager extends PHPMailer
{
    private $mail;

    function __construct(){
        $mail = new PHPMailer();
    }

    private function SetParameters(){
        $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
        $mail->Host = 'mail.votredomaine.com'; // Spécifier le serveur SMTP
        $mail->SMTPAuth = true; // Activer authentication SMTP
        $mail->Username = 'user@votredomaine.com'; // Votre adresse email d'envoi
        $mail->Password = 'secret'; // Le mot de passe de cette adresse email
        $mail->SMTPSecure = 'ssl'; // Accepter SSL
        $mail->Port = 465;
    }
}