<?php

require_once '../Domain/Helpers.php';
require_once '../DataAccess/HelpersDA.php';
require_once '../DataAccess/SocietyEventDA.php';
require_once '../DataAccess/StudentDA.php';
require_once '../Domain/SocietyEvent.php';
require '../Domain/Email.php';
//for ($i = 0; $i < 9999; $i++) {
//    echo "INSERT INTO student (userID,username,password,studEmail,studID) VALUES (SOC$i ,username$i ,abcdefgA123!,n.kianhee99@gmail.com)";
//}

if (isset($_POST['eventID']) && isset($_POST['userID']) && isset($_POST['applyDate']) && isset($_POST['applyStatus'])) {


    $eventID = $_POST['eventID'];
    $userID = $_POST['userID'];
    $applyDate = $_POST['applyDate'];
    $applyStatus = $_POST['applyStatus'];
    $helper = new Helpers($eventID, $userID, $applyDate, $applyStatus);
    $helperDA = new HelpersDA();
    if ($helperDA->update($helper)) {
        //Send email after approved helper.
        $eventDA = new SocietyEventDA();
        $event = $eventDA->retrieveByEventID($eventID);
        $studDA = new StudentDA();
        $stud = $studDA->retrieveByStudID($userID);
        $to = $stud->studEmail;
        $toName = 'Helper';
        $subject = "$event->eventName - Helper Application : $applyStatus";
        $message = "Hi you have $applyStatus for being helper $event->eventName.\n<a href='http://localhost/FYP/UI/login.php'>Click here to login.</a>";
        $from = "eventmanagementsystemtaruc@gmail.com";
        $sender = "TAR UC Event Management System";
        $mail = new Email($to, $toName, $subject, $message, $from, $sender);
        if ($mail->setting()) {
            echo $helper->userID . ' application status is marked as ' . $helper->applyStatus;
        } else {
            echo "Marked as $helper->applyStatus but email couldn't be sent.";
        }
    } else {
        echo "Unexpected error occur. Couldn't update currenlty. Please contact system administrator.";
    }
}


