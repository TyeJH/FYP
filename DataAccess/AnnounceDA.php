<?php

require_once '../DataAccess/DatabaseConnection.php';
require_once '../Domain/Announcement.php';

class AnnounceDA {

    public function getAll() {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM announcement";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $ann = $stmt->fetchAll();
            $aList=[];
            foreach($ann as $a){
               $aList[] = new Announcement($a['annID'], $a['annTitle'], $a['annContent'], $a['annDate'], $a['adminID']);
            }
            DatabaseConnection::closeConnection($db);
            return $aList;
        }
    }
    
    public function retrieve($annid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM announcement WHERE annID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $annid, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $a = $stmt->fetch(PDO::FETCH_ASSOC);
            $ann = new Announcement($a['annID'], $a['annTitle'], $a['annContent'], $a['annDate'], $a['adminID']);
            DatabaseConnection::closeConnection($db);
            return $ann;
        }
    }

    public function regsiter(Announcement $an) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO announcement VALUES(?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $an->annID, PDO::PARAM_STR);
        $stmt->bindParam(2, $an->annTitle, PDO::PARAM_STR);
        $stmt->bindParam(3, $an->annContent, PDO::PARAM_STR);
        $stmt->bindParam(4, $an->annDate, PDO::PARAM_STR);
        $stmt->bindParam(5, $an->adminID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function update(Announcement $an) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE announcement SET annTitle = ?, annContent = ?, annDate = ?, adminID = ? WHERE annID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $an->annTitle, PDO::PARAM_STR);
        $stmt->bindParam(2, $an->annContent, PDO::PARAM_STR);
        $stmt->bindParam(3, $an->annDate, PDO::PARAM_STR);
        $stmt->bindParam(4, $an->adminID, PDO::PARAM_STR);
        $stmt->bindParam(5, $an->annID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function delete($an) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'DELETE FROM announcement WHERE annID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $an, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function checkID($newId) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT annID FROM announcement WHERE annID = ?");
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
