<?php

include_once '../Domain/SessionManagement.php';
include_once '../Domain/Participants.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/ParticipantsDA.php';
include_once '../Domain/Student.php';
session_start();
if (isset($_POST['participate'])) {

    $eventID = $_POST['eventID'];
    $scheduleID = $_GET['scheduleID'];
    $userID = $_SESSION['current']->studID;
    $applyStatus = "Pending";
    $applyDate = date('Y-m-d H:i:s'); //2020-10-22 03:53:54 sample format
    if (empty($eventID)) {
        //If students didn't select an event
        header("location:HomePage.php");
    } else if (empty($userID)) {
        //Student have to be logged in first.
    } else {
        $participant = new Participants($scheduleID, $userID, $applyDate, $applyStatus);
        $participantDA = new ParticipantsDA();
        if ($participantDA->create($participant)) {
            $_SESSION['message'] = "<script>alert('Thanks for joining us! An email had send to you.');</script>";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, unexpected error occur.</div>";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        }
    }
}