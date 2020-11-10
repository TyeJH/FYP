<?php
require '../DataAccess/DocumentationDA.php';
require '../DataAccess/SocietyEventDA.php';
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

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

        <!--Display Modal-->
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>

        <title>View Applications</title>
        <script>
            $(document).on('click', '.view_data', function () {
                var docID = $(this).attr("id");
                if (docID !== '')
                {
                    $.ajax({
                        url: "../Domain/ViewFeedbackDocument.php",
                        method: "POST",
                        data: {docID: docID},
                        success: function (data) {
                            //alert("hi");
                            $('#feedbackDetails').html(data);
                            $('#myModal').modal('show');
                        }
                    });
                }
            });
            $(document).ready(function () {
                $('#documentsTable').DataTable();
            });

        </script>
    </head>
    <body>
        <div class='container'>
            <div class='page-header'>
                <h1>Your Applications</h1>
            </div>
            <?php
            if (isset($_SESSION['result'])) {
                echo "<table id='documentsTable' class = 'table table-hover table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Document ID</th>";
                echo "<th>Name</th>";
                echo "<th>Date Applied</th>";
                echo "<th>Status</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "<thead>";
                echo "<tbody>";

                $societyID = $_SESSION['result']->societyID;
                $documentationDA = new DocumentationDA();
                $docArray = $documentationDA->retrieveBySocietyID($societyID);
                if ($docArray == null) {
                    echo "<tr>";
                    echo "<td colspan='4' style=color:red;text-align:center;>No records found.</td>";
                    echo "</tr>";
                } else {
                    foreach ($docArray as $doc) {
                        echo "<tr>";
                        echo "<td>{$doc->docID}</td>";
                        echo "<td><a title='Download File' download='" . $doc->docName . "' href=data:" . $doc->mime . ";base64," . base64_encode($doc->docContent) . ">$doc->docName</a></td>";
                        $dateFormatted = date("Y-M-d", strtotime($doc->applyDate));
                        echo "<td>{$dateFormatted}</td>";
                        if ($doc->status == "Approved") {
                            echo "<td><div style='color:#3c763d;' >{$doc->status}</div></td>";
                        } else if ($doc->status == "Pending") {
                            echo "<td><div style='color:#8a6d3b;' >{$doc->status}</div></td>";
                        } else if ($doc->status == "Disapproved") {
                            echo "<td><div style='color:#a94442;' >{$doc->status}</div></td>";
                        }
                        $eventDA = new SocietyEventDA();
                        if ($eventDA->isApplyIdExist($doc->docID)) {
                            echo "<td> <p class='btn btn-info m-r-1em'>Created</p> </td>";
                        } else {
                            if ($doc->status == "Approved") {
                                echo "<td> <a href = 'SocietyCreateEvent.php?applyID={$doc->docID}' class='btn btn-primary m-r-1em'>Create event</a> </td>";
                            } else if ($doc->status == "Pending") {
                                echo "<td> <p>Waiting for approval</p> </td>";
                            } else if ($doc->status == "Disapproved") {
                                echo "<td><input type = 'button' name = 'edit' value = 'View Feedback' id = '{$doc->docID}' class = 'btn btn-primary m-r-1em view_data' /></td>";
                            }
                        }
                    }
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                header('Location:EventOrganizerHome.php');
            }
            ?>
            <a href="EventOrganizerHome.php" class="btn btn-danger">Back</a>
        </div>

        <!--Display Feedback Modal-->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Feedback</h4>
                    </div>
                    <div class="modal-body" id="feedbackDetails">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
