<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';
require '../DataAccess/DocumentationDA.php';
require '../Domain/SocietyEvent.php';
session_start();
if ($_SESSION['current'] != 'Admin') {
    unset($_SESSION['current']);
    $_SESSION['role'] = 'staff';
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
        <title>Document History</title>

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
                $('#documentApplication').DataTable();
            });
            function approveDocument(value) {
                if (confirm('Are you sure want to approve?')) {
                    var valueSpilted = value.split(':');
                    var approveButton = document.getElementById(valueSpilted[0] + ":" + valueSpilted[1] + ":Approved");
                    var disapproveButton = document.getElementById(valueSpilted[0] + ":" + valueSpilted[1] + ":Disapproved");
                    var processedButton = document.getElementById(valueSpilted[0] + ":" + valueSpilted[1] + ":Processed");
                    var statusText = document.getElementById(valueSpilted[0] + ":status");
                    $.ajax
                            ({
                                type: "POST",
                                url: "../Domain/UpdateDocument.php",
                                data: {
                                    "docID": valueSpilted[0],
                                    "status": valueSpilted[2]
                                },
                                success: function (data) {
                                    if (data != 'error') {
                                        statusText.innerHTML = 'Approved';
                                        approveButton.style.display = 'none';
                                        disapproveButton.style.display = 'none';
                                        processedButton.style.display = 'block';
                                        alert(data);
                                    } else {
                                        alert('Sorry, unexpected error occur');
                                    }
                                    //location.reload();
                                }
                            });
                }

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
                var approveButton = document.getElementById(docID + ":" + societyID + ":Approved");
                var disapproveButton = document.getElementById(docID + ":" + societyID + ":Disapproved");
                var processedButton = document.getElementById(docID + ":" + societyID + ":Processed");
                var statusText = document.getElementById(docID + ":status");
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
                                if (data != 'error') {
                                    statusText.innerHTML = 'Disapproved';
                                    approveButton.style.display = 'none';
                                    disapproveButton.style.display = 'none';
                                    processedButton.style.display = 'block';
                                    alert(data);
                                } else {
                                    alert('Sorry, unexpected error occur');
                                }
                                //location.reload();
                            }
                        });
            }
        </script>
    </head>

    <body>
        <div class='container'>
            <h1 class='bodyTitle'>Manage Document</h1>
            <hr>
            <?php
            if (isset($_SESSION['result'])) {
                echo "<table id='documentApplication' class = 'table table-hover table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>No</th>";
                echo "<th>Document ID</th>";
                echo "<th>Name</th>";
                echo "<th>Date Applied</th>";
                echo "<th>Status</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                $documentationDA = new DocumentationDA();
                $docArray = $documentationDA->retrieveAll();
                if ($docArray == null) {
                    echo "<tr>";
                    echo "<td colspan='5' style='color:red;text-align:center;'>No records found.</td>";
                    echo "</tr>";
                } else {
                    $count = 1;
                    foreach ($docArray as $doc) {
                        echo "<tr>";
                        echo "<td>$count</td>";

                        echo "<td>{$doc->docID}</td>";
                        echo "<td><a title='Download File' download='" . $doc->docName . "' href=data:" . $doc->mime . ";base64," . base64_encode($doc->docContent) . ">$doc->docName</a></td>";
                        $dateFormatted = date("d-M-Y", strtotime($doc->applyDate));
                        echo "<td>{$dateFormatted}</td>";
                        echo "<td id='$doc->docID:status'>{$doc->status}</td>";
                        if ($doc->status == 'Pending') {
                            echo "<td id='$doc->docID:existCol'> "
                            . "<a id='$doc->docID:$doc->societyID:Approved' onClick='approveDocument(this.id)' class='btn btn-success m-r-1em'>Approve</a> "
                            . "<a id='$doc->docID:$doc->societyID:Disapproved' onClick='openFeedbackForm(this.id)' class='btn btn-danger m-r-1em'>Disapprove</a>"
                            . "<button style='display:none;' id='$doc->docID:$doc->societyID:Processed' class='btn btn-secondary m-r-1em' disabled>Processed</button></td>";
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
            <a href = "HomePage.php" class = "btn btn-info">Back</a>
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
