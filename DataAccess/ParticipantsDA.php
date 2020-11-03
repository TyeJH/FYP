<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Participants.php';

class ParticipantsDA {

    public function create(Participants $participant) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO participants (scheduleID, eventID, userID, applyDate, applyStatus) VALUES (?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $participant->scheduleID, PDO::PARAM_STR);
        $stmt->bindParam(2, $participant->eventID, PDO::PARAM_STR);
        $stmt->bindParam(3, $participant->userID, PDO::PARAM_STR);
        $stmt->bindParam(4, $participant->applyDate);
        $stmt->bindParam(5, $participant->applyStatus, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieve($scheduleID, $applyStatus) {

        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM participants WHERE scheduleID = ? AND applyStatus = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $scheduleID, PDO::PARAM_STR);
        $stmt->bindParam(2, $applyStatus);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $participantsArray = array();
            $participant = new Participants();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $participant = new Participants($row['scheduleID'], $row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus'], $row['attendanceStatus']);
                $participantsArray[] = $participant;
            }
            return $participantsArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveByScheduleIDUserID($scheduleID, $userID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM participants WHERE scheduleID = ? AND userID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $scheduleID);
        $stmt->bindParam(2, $userID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $participant = new Participants($row['scheduleID'], $row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus'], $row['attendanceStatus']);
            return $participant;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function update(Participants $participant) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE participants SET applyStatus = ? , attendanceStatus = ? WHERE userID = ? AND eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $participant->applyStatus);
        $stmt->bindValue(2, $participant->attendanceStatus);
        $stmt->bindValue(3, $participant->userID);
        $stmt->bindValue(4, $participant->eventID);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }
public function retrieveStudentEvent($student) {

        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM participants WHERE userID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $student, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $participantsArray = array();
            $participant = new Participants();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $participant = new Participants($row['scheduleID'],$row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus'], $row['attendanceStatus']);
                $participantsArray[] = $participant;
            }
            return $participantsArray;
        }
        DatabaseConnection::closeConnection($db);
    }
}
