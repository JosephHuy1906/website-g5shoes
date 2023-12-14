<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../library/PHPMailer/src/Exception.php';
require '../library/PHPMailer/src/PHPMailer.php';
require '../library/PHPMailer/src/SMTP.php';
class Mail {
    private $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'g5ghoes@gmail.com';
        $this->mail->Password = 'lchzvgcldojhwcwn';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->Port = 465;
        $this->mail->CharSet = 'UTF-8';
        //$this->mail->SMTPDebug=0;
    }

    public function sendMail($usermail, $title, $message) {
        try {
            $this->mail->setFrom('g5ghoes@gmail.com', "G5 Shoes");
            $this->mail->addAddress($usermail);
            $this->mail->isHTML(true);
            $this->mail->Subject = $title;
            $this->mail->Body = $message;
            $this->mail->isHTML(true);
            $this->mail->send();
            $resp = true;
        } catch(Exception $e) {
            $resp = false;
        }
        return $resp;
    }
}
?>