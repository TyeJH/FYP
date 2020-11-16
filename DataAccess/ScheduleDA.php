<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Schedule.php';

class ScheduleDA {

    public function create(Schedule $schedule) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO schedule (venue, startDate, startTime, endDate, endTime, unlimited, noOfParticipant, noOfJoined, scheduleStatus, eventID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $schedule->venue);
        $stmt->bindParam(2, $schedule->startDate);
        $stmt->bindParam(3, $schedule->startTime, PDO::PARAM_STR);
        $stmt->bindParam(4, $schedule->endDate, PDO::PARAM_STR);
        $stmt->bindParam(5, $schedule->endTime, PDO::PARAM_STR);
        $stmt->bindParam(6, $schedule->unlimited);
        $stmt->bindParam(7, $schedule->noOfParticipant);
        $stmt->bindParam(8, $schedule->noOfJoined, PDO::PARAM_STR);
        $stmt->bindParam(9, $schedule->scheduleStatus, PDO::PARAM_STR);
        $stmt->bindParam(10, $schedule->eventID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieve($eventID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM schedule WHERE eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $scheduleArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $schedule = new Schedule($row['scheduleID'], $row['venue'], $row['startDate'], $row['startTime'], $row['endDate'], $row['endTime'], $row['unlimited'], $row['noOfParticipant'], $row['noOfJoined'], $row['scheduleStatus'], $row['eventID']);
                $scheduleArray[] = $schedule;
            }
            return $scheduleArray;
        }
        DatabaseConnection::closeConnection($db);
    }
    
    public function retrieveHistory($eventID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT DISTINCT(eventID), MIN(startDate) AS Start, MAX(endDate) AS End FROM schedule WHERE eventID = ? AND endDate < CURDATE() GROUP BY eventID';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $scheduleArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $schedule = new Schedule("", "", $row['Start'], "", $row['End'], "", "", "", "", "", $row['eventID']);
                $scheduleArray[] = $schedule;
            }
            return $scheduleArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveFuture($eventID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM schedule WHERE eventID = ? AND endDate >= CURDATE()';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $scheduleArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $schedule = new Schedule($row['scheduleID'], $row['venue'], $row['startDate'], $row['startTime'], $row['endDate'], $row['endTime'], $row['unlimited'], $row['noOfParticipant'], $row['noOfJoined'], $row['scheduleStatus'], $row['eventID']);
                $scheduleArray[] = $schedule;
            }
            return $scheduleArray;
        }
        DatabaseConnection::closeConnection($db);
    }
    
    public function retrieveLowestDateByEventID($eventID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM schedule WHERE eventID = ? AND startDate = (SELECT MIN(startDate) FROM schedule where eventID = ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID);
        $stmt->bindParam(2, $eventID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $schedule = new Schedule($row['scheduleID'], $row['venue'], $row['startDate'], $row['startTime'], $row['endDate'], $row['endTime'], $row['unlimited'], $row['noOfParticipant'], $row['noOfJoined'], $row['scheduleStatus'], $row['eventID']);
            return $schedule;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveByScheduleID($scheduleID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM schedule WHERE scheduleID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $scheduleID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $schedule = new Schedule($row['scheduleID'], $row['venue'], $row['startDate'], $row['startTime'], $row['endDate'], $row['endTime'], $row['unlimited'], $row['noOfParticipant'], $row['noOfJoined'], $row['scheduleStatus'], $row['eventID']);
            return $schedule;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function update(Schedule $schedule) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE schedule SET venue = ?, startDate = ?, startTime = ?, endDate = ?, endTime = ?, unlimited = ?, noOfParticipant = ?, noOfJoined = ?, scheduleStatus = ? WHERE scheduleID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $schedule->venue, PDO::PARAM_STR);
        $stmt->bindValue(2, $schedule->startDate, PDO::PARAM_STR);
        $stmt->bindValue(3, $schedule->startTime, PDO::PARAM_STR);
        $stmt->bindValue(4, $schedule->endDate, PDO::PARAM_STR);
        $stmt->bindValue(5, $schedule->endTime, PDO::PARAM_STR);
        $stmt->bindValue(6, $schedule->unlimited, PDO::PARAM_STR);
        $stmt->bindValue(7, $schedule->noOfParticipant, PDO::PARAM_STR);
        $stmt->bindValue(8, $schedule->noOfJoined, PDO::PARAM_STR);
        $stmt->bindValue(9, $schedule->scheduleStatus, PDO::PARAM_STR);
        $stmt->bindValue(10, $schedule->scheduleID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function updateNoOfJoined($scheduleID,$applyStatus) {
        $db = DatabaseConnection::getInstance()->getDB();
        if ($applyStatus == 'Approved') {
            $query = 'UPDATE schedule SET noOfJoined = noOfJoined + ? WHERE scheduleID = ?';
        } else {
            $query = 'UPDATE schedule SET noOfJoined = noOfJoined - ? WHERE scheduleID = ?';
        }
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, 1, PDO::PARAM_STR);
        $stmt->bindValue(2, $scheduleID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

}
