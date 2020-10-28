<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Admin.php';

class AdminDA {

    public function login($adminid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM admin WHERE adminID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $adminid, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $a = $stmt->fetch(PDO::FETCH_ASSOC);
            $adm = new Admin($a['adminID'], $a['password']);
            DatabaseConnection::closeConnection($db);
            return $adm;
        }
    }

    public function register(Admin $ad) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO admin VALUES(?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $ad->adminID, PDO::PARAM_STR);
        $stmt->bindParam(2, $ad->password, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function update(Admin $ad) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE admin SET password = ? WHERE adminID=?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $ad->password, PDO::PARAM_STR);
        $stmt->bindParam(2, $ad->adminID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function checkID($newId) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT adminID FROM admin WHERE adminID = ?");
        $stmt->bindParam(1, $newId, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }
}
