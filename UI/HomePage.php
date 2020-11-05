<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Society.php';
include_once '../DataAccess/SocietyEventDA.php';
include_once '../DataAccess/ScheduleDA.php';

session_start();
require '../UI/header.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home Page</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
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
        <style>
            .visitButton{
                background-color:#ffedf7;
                color:#000000;
            }
            .contentHeader{
                background-color:#ff8f94;
            }
            .content{
                font-family:verdana;
            }
        </style>
    </head>
    <body>
<!--        original table class <table id='eventTable' class ='table table-hover table-responsive table-bordered'>-->
        <div class='container'>
            <div class='page-header'>
                <h1 style="font-family: helvetica;">Events Happening</h1>
            </div>
            <?php
            //table clsas removed table-responsive
            echo "<table id='eventTable' class ='table table-hover  table-bordered'>";
            echo "<thead class='contentHeader'>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $eventDA = new SocietyEventDA();
            $eventArray = $eventDA->retrieve();
            if ($eventArray == null) {
                echo "<tr>";
                echo "<td colspan='7' style=color:red;text-align:center;>No records found.</td>";
                echo "</tr>";
            } else {
                foreach ($eventArray as $event) {
                    echo "<tr>";
                    $scheduleDA = new ScheduleDA();
                    $schedule = $scheduleDA->retrieveLowestDateByEventID($event->eventID);
                    if ($schedule != null) {
                        $stFormat = $schedule->startDate . " " . $schedule->startTime;
                        $st = strtotime($stFormat);
                        //convert format to Thursday, 2020--Oct-01 4:00 PM
                        $startDateTimeFormatted = date("D, Y-M-d h:i A", strtotime($stFormat));
                    } else {
                        $startDateTimeFormatted = '';
                    }
                    echo "<td class='content'>$event->eventName <p style='color:#c95f66'>$startDateTimeFormatted </p></td>";
                    echo "<td> <a href = 'EventDetails.php?eventID={$event->eventID}' class='btn btn-primary m-r-1em visitButton'>Visit</a> ";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            ?>
        </div>
    </body>
</html>
