<?php

require_once '../Domain/Participants.php';
require_once '../DataAccess/ParticipantsDA.php';
require_once '../DataAccess/ScheduleDA.php';
require_once '../DataAccess/SocietyEventDA.php';
require_once '../Domain/SocietyEvent.php';
require '../Domain/Email.php';

if (isset($_POST['type']) && isset($_POST['scheduleID']) && isset($_POST['userID']) && isset($_POST['applyDate']) && isset($_POST['applyStatus']) && isset($_POST['attendanceStatus'])) {

    $type = $_POST['type'];
    $scheduleID = $_POST['scheduleID'];
    $eventID = $_POST['eventID'];
    $userID = $_POST['userID'];
    $applyDate = $_POST['applyDate'];
    $applyStatus = $_POST['applyStatus'];
    $attendanceStatus = $_POST['attendanceStatus'];
    if ($type == 'approval') {
        if ($applyStatus == "Approved") {
            //By default after approved then user will become absent.
            //Pending > Approved > Absent > Attend 
            $participant = new Participants($scheduleID, $eventID, $userID, $applyDate, $applyStatus, 'Absent');
        } else {
            $participant = new Participants($scheduleID, $eventID, $userID, $applyDate, $applyStatus, 'N/A');
        }
    } else {
        $participant = new Participants($scheduleID, $eventID, $userID, $applyDate, $applyStatus, $attendanceStatus);
    }
    $participantDA = new ParticipantsDA();
    if ($participantDA->update($participant)) {
        echo $participant->scheduleID . " " . $participant->userID . " " . $participant->attendanceStatus;
        exit;
        if ($type == 'approval') {
            //Update noOfJoined in Schedule table.
            $scheduleDA = new ScheduleDA();
            $scheduleDA->updateNoOfJoined($scheduleID);
            //Send email after approved participant.
            $eventDA = new SocietyEventDA();
            $event = $eventDA->retrieveByEventID($eventID);
            $to = 'n.kianhee99@gmail.com';
            $toName = 'Participant';
            $subject = "$event->eventName - Approval of event application";
            $message = "Hi you have approved for joining $event->eventName for more information. \nLog in your account to view the event details.";
            $from = "eventmanagementsystemtaruc@gmail.com";
            $sender = "TAR UC Event Management System";
            
            $mail = new Email($to, $toName, $subject, $message, $from, $sender);
            echo $participant->userID . ' application status is marked as ' . $participant->applyStatus;
//            if ($mail->setting()) {
//                echo $participant->userID . ' application status is marked as ' . $participant->applyStatus;
//            } else {
//                echo "Unepected error occur. Email couldn't be sent.";
//            }
        } else {
            echo $participant->userID . ' attendance status is marked as ' . $participant->attendanceStatus;
        }
    } else {
        echo "Unexpected error occur. Please contact system administrator.";
    }
}


