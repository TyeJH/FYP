<?php

require_once '../Domain/Helpers.php';
require_once '../DataAccess/HelpersDA.php';
require_once '../DataAccess/SocietyEventDA.php';
require_once '../Domain/SocietyEvent.php';
require '../Domain/Email.php';

if (isset($_POST['scheduleID']) && isset($_POST['userID']) && isset($_POST['applyDate']) && isset($_POST['applyStatus'])) {

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
        $to = $_SESSION['result']->studEmail;
        $toName = 'Helper';
        $subject = "$event->eventName - Helper Application : Approved";
        $message = "Hi you have approved for being helper $event->eventName for more information. \nLog in your account to view the event details.";
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


