<?php require_once '../DataAccess/ParticipantsDA.php'; ?>

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
                    applyStatus = "Disapprove";
                }
                $.ajax
                        ({
                            type: "POST",
                            url: "../Domain/UpdateParticipant.php", //can remove URL also fine bcuz I had included the eventProcess.php
                            data: {
                                "type": type,
                                "scheduleID": valueSpilted[0],
                                "eventID": valueSpilted[1],
                                "userID": userID,
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
                <h1>Participants Applications</h1>
            </div>

            <?php
            echo "<table id=participantsApplication class = 'table table-hover table-responsive table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>No </th>";
            echo "<th>Student ID</th>";
            //echo "<th>Name</th>";
            echo "<th>Schedule ID</th>";
            echo "<th>Apply Date</th>";
            echo "<th>Approval</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            if (isset($_GET['eventID'])) {
                $participantsDA = new ParticipantsDA();
                $participants = array();
                $participants = $participantsDA->retrieve($_GET['eventID'], 'Pending');
                $count = 1;
                if ($participants == null) {
                    echo "<tr>";
                    echo "<td colspan='5' style=color:red;text-align:center;>No records found.</td>";
                    echo "</tr>";
                } else {
                    foreach ($participants as $participant) {
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>$participant->userID</td>";
                        echo "<td>$participant->scheduleID</td>";
                        //echo "<td>{$studName}</td>";
                        $dateFormatted = date("Y-M-d", strtotime($participant->applyDate));
                        echo "<td>{$dateFormatted}</td>";

                        if ($participant->applyStatus == 'Approved') {
                            echo "<td>  <input type='checkbox' onclick='updateApplyStatus(this.id)' id='$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate' checked></td>";
                        } else {
                            echo "<td>  <input type='checkbox' onclick='updateApplyStatus(this.id)' id='$participant->userID' value='$participant->scheduleID,$participant->eventID,$participant->userID,$participant->applyDate'></td>";
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
