<?php

include_once '../Domain/Booking.php';
include_once '../DataAccess/BookingDA.php';
include_once '../Domain/Society.php';

session_start();
if (isset($_POST['bookVenue'])) {

    //initializes
    if ($_POST['purpose'] == "Others") {
        $purpose = $_POST['otherPurposes'];
    } else {
        $purpose = $_POST['purpose'];
    }
    $bookDate = $_POST['bookDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $bookStatus = 'Approved';
    $societyID = $_SESSION['result']->societyID;
    $venueID = $_POST['venue'];

    //convert format to dd/mm/yyyy 2400
    $stFormat = $bookDate . " " . $startTime;
    $etFormat = $bookDate . " " . $endTime;
    $st = strtotime($stFormat);
    $et = strtotime($etFormat);
    if (empty($purpose)) {
        echo "<script>alert('Please insert purposes.');</script>";
    }
    if ($st > $et || $st == $et) {
        echo "<script>alert('The end time must be greater than the start time.');</script>";
    } else if (millisecsBetween($stFormat, $etFormat) > 7200000) {
        echo "<script>alert('Maximum 120 minutes per book.');</script>";
    } else {
        $booking = new Booking($bookingID = "", $purpose, $bookDate, $startTime, $endTime, $bookStatus, $societyID, $venueID);
        $bookingDA = new BookingDA();
        if ($bookingDA->create($booking)) {
            echo '<script>alert("Successfully Booked");location.href = "../UI/BookVenue.php";</script>';
        } else {
            //echo '<script>alert("Unexpected error occur");location.href = "../UI/BookVenue.php";</script>';
        }
    }
}

//if input false, negative result will occur when dateOne is earlier than dateTwo
function millisecsBetween($dateOne, $dateTwo, $abs = true) {
    $func = $abs ? 'abs' : 'intval';
    return $func(strtotime($dateOne) - strtotime($dateTwo)) * 1000;
}
