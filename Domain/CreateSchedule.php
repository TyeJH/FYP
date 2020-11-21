<?php

include_once '../Domain/Schedule.php';
include_once '../DataAccess/ScheduleDA.php';
include_once '../Domain/Society.php';

session_start();
if (isset($_POST['createSchedule'])) {

    //initializes
    if ($_POST['unlimited'] == "Yes") {
        $unlimited = 'Yes';
        $noOfParticipant = null;
    } else {
        $unlimited = 'No';
        $noOfParticipant = $_POST['noOfParticipant'];
    }
    $venue = $_POST['venue'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endDate = $_POST['endDate'];
    $endTime = $_POST['endTime'];
    $scheduleStatus = 'Ongoing';
    $societyID = $_SESSION['result']->societyID;
    $eventID = $_POST['eventID'];
    $noOfJoined = 0;
    //convert format to dd/mm/yyyy 2400
    $stFormat = $startDate . " " . $startTime;
    $etFormat = $endDate . " " . $endTime;
    $st = strtotime($stFormat);
    $et = strtotime($etFormat);

    if ($st > $et || $st == $et) {
        $_SESSION['errorMsg'] = "The end time must be greater than the start time";
        header("Location:../UI/EnterSchedule.php?eventID=$eventID");
    } else {
        $schedule = new Schedule($scheduleID = "", $venue, $startDate, $startTime, $endDate, $endTime, $unlimited, $noOfParticipant, $noOfJoined, $scheduleStatus, $eventID);
        $scheduleDA = new ScheduleDA();
        if ($scheduleDA->create($schedule)) {
            $_SESSION['successMsg'] = 'Schedule Created.';
            header("Location:../UI/EnterSchedule.php?eventID=$eventID");
        } else {
            $_SESSION['errorMsg'] = 'Unexpected error occur.';
            header("Location:../UI/EnterSchedule.php?eventID=$eventID");
        }
    }
}

//if input false, negative result will occur when dateOne is earlier than dateTwo
function millisecsBetween($dateOne, $dateTwo, $abs = true) {
    $func = $abs ? 'abs' : 'intval';
    return $func(strtotime($dateOne) - strtotime($dateTwo)) * 1000;
}
