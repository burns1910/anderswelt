<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/mail/Exception.php';
require 'lib/mail/PHPMailer.php';
require 'lib/mail/SMTP.php';

  function sendMailMitAnhang($empfaenger, $betreff, $text, $absender_mail, $absender_name, $dateipfad) {
    $email = new PHPMailer();
    $email->SetFrom($absender_mail, $absender_name); //Name is optional $absender
    $email->Subject   = $betreff;
    $email->Body      = $text;
    $email->AddAddress( $empfaenger ); //$empfaenger
    $email->AddAttachment($dateipfad);

    return $email->Send();
  }

  function sendMail($empfaenger, $betreff, $text, $absender_mail, $absender_name) {
    $mail = new PHPMailer();
    $mail->IsHTML(true);
    $mail->CharSet = "text/html; charset=UTF-8;";
    #$mail->WordWrap = 80;

    $mail->SetFrom($absender_mail, $absender_name);
    $mail->Subject   = $betreff;
    $mail->Body      = $text;
    $mail->AltBody   = strip_tags($text);
    $mail->AddAddress( $empfaenger );

    return $mail->Send();
  }


?>
