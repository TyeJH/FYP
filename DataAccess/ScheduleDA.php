<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Schedule.php';

class ScheduleDA {

    public function create(Schedule $schedule) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO schedule (venue, startDate, startTime, endDate, endTime, unlimted, noOfParticipant, noOfJoined, scheduleStatus, eventID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $schedule->venue, PDO::PARAM_STR);
        $stmt->bindParam(2, $schedule->startDate, PDO::PARAM_STR);
        $stmt->bindParam(3, $schedule->startTime, PDO::PARAM_STR);
        $stmt->bindParam(4, $schedule->endDate, PDO::PARAM_STR);
        $stmt->bindParam(5, $schedule->endTime, PDO::PARAM_STR);
        $stmt->bindParam(6, $schedule->unlimted, PDO::PARAM_STR);
        $stmt->bindParam(7, $schedule->noOfParticipant, PDO::PARAM_STR);
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
                $schedule = new Schedule($row['scheduleID'], $row['venue'], $row['startDate'], $row['startTime'], $row['endDate'], $row['endTime'], $row['unlimted'], $row['noOfParticipant'], $row['noOfJoined'], $row['scheduleStatus'], $row['eventID']);
                $scheduleArray[] = $schedule;
            }
            return $scheduleArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function update(Schedule $schedule) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE schedule SET venue = ?, startDate = ?, startTime = ?, endDate = ?, endTime = ?, unlimted = ?, noOfParticipant = ?, noOfJoined = ?, scheduleStatus = ? WHERE scheduleID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $schedule->venue, PDO::PARAM_STR);
        $stmt->bindParam(2, $schedule->startDate, PDO::PARAM_STR);
        $stmt->bindParam(3, $schedule->startTime, PDO::PARAM_STR);
        $stmt->bindParam(4, $schedule->endDate, PDO::PARAM_STR);
        $stmt->bindParam(5, $schedule->endTime, PDO::PARAM_STR);
        $stmt->bindParam(6, $schedule->unlimted, PDO::PARAM_STR);
        $stmt->bindParam(7, $schedule->noOfParticipant, PDO::PARAM_STR);
        $stmt->bindParam(8, $schedule->noOfJoined, PDO::PARAM_STR);
        $stmt->bindParam(9, $schedule->scheduleStatus, PDO::PARAM_STR);
        $stmt->bindParam(10, $schedule->scheduleID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

}
