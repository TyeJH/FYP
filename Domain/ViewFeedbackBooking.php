<?php

require '../DataAccess/FeedbackBookingDA.php';
require '../Domain/Society.php';

session_start();
if (isset($_POST['bookingID'])) {
    $feedbackBookingDA = new FeedbackBookingDA();
    $feedbackBooking = $feedbackBookingDA->retrieve($_POST['bookingID'], $_SESSION['result']->societyID);
    if ($feedbackBooking != null) {
        echo $feedbackBooking->content;
    } else {
        echo "No content found.";
    }
}
