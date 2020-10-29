<?php

include_once '../Domain/Schedule.php';
include_once '../DataAccess/ScheduleDA.php';
include_once '../Domain/Society.php';

session_start();
if (isset($_POST['updateSchedule'])) {

    //initializes
    $scheduleID = $_POST['scheduleID'];
    if ($_POST["unlimited:$scheduleID"] == 'Yes') {
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
    $scheduleStatus = $_POST['scheduleStatus'];
    //$societyID = $_SESSION['result']->societyID;
    $eventID = $_POST['eventID'];
    $noOfJoined = $_POST['noOfJoined'];
    //convert format to dd/mm/yyyy 2400
    $stFormat = $startDate . " " . $startTime;
    $etFormat = $endDate . " " . $endTime;
    $st = strtotime($stFormat);
    $et = strtotime($etFormat);
    if ($st > $et || $st == $et) {
        echo "<script>alert('The end time must be greater than the start time.');location.href = '../UI/EditSchedule.php?eventID=$eventID';</script>";
    } else {
        $schedule = new Schedule($scheduleID, $venue, $startDate, $startTime, $endDate, $endTime, $unlimited, $noOfParticipant, $noOfJoined, $scheduleStatus, $eventID);
        $scheduleDA = new ScheduleDA();
        if ($scheduleDA->update($schedule)) {
           echo "<script>alert('Successfully Updated.');location.href = '../UI/EditSchedule.php?eventID=$eventID';</script>";
        } else {
            echo "<script>alert('Unexpected error occur.');location.href = '../UI/EditSchedule.php?eventID=$eventID';</script>";
        }
    }
}
