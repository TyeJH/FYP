<?php

include_once '../Domain/SocietyEvent.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/SocietyEventDA.php';
session_start();
if (isset($_POST['updateEvent'])) {
    $allowed = array('jpg', 'png');

    $eventID = $_POST['eventID'];

    $val = new Validation();
    $eventName = $_POST['eventName'];
    $eventDesc = $val->test_input($_POST['eventDesc']);

    $file = 0;

    if ($_FILES['myfile']['error'] == 4) {
        //If user didn't upload new image file, then use existing one
        $eventDA = new SocietyEventDA();
        $event = new SocietyEvent();
        $event = $eventDA->retrieveByEventID($eventID);
        $content = $event->image;
    } else {
        //If user upload new image file, then use the uploaded one
        $filename = $_FILES['myfile']['name'];
        $mime = $_FILES['myfile']['type'];
        $content = file_get_contents($_FILES['myfile']['tmp_name']);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file = 1;
    }
    $eventCategory = $val->test_input($_POST['eventCategory']);
    $noOfHelper = $_POST['noOfHelper'];
    $contactNo = $_POST['contactNo'];


    if (empty($eventName)) {
        $_SESSION['errorMsg'] = 'Please enter the event name';
        header("location:../UI/EditEvent.php?eventID=$eventID");
    } else if (empty($eventDesc)) {
        $_SESSION['errorMsg'] = 'Please enter the event description';
        header("location:../UI/EditEvent.php?eventID=$eventID");
    } else if (!in_array($ext, $allowed) && $file == 1) {
        //If file type is not allowed
        $_SESSION['errorMsg'] = 'Sorry, image file only jpg and png is accepted.';
        header("location:../UI/EditEvent.php?eventID=$eventID");
    } else {

        $event = new SocietyEvent($eventID, $eventName, $eventDesc, $eventCategory, $content, $noOfHelper, $contactNo, $societyID, $applyID);
        $eventDA = new SocietyEventDA();
        if ($eventDA->update($event)) {
            $_SESSION['successMsg'] = 'Event details updated.';
            header("location:../UI/EditEvent.php?eventID=$eventID");
        } else {
            $_SESSION['errorMsg'] ='Sorry, an unexpected error occured';
            header("location:../UI/EditEvent.php?eventID=$eventID");
        }
    }
}
