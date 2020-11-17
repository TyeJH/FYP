<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Helpers.php';

class HelpersDA {

    public function create(Helpers $helper) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO helpers (eventID, userID, applyDate, applyStatus) VALUES (?, ?, ?, ?)';
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
            $helpersArray = array();
            $helper = new Helpers();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $helper = new Helpers($row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus']);
                $helpersArray[] = $helper;
            }
            return $helpersArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveByUserID($userID) {

        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM helpers WHERE userID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $userID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $helper = new Helpers($row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus']);
        }
        return $helper;

        DatabaseConnection::closeConnection($db);
    }

    public function retrieveByEventIDAndUserID($eventID, $userID) {

        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM helpers WHERE eventID = ? AND userID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID);
        $stmt->bindParam(2, $userID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $helper = new Helpers($row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus']);
        }
        return $helper;

        DatabaseConnection::closeConnection($db);
    }

    public function retrieveHelpHistory($userID) {

        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM helpers WHERE userID = ? AND applyStatus = "Approved"';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $userID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $helperArray = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $helper = new Helpers($row['eventID'], $row['userID'], $row['applyDate'], $row['applyStatus']);
                $helperArray[] = $helper;
            }
            return $helperArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function update(Helpers $helper) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE helpers SET applyStatus = ? WHERE userID = ? AND eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $helper->applyStatus, PDO::PARAM_STR);
        $stmt->bindValue(2, $helper->userID, PDO::PARAM_STR);
        $stmt->bindValue(3, $helper->eventID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

}
