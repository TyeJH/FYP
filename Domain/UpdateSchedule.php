<?php

include_once '../Domain/Schedule.php';
include_once '../DataAccess/ScheduleDA.php';
include_once '../DataAccess/ParticipantsDA.php';
include_once '../Domain/Society.php';
include_once '../Domain/Participants.php';
include_once '../Domain/Student.php';

require '../Domain/Email.php';

session_start();
if (isset($_POST['updateSchedule'])) {

    //initializes
    $scheduleID = $_POST['scheduleID'];
    if ($_POST["unlimited:$scheduleID"] == 'Yes') {
        $unlimited = 'Yes';
        $noOfParticipant = null;
    } else {
        $unlimited = 'No';
        $noOfParticipant = $_POST['noOfParticipant'];
    }
    $venue = $_POST['venue'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endDate = $_POST['endDate'];
    $endTime = $_POST['endTime'];
    $scheduleStatus = $_POST['scheduleStatus'];
    //$societyID = $_SESSION['result']->societyID;
    $eventID = $_POST['eventID'];
    $noOfJoined = $_POST['noOfJoined'];
    //convert format to dd/mm/yyyy 2400
    $stFormat = $startDate . " " . $startTime;
    $etFormat = $endDate . " " . $endTime;
    $st = strtotime($stFormat);
    $et = strtotime($etFormat);
    if ($st > $et || $st == $et) {
        $_SESSION['errorMsg'] = 'The end time must be greater than the start time.';
        header("Location:../UI/ManageSchedule.php?eventID=$eventID");
    } else {
        $schedule = new Schedule($scheduleID, $venue, $startDate, $startTime, $endDate, $endTime, $unlimited, $noOfParticipant, $noOfJoined, $scheduleStatus, $eventID);
        $scheduleDA = new ScheduleDA();
        if ($scheduleDA->update($schedule)) {
            $participantsDA = new ParticipantsDA();

            $participantArray = $participantsDA->retrieveByScheduleID($eventID);
            //Notify students schedule updates.
            if ($participantArray != null) {
                foreach ($participantArray as $participant) {
                    $studDA = new StudentDA();
                    $stud = $studDA->retrieveByStudID($participant->userID);
                    $to = $stud->studEmail;
                    echo $participant->userID;
                    echo $to;
                    $toName = 'Participant';
                    $subject = "Schedule Updates";
                    $message = "Venue : $venue\nStart Date : $startDate\nStart Time : $startTime\nEnd Date : $endDate\nEnd Time : $endTime\n ";
                    $from = "eventmanagementsystemtaruc@gmail.com";
                    $sender = "TAR UC Event Management System";
                    $mail = new Email($to, $toName, $subject, $message, $from, $sender);
                    //$mail->setting();
                }
            }
            $_SESSION['successMsg'] = 'Your schedule just updated.';
            header("Location:../UI/ManageSchedule.php?eventID=$eventID");
        } else {
            $_SESSION['errorMsg'] =  'Unexpected error occur';
            header("Location:../UI/ManageSchedule.php?eventID=$eventID");
        }
    }
}
