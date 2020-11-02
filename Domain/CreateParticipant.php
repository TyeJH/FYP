<?php

include_once '../Domain/Participants.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/ParticipantsDA.php';
include_once '../Domain/Student.php';
session_start();
if (isset($_GET['eventID']) && isset($_GET['scheduleID'])) {

    $eventID = $_GET['eventID'];
    $scheduleID = $_GET['scheduleID'];
    $userID = $_SESSION['result']->studID;
    //$userID = 123;
    $applyStatus = "Pending";
    $applyDate = date('Y-m-d H:i:s'); //2020-10-22 03:53:54 sample format
    if (empty($eventID)) {
        //If students didn't select an event
        header("location:../UI/EventDetails.php?eventID=$eventID");
    } else if (empty($userID)) {
        //Student have to be logged in first.
        header("location:../UI/Login.php");
    } else {

        $participant = new Participants($scheduleID, $eventID, $userID, $applyDate, $applyStatus);
        $participantDA = new ParticipantsDA();
        if ($participantDA->create($participant)) {
            echo "<div class='alert alert-success'><strong>Success!</strong> Thanks for joining us! An email had send to you.</div>";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        } else {
            echo "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, unexpected error occur. Check if you have already applied.</div>";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        }
    }
}