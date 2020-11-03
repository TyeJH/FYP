<?php
require '../DataAccess/FeedbackDocumentDA.php';
require '../Domain/Society.php';

session_start();
if (isset($_POST['docID'])) {
    $feedbackDocumentDA = new FeedbackDocumentDA();
    $feedbackDocument = $feedbackDocumentDA->retrieve($_POST['docID'], $_SESSION['result']->societyID);
    if ($feedbackDocument != null) {
        echo $feedbackDocument->content;
    } else {
        echo "No content found.";
    }
}
