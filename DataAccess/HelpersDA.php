<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Helpers.php';

class HelpersDA {

    public function create(Helpers $helper) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO helpers (eventID, studID, applyDate, applyStatus) VALUES (?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $helper->eventID, PDO::PARAM_STR);
        $stmt->bindParam(2, $helper->userID, PDO::PARAM_STR);
        $stmt->bindParam(3, $helper->applyDate);
        $stmt->bindParam(4, $helper->applyStatus, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieve($eventID) {

        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM helpers WHERE eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $participantsArray = array();
            $participant = new Participants();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $participant = new Participants($row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus']);
                $participantsArray[] = $participant;
            }
            return $participantsArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function update(Helpers $helper) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE helpers SET applyStatus = ? WHERE userID = ? AND eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $helper->applyStatus, PDO::PARAM_STR);
        $stmt->bindParam(2, $helper->userID, PDO::PARAM_STR);
        $stmt->bindParam(3, $helper->eventID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

}
