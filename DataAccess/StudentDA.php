<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Student.php';

class StudentDA {

    public function login($studid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM student WHERE username = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $studid, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $std = new Student($s['userID'], $s['username'], $s['password'], $s['studEmail'], $s['studID']);
            DatabaseConnection::closeConnection($db);
            return $std;
        }
    }
    
    public function retrieveByStudID($userID) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM student WHERE userID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $userID, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $std = new Student($s['userID'], $s['username'], $s['password'], $s['studEmail'], $s['studID']);
            DatabaseConnection::closeConnection($db);
            return $std;
        }
    }

    public function register(Student $st) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO student VALUES(?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $st->studID, PDO::PARAM_STR);
        $stmt->bindParam(2, $st->username, PDO::PARAM_STR);
        $stmt->bindParam(3, $st->password, PDO::PARAM_STR);
        $stmt->bindParam(4, $st->studEmail, PDO::PARAM_STR);
        $stmt->bindParam(5, $st->uniStudID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function update(Student $st) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE student SET username = ?, password = ?, studEmail = ?, studID = ? WHERE userID=?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $st->username, PDO::PARAM_STR);
        $stmt->bindParam(2, $st->password, PDO::PARAM_STR);
        $stmt->bindParam(3, $st->studEmail, PDO::PARAM_STR);
        $stmt->bindParam(4, $st->uniStudID, PDO::PARAM_STR);
        $stmt->bindParam(5, $st->studID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
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

    public function checkUsername($newname) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT username FROM student WHERE username = ?");
        $stmt->bindParam(1, $newname, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }
    
    public function checkEmail($email) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT studEmail FROM student WHERE studEmail = ?");
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }
    
    public function checkStudID($studID) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT studID FROM student WHERE studID = ?");
        $stmt->bindParam(1, $studID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function checkUniID($uniID) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT studID FROM unistudent WHERE studID = ?");
        $stmt->bindParam(1, $uniID, PDO::PARAM_STR);
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
