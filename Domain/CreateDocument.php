<?php
include_once '../Domain/Documentation.php';
include_once '../Domain/Validation.php';
include_once '../Domain/Society.php';
include_once '../DataAccess/DocumentationDA.php';
session_start();
if (isset($_POST['apply'])) {

    $allowed = array('docx', 'pdf');
    $filename = $_FILES['myfile']['name'];
    $mime = $_FILES['myfile']['type'];
    $content = file_get_contents($_FILES['myfile']['tmp_name']);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $applyDate = date('Y-m-d H:i:s');
    $societyID = $_SESSION['result']->societyID;
    $status = 'Pending';
    if ($_FILES['myfile']['error'] == 4) {
        //If file is empty
        $_SESSION['errorMsg'] = 'Please select a file.';
        header("Location:../UI/ApplyNewEvent.php");
    } else if (!in_array($ext, $allowed)) {
        //If file type is not allowed
        $_SESSION['errorMsg'] ='Sorry, only .docx or .pdf file type is accepted.';
        header("Location:../UI/ApplyNewEvent.php");
    } else {
        $document = new Documentation($docID = "", $filename, $mime, $content, $applyDate, $societyID, $status);
        $documentationDA = new DocumentationDA();
        if ($documentationDA->create($document)) {
            $_SESSION['successMsg'] ='Your application successfully submitted.';
            header("Location:../UI/ApplyNewEvent.php");
        } else {
            $_SESSION['errorMsg'] = 'Sorry, currently cannot submit';
            header("Location:../UI/ApplyNewEvent.php");
        }
    }
}

