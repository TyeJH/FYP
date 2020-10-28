<?php

require_once '../DataAccess/DatabaseConnection.php';
require_once '../Domain/Society.php';

class SocietyDA {

    public function login($societyid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM society WHERE societyID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $societyid, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $soc = new Society($s['societyID'], $s['societyName'], $s['societyDesc'], $s['societyMember'], $s['societyPass']);
            DatabaseConnection::closeConnection($db);
            return $soc;
        }
    }

    public function regsiter(Society $sc) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO society VALUES(?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $sc->societyID, PDO::PARAM_STR);
        $stmt->bindParam(2, $sc->societyName, PDO::PARAM_STR);
        $stmt->bindParam(3, $sc->societyDesc, PDO::PARAM_STR);
        $stmt->bindParam(4, $sc->societyMember, PDO::PARAM_STR);
        $stmt->bindParam(5, $sc->societyPass, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function update(Society $sc) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE society SET societyName = ?, societyDesc = ?, societyMember = ?, societyPass = ? WHERE societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $sc->societyName, PDO::PARAM_STR);
        $stmt->bindParam(2, $sc->societyDesc, PDO::PARAM_STR);
        $stmt->bindParam(3, $sc->societyMember, PDO::PARAM_STR);
        $stmt->bindParam(4, $sc->societyPass, PDO::PARAM_STR);
        $stmt->bindParam(5, $sc->societyID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function delete(Society $sc) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'DELETE FROM society WHERE societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $sc->societyID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function checkID($newId) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT societyID FROM society WHERE societyID = ?");
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
