<?php

include_once '../Domain/Documentation.php';
include_once '../DataAccess/DocumentationDA.php';
include_once '../DataAccess/FeedbackDocumentDA.php';
include_once '../Domain/FeedbackDocument.php';
include_once '../Domain/Admin.php';

session_start();

if (isset($_POST['docID']) && isset($_POST['status'])) {
    $docID = $_POST['docID'];
    $status = $_POST['status'];
    $documentDA = new DocumentationDA();
    if ($documentDA->updateDocument($docID, $status)) {
        echo "Document Status updated to $status";
        if ($_POST['status'] == 'Disapproved') {
            //disapproved by staff then will have feedback.
            if (isset($_POST['feedback']) && isset($_POST['societyID'])) {
                $adminID = 'DSA';
                $feedbackDocumentDA = new FeedbackDocumentDA();
                $feedbackDocument = new FeedbackDocument($feedbackDocumentID = "", $_POST['feedback'], $adminID, $docID, $_POST['societyID']);
                if (!$feedbackDocumentDA->create($feedbackDocument)) {
                    echo "Unexpected error occur ";
                }
            }
        }
    } else {
        echo 'error';
    }
}