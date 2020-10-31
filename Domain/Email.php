
<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'C:\xampp\composer\vendor\autoload.php';

class Email {

    private $to;
    private $toName;
    private $subject;
    private $message;
    private $from;
    private $sender;

    public function __construct($to, $toName, $subject, $message, $from, $sender) {
        $this->to = $to;
        $this->toName = $toName;
        $this->subject = $subject;
        $this->message = $message;
        $this->from = $from;
        $this->sender = $sender;
    }

    public function setting() {
        $mail = new PHPMailer();
        $mail->isSMTP();                        // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com;';    // Specify main SMTP server
        $mail->SMTPAuth = true;               // Enable SMTP authentication
        $mail->Username = 'eventmanagementsystemtaruc@gmail.com';     // SMTP username
        $mail->Password = 'AbcdefgA123!';         // SMTP password
        $mail->SMTPSecure = 'tls';              // Enable TLS encryption, 'ssl' also accepted
        $mail->Port = 587;
        $mail->setFrom($this->from, $this->sender);
        $mail->addAddress($this->to, $this->toName);
        $mail->Subject = $this->subject;
        $mail->Body = $this->message;
        if ($mail->send()) {
            return true;
        } else {
            return $mail->ErrorInfo;
        }
    }

}
