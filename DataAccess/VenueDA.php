<?php

require_once '../DataAccess/DatabaseConnection.php';
require_once '../Domain/Venue.php';

class VenueDA {

    public function getAll() {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM venue where venueStatus = 'A' ";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $ven = $stmt->fetchAll();
            $vList =[];
            foreach($ven as $v) {
                $vList[] = new Venue($v['venueID'], $v['venueName'], $v['venueDesc'], $v['venueStatus']);
            }
            DatabaseConnection::closeConnection($db);
            return $vList;
        }
    }
    
    public function getAllByAdmin() {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM venue";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $ven = $stmt->fetchAll();
            $vList =[];
            foreach($ven as $v) {
                $vList[] = new Venue($v['venueID'], $v['venueName'], $v['venueDesc'], $v['venueStatus']);
            }
            DatabaseConnection::closeConnection($db);
            return $vList;
        }
    }

    public function retrieve($venueid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM venue WHERE venueID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $venueid, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $v = $stmt->fetch(PDO::FETCH_ASSOC);
            $ven = new Venue($v['venueID'], $v['venueName'], $v['venueDesc'], $v['venueStatus']);
            DatabaseConnection::closeConnection($db);
            return $ven;
        }
    }
    
    public function retrieveJSON($venueid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM venue WHERE venueID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $venueid, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $v = $stmt->fetch(PDO::FETCH_ASSOC);
            DatabaseConnection::closeConnection($db);
            return $v;
        }
    }

    public function regsiter(Venue $vn) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO venue VALUES(?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $vn->venueID, PDO::PARAM_STR);
        $stmt->bindParam(2, $vn->venueName, PDO::PARAM_STR);
        $stmt->bindParam(3, $vn->venueDesc, PDO::PARAM_STR);
        $stmt->bindParam(4, $vn->venueStatus, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function update(Venue $vn) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE venue SET venueName = ?, venueDesc = ?, venueStatus = ? WHERE venueID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $vn->venueName, PDO::PARAM_STR);
        $stmt->bindParam(2, $vn->venueDesc, PDO::PARAM_STR);
        $stmt->bindParam(3, $vn->venueStatus, PDO::PARAM_STR);
        $stmt->bindParam(4, $vn->venueID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function checkID($newId) {
        $db = DatabaseConnection::getInstance()->getDb();
        $stmt = $db->prepare("SELECT venueID FROM venue WHERE venueID = ?");
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
