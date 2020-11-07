<?php

include_once '../Domain/Participants.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/ParticipantsDA.php';
include_once '../Domain/Student.php';
include_once '../DataAccess/ScheduleDA.php';
session_start();
if (isset($_GET['eventID']) && isset($_GET['scheduleID'])) {
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $eventID = $_GET['eventID'];
    $scheduleID = $_GET['scheduleID'];
    $userID = $_SESSION['result']->studID;
    //$userID = 123;
    $applyStatus = "Pending";
    $applyDate = date('Y-m-d H:i:s'); //2020-10-22 03:53:54 sample format
    
    //Validate join permission
    $scheduleDA = new ScheduleDA();
    $schedule = $scheduleDA->retrieveByScheduleID($scheduleID);
    if ($schedule != null) {
        //convert format to dd/mm/yyyy 2400
        $stFormat = $schedule->startDate . " " . $schedule->startTime;
        $at = strtotime($applyDate);
        $st = strtotime($stFormat);
        //if apply date is after event started
        if ($at > $st) {
            echo "<script>alert('We are sorry student, the event has started. You may try out other event slots.');location.href = '../UI/EventDetails.php?eventID=$eventID';</script>";
        }
    }
    if (empty($eventID)) {
        //If students didn't select an event
        header("location:../UI/HomePage.php");
    } else if (empty($userID)) {
        //Student have to be logged in first.
        echo "<script>alert('Hi student, you are required to log in first.');location.href = '../UI/Login.php?student';</script>";
    } else if (date() > $applyDate) {
        $_SESSION['errorMsg'] = "Sorry the event has started.";
        header("location:../UI/EventDetails.php?eventID=$eventID");
    } else {
        $participant = new Participants($scheduleID, $eventID, $userID, $applyDate, $applyStatus);
        $participantDA = new ParticipantsDA();
        if ($participantDA->create($participant)) {
            $_SESSION['succeessMsg'] = 'Thanks for joining us! We will approve you as soon as possible.';
            header("location:../UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['errorMsg'] = "Unexpected error occur.";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        }
    }
}