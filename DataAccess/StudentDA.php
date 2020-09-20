<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Student.php';

class StudentDA {
   public function login($studid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM student WHERE userID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $studid, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $std = new Student($s['userID'], $s['username'], $s['password'], $s['studID']);
            DatabaseConnection::closeConnection($db);
            return $std;
        }
    }
    
    public function checkID($newId) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT userID FROM student WHERE userID = ?");
        $stmt->bindParam(1, $newId, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        } else {
            return true;
        }
        DatabaseConnection::closeConnection($db);
    }
}
