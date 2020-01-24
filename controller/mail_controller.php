<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/mail/Exception.php';
require 'lib/mail/PHPMailer.php';
require 'lib/mail/SMTP.php';

    function listeAllerAbsender() {
        global $mail_absender;
        $retval = $mail_absender;
    return $retval;
    }

    function getAllMailsFromListID($list_id) {
        global $connection;
        $query = $connection->prepare("SELECT crew_member.email FROM crew_member, crew_listen_member WHERE crew_listen_member.list_id =:list_id AND crew_listen_member.crew_member_id = crew_member.id");
        $query->bindParam("list_id", $list_id, PDO::PARAM_STR);
        $query->execute();
 
        $retvalQueryArray = $query->fetchAll(PDO::FETCH_ASSOC);
        $retval = array();
        foreach ($retvalQueryArray as $mailAdresse) {
            array_push($retval, $mailAdresse['email']);
        }

    return $retval;
    }

    function getAllMailsFromLists($list_ids, $crew_member_ids) {
        $retval = array();

        foreach ($list_ids as $list_id) {
            $mailsFromList = getAllMailsFromListID($list_id);
            $retval = array_unique(array_merge($retval, $mailsFromList));
        }

        $crew_member_mails = array();
        foreach ($crew_member_ids as $crew_member_id) {
            array_push($crew_member_mails, getMailFromCrewMemberByID($crew_member_id));
        }
        $retval = array_unique(array_merge($retval, $crew_member_mails));

    return $retval;
    }

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