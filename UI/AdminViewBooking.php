<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';
require '../DataAccess/BookingDA.php';
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
        <title>Booking History</title>

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
                $('#bookingApplication').DataTable();
            });
            function approveBooking(value) {
                if (confirm('Are you sure want to approve?')) {
                    // Save it!
                    var valueSpilted = value.split(':');
                    var existCol = document.getElementById(valueSpilted[0] + ":existCol");
                    var hiddenCol = document.getElementById(valueSpilted[0] + ":hiddenCol");
                    existCol.style.display = 'none';
                    hiddenCol.style.display = 'block';
                    $.ajax
                            ({
                                type: "POST",
                                url: "../Domain/UpdateBooking.php",
                                data: {
                                    "bookingID": valueSpilted[0],
                                    "bookStatus": valueSpilted[1],
                                },
                                success: function (data) {
                                    alert(data);
                                }
                            });
                } else {
                    // Do nothing!
                }
            }
            function openFeedbackForm(value) {
                var valueSpilted2 = value.split(':');
                $('#bookingID').val(valueSpilted2[0]);
                $('#societyID').val(valueSpilted2[1]);
                $('#add_data_Modal').modal('show');
            }
            function disapproveBooking() {

                var bookingID = document.getElementById("bookingID").value;
                var societyID = document.getElementById("societyID").value;
                var feedback = document.getElementById("feedback").value;
                $.ajax
                        ({
                            type: "POST",
                            url: "../Domain/UpdateBooking.php",
                            data: {
                                "bookingID": bookingID,
                                "bookStatus": 'Disapproved',
                                "feedback": feedback,
                                "societyID": societyID
                            },
                            success: function (data) {
                                $('#add_data_Modal').modal('hide');
                                alert(data);
                                location.reload();
                            }
                        });
            }
        </script>
    </head>

    <body>
        <div class='container'>
            <h1 class='bodyTitle'>Manage Booking</h1>
            <hr>
            <?php
            if (isset($_SESSION['result'])) {
                echo "<table id='bookingApplication' class='table table-hover table-bordered'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>No</th>";
                echo "<th>Booking ID</th>";
                echo "<th>Venue</th>";
                echo "<th>Date</th>";
                echo "<th>Duration</th>";
                echo "<th>Status</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                $bookingDA = new BookingDA();
                $bookingArray = $bookingDA->retrieveAll();
                if ($bookingArray == null) {
                    echo "<tr>";
                    echo "<td colspan='7' style=color:red;text-align:center;>No records found.</td>";
                    echo "</tr>";
                } else {
                    //class= 'table table-hover table-responsive table-bordered'
                    $count = 1;
                    foreach ($bookingArray as $booking) {
                        $dateFormatted = date("d-M-Y", strtotime($booking->bookDate));
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>{$booking->bookID}</td>";
                        echo "<td>{$booking->venueName}</td>";
                        echo "<td>{$dateFormatted}</td>";
                        $stFormatted = date("g:i A", strtotime($booking->startTime));
                        $etFormatted = date("g:i A", strtotime($booking->endTime));
                        echo "<td>{$stFormatted} - {$etFormatted}</td>";
                        echo "<td>{$booking->bookStatus}</td>";
                        if ($booking->bookStatus == 'Pending') {
                            //if pending show Approve, Disapprove Button
                            echo "<td id='$booking->bookID:existCol' > "
                            . "<a id='$booking->bookID:Approved' onClick='approveBooking(this.id)'  class='btn btn-success m-r-1em'>Approve</a> "
                            . "<p id='$booking->bookID:$booking->societyID:Disapproved' onClick='openFeedbackForm(this.id)' class='btn btn-danger m-r-1em'>Disapprove</p> ";
                            echo "<td id='$booking->bookID:hiddenCol' style='display:none;'>  <a id='$booking->bookID' class='btn btn-info m-r-1em'>Processed</a> </td>";
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
                header('location:HomePage.php');
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
                            <input type="hidden" name="bookingID" id="bookingID"/>
                            <input type="hidden" name="societyID" id="societyID"/>
                            <input type="submit" name="vSubmit" id="insert" onClick='disapproveBooking()' value="Insert" class="btn btn-success" />  
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
