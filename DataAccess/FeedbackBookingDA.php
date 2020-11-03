<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/FeedbackBooking.php';

class FeedbackBookingDA {

    public function create(FeedbackBooking $feedbackBooking) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO feedbackBooking (content, adminID, bookingID, societyID) VALUES(?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $feedbackBooking->content, PDO::PARAM_STR);
        $stmt->bindValue(2, $feedbackBooking->adminID, PDO::PARAM_STR);
        $stmt->bindValue(3, $feedbackBooking->bookingID, PDO::PARAM_STR);
        $stmt->bindValue(4, $feedbackBooking->societyID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

}
