<?php
require '../DataAccess/BookingDA.php';
require '../Domain/SocietyEvent.php';
session_start();
if (!isset($_SESSION['result'])) {
    $_SESSION['current'] = 'Society';
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
        <title>Booking History</title>
        <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">-->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <!--Display Modal-->
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
        <script>
            $(document).on('click', '.view_data', function () {
                var bookingID = $(this).attr("id");
                if (bookingID != '')
                {
                    $.ajax({
                        url: "../Domain/ViewFeedBackBooking.php",
                        method: "POST",
                        data: {bookingID: bookingID},
                        success: function (data) {
                            //alert("hi");
                            $('#feedbackDetails').html(data);
                            $('#myModal').modal('show');
                        }
                    });
                }
            });
            $(document).ready(function () {
                $('#BookingHistory').DataTable();
            });

        </script>
    </head>

    <body>
        <div class='container'>
            <h2>Booking History</h2>
            <?php
            echo "<table id='BookingHistory' class='table table-striped table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>No</th>";
            echo "<th>Booking ID</th>";
            echo "<th>Venue</th>";
            echo "<th>Date</th>";
            echo "<th>Duration</th>";
            echo "<th>Status</th>";
            echo "<th>Action</th>";
            echo "</thead>";
            echo "<tbody>";
            echo "</tr>";
            if (isset($_SESSION['result'])) {
                $bookingDA = new BookingDA();
                $bookingArray = $bookingDA->retrieve($_SESSION['result']->societyID);
                if ($bookingArray == null) {
                    echo "<tr>";
                    echo "<td colspan='6' style=color:red;text-align:center;>No records found.</td>";
                    echo "</tr>";
                } else {
                    //class= 'table table-hover table-responsive table-bordered'
                    $count = 1;
                    foreach ($bookingArray as $booking) {
                        echo "<tr>";
                        echo "<td>$count</td>";
                        echo "<td>{$booking->bookID}</td>";
                        echo "<td>{$booking->venueName}</td>";
                        echo "<td>{$booking->bookDate}</td>";
                        $stFormatted = date("g:i A", strtotime($booking->startTime));
                        $etFormatted = date("g:i A", strtotime($booking->endTime));
                        echo "<td>{$stFormatted}-{$etFormatted}</td>";
                        echo "<td>{$booking->bookStatus}</td>";
                        if ($booking->bookStatus == "Approved") {
                            echo "<td> <p>N/A</p> </td>";
                        } else if ($booking->bookStatus == "Pending") {
                            echo "<td> <p>Waiting for approval</p> </td>";
                        } else if ($booking->bookStatus == "Disapproved") {
                            echo "<td><input type = 'button' name = 'edit' value = 'View Feedback' id = '{$booking->bookID}' class = 'btn btn-primary m-r-1em view_data' /></td>";
                        }
                        //echo "<td> <a href = '' class='btn btn-danger m-r-1em'>Delete</a> </td>";
                        echo "</tr>";
                        $count++;
                    }
                }
                echo "<tbody>";
                echo "</table>";
            } else {
                header('location:EventOrganizerHome.php');
            }
            ?>
            <a href = "EventOrganizerHome.php" class = "btn btn-danger">Back</a>
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
