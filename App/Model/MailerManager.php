<?php 

namespace App\Model;
use PHPMailer\PHPMailer\PHPMailer;

class MailerManager
{
    private $mail;

    function __construct(){
        $this->mail = new PHPMailer;
        $this->setParameters();
    }

    private function setParameters(){
        $this->mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
        $this->mail->Host = 'smtp.gmail.com'; // Spécifier le serveur SMTP
        $this->mail->SMTPAuth = true; // Activer authentication SMTP
        $this->mail->Username = 'lecat.enterprise@gmail.com'; // Votre adresse email d'envoi
        $this->mail->Password = 'lecat.enterprise24'; // Le mot de passe de cette adresse email
        $this->mail->SMTPSecure = 'ssl'; // Accepter SSL
        $this->mail->Port = 465;
        $this->mail->IsHTML(true);
        //$this->mail->IsHTML = true;
    }

    public function setEmailInfo($emailUser, $subject, $body){
        $success = 1;
        $this->mail->setFrom('TodoBot@gmail.com', 'TodoBot'); // Personnaliser l'envoyeur
        $this->mail->addAddress($emailUser, 'Lecat Jean'); // Ajouter le destinataire
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        if(!$this->mail->send()){
            $success = 0;
        }
        //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        return $success;
    }

    
}