<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/SocietyEvent.php';

class SocietyEventDA {

    public function create(SocietyEvent $event) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO SocietyEvent (eventName, eventDesc, eventCategory, image, noOfHelper, contactNo, societyID, applyID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $event->eventName, PDO::PARAM_STR);
        $stmt->bindValue(2, $event->eventDesc, PDO::PARAM_STR);
        $stmt->bindValue(3, $event->eventCategory, PDO::PARAM_STR);
        $stmt->bindValue(4, $event->image);
        $stmt->bindValue(5, $event->noOfHelper);
        $stmt->bindValue(6, $event->contactNo);
        $stmt->bindValue(7, $event->societyID);
        $stmt->bindValue(8, $event->applyID);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieve() {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM SocietyEvent';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $eventArray = array();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $event = new SocietyEvent($result['eventID'], $result['eventName'], $result['eventDesc'], $result['eventCategory'], $result['image'], $result['noOfHelper'], $result['contactNo'], $result['societyID'], $result['applyID']);
                $eventArray[] = $event;
            }
            return $eventArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveByEventID($eventID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM SocietyEvent WHERE eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $event = new SocietyEvent($result['eventID'], $result['eventName'], $result['eventDesc'], $result['eventCategory'], $result['image'], $result['noOfHelper'], $result['contactNo'], $result['societyID'], $result['applyID']);
            return $event;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveBySocietyID($societyID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM SocietyEvent WHERE societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $societyID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $eventArray = array();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $event = new SocietyEvent($result['eventID'], $result['eventName'], $result['eventDesc'], $result['eventCategory'], $result['image'], $result['noOfHelper'], $result['contactNo'], $result['societyID'], $result['applyID']);
                $eventArray[] = $event;
            }
            return $eventArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function update(SocietyEvent $event) {

        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE SocietyEvent SET eventName = ? , eventDesc = ? , eventCategory = ? , image = ? , noOfHelper = ?, contactNo = ? WHERE eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $event->eventName, PDO::PARAM_STR);
        $stmt->bindParam(2, $event->eventDesc, PDO::PARAM_STR);
        $stmt->bindParam(3, $event->eventCategory, PDO::PARAM_STR);
        $stmt->bindParam(4, $event->image);
        $stmt->bindParam(5, $event->noOfHelper);
        $stmt->bindParam(6, $event->contactNo);
        $stmt->bindParam(7, $event->eventID);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function isApplyIdExist($applyID) {
        $db = DatabaseConnection::getInstance()->getDB();

        $query = 'SELECT * FROM SocietyEvent WHERE applyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $applyID, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total > 0) {
            //If applyID is found which means created
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveAllEndDateBeforeTomorrow() {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT DISTINCT(SE.eventID),SE.eventName,SE.eventDesc,SE.eventCategory,SE.image,SE.noOfHelper,SE.contactNo,SE.societyID,SE.applyID FROM SocietyEvent SE, schedule S WHERE SE.eventID = S.eventID AND ((SELECT max(S2.endDate) FROM schedule S2 WHERE S2.eventID = SE.eventID))>= CURDATE()';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $eventArray = array();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $event = new SocietyEvent($result['eventID'], $result['eventName'], $result['eventDesc'], $result['eventCategory'], $result['image'], $result['noOfHelper'], $result['contactNo'], $result['societyID'], $result['applyID']);
                $eventArray[] = $event;
            }
            return $eventArray;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveAllEndDateBeforeTomorrowForSociety($societyID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT DISTINCT(SE.eventID),SE.eventName,SE.eventDesc,SE.eventCategory,SE.image,SE.noOfHelper,SE.contactNo,SE.societyID,SE.applyID FROM SocietyEvent SE, schedule S WHERE SE.societyID = ? AND SE.eventID = S.eventID AND ((SELECT max(S2.endDate) FROM schedule S2 WHERE S2.eventID = SE.eventID))>= CURDATE()';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $societyID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $eventArray = array();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $event = new SocietyEvent($result['eventID'], $result['eventName'], $result['eventDesc'], $result['eventCategory'], $result['image'], $result['noOfHelper'], $result['contactNo'], $result['societyID'], $result['applyID']);
                $eventArray[] = $event;
            }
            return $eventArray;
        }
        DatabaseConnection::closeConnection($db);
    }

}
