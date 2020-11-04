<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/Documentation.php';

class DocumentationDA {

    public function create(Documentation $document) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO documentation (docName, mime, docContent, applyDate, societyID, status) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $document->docName, PDO::PARAM_STR);
        $stmt->bindParam(2, $document->mime, PDO::PARAM_STR);
        $stmt->bindParam(3, $document->docContent);
        $stmt->bindParam(4, $document->applyDate);
        $stmt->bindParam(5, $document->societyID);
        $stmt->bindParam(6, $document->status, PDO::PARAM_STR);
       
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieveBySocietyID($societyID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM documentation WHERE societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $societyID);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $documentArray = array();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $document = new Documentation($result['docID'], $result['docName'], $result['mime'], $result['docContent'], $result['applyDate'], $result['societyID'], $result['status']);
                $documentArray[] = $document;
            }
            return $documentArray;
        }
        DatabaseConnection::closeConnection($db);
    }
    public function retrieveAll() {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM documentation';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $documentArray = array();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $document = new Documentation($result['docID'], $result['docName'], $result['mime'], $result['docContent'], $result['applyDate'], $result['societyID'], $result['status']);
                $documentArray[] = $document;
            }
            return $documentArray;
        }
        DatabaseConnection::closeConnection($db);
    }
    public function updateDocument($docID, $status) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'UPDATE documentation SET status = ? WHERE docID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $status);
        $stmt->bindValue(2, $docID);
        $stmt->execute();
     
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }
}
