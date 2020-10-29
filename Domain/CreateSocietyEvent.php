<?php

include_once '../Domain/Society.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/SocietyEventDA.php';
include_once '../Domain/SessionManagement.php';
session_start();
//Create Event
if (isset($_POST['createEvent'])) {
    $allowed = array('jpg', 'png');

    $val = new Validation();
    $eventName = $val->test_input($_POST['eventName']);
    $eventDesc = $val->test_input($_POST['eventDesc']);
    $eventCategory = $val->test_input($_POST['eventCategory']);

    //Event Image file
    $filename = $_FILES['myfile']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $content = file_get_contents($_FILES['myfile']['tmp_name']);
    $noOfHelper = $_POST['noOfHelper'];
    $contactNo = $_POST['contactNo'];
    $societyID = $_SESSION['result']->societyID;
    $applyID = $_POST['applyID'];

    if (empty($eventName)) {
         $_SESSION['message'] =  "<div class='alert alert-info'><strong>Please enter the event name</strong></div>";
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else if (empty($eventDesc)) {
         $_SESSION['message'] =  "<div class='alert alert-info'><strong>Please enter the event description</strong></div>";
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else if ($_FILES['myfile']['error'] == 4) {
        //If file is empty
         $_SESSION['message'] = "<div class='alert alert-info'><strong>Please select an image</strong></div>";
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else if (!in_array($ext, $allowed)) {
        //If file type is not allowed
        $_SESSION['message'] =  "<div class='alert alert-info'><strong>Sorry, image file only jpg and png is accepted.</strong></div>";
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else {
        $event = new SocietyEvent($eventID = "", $eventName, $eventDesc, $eventCategory, $content, $noOfHelper, $contactNo, $societyID, $applyID);
        $eventDA = new SocietyEventDA();
        if ($eventDA->create($event)) {
            $_SESSION['message'] = "<div class='alert alert-success'><strong>Success!</strong> You have posted a new event.</div>";
            header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
        } else {
             $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, an unexpected error occured.</div>";
            header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
        }
    }
}
    