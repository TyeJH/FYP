<?php
include_once '../Domain/Venue.php';
include_once '../DataAccess/VenueDA.php';
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
        <title>Book Venue</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!--Date input-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <!--Date format-->
        <script src="http://stevenlevithan.com/assets/misc/date.format.js"></script>
        <script type="text/javascript">
            function CheckPurpose(val) {
                var element = document.getElementById('otherPurposes');
                if (val === 'Others') {
                    element.style.display = 'block';
                    element.required = true;
                } else {
                    element.style.display = 'none';
                    element.required = false;
                }
                checkTimeValid();
            }
            function checkTimeValid() {
                var purpose = document.getElementById('purpose').value;
                var button = document.getElementById('bookVenue');

                var bookDate = document.getElementById('bookDate').value;
                var errMsg = document.getElementById('errMsg');
                var errMsg2 = document.getElementById('errMsg2');
                var errMsg3 = document.getElementById('errMsg3');

                var date = new Date(bookDate);
                var startTime = date.format('yyyy/mm/dd') + " " + document.getElementById('startTime').value;
                var endTime = date.format('yyyy/mm/dd') + " " + document.getElementById('endTime').value;
                var st = new Date(Date.parse(startTime));
                var et = new Date(Date.parse(endTime));
                //if start time more than end time or start time is equal end time
                var disable = 0;
                if (st > et || st === et) {
                    errMsg.style.display = 'block';
                    disable++;
                } else {
                    errMsg.style.display = 'none';
                }
                if (purpose === 'Discussion') {
                    //alert(st + "\n" + et);
                    //if duration for discussion is more than 120mins
                    if (et - st > 7200000) {
                        errMsg2.style.display = 'block';
                        disable++;
                    } else {
                        errMsg2.style.display = 'none';
                    }
                } else {
                    errMsg2.style.display = 'none';
                }
                var now = new Date();
                if (st < now) {
                    errMsg3.style.display = 'block';
                    disable++;
                } else {
                    errMsg3.style.display = 'none';

                }
                if (disable > 0) {
                    button.disabled = true;
                } else {
                    button.disabled = false;
                }
            }
        </script> 
        <style>
            .error-msg {
                color: #d16e6c;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1 class='bodyTitle'>Book Venue</h1>
            </div>
            <?php
            if (isset($_SESSION['successMsg'])) {
                echo "<div class='alert alert-success'><strong>Success! </strong>" . $_SESSION['successMsg'] . '</div>';
                unset($_SESSION['successMsg']);
            }
            if (isset($_SESSION['errorMsg'])) {
                echo "<div class='alert alert-danger'><strong>Failed! </strong>" . $_SESSION['errorMsg'] . '</div>';
                unset($_SESSION['errorMsg']);
            }
            ?>
            <form action="../Domain/CreateBooking.php" method="post" enctype="multipart/form-data" >
                <table class="table table-hover table-bordered">
                    <tbody>

                        <tr>
                            <td>
                                <label for="purposes">Purpose: </label>
                            </td>
                            <td>
                                <select name="purpose" id="purpose" onchange="CheckPurpose(this.value);" required>
                                    <option value="Discussion">Discussion</option>
                                    <option value="Organize">Organize event</option>
                                    <option value="Others">Others</option>
                                </select>
                                <input type="text" name="otherPurposes" onchange="isTextBoxEmpty()"id="otherPurposes" placeholder="Your purposes"style='display:none;'/>               
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Booking Date:</label>
                            </td>
                            <td>
                                <input type="date" name="bookDate" id="bookDate" onchange="checkTimeValid()" required>
                                <script type="text/javascript">
                                    bookDate.min = new Date().toISOString().split("T")[0];
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="bookTime">Time Duration</label>
                            </td>
                            <td>
                                From: <select id="startTime" name="startTime"  onchange="checkTimeValid()" required>
                                    <!--                                    <option  disabled selected>Start Time:</option>-->
                                    <?php
                                    $startTime = 800;
                                    $endTime = 2030;
                                    //Method 1: use newHour to indicate every 60mins = 1hour
                                    $newHour = 0;
                                    for ($startTime; $startTime <= $endTime; $startTime += 30) {
                                        if ($newHour == 60) {
                                            $startTime -= 60;
                                            $startTime += 100;
                                            $newHour = 0;
                                        }
                                        if (strlen($startTime) < 4) {
                                            $startTime = "0" . $startTime;
                                        }
                                        $string = ':';
                                        $position = '2';
                                        $time = substr_replace($startTime, $string, $position, 0);
                                        $twevleHourFormat = date("g:i A", strtotime($time));
                                        echo "<option value='" . $time . "'>" . $twevleHourFormat . "</option>";
                                        $newHour += 30;
                                    }
                                    ?>
                                </select>
                                To: <select id="endTime" name="endTime" onchange="checkTimeValid()" required>
                                    <!--                                    <option  disabled selected>End Time:</option>-->
                                    <?php
                                    $startTime = 830;
                                    $endTime = 2100;
                                    for ($startTime; $startTime <= $endTime; $startTime += 30) {
                                        //Method 2: change 830 to 0830 for checking the minutes is 60 
                                        //or not at second IF statement
                                        if (strlen($startTime) < 4) {
                                            $startTime = "0" . $startTime;
                                        }
                                        if (substr($startTime, 2) == 60) {
                                            $startTime -= 60;
                                            $startTime += 100;
                                        }
                                        if (strlen($startTime) < 4) {
                                            $startTime = "0" . $startTime;
                                        }
                                        $string = ':';
                                        $position = '2';
                                        $time = substr_replace($startTime, $string, $position, 0);
                                        $twevleHourFormat = date("g:i A", strtotime($time));
                                        echo "<option value='" . $time . "'>" . $twevleHourFormat . "</option>";
                                    }
                                    ?>
                                </select>
                                <label id="errMsg" class="error-msg" style="display:none;">The end time must be greater than the start time.</label>
                                <label id="errMsg2" class="error-msg" style="display:none;">Maximum 120 minutes per book for discussion.</label>
                                <label id="errMsg3" class="error-msg" style="display:none;">Please select the starting time greater than now.</label>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="venue">Venue: </label>
                            </td>
                            <td>
                                <select name="venue" required>
                                    <?php
                                    $venueDA = new VenueDA();
                                    $venueArray = $venueDA->getAll();
                                    if ($venueArray != null) {
                                        foreach($venueArray as $venue){
                                            //if user chosed from Venue List then make default option for user.
                                            if (strcmp($_GET['venueID'], $venue->venueID) == 0) {
                                                echo "<option selected='selected' value='$venue->venueID'>$venue->venueName</option>";
                                            } else {
                                                echo "<option value='$venue->venueID'>$venue->venueName</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>              
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <button type="submit" class='btn btn-primary' id="bookVenue" name='bookVenue' disabled>Book Now</button>
                                <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
                            </td>
                        </tr>
                    </tbody>                    
                </table>
            </form>
        </div>    
    </body>
</html>
