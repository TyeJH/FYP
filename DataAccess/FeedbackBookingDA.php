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

    public function retrieve($bookingID, $societyID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM feedbackBooking WHERE bookingID = ? AND societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $bookingID, PDO::PARAM_STR);
        $stmt->bindParam(2, $societyID, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $feedbackBooking = new FeedbackBooking($result['feedbackBookingID'], $result['content'], $result['adminID'], $result['bookingID'], $result['societyID']);
            DatabaseConnection::closeConnection($db);
            return $feedbackBooking;
        }
        DatabaseConnection::closeConnection($db);
    }

}
