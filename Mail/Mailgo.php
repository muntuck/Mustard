<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/Mustard/Utility/define.php";
require CONFIG."Mailparameters.php";
require EXTERNAL."/PHPMailer/PHPMailerAutoload.php";
    
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mailgo
 *
 * @author muntu
 */
class Mailgo {
    
    public $mail;
    
    function __construct() {
        // parent::__construct();
        
        $this->mail = new PHPMailer;

        // $this->mail->SMTPDebug = 2;                               // Enable verbose debug output

        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = SMTP_HOST;          // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;           // Enable SMTP authentication
        $this->mail->Username = MAIL_USERNAME;                 // SMTP username
        $this->mail->Password = MAIL_PASSWORD;                 // SMTP password
        $this->mail->SMTPSecure = SMTP_ENCRYPTION;             // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = SMTP_PORT;                         // TCP port to connect to

        $this->mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $this->mail->addReplyTo(MAIL_REPLYTO);
        
        //  $this->mail->addAddress('muntuckyap@yahoo.com', 'Muntuck Yap');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $this->mail->isHTML(true);                                  // Set email format to HTML

    }
    
    public function addAddress($addr) {
        $this->mail->addAddress($addr);     // Add a recipient     
    }
    
    
    public function setSubject($header) {
        $this->mail->Subject = $header;
    }
    
    public function setBody($body) {
        $this->mail->Body    = $body;
    }
    
    public function setAltBody($altBody) { // for nonhtml message
        $this->mail->AltBody = $altBody;
    }
    
    public function send() {
        if(!$this->mail->send()) {
            echo "<br>send error: " . $this->mail->ErrorInfo;
            return FALSE;
        }
        else
            return TRUE;
    }
    
    public function getError() {
        return $this->mail->ErrorInfo;
    }
}

?>