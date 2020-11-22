<?php

require_once '../DataAccess/DatabaseConnection.php';
require_once '../Domain/Society.php';
require_once '../Domain/Transaction.php';

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
            $soc = new Society($s['societyID'], $s['societyName'], $s['societyDesc'], $s['societyPass'], $s['societyAcc']);
            DatabaseConnection::closeConnection($db);
            return $soc;
        }
    }

    public function getAll() {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM society";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $soc = $stmt->fetchAll();
            $sList = [];
            foreach ($soc as $s) {
                $sList[] = new Society($s['societyID'], $s['societyName'], $s['societyDesc'], $s['societyPass'], $s['societyAcc']);
            }
            DatabaseConnection::closeConnection($db);
            return $sList;
        }
    }

    public function retrieveJSON($socid) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM society WHERE societyID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $socid, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            DatabaseConnection::closeConnection($db);
            return $s;
        }
    }

    public function regsiter(Society $sc) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO society VALUES(?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $sc->societyID, PDO::PARAM_STR);
        $stmt->bindParam(2, $sc->societyName, PDO::PARAM_STR);
        $stmt->bindParam(3, $sc->societyDesc, PDO::PARAM_STR);
        $stmt->bindParam(4, $sc->societyPass, PDO::PARAM_STR);
        $stmt->bindParam(5, $sc->societyAcc, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function update(Society $sc) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE society SET societyName = ?, societyDesc = ?, societyPass = ?, societyAcc = ? WHERE societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $sc->societyName, PDO::PARAM_STR);
        $stmt->bindParam(2, $sc->societyDesc, PDO::PARAM_STR);
        $stmt->bindParam(3, $sc->societyPass, PDO::PARAM_STR);
        $stmt->bindParam(4, $sc->societyAcc, PDO::PARAM_STR);
        $stmt->bindParam(5, $sc->societyID, PDO::PARAM_STR);
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

    public function creditDebit(Transaction $tr) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'Insert into transhistory VALUES (?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $tr->transID, PDO::PARAM_STR);
        $stmt->bindParam(2, $tr->transDate, PDO::PARAM_STR);
        $stmt->bindParam(3, $tr->amount, PDO::PARAM_STR);
        $stmt->bindParam(4, $tr->purpose, PDO::PARAM_STR);
        $stmt->bindParam(5, $tr->societyID, PDO::PARAM_STR);
        $stmt->execute();
        DatabaseConnection::closeConnection($db);
    }

    public function getTrans($socID) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM transhistory WHERE societyID = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $socID, PDO::PARAM_STR);
        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $tra = $stmt->fetchAll();
            $trList = [];
            foreach ($tra as $t) {
                $trList[] = new Transaction($t['transID'], $t['transDate'], $t['amount'], $t['purpose'], $t['societyID']);
            }
            DatabaseConnection::closeConnection($db);
            return $trList;
        }
    }

    public function getTransBetweenDate($socID, $startDate, $endDate) {
        $db = DatabaseConnection::getInstance()->getDb();
        $query = "SELECT * FROM transhistory WHERE societyID = ? AND transDate >= ? AND transDate <= ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $socID, PDO::PARAM_STR);
        $stmt->bindParam(2, $startDate, PDO::PARAM_STR);
        $stmt->bindParam(3, $endDate, PDO::PARAM_STR);

        $stmt->execute();

        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $tra = $stmt->fetchAll();
            $trList = [];
            foreach ($tra as $t) {
                $trList[] = new Transaction($t['transID'], $t['transDate'], $t['amount'], $t['purpose'], $t['societyID']);
            }
            DatabaseConnection::closeConnection($db);
            return $trList;
        }
    }

}
