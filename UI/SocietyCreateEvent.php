<?php
require_once '../DataAccess/SocietyEventDA.php';

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
        function verifySubmit() {
            if (document.editEventDetailsForm.eventName.value == '') {
                alert('Please enter the event name.');
                return false;
            }
            if (document.editEventDetailsForm.eventDesc.value == '') {
                alert('Please enter the event name.');
                return false;
            }
            if (document.editEventDetailsForm.eventCategory.value == '') {
                alert('Please enter the event name.');
                return false;
            }
            if (document.editEventDetailsForm.noOfHelper.value == '') {
                alert('Please enter the event name.');
                return false;
            }
            if (document.editEventDetailsForm.myfile.value == '') {
                alert('Please enter the event name.');
                return false;
            }
        }
    </script>

    <body>
        <div class="container">
            <div class="page-header">
                <h1>Create Event</h1>
            </div>
            <?php
            if (!isset($_GET['applyID'])) {
                //If user haven't chose which approved document.
                echo "<p>Have your documentation approved yet? <a href='ViewApplyStatus.php'> Click here to view </a></p>";
            } else {
                $applyID = $_GET['applyID'];
                $eventDA = new SocietyEventDA();
                if ($eventDA->isApplyIdExist($applyID)) {
                    //If event already created by user.
                    if (isset($_SESSION['successMsg'])) {
                        echo "<div class='alert alert-success'><strong>Success! </strong>" . $_SESSION['successMsg'] . '</div>';
                        unset($_SESSION['successMsg']);
                    }
                    if (isset($_SESSION['errorMsg'])) {
                        echo "<div class='alert alert-danger'><strong>Failed! </strong>" . $_SESSION['errorMsg'] . '</div>';
                        unset($_SESSION['errorMsg']);
                    }
                    echo "<p>You have already created your event. <a href='EventOrganizerHome.php'> Click here to view </a></p>";
                } else {
                    ?>
                    <form name="createEventDetailsForm" action="../Domain/CreateSocietyEvent.php" method="post" enctype="multipart/form-data" onSubmit="return verifySubmit()">
                        <table class='table table-hover table-bordered'>
                            <tr>
                                <td>Event Name :</td>
                                <td>
                                    <input type="text" name="eventName" class='form-control' value="<?php echo isset($_POST["eventName"]) ? $_POST["eventName"] : ''; ?>"/><br>
                                </td>
                            </tr>
                            <tr>
                                <td>Description :</td>
                                <td>
                                    <input type="text" name="eventDesc" class='form-control' value="<?php echo isset($_POST['eventDesc']); ?>"/><br>
                                </td>
                            </tr>
                            <tr>
                                <td>Category :</td>
                                <td>
                                    <input type="text" name="eventCategory" class="form-control"/><br>
                                </td>
                            </tr>
                            <tr>
                                <td>Helper Needed : </td>
                                <td>  
                                    <input type="number" min="0" name="noOfHelper" class='form-control'/><br>
                                </td>
                            </tr>
                            <tr>            
                                <td>Contact No (+60):</td>
                                <td>
                                    <input type="text"  placeholder="Optional" pattern="[0-9]{9}" class='form-control' name="contactNo"/> Format : 162152296<br>
                                </td>
                            </tr>
                            <tr>
                                <td>Event Picture : </td>
                                <td>
                                    <input type="file" name="myfile"><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <input type="hidden" name="applyID" value="<?php echo $applyID; ?>"/><br>
                                    <button type="submit" onclick="return confirm('Would you like to publish now?')" class='btn btn-primary' name="createEvent">Post Now</button>
                                    <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
                                </td>
                            </tr>

                        </table>

                    </form>
                </div>

                <?php
            }
        }
        ?>
    </body>
</html>
