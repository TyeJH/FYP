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
        $_SESSION['errorMsg'] = 'Please insert purposes.';
        header("Location:../UI/BookVenue.php?venueID=$venueID");
    }
    if ($st > $et || $st == $et) {
        $_SESSION['errorMsg'] = 'The end time must be greater than the start time';
        header("Location:../UI/BookVenue.php?venueID=$venueID");
    } else if (millisecsBetween($stFormat, $etFormat) > 7200000) {
        $_SESSION['errorMsg'] = 'Maximum 120 minutes per book.';
        header("Location:../UI/BookVenue.php?venueID=$venueID");
    } else {
        $booking = new Booking($bookingID = "", $purpose, $bookDate, $startTime, $endTime, $bookStatus, $societyID, $venueID);
        $bookingDA = new BookingDA();
        if ($bookingDA->create($booking)) {
            $_SESSION['successMsg'] = 'Successfully Booked. Waiting for staff to approve.';
            header("Location:../UI/BookVenue.php?venueID=$venueID");
        } else {
            $_SESSION['errorMsg'] = 'Unexpected error occur';
            header("Location:../UI/BookVenue.php?venueID=$venueID");
        }
    }
}

//if input false, negative result will occur when dateOne is earlier than dateTwo
function millisecsBetween($dateOne, $dateTwo, $abs = true) {
    $func = $abs ? 'abs' : 'intval';
    return $func(strtotime($dateOne) - strtotime($dateTwo)) * 1000;
}
