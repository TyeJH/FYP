<?php
require_once '../Domain/Schedule.php';
require_once '../DataAccess/ScheduleDA.php';
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
            $('#start').datepicker({
                onSelect: function (dateText) {
                    $('#end').datepicker('option', 'minDate', new Date(dateText));
                    $("#start").datepicker("option", "dateFormat", 'yy-mm-dd');
                }
            });
            $('#end').datepicker({
                onSelect: function (dateText) {
                    $('#start').datepicker('option', 'maxDate', new Date(dateText));
                    $("#end").datepicker("option", "dateFormat", 'yy-mm-dd');
                }
            });
        });
        function checkUnlimited(id) {
            var element = document.getElementById('participant:' + id);
            var radios = document.getElementsByName('unlimited');
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    // do whatever you want with the checked radio
                    alert('participant:' + id + ' ' + radios[i].value);
                    if (radios[i].value === 'Yes') {
                        element.value = null;
                        element.disabled = true;
                        element.required = false;
                    } else {
                        element.disabled = false;
                        element.required = true;
                    }
                    // only one radio can be logically checked, don't check the rest
                    break;
                }
            }
        }

    </script>

    <body>

        <div class='container'>
            <div class='page-header'>
                <h1>Your Schedules</h1>
            </div>

            <?php
            if (isset($_SESSION['message'])) {
                echo '<br>' . $_SESSION['message'];
                unset($_SESSION['message']);
            }
            if (isset($_GET['eventID'])) {
                $eventID = $_GET['eventID'];
                $scheduleDA = new ScheduleDA();
                $scheduleArray = $scheduleDA->retrieve($eventID);
                $count = 1;
                if ($scheduleArray == null) {
                    echo "<p style=color:red;text-align:center;>No records found.</p>";
                } else {
                    foreach ($scheduleArray as $schedule) {
                        echo "<h3>Schedule $count</h3>";
                        ?>
                        <form action="../Domain/UpdateSchedule.php" method="post" enctype="multipart/form-data">
                            <table class='table table-hover table-responsive table-bordered'>
                                <tr>
                                    <td>Venue : </td>
                                    <td>  
                                        <input type="text" name="venue" class='form-control' value="<?= $schedule->venue ?>"/><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date Time :</td>
                                    <td>
                                        Start Date : <input type="text" id="start" name="startDate" value="<?= $schedule->startDate ?>"/>
                                        Time : <input type="time" name="startTime" value="<?= $schedule->startTime ?>"/>
                                    </td>
                                </tr>
                                <tr>            
                                    <td></td>
                                    <td>
                                        End Date : <input type="text" id="end" name="endDate" value="<?= $schedule->endDate ?>"/>
                                        Time : <input type="time" name="endTime" value="<?= $schedule->endTime ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unlimited Participant : </td>
                                    <td>
                                        <?php
                                        if ($schedule->unlimited == 'Yes') {
                                            echo "Yes <input type='radio' name='unlimited' onChange='checkUnlimited($schedule->scheduleID);' value='Yes' checked/> ";
                                            echo "No <input type='radio'  name='unlimited' onChange='checkUnlimited($schedule->scheduleID);' value='No'/>";
                                        } else {
                                            echo "Yes <input type='radio' name='unlimited' onChange='checkUnlimited($schedule->scheduleID);' value='Yes'/> ";
                                            echo "No <input type='radio'  name='unlimited' onChange='checkUnlimited($schedule->scheduleID);' value='No' checked/>";
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
                                        <button type="submit" onclick="return confirm('Save?')" class='btn btn-primary' name="updateSchedule">Save</button>
                                        <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
                                    </td>
                                </tr>
                            </table>
                        </form>
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
