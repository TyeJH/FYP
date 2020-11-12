<?php
require_once '../Domain/Schedule.php';
require_once '../DataAccess/ScheduleDA.php';
session_start();
if ($_SESSION['current'] != 'Society') {
    unset($_SESSION['current']);
    $_SESSION['role'] = 'society';
    header('location:Login.php');
}
require 'header.php';
?>
<!DOCTYPE html> 
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">  
        <title>Edit Event</title>
        <style>
            img {
                align: center;
                border: 1px solid #ddd;
                width: 300px;
                height: 200px;
            }

        </style>
    </head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('.start').datepicker({
                onSelect: function (dateText) {
                    $('.end').datepicker('option', 'minDate', new Date(dateText));
                    $(".start").datepicker("option", "dateFormat", 'yy-mm-dd');
                }
            });
            $('.end').datepicker({
                onSelect: function (dateText) {
                    $('.start').datepicker('option', 'maxDate', new Date(dateText));
                    $(".end").datepicker("option", "dateFormat", 'yy-mm-dd');
                }
            });
        });
        function checkUnlimited(id) {
            var element = document.getElementById('participant:' + id);
            var radios = document.getElementsByName('unlimited:' + id);
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    if (radios[i].value == 'Yes') {
                        element.value = null;
                        element.disabled = true;
                        element.required = false;
                    } else {
                        element.disabled = false;
                        element.required = true;
                    }
                }
            }
        }

    </script>

    <body>
        <div class='container'>
            <div class='page-header'>
                <h1 class='bodyTitle'>Manage Helper</h1>
            </div>
            <a href = 'EnterSchedule.php?eventID=<?= $_GET['eventID'] ?>' class = 'btn btn-primary'>Add Schedule</a>
            <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
            <br><br>

            <?php
            if (isset($_SESSION['successMsg'])) {
                echo "<div class='alert alert-success'><strong>Success! </strong>" . $_SESSION['successMsg'] . '</div>';
                unset($_SESSION['successMsg']);
            }
            if (isset($_SESSION['errorMsg'])) {
                echo "<div class='alert alert-danger'><strong>Failed! </strong>" . $_SESSION['errorMsg'] . '</div>';
                unset($_SESSION['errorMsg']);
            }
            if (isset($_GET['eventID'])) {
                $eventID = $_GET['eventID'];
                $scheduleDA = new ScheduleDA();
                $scheduleArray = $scheduleDA->retrieve($eventID);
                $count = 1;
                if ($scheduleArray == null) {
                    echo "<p style=color:blue;text-align:center;>Schedule your event now !</p>";
                } else {
                    foreach ($scheduleArray as $schedule) {
                        echo "<h3>Schedule $count</h3>";
                        ?>
                        <form action="../Domain/UpdateSchedule.php" method="post" id="form:scheduleID:<?= $schedule->scheduleID ?>" enctype="multipart/form-data">
                            <p>
                                <button type="button" class="btn btn-info btn-lg" value="scheduleID:<?= $schedule->scheduleID ?>" onclick='editManage(this.value, false)'>
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </p>
                            <fieldset id="scheduleID:<?= $schedule->scheduleID ?>" disabled>
                                <table class='table table-hover table-bordered'>
                                    <tr>
                                        <td>Venue : </td>
                                        <td>  
                                            <input type="text" name="venue" class='form-control' value="<?= $schedule->venue ?>"/><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Date Time :</td>
                                        <td>
                                            Start Date : <input type="text" class="start" name="startDate" value="<?= $schedule->startDate ?>"/>
                                            Time : <input type="time" name="startTime" value="<?= $schedule->startTime ?>"/>
                                        </td>
                                    </tr>
                                    <tr>            
                                        <td></td>
                                        <td>
                                            End Date : <input type="text" class="end" name="endDate" value="<?= $schedule->endDate ?>"/>
                                            Time : <input type="time" name="endTime" value="<?= $schedule->endTime ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unlimited Participant : </td>
                                        <td>
                                            <?php
                                            if ($schedule->unlimited == 'Yes') {
                                                echo "Yes <input type='radio' name='unlimited:$schedule->scheduleID' onChange='checkUnlimited($schedule->scheduleID);' value='Yes' checked/> ";
                                                echo "No <input type='radio'  name='unlimited:$schedule->scheduleID' onChange='checkUnlimited($schedule->scheduleID);' value='No'/>";
                                            } else {
                                                echo "Yes <input type='radio' name='unlimited:$schedule->scheduleID' onChange='checkUnlimited($schedule->scheduleID);' value='Yes'/> ";
                                                echo "No <input type='radio'  name='unlimited:$schedule->scheduleID' onChange='checkUnlimited($schedule->scheduleID);' value='No' checked/>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Participants Allowed :</td>
                                        <td>
                                            <?php
                                            if ($schedule->unlimited == 'Yes') {
                                                echo "<input disabled type = 'number' min = '$schedule->noOfJoined' id='participant:$schedule->scheduleID'  name = 'noOfParticipant' value = '$schedule->noOfParticipant' class = 'form-control'/><br>";
                                            } else {
                                                echo "<input type = 'number' min = '$schedule->noOfJoined' id='participant:$schedule->scheduleID'  name = 'noOfParticipant' value = '$schedule->noOfParticipant' class = 'form-control'/><br>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status :</td>
                                        <td>
                                            <?php
                                            if ($schedule->scheduleStatus == 'Ongoing') {
                                                echo "Ongoing <input type='radio' id='scheduleStatus' name='scheduleStatus' value='Ongoing' checked/> ";
                                                echo "Cancel <input type='radio' id='scheduleStatus' name='scheduleStatus' value='Cancel'/>";
                                            } else {
                                                echo "Ongoing <input type='radio' id='scheduleStatus' name='scheduleStatus' value='Ongoing'/> ";
                                                echo "Cancel <input type='radio' id='scheduleStatus' name='scheduleStatus' value='Cancel' checked/>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <input type="hidden" name="noOfJoined" value="<?= $schedule->noOfJoined ?>"/>
                                            <input type="hidden" name="eventID" value="<?= $schedule->eventID ?>"/>
                                            <input type="hidden" name="scheduleID" value="<?= $schedule->scheduleID ?>"/>
                                            <button type="submit" class="btn btn-primary"onclick="return confirm('Save?')" class='btn btn-primary' name="updateSchedule">Save</button>
                                            <button type="reset" class="btn btn-danger" value="Reset" id="scheduleID:<?= $schedule->scheduleID ?>" onclick='editManage(this.id, true)' class='btn btn-primary' name="Reset">Cancel</button>
                                            <!--<a href='ManageSchedule.php?eventID=<?= $schedule->eventID ?>' class='btn btn-danger'>Cancel</a>-->
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                        </form>
                        <script>
                            function editManage(id, value) {
                                document.getElementById(id).disabled = value;
                                if (value == true) {
                                    //Reset button value function will be overwrite by onClick. Therefore, need a statement to reset the value.
                                    document.getElementById("form:" + id).reset();
                                }
                            }
                        </script>

                        <?php
                        $count++;
                    }
                }
            } else {
                header('location:EventOrganizerHome.php');
            }
            ?>
        </div>

    </body>
</html>
