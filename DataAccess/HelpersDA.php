<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Helpers.php';

class HelpersDA {

    public function create(Participants $participant) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO helpers (eventID, studID, applyDate, applyStatus) VALUES (?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $participant->eventID, PDO::PARAM_STR);
        $stmt->bindParam(2, $participant->studID, PDO::PARAM_STR);
        $stmt->bindParam(3, $participant->applyDate);
        $stmt->bindParam(4, $participant->applyStatus, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

}
