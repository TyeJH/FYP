<?php

require_once'../DataAccess/DatabaseConnection.php';
require_once '../Domain/FeedbackDocument.php';

class FeedbackDocumentDA {

    public function create(FeedbackDocument $feedbackDocument) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'INSERT INTO feedbackDocument (content, adminID, docID, societyID) VALUES(?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $feedbackDocument->content, PDO::PARAM_STR);
        $stmt->bindValue(2, $feedbackDocument->adminID, PDO::PARAM_STR);
        $stmt->bindValue(3, $feedbackDocument->docID, PDO::PARAM_STR);
        $stmt->bindValue(4, $feedbackDocument->societyID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        DatabaseConnection::closeConnection($db);
    }

    public function retrieve($docID, $societyID) {
        $db = DatabaseConnection::getInstance()->getDB();
        $query = 'SELECT * FROM feedbackDocument WHERE docID = ? AND societyID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $docID, PDO::PARAM_STR);
        $stmt->bindParam(2, $societyID, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->rowCount();
        if ($total == 0) {
            return null;
        } else {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $feedbackBooking = new FeedbackBooking($result['feedbackDocumentID'], $result['content'], $result['adminID'], $result['docID'], $result['societyID']);
            DatabaseConnection::closeConnection($db);
            return $feedbackBooking;
        }
        DatabaseConnection::closeConnection($db);
    }

}
