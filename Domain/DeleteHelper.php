<?php

include_once '../Domain/Helpers.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/HelpersDA.php';
include_once '../Domain/Student.php';
session_start();
if (isset($_GET['eventID'])) {
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $eventID = $_GET['eventID'];
    $userID = $_SESSION['result']->studID;
    
    if (empty($eventID)) {
        //If students didn't select an event
        header("location:../UI/HomePage.php");
    } else if (empty($userID)) {
        //Student have to be logged in first.
        echo "<script>alert('Hi student, you are required to log in first.');location.href = '../UI/Login.php?student';</script>";
    } else {
        $helper = new Helpers($eventID, $userID, '', '');
        $helperDA = new HelpersDA();
        if ($helperDA->delete($helper)) {
            $_SESSION['successMsg2'] = "You have drop out from the event as a <strong>helper</strong>. Hope to see you again!";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['errorMsg'] = "Unexpected error occur.";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        }
    }
}