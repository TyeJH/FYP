<?php

include_once '../Domain/Documentation.php';
include_once '../DataAccess/DocumentationDA.php';
include_once '../DataAccess/FeedbackDocumentDA.php';
include_once '../Domain/FeedbackDocument.php';
include_once '../Domain/Admin.php';

session_start();
if (isset($_POST['docID']) && isset($_POST['status'])) {

    $adminID = 'DSA';
    $docID = $_POST['docID'];
    $status = $_POST['status'];
    $documentDA = new DocumentationDA();
    if ($documentDA->updateDocument($docID, $status)) {
        echo "$docID Document Status updated to $status";
        
        if (isset($_POST['feedback']) && isset($_POST['societyID'])) {
            $feedbackDocumentDA = new FeedbackDocumentDA();
            $feedbackDocument = new FeedbackDocument($feedbackDocumentID = "", $_POST['feedback'], $adminID, $docID, $_POST['societyID']);
            if (!$feedbackDocumentDA->create($feedbackDocument)) {
                echo "Unexpected error occur ";
            }
        }
    } else {
        echo "Unexpected error occur ";
    }
}