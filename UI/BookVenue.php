<?php
require '../serverLoad.php';
session_start();
if (!isset($_SESSION['result'])) {
    $_SESSION['current'] = 'Society';
    $_SESSION['role'] = 'society';
    header('location:Login.php');
}
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
            }
            function CompareTime() {
                //var purpose = document.getElementById('purpose').value;
                var bookDate = document.getElementById('bookDate').value;
                var errMsg = document.getElementById('errMsg');
                var errMsg2 = document.getElementById('errMsg2');
                var date = new Date(bookDate);
                var startTime = date.format('yyyy/mm/dd') + " " + document.getElementById('startTime').value;
                var endTime = date.format('yyyy/mm/dd') + " " + document.getElementById('endTime').value;
                var st = new Date(Date.parse(startTime));
                var et = new Date(Date.parse(endTime));
                //alert(st + "\n" + et);
                if (st > et || st === et) {
                    errMsg.style.display = 'block';
                } else {
                    errMsg.style.display = 'none';
                }
                if (et - st > 7200000) {
                    errMsg2.style.display = 'block';
                } else {
                    errMsg2.style.display = 'none';
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
                <h1>Venue Booking</h1> 
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
            <form action="../Domain/CreateBooking.php" method="post" enctype="multipart/form-data">
                <table class="table table-hover table-responsive table-bordered">
                    <tbody>

                        <tr>
                            <td>
                                <label for="purposes">Purpose: </label>
                            </td>
                            <td>
                                <select name="purpose" id="purpose" onchange="CheckPurpose(this.value);" required>
                                    <option value="Organize">Organize event</option>
                                    <option value="Discussion">Discussion</option>
                                    <option value="Others">Others</option>
                                </select>
                                <input type="text" name="otherPurposes" id="otherPurposes" placeholder="Your purposes"style='display:none;'/>               
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Booking Date:</label>
                            </td>
                            <td>
                                <input type="date" name="bookDate" id="bookDate" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="bookTime">Time Duration</label>
                            </td>
                            <td>
                                From: <select id="startTime" name="startTime"  onchange="CompareTime()" required>
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
                                To: <select id="endTime" name="endTime" onchange="CompareTime()" required>
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
                                <label id="errMsg2" class="error-msg" style="display:none;">Maximum 120 minutes per book</label>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="venue">Venue: </label>
                            </td>
                            <td>
                                <select name="venue" required>
                                    <?php
                                    $query = 'SELECT * FROM venue';
                                    $stmt = $db->prepare($query);
                                    $stmt->execute();
                                    $num = $stmt->rowCount();
                                    if ($num > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row);
                                            //if user chosed from Venue List then make default option for user.
                                            if (strcmp($_GET['venueID'], $venueID) == 0) {
                                                echo strcmp($venueID, $_GET['venueID']);
                                                echo "<option selected='selected' value='{$venueID}'>{$venueName}</option>";
                                            } else {
                                                echo "<option value='{$venueID}'>{$venueName}</option>";
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
                                <button type="submit" class='btn btn-primary' name='bookVenue'>Book Now</button>
                                <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
                            </td>
                        </tr>
                    </tbody>                    
                </table>
            </form>
        </div>    
    </body>
</html>
