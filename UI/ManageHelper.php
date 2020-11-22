<?php
require_once '../Domain/Helpers.php';
require_once '../DataAccess/HelpersDA.php';
require_once '../DataAccess/StudentDA.php';
require_once '../DataAccess/SocietyEventDA.php';

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

        <!--Display Modal-->
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js' type='text/javascript'></script>
        <script>
            $(document).ready(function () {
                $('#helpersApplication').DataTable();
            });
            function updateApplyStatus(userID) {
                var checkBox = document.getElementById(userID);
                var value = document.getElementById(userID).value;
                var valueSpilted = value.split(',');
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
                            url: "../Domain/UpdateHelper.php", //can remove URL also fine bcuz I had included the eventProcess.php
                            data: {
                                "type": type,
                                "eventID": valueSpilted[0],
                                "userID": valueSpilted[1],
                                "applyDate": valueSpilted[2],
                                "applyStatus": applyStatus
                            },
                            success: function (data) {
                                alert(data);
                            }
                        });
            }
            $(document).on('click', '.view_data', function () {
                var eventID = $(this).attr("id");
                if (eventID != '')
                {
                    $.ajax({
                        url: "../Domain/ViewHelpersContactList.php",
                        method: "POST",
                        data: {eventID: eventID},
                        success: function (data) {
                            //alert("hi");
                            $('#helpersDetails').html(data);
                            $('#helpersDetailsModal').modal('show');
                        }
                    });
                }
            });
        </script>
    </head>
    <body>
        <div class='container'>
            <div class='page-header'>
                <h1 class='bodyTitle'>Manage Helper</h1>
            </div>
            <?php
            $societyDA = new SocietyEventDA();
            $society = $societyDA->retrieveByEventID($_GET['eventID']);
            if ($society != null) {
                echo "<h3>$society->eventName</h3>";
            }
            ?>
            <?php
            if (isset($_GET['eventID'])) {
                $eventID = $_GET['eventID'];
                $helpersDA = new HelpersDA();
                $helperArray = $helpersDA->retrieve($eventID);
                $studentDA = new StudentDA();
                $count = 1;
                if ($helperArray == null) {
                    echo "<p>No helper applied yet.</p>";
                } else {
                    echo "<input type = 'button' name = 'viewApprovedHelpersContacts' value = 'View Approved Helper Contact' id = '$eventID' class = 'btn btn-info m-r-1em view_data' />";
                    echo "<br>";
                    echo "<br>";
                    echo "<table id='helpersApplication' class = 'table table-hover table-bordered'>";
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
                    foreach ($helperArray as $helper) {
                        $student = $studentDA->retrieveStudentDetails($helper->userID);
                        echo "<tr>";
                        echo "<td>$count</td>";
                        //echo "<td>$helper->userID</td>";
                        echo "<td>{$student['studID']}</td>";
                        echo "<td>{$student['studName']}</td>";
                        echo "<td>{$student['studEmail']}</td>";
                        $dateFormatted = date("d-M-Y", strtotime($helper->applyDate));
                        echo "<td>{$dateFormatted}</td>";
                        if ($helper->applyStatus == 'Approved') {
                            echo "<td><input type='checkbox' onclick='updateApplyStatus(this.id)' id='$helper->eventID:$helper->userID' value='$helper->eventID,$helper->userID,$helper->applyDate' checked></td>";
                        } else {
                            echo "<td><input type='checkbox' onclick='updateApplyStatus(this.id)' id='$helper->eventID:$helper->userID' value='$helper->eventID,$helper->userID,$helper->applyDate'></td>";
                        }
                        echo "</tr>";
                        $count++;
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
            } else {
                header('location:EventOrganizerHome.php');
            }
            ?>
            <a href="EventOrganizerHome.php" class="btn btn-danger">Back</a>

            <!--Display Contacts Modal-->
            <div class="modal fade" id="helpersDetailsModal" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Contacts</h4>
                        </div>
                        <div class="modal-body" id="helpersDetails">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
