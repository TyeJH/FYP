<?php

include_once '../Domain/SessionManagement.php';
include_once '../Domain/Helpers.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/HelpersDA.php';

if (isset($_POST['applyHelper'])) {

    $eventID = $_POST['eventID'];
    $userID = 123;
    $applyStatus = "Pending";
    $applyDate = date('Y-m-d H:i:s'); //2020-10-22 03:53:54 sample format
    if (empty($eventID)) {
        //If students didn't select an event
        header("location:HomePage.php");
    } else if (empty($studID)) {
        //Student have to be logged in first.
    } else {
        $participant = new Participants($eventID = "", $userID, $applyStatus, $applyDate);
        $participantDA = new ParticipantsDA();
        if ($participantDA->execute($participant)) {
            $_SESSION['message'] = "<script>alert('Thanks for joining us as Helper! An email had send to you.');</script>";
            header("location:../FYP/UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, currently cannot submit.</div>";
            header("location:../FYP/UI/EventDetails.php?eventID=$eventID");
        }
    }
}