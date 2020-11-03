<?php
session_start();
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
        <title>Create Event</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    </head>
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
        function checkUnlimited(yesNo) {
            var element = document.getElementById('noOfParticipant');
            if (yesNo === 'Yes') {
                element.value = null;
                element.disabled = true;
                element.required = false;
            } else {
                element.disabled = false;
                element.required = true;
            }
        }

    </script>

    <body>
        <div class="container">
            <div class="page-header">
                <h1>Create Schedule</h1>
            </div>
            <?php
            if (!isset($_GET['eventID'])) {
                //If user haven't chose which approved document.
                echo "<p>Have your documentation approved yet? <a href='ViewApplyStatus.php'> Click here to view </a></p>";
            } else {
                if (isset($_SESSION['successMsg'])) {
                    echo "<div class='alert alert-success'><strong>Success! </strong>" . $_SESSION['successMsg'] . '</div>';
                    unset($_SESSION['successMsg']);
                }
                if (isset($_SESSION['errorMsg'])) {
                    echo "<div class='alert alert-danger'><strong>Failed! </strong>" . $_SESSION['errorMsg'] . '</div>';
                    unset($_SESSION['errorMsg']);
                }
                $eventID = $_GET['eventID'];
                ?>
                <form action="../Domain/CreateSchedule.php" method="post" enctype="multipart/form-data">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>Venue : </td>
                            <td>  
                                <input type="text" name="venue" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Date Time :</td>
                            <td>
                                Start Date : <input type="text" id="start" name="startDate" />
                                Time : <input type="time" name="startTime" />
                            </td>
                        </tr>
                        <tr>            
                            <td></td>
                            <td>
                                End Date : <input type="text" id="end" name="endDate"/>
                                Time : <input type="time" name="endTime" />
                            </td>
                        </tr>
                        <tr>
                            <td>Unlimited Participant : </td>
                            <td>
                                Yes <input type="radio" id="unlimited" name="unlimited" onClick="checkUnlimited(this.value)" value="Yes"/>
                                No <input type="radio" id="unlimited" name="unlimited" onClick="checkUnlimited(this.value)" value="No" checked/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Participants Allowed :</td>
                            <td>
                                <input type="number" min="1" id="noOfParticipant" name="noOfParticipant" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input type="hidden" name="eventID" value="<?php echo $eventID; ?>"/><br>
                                <button type="submit" onclick="return confirm('Would you like to publish the schedule now?')" class='btn btn-primary' name="createSchedule">Schedule Now</button>
                                <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
                            </td>
                        </tr>
                    </table>

                </form>
            </div>

            <?php
        }
        ?>
    </body>
</html>
