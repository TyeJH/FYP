<?php

require_once'../DataAccess/DatabaseConnection.php';
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
            $soc = new Society($s['societyID'], $s['societyName'], $s['societyDesc'], $s['societyMember'],$s['societyPass']);
            DatabaseConnection::closeConnection($db);
            return $soc;
        }
    }
}
