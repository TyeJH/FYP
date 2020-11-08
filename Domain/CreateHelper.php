<?php

include_once '../Domain/Helper.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/HelpersDA.php';
include_once '../Domain/Student.php';
include_once '../DataAccess/ScheduleDA.php';
session_start();
if (isset($_GET['eventID'])) {
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $eventID = $_GET['eventID'];
    $userID = $_SESSION['result']->studID;
    //$userID = 123;
    $applyStatus = "Pending";
    $applyDate = date('Y-m-d H:i:s'); //2020-10-22 03:53:54 sample format
    
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
        $helper = new Helpers($eventID, $userID, $applyDate, $applyStatus);
        $helpersDA = new HelpersDA();
        if ($helpersDA->create($helper)) {
            $_SESSION['succeessMsg'] = 'Thanks for joining us! Do give us time for approving.';
            header("location:../UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['errorMsg'] = "Unexpected error occur.";
            header("location:../UI/EventDetails.php?eventID=$eventID");
        }
    }
}