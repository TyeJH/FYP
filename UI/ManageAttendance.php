<?php require '../DataAccess/ParticipantsDA.php'; ?>
<?php require '../Domain/UpdateParticipant.php'; ?>

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
            function updateAttendanceStatus(userID) {
                var checkBox = document.getElementById(userID);
                var value = document.getElementById(userID).value;
                var valueSpilted = value.split(',');
                var attendanceStatus = "";
                var type = 'attendance';
                if (checkBox.checked === true) {;
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
                                "eventID": valueSpilted[0],
                                "userID": userID,
                                "applyDate": valueSpilted[2],
                                "applyStatus": valueSpilted[3],
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
                $participantsDA = new ParticipantsDA();
                $participantArray = $participantsDA->retrieve($_GET['eventID'],'Approved');
                $count = 1;
                echo "<table id=participantsApplication class = 'table table-hover table-responsive table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>No </th>";
                echo "<th>Student ID</th>";
                //echo "<th>Name</th>";
                echo "<th>Attendance</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                if ($participantArray == null) {
                    echo "<tr>";
                    echo "<td colspan='5' style=color:red;text-align:center;>No records found.</td>";
                    echo "</tr>";
                } else {
                    foreach ($participantArray as $participant) {
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>$participant->userID</td>";
                        //echo "<td>{$studName}</td>";
                        if ($participant->attendanceStatus == 'Attended') {
                            echo "<td>  <input type='checkbox' onclick='updateAttendanceStatus(this.id)' id='$participant->userID' value='$participant->eventID,$participant->userID,$participant->applyDate,$participant->applyStatus' checked></td>";
                        } else {
                            echo "<td>  <input type='checkbox' onclick='updateAttendanceStatus(this.id)' id='$participant->userID' value='$participant->eventID,$participant->userID,$participant->applyDate,$participant->applyStatus'></td>";
                        }
                        $count++;
                    }
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                header('location:EventOrganizerHome.php');
            }
            ?>
            <a href="EventOrganizerHome.php" class="btn btn-danger">Back</a>
        </div>
    </body>
</html>
