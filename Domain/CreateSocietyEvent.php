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
         $_SESSION['errorMsg'] =  'Please enter the event name.';
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else if (empty($eventDesc)) {
         $_SESSION['errorMsg'] =  'Please enter the event description.';
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else if ($_FILES['myfile']['error'] == 4) {
        //If file is empty
         $_SESSION['errorMsg'] = 'Please select an image.';
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else if (!in_array($ext, $allowed)) {
        //If file type is not allowed
        $_SESSION['errorMsg'] =  'Sorry, image file only jpg and png is accepted.';
        header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
    } else {
        $event = new SocietyEvent($eventID = "", $eventName, $eventDesc, $eventCategory, $content, $noOfHelper, $contactNo, $societyID, $applyID);
        $eventDA = new SocietyEventDA();
        if ($eventDA->create($event)) {
            $_SESSION['successMsg'] = 'You have posted a new event.';
            header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
        } else {
             $_SESSION['errorMsg'] = 'Sorry, an unexpected error occured.';
            header("location:../UI/SocietyCreateEvent.php?applyID=$applyID");
        }
    }
}
    