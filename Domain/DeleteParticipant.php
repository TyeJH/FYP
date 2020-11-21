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
    $scheduleDA = new ScheduleDA();
    $schedule = $scheduleDA->retrieveByScheduleID($scheduleID);
    if ($schedule != null) {
        //convert format to dd/mm/yyyy 2400
        $stFormat = $schedule->startDate . " " . $schedule->startTime;
        $at = strtotime($applyDate);
        $st = strtotime($stFormat);
        //if apply date is after event started
        $startDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($stFormat));
        $endDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($etFormat));
    }
    if (empty($eventID)) {
        //If students didn't select an event
        header("location:../UI/HomePage.php");
    } else if (empty($userID)) {
        //Student have to be logged in first.
        echo "<script>alert('Hi student, you are required to log in first.');location.href = '../UI/Login.php?student';</script>";
    } else {
        $participant = new Participants($scheduleID, $eventID, $userID, '', '');
        $participantDA = new ParticipantsDA();
        if ($participantDA->delete($participant)) {
            $_SESSION['successMsg2'] = "You have drop out from the schedule ($startDateTimeFormatted - $endDateTimeFormatted). Hope to see you again!";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['errorMsg'] = "Unexpected error occur.";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        }
    }
}