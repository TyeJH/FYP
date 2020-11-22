<?php
require '../DataAccess/ParticipantsDA.php';
require '../DataAccess/ScheduleDA.php';
require '../DataAccess/SocietyEventDA.php';
require '../DataAccess/StudentDA.php';
require '../Domain/UpdateParticipant.php';
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#participantsApplication').DataTable();
            });
            function updateAttendanceStatus(scheduleIDuserID) {
                var checkBox = document.getElementById(scheduleIDuserID);
                var value = document.getElementById(scheduleIDuserID).value;
                var valueSpilted = value.split(',');
                var attendanceStatus = "";
                var type = 'attendance';
                if (checkBox.checked === true) {
                    attendanceStatus = "Attend";
                } else {
                    attendanceStatus = "Absent";
                }
                $.ajax
                        ({
                            type: "POST",
                            url: "../Domain/UpdateParticipant.php",
                            data: {
                                "type": type,
                                "scheduleID": valueSpilted[0],
                                "eventID": valueSpilted[1],
                                "userID": valueSpilted[2],
                                "applyDate": valueSpilted[3],
                                "applyStatus": valueSpilted[4],
                                "attendanceStatus": attendanceStatus
                            },
                            success: function (data) {
                                alert(data);
                            }
                        });
            }
//            function generateAttendanceReport(data) {
//                var valueSpilted = data.split(',');
//                $.ajax
//                        ({
//                            type: "POST",
//                            url: "../Domain/GenerateAttendanceReport.php",
//                            data: {
//                                "eventID": valueSpilted[0],
//                                "scheduleID": valueSpilted[1]
//                            },
//                            success: function (data) {
//                                
//                            }
//                        });
//            }
        </script>
    </head>
    <body>
        <div class='container'>
            <div class='page-header'>
                <h1 class='bodyTitle'>Manage Attendance</h1>

            </div>
            <?php
            $societyDA = new SocietyEventDA();
            $society = $societyDA->retrieveByEventID($_GET['eventID']);
            if ($society != null) {
                echo "<h3>$society->eventName</h3>";
            }
            ?>
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
                <button type="submit" class="btn btn-info m-r-1em">Display</button>
            </form>
            <?php
            if (isset($_GET['eventID'])) {
                echo "<hr style='color:black;border-width:10px;'>";

                $eventID = $_GET['eventID'];
                $scheduleDA = new ScheduleDA();
                $schedule = $scheduleDA->retrieve($eventID);
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
                        echo "<h3><strong>Schedule Session :</strong> $startDateTimeFormatted - $endDateTimeFormatted</h3>";
                        echo "<p><strong>Venue :</strong> $schedule->venue</p>";
                        $participantsDA = new ParticipantsDA();
                        $participantArray = $participantsDA->retrieve($schedule->scheduleID, 'Approved');
                        $studentDA = new StudentDA();
                        $count = 1;
                        if ($participantArray == null) {
                            echo "<p>No participant in this schedule yet.</p>";
                        } else {
                            echo "<form target='_blank' action='../Domain/GenerateAttendanceReport.php' method='Post'>";
                            echo "<input type='hidden' value='$eventID' name='eventID'>";
                            echo "<input type='hidden' value='$schedule->scheduleID' name='scheduleID'>";
                            echo "<label>Attendance Report</label><br>";
                            echo "<input style='border:1px solid;'type='image' src='../image/attendanceIcon.jpg' alt='Submit' width='48' height='48'>";
                            echo "</form>";
                            //echo "<button onclick='generateAttendanceReport(this.value)' value='$eventID,$schedule->scheduleID'>Attendance Report</button>";
                            echo "<table id='participantsApplication' class = 'table table-hover  table-bordered'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>No </th>";
                            echo "<th>Student ID</th>";
                            echo "<th>Name</th>";
                            echo "<th>Email</th>";
                            echo "<th>Attendance</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($participantArray as $participant) {
                                $student = $studentDA->retrieveStudentDetails($participant->userID);
                                echo "<tr>";
                                echo "<td>$count</td>";
                                //echo "<td>$helper->userID</td>";
                                echo "<td>{$student['studID']}</td>";
                                echo "<td>{$student['studName']}</td>";
                                echo "<td>{$student['studEmail']}</td>";
                                if ($participant->attendanceStatus == 'Attended') {
                                    echo "<td>  <input type='checkbox' onclick='updateAttendanceStatus(this.id)' id='$participant->scheduleID,$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate,$participant->applyStatus' checked></td>";
                                } else {
                                    echo "<td>  <input type='checkbox' onclick='updateAttendanceStatus(this.id)' id='$participant->scheduleID,$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate,$participant->applyStatus'></td>";
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
