<?php
require '../DataAccess/SocietyEventDA.php';
require '../DataAccess/ScheduleDA.php';
require '../DataAccess/ParticipantsDA.php';
require '../DataAccess/HelpersDA.php';
require '../Domain/Student.php';

session_start();
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
AUTHOR : NGO KIAN HEE
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">  
        <style>
            img {
                align: center;
                border: 1px solid #ddd;
                width: 600px;
                height: 500px;
            }

        </style>
        <title>Event Details</title>
    </head>
    <body>

        <div class='container'>
            <div class='page-header'>
                <h1>Event Details</h1>
            </div>

            <?php
            if (isset($_SESSION['successMsg'])) {
                echo "<div class='alert alert-success'><strong>Success! </strong>" . $_SESSION['successMsg'] . '</div>';
                unset($_SESSION['successMsg']);
            }
            if (isset($_SESSION['successMsg2'])) {
                echo "<div class='alert alert-info'><strong>Notice </strong>" . $_SESSION['successMsg2'] . '</div>';
                unset($_SESSION['successMsg2']);
            }
            if (isset($_SESSION['errorMsg'])) {
                echo "<div class='alert alert-danger'><strong>Failed! </strong>" . $_SESSION['errorMsg'] . '</div>';
                unset($_SESSION['errorMsg']);
            }
            if (isset($_GET['eventID'])) {
                $eventID = $_GET['eventID'];
                $eventDA = new SocietyEventDA();
                $event = $eventDA->retrieveByEventID($eventID);
                if ($event == null) {
                    header('location:EventOrganizerHome.php');
                }
                ?>
                <form action="../Domain/CreateParticipant.php" method="post" enctype="multipart/form-data">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td colspan="2" style="text-align: center;"><img src="data:image/jpeg;base64, <?php echo base64_encode($event->image); ?>"/></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= $event->eventName ?></td>
                        </tr>
                        <tr>
                            <td>Description :</td>
                            <td>
                                <?= $event->eventDesc ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Category :</td>
                            <td>
                                <?= $event->eventCategory ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Helper Needed : </td>
                            <td>  
                                <?= $event->noOfHelper ?>
                            </td>
                        </tr>
                        <tr>
                            <?php
                            if (!empty($event->contactNo)) {
                                ?>
                                <td>Contact Us :</td>
                                <td>
                                    <!--there are two methods, both are working fine
                                    <a href = "https://api.whatsapp.com/send?phone=+60162152296&text=Hi! I would like to enquiry about the event details.">WhatsApp</a> -->
                                    <a target = "_blank" href = "https://wa.me/60<?= $event->contactNo ?>?text=Hi! I would like to enquiry about the event details.">WhatsApp</a>
                                </td>
                                <?php
                            }
                            ?>

                        </tr>
                        <tr>
                            <td>
                                Schedule Session
                            </td>
                            <td>
                                <?php
                                $scheduleDA = new ScheduleDA();
                                $scheduleArray = $scheduleDA->retrieve($eventID);
                                $count = 1;
                                if ($scheduleArray != null) {
                                    foreach ($scheduleArray as $schedule) {
                                        echo "<b>Session $count </b> </br>";
                                        echo "<b>Venue :</b> $schedule->venue  </br>";
                                        if ($schedule->unlimited == 'No') {
                                            echo "Slots: $schedule->noOfJoined/$schedule->noOfParticipant</br>";
                                        } else {
                                            echo "Unlimited slots</br>";
                                        }
                                        //convert format to dd/mm/yyyy 2200
                                        $stFormat = $schedule->startDate . " " . $schedule->startTime;
                                        $etFormat = $schedule->endDate . " " . $schedule->endTime;
                                        $st = strtotime($stFormat);
                                        $et = strtotime($etFormat);
                                        //convert format to Thursday, 2020--Oct-01 4:00 PM
                                        $startDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($stFormat));
                                        $endDateTimeFormatted = date("D, d-M-Y h:i A", strtotime($etFormat));
                                        //$et = strtotime($etFormat);
                                        //When student logged in
                                        if ($_SESSION['current'] == 'Student') {

                                            if (isset($_SESSION['result'])) {
                                                $participantDA = new ParticipantsDA();
                                                $result = $participantDA->retrieveByScheduleIDUserID($schedule->scheduleID, $_SESSION['result']->studID);
                                                //If student already joined or applied
                                                if ($result != null) {
                                                    if ($result->applyStatus == 'Approved') {
                                                        echo "$startDateTimeFormatted - $endDateTimeFormatted <p class ='btn btn-success'>Joined</p></br>";
                                                    } else if ($result->applyStatus == 'Pending') {
                                                        echo "$startDateTimeFormatted - $endDateTimeFormatted <p class ='btn btn-info'>Pending for approval</p> <a href ='../Domain/DeleteParticipant.php?eventID=$event->eventID&scheduleID=$schedule->scheduleID' type = 'submit' class = 'btn btn-warning' name = 'participate'>Cancel</a></br>";
                                                    } else if ($result->applyStatus == 'Disapproved') {
                                                        echo "$startDateTimeFormatted - $endDateTimeFormatted <p class ='btn btn-danger'>Disapproved</p></br>";
                                                    }
                                                } else {
                                                    //If student didn't joined
                                                    if ($schedule->unlimited == 'No') {
                                                        if ($schedule->noOfJoined >= $schedule->noOfParticipant) {
                                                            echo "$startDateTimeFormatted - $endDateTimeFormatted <p class ='btn btn-danger'>Full</p></br>";
                                                        } else {
                                                            echo "$startDateTimeFormatted - $endDateTimeFormatted <a href ='../Domain/CreateParticipant.php?eventID=$event->eventID&scheduleID=$schedule->scheduleID' type = 'submit' class = 'btn btn-primary' name = 'participate'>Join here!</a></br>";
                                                        }
                                                    } else {
                                                        echo "$startDateTimeFormatted - $endDateTimeFormatted <a href ='../Domain/CreateParticipant.php?eventID=$event->eventID&scheduleID=$schedule->scheduleID'  type = 'submit' class = 'btn btn-primary' name = 'participate'>Join here!</a></br>";
                                                    }
                                                }
                                            } else {
                                                //When not loggeed in
                                                if ($schedule->unlimited == 'No') {
                                                    if ($schedule->noOfJoined >= $schedule->noOfParticipant) {
                                                        echo "$startDateTimeFormatted - $endDateTimeFormatted <p class ='btn btn-danger'>Full</p></br>";
                                                    } else {
                                                        echo "$startDateTimeFormatted - $endDateTimeFormatted <a href ='../Domain/CreateParticipant.php?eventID=$event->eventID&scheduleID=$schedule->scheduleID' type = 'submit' class = 'btn btn-primary' name = 'participate'>Join here!</a></br>";
                                                    }
                                                } else {
                                                    echo "$startDateTimeFormatted - $endDateTimeFormatted <a href ='../Domain/CreateParticipant.php?eventID=$event->eventID&scheduleID=$schedule->scheduleID' type = 'submit' class = 'btn btn-primary' name = 'participate'>Join here!</a></br>";
                                                }
                                            }
                                        }
                                        $count++;
                                    }
                                } else {
                                    echo "Waiting for event organizer to upload schedule.";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Register for Helper!
                            </td>
                            <td>
                                <?php
                                if ($_SESSION['current'] == 'Student') {
                                    if (isset($_SESSION['result'])) {
                                        $helpersDA = new HelpersDA();
                                        $result2 = $helpersDA->retrieveByEventIDAndUserID($eventID, $_SESSION['result']->studID);
                                        //If student already joined or applied
                                        if ($result2 != null) {
                                            if ($result2->applyStatus == 'Approved') {
                                                echo "<a class = 'btn btn-info' name = 'helper'>Registered</a></br>";
                                            } else if ($result2->applyStatus == 'Pending') {
                                                echo "<a class = 'btn btn-info' name = 'helper'>Pending for approval</a> <a href ='../Domain/DeleteHelper.php?eventID=$event->eventID'  type = 'submit' class = 'btn btn-warning' name = 'helper'>Cancel</a></br>";
                                            } else if ($result2->applyStatus == 'Disapproved') {
                                                echo "<a class = 'btn btn-info' name = 'helper'>Disapproved</a></br>";
                                            }
                                        } else {
                                            echo "<a href ='../Domain/CreateHelper.php?eventID=$event->eventID' type = 'submit' class = 'btn btn-primary' name = 'helper'>Register here</a></br>";
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>                  
                                <a href='HomePage.php' class='btn btn-danger'>Back</a>
                            </td>
                        </tr>
                    </table>

                    <?php
                } else {
                    header("Location:HomePage.php");
                }
                ?>

            </form>
        </div>

    </body>
</html>
