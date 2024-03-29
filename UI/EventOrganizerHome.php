<?php
require '../DataAccess/SocietyEventDA.php';
require_once '../Domain/Schedule.php';
require_once '../Domain/SocietyEvent.php';
require '../DataAccess/ScheduleDA.php';

session_start();
if ($_SESSION['current'] != 'Society') {
    if (!isset($_SESSION['result'])) {
        //$_SESSION['current'] = 'Society';
        $_SESSION['role'] = 'society';
        header('location:Login.php');
    } else if (isset($_SESSION['result'])) {
        if ($_SESSION['result']->societyID == null) {
            $_SESSION['role'] = 'society';
            header('location:Login.php');
        }
    }
}
require 'header.php';
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        、<!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Home</title>
        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#eventTable').DataTable();
            });
        </script>
    </head>
    <body>
        <div class='container'>
            <h1>Home</h1>
            <?php echo "<p style='font-size:15px;'>Welcome back, " . $_SESSION['result']->societyName . "</p>"; ?>
            <h2>Events Happening</h2>

            <?php
            //class ='table table-hover table-responsive table-bordered' << original class
            echo "<table id='eventTable' class ='table table-hover table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Event ID</th>";
            echo "<th>Name</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $societyID = $_SESSION['result']->societyID;
            $eventDA = new SocietyEventDA();
            $scheduleDA = new ScheduleDA();
            $eventArray = $eventDA->retrieveBySocietyID($societyID);
            $found = false;
            if ($eventArray != null) {
                //retrieve schedule from the society created event
                foreach ($eventArray as $event) {
                    $haveScheduled = $scheduleDA->retrieve($event->eventID);
                    if ($haveScheduled != null) {
                        //if schedule created check if the schedule are end or not
                        $end = $eventDA->isEventEnd($event->eventID);
                        if (!$end) {
                            //display the event details
                            echo "<tr>";
                            echo "<td>{$event->eventID}</td>";
                            echo "<td>{$event->eventName}</td>";
                            echo "<td> <a href = 'EditEvent.php?eventID={$event->eventID}' class='btn btn-primary m-r-1em'>View</a> "
                            . "<a href = 'ManageSchedule.php?eventID={$event->eventID}' class = 'btn btn-primary'>Manage Schedule</a> "
                            . "<a href = 'ViewParticipantsApplication.php?eventID={$event->eventID}' class = 'btn btn-primary'>Participants</a> "
                            . "<a href='ManageAttendance.php?eventID={$event->eventID}' class='btn btn-primary'>Attendance</a> "
                            . "<a href='ManageHelper.php?eventID={$event->eventID}' class='btn btn-primary'>Helper</a></td>";
                            echo "</tr>";
                            $found = true;
                        }
                    } else {
                        //else no created schedule means new event then display
                        echo "<tr>";
                        echo "<td>{$event->eventID}</td>";
                        echo "<td>{$event->eventName}</td>";
                        echo "<td> <a href = 'EditEvent.php?eventID={$event->eventID}' class='btn btn-primary m-r-1em'>View</a> "
                        . "<a href = 'ManageSchedule.php?eventID={$event->eventID}' class = 'btn btn-primary'>Manage Schedule</a> "
                        . "<a href = 'ViewParticipantsApplication.php?eventID={$event->eventID}' class = 'btn btn-primary'>Participants</a> "
                        . "<a href='ManageAttendance.php?eventID={$event->eventID}' class='btn btn-primary'>Attendance</a> "
                        . "<a href='ManageHelper.php?eventID={$event->eventID}' class='btn btn-primary'>Helper</a></td>";
                        echo "</tr>";
                        $found = true;
                    }
                }
            } 
            if(!$found){
                echo "<tr>";
                echo "<td colspan='3' style=color:red;text-align:center;>No records found.</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            ?>
        </div>
    </body>
</html>
