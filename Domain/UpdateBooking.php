<?php

include_once '../Domain/Booking.php';
include_once '../DataAccess/BookingDA.php';
include_once '../DataAccess/FeedbackBookingDA.php';
include_once '../Domain/FeedbackBooking.php';
include_once '../Domain/Admin.php';

session_start();
if (isset($_POST['bookingID']) && isset($_POST['bookStatus'])) {

    $adminID = 'DSA';
    $bookingID = $_POST['bookingID'];
    $bookStatus = $_POST['bookStatus'];
    $bookingDA = new BookingDA();
    if ($bookingDA->updateBooking($bookingID, $bookStatus)) {
        echo "Booking Status updated to " . $bookStatus;
        if (isset($_POST['feedback']) && isset($_POST['societyID'])) {
            $feedbackBookingDA = new FeedbackBookingDA();
            $feedbackBooking = new FeedbackBooking($feedbackBookingID = "", $_POST['feedback'], $adminID, $bookingID, $_POST['societyID']);
            if (!$feedbackBookingDA->create($feedbackBooking)) {
                echo "Unable to give feedback.";
            }
        }
    } else {
        echo "Unexpected error occur ";
    }
}



    