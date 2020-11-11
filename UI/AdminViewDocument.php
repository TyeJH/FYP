<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';
require '../DataAccess/DocumentationDA.php';
require '../Domain/SocietyEvent.php';
session_start();
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
        <title>Document History</title>
        <!--        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
        
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
                Data Table
                <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
                <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
                <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        
                Display Modal
                <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        <script>
            $(document).ready(function () {
                $('#documentApplication').DataTable();
            });
            function approveDocument(value) {
                var valueSpilted = value.split(':');
                var existCol = document.getElementById(valueSpilted[0] + ":existCol");
                var hiddenCol = document.getElementById(valueSpilted[0] + ":hiddenCol");
                existCol.style.display = 'none';
                hiddenCol.style.display = 'block';
                $.ajax
                        ({
                            type: "POST",
                            url: "../Domain/UpdateDocument.php",
                            data: {
                                "docID": valueSpilted[0],
                                "status": valueSpilted[1],
                            },
                            success: function (data) {
                                alert(data);
                            }
                        });
            }
            function openFeedbackForm(value) {
                var valueSpilted2 = value.split(':');
                $('#docID').val(valueSpilted2[0]);
                $('#societyID').val(valueSpilted2[1]);
                $('#add_data_Modal').modal('show');
            }
            function disapproveDocument() {
                var docID = document.getElementById("docID").value;
                var societyID = document.getElementById("societyID").value;
                var feedback = document.getElementById("feedback").value;

                $.ajax
                        ({
                            type: "POST",
                            url: "../Domain/UpdateDocument.php",
                            data: {
                                "docID": docID,
                                "status": 'Disapproved',
                                "feedback": feedback,
                                "societyID": societyID
                            },
                            success: function (data) {
                                $('#add_data_Modal').modal('hide');
                                alert(data);
                            }
                        });
            }
        </script>
    </head>

    <body>
        <div class='container'>
            <h2>Document Application</h2>
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
                $documentationDA = new DocumentationDA();
                $docArray = $documentationDA->retrieveAll();
                if ($docArray == null) {
                    echo "<tr>";
                    echo "<td colspan='4' style=color:red;text-align:center;>No records found.</td>";
                    echo "</tr>";
                } else {
                    $count = 1;
                    foreach ($docArray as $doc) {
                        echo "<tr>";
                        echo "<td>{$doc->docID}</td>";
                        echo "<td><a title='Download File' download='" . $doc->docName . "' href=data:" . $doc->mime . ";base64," . base64_encode($doc->docContent) . ">$doc->docName</a></td>";
                        $dateFormatted = date("d-M-Y", strtotime($doc->applyDate));
                        echo "<td>{$dateFormatted}</td>";
                        echo "<td>{$doc->status}</td>";
                        if ($doc->status == 'Pending') {
                            echo "<td id='$doc->docID:existCol' >  "
                            . "<a id='$doc->docID:Approved' onClick='approveDocument(this.id)' class='btn btn-success m-r-1em'>Approve</a> "
                            . "<p id='$doc->docID:$doc->societyID:Disapproved' onClick='openFeedbackForm(this.id)' class='btn btn-danger m-r-1em'>Disapprove</p> </td>";
                            echo "<td id='$doc->docID:hiddenCol' style='display:none;'>  <a id='$doc->docID' class='btn btn-info m-r-1em'>Processed</a> ";
                        } else {
                            echo "<td> <button class='btn btn-secondary m-r-1em' disabled>Processed</button> </td>";
                        }
                        echo "</tr>";
                        $count++;
                    }
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                header('Location:HomePage.php');
            }
            ?>
            <a href = "HomePage.php" class = "btn btn-danger">Back</a>
        </div>
        <!--Add Feedback Details-->
        <div id="add_data_Modal" class="modal fade">  
            <div class="modal-dialog">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                        <h4 class="modal-title">Feedback</h4>  
                    </div>  
                    <div class="modal-body">
                        <form method="POST" id="insert_form">  
                            <label>Feedback</label> 
                            <textarea name="feedback" id="feedback" class="form-control" placeholder="Enter feedback details" style="resize: none;"></textarea> 
                            <br />
                            <input type="hidden" name="docID" id="docID"/>
                            <input type="hidden" name="societyID" id="societyID"/>
                            <input type="submit" name="vSubmit" id="insert" onClick='disapproveDocument()' value="Insert" class="btn btn-success" />  
                        </form>  
                    </div>  
                    <div class="modal-footer">  
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </body>
</html>
