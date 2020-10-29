<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Booking.php';

class BookingDA {

    public function create(Booking $booking) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO booking (purpose, bookDate, startTime, endTime, bookStatus, societyID, venueID) VALUES(?, ?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $booking->purpose, PDO::PARAM_STR);
        $stmt->bindParam(2, $booking->bookDate, PDO::PARAM_STR);
        $stmt->bindParam(3, $booking->startTime, PDO::PARAM_STR);
        $stmt->bindParam(4, $booking->endTime, PDO::PARAM_STR);
        $stmt->bindParam(5, $booking->bookStatus, PDO::PARAM_STR);
        $stmt->bindParam(6, $booking->societyID, PDO::PARAM_STR);
        $stmt->bindParam(7, $booking->venueID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieve($societyID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM booking B, venue V WHERE B.venueID = V.venueID AND societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $societyID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $bookingArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $booking = new Booking($row['bookingID'], $row['purpose'], $row['bookDate'], $row['startTime'], $row['endTime'], $row['bookStatus'], $row['societyID'], $row['venueID'],$row['venueName']);
                $bookingArray[] = $booking;
            }
            return $bookingArray;
        }
        DatabaseConnection::closeConnection($db);
    }

}