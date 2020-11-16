<?php
require_once '../DataAccess/ParticipantsDA.php';
require_once '../DataAccess/ScheduleDA.php';
require_once '../DataAccess/StudentDA.php';
session_start();
if ($_SESSION['current'] != 'Society') {
    unset($_SESSION['current']);
    $_SESSION['role'] = 'society';
    header('location:Login.php');
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
        <title>View Participants Application</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#participantsApplication').DataTable();
            });
            function updateApplyStatus(userID) {
                var checkBox = document.getElementById(userID);
                var value = document.getElementById(userID).value;
                var valueSpilted = value.split(',');
                var attendanceStatus = "";
                var type = 'approval';
                var applyStatus = "";
                if (checkBox.checked === true) {
                    applyStatus = "Approved";
                } else {
                    applyStatus = "Disapproved";
                }
                $.ajax
                        ({
                            type: "POST",
                            url: "../Domain/UpdateParticipant.php", //can remove URL also fine bcuz I had included the eventProcess.php
                            data: {
                                "type": type,
                                "scheduleID": valueSpilted[0],
                                "eventID": valueSpilted[1],
                                "userID": valueSpilted[2],
                                "applyDate": valueSpilted[3],
                                "applyStatus": applyStatus,
                                "attendanceStatus": attendanceStatus
                            },
                            success: function (data) {
                                alert(data);
                            }
                        });
            }
        </script>
    </head>
    <body>
        <div class='container'>
            <div class='page-header'>
                <h1 class='bodyTitle'>Manage Participant</h1>
            </div>
            <form action="" method="post">
                <label>
                    Session : 
                </label>
                <select name="sessionFilter">
                    <?php
                    $scheduleDA = new ScheduleDA();
                    $scheduleArray = $scheduleDA->retrieve($_GET['eventID']);
                    if ($scheduleArray != null) {
                        foreach ($scheduleArray as $schedule) {
                            //convert format to dd/mm/yyyy 2200
                            $stFormat = $schedule->startDate . " " . $schedule->startTime;
                            $etFormat = $schedule->endDate . " " . $schedule->endTime;
                            $st = strtotime($stFormat);
                            $et = strtotime($etFormat);
                            //convert format to Thursday, 2020--Oct-01 4:00 PM
                            $startDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($stFormat));
                            $endDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($etFormat));
                            if (isset($_POST['sessionFilter'])) {
                                if ($_POST['sessionFilter'] == $schedule->scheduleID) {
                                    echo "<option value='$schedule->scheduleID' selected>$startDateTimeFormatted - $endDateTimeFormatted</option>";
                                } else {
                                    echo "<option value='$schedule->scheduleID'>$startDateTimeFormatted - $endDateTimeFormatted</option>";
                                }
                            } else {
                                echo "<option value='$schedule->scheduleID'>$startDateTimeFormatted - $endDateTimeFormatted</option>";
                            }
                        }
                    }
                    ?>
                </select>
                <label>
                    Apply Status: 
                </label>
                <select name="statusFilter">
                    <?php
                    $status = array('Pending', 'Approved', 'Disapproved');
                    foreach ($status as $s) {
                        if (isset($_POST['statusFilter'])) {
                            if ($_POST['statusFilter'] == $s) {
                                echo "<option value='$s' selected>$s</option>";
                            } else {
                                echo "<option value='$s'>$s</option>";
                            }
                        } else {
                            echo "<option value='$s'>$s</option>";
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-info m-r-1em">Display</button>
            </form>
            <?php
            echo "<hr style='color:black;border-width:10px;'>";
            if (isset($_GET['eventID'])) {
                if (isset($_POST['statusFilter'])) {
                    $status = $_POST['statusFilter'];
                } else {
                    $status = "Pending";
                }
                if (isset($_POST['sessionFilter'])) {
                    $scheduleID = $_POST['sessionFilter'];
                    $scheduleDA = new ScheduleDA();
                    $schedule = $scheduleDA->retrieveByScheduleID($scheduleID);
                    if ($schedule != null) {
                        //convert format to dd/mm/yyyy 2200
                        $stFormat = $schedule->startDate . " " . $schedule->startTime;
                        $etFormat = $schedule->endDate . " " . $schedule->endTime;
                        $st = strtotime($stFormat);
                        $et = strtotime($etFormat);
                        //convert format to Thursday, 2020--Oct-01 4:00 PM
                        $startDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($stFormat));
                        $endDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($etFormat));
                        echo "<p><strong>Schedule Session :</strong> $startDateTimeFormatted - $endDateTimeFormatted</p>";
                        echo "<p><strong>Venue :</strong> $schedule->venue</p>";
                        $participantsDA = new ParticipantsDA();
                        $participants = array();
                        $participantArray = $participantsDA->retrieve($schedule->scheduleID, $status);
                        $studentDA = new StudentDA();
                        $count = 1;
                        if ($participantArray == null) {
                            echo "<p>No participant in '$status' yet.</p>";
                        } else {
                            echo "<table id=participantsApplication class = 'table table-hover table-bordered'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>No </th>";
                            echo "<th>Student ID</th>";
                            echo "<th>Name</th>";
                            echo "<th>Email</th>";
                            echo "<th>Apply Date</th>";
                            echo "<th>Approval</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($participantArray as $participant) {
                                $student = $studentDA->retrieveStudentDetails($participant->userID);
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td>{$student['studID']}</td>";
                                echo "<td>{$student['studName']}</td>";
                                echo "<td>{$student['studEmail']}</td>";
                                $dateFormatted = date("d-M-Y", strtotime($participant->applyDate));
                                echo "<td>{$dateFormatted}</td>";
                                if ($participant->applyStatus == 'Approved') {
                                    echo "<td><input type='checkbox' onclick='updateApplyStatus(this.id)' id='$participant->scheduleID:$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate' checked></td>";
                                } else {
                                    echo "<td><input type='checkbox' onclick='updateApplyStatus(this.id)' id='$participant->scheduleID:$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate'></td>";
                                }
                                echo "</tr>";
                                $count++;
                            }
                            echo "</tbody>";
                            echo "</table>";
                        }
                    }
                }
            } else {
                header('location:EventOrganizerHome.php');
            }
            ?>
            <a href="EventOrganizerHome.php" class="btn btn-danger">Back</a>
        </div>
    </body>
</html>
