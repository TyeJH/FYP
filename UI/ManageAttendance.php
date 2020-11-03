<?php
require '../DataAccess/ParticipantsDA.php';
require '../DataAccess/ScheduleDA.php';
require '../Domain/UpdateParticipant.php';
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
                    attendanceStatus = "Attended";
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
        </script>
    </head>
    <body>
        <div class='container'>
            <div class='page-header'>
                <h1>Manage Attendance</h1>
            </div>

            <?php
            if (isset($_GET['eventID'])) {
                $scheduleDA = new ScheduleDA();
                $scheduleArray = $scheduleDA->retrieve($_GET['eventID']);
                if ($scheduleArray != null) {
                    foreach ($scheduleArray as $schedule) {
                        echo "<div style='background-color:#FFF5F5'>";
                        //convert format to dd/mm/yyyy 2200
                        $stFormat = $schedule->startDate . " " . $schedule->startTime;
                        $etFormat = $schedule->endDate . " " . $schedule->endTime;
                        $st = strtotime($stFormat);
                        $et = strtotime($etFormat);
                        //convert format to Thursday, 2020--Oct-01 4:00 PM
                        $startDateTimeFormatted = date("D, Y-M-d h:i A", strtotime($stFormat));
                        $endDateTimeFormatted = date("D, Y-M-d h:i A", strtotime($etFormat));
                        echo "<h3><strong>Schedule Session :</strong> $startDateTimeFormatted - $endDateTimeFormatted</h3>";
                        echo "<p><strong>Venue :</strong> $schedule->venue</p>";
                        $participantsDA = new ParticipantsDA();
                        $participantArray = $participantsDA->retrieve($schedule->scheduleID, 'Approved');
                        $count = 1;
                        echo "<table id='participantsApplication' class = 'table table-hover table-responsive table-bordered'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>No </th>";
                        echo "<th>Student ID</th>";
                        //echo "<th>Name</th>";
                        //echo "<th>Schedule Session</th>";
                        echo "<th>Attendance</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        if ($participantArray == null) {
                            echo "<p>Currently no participants in this schedule yet.</p>";
                        } else {
                            foreach ($participantArray as $participant) {
                                echo "<tr>";
                                echo "<td>$count</td>";
                                echo "<td>$participant->userID</td>";
                                //echo "<td>{$studName}</td>";
                                if ($participant->attendanceStatus == 'Attended') {
                                    echo "<td>  <input type='checkbox' onclick='updateAttendanceStatus(this.id)' id='$participant->scheduleID,$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate,$participant->applyStatus' checked></td>";
                                } else {
                                    echo "<td>  <input type='checkbox' onclick='updateAttendanceStatus(this.id)' id='$participant->scheduleID,$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate,$participant->applyStatus'></td>";
                                }
                                echo "</tr>";
                                $count++;
                            }
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                        echo "<hr style='color:black;border-width:10px;'>";
                    }
                } else {
                    echo "<a href='..UI/ManageSchedule.php'>No schedule yet. Click here to add schedule</a><br><br>";
                }
            } else {
                header('location:EventOrganizerHome.php');
            }
            ?>
            <a href="EventOrganizerHome.php" class="btn btn-danger">Back</a>
        </div>
    </body>
</html>
