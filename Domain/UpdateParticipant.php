<?php

require_once '../Domain/Participants.php';
require_once '../DataAccess/ParticipantsDA.php';
if (isset($_POST['type']) && isset($_POST['eventID']) && isset($_POST['userID']) && isset($_POST['applyDate']) && isset($_POST['applyStatus']) && isset($_POST['attendanceStatus'])) {

    $type = $_POST['type'];
    $eventID = $_POST['eventID'];
    $userID = $_POST['userID'];
    $applyDate = $_POST['applyDate'];
    $applyStatus = $_POST['applyStatus'];
    $attendanceStatus = $_POST['attendanceStatus'];
    if ($type == 'approval') {
        if ($applyStatus == "Approved") {
            //By default after approved then user will become absent.
            //Pending > Approved > Absent > Attend 
            $participant = new Participants($eventID, $userID, $applyDate, $applyStatus, 'Absent');
        } else {
            $participant = new Participants($eventID, $userID, $applyDate, $applyStatus, 'N/A');
        }
    } else {
        $participant = new Participants($eventID, $userID, $applyDate, $applyStatus, $attendanceStatus);
    }
    $participantDA = new ParticipantsDA();
    if ($participantDA->update($participant)) {
        if ($type == 'approval') {
            echo $participant->userID . ' application status is marked as ' . $participant->applyStatus;
        } else {
            echo $participant->userID . ' attendance status is marked as ' . $participant->attendanceStatus;
        }
    } else {
        echo "Unexpected error occur. Please contact system administrator.";
    }
}

