<?php
require_once '../Domain/SocietyEvent.php';
require_once '../DataAccess/SocietyEventDA.php';
include_once '../Domain/UpdateEvent.php';

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
    </script>

    <body>

        <div class='container'>
            <div class='page-header'>
                <h1>Your Event</h1>
            </div>

            <?php
            if (isset($_SESSION['message'])) {
                echo '<br>' . $_SESSION['message'];
                unset($_SESSION['message']);
            }
            if (isset($_GET['eventID'])) {
                $eventID = $_GET['eventID'];
                $eventDA = new SocietyEventDA();
                $event = $eventDA->retrieveByEventID($eventID);
                if ($event == null) {
                    header('location:EventOrganizerHome.php');
                }
                ?>
                <form action="../Domain/UpdateEvent.php" method="post" enctype="multipart/form-data">
                    <table class='table table-hover table-responsive table-bordered'>
                        <tr>
                            <td>Event Name :</td>
                            <td>
                                <input type="text" name="eventName" value="<?= $event->eventName ?>" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Description :</td>
                            <td>
                                <input type="text" name="eventDesc" value="<?= $event->eventDesc ?>" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Category :</td>
                            <td>
                                <input type="text" name="eventCategory" value="<?= $event->eventCategory ?>" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Participants Allowed : </td>
                            <td>
                                <input type="number" min="1" name="noOfParticipant" value="<?= $event->noOfParticipant ?>" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Helper Needed : </td>
                            <td>  
                                <input type="number" min="0" name="noOfHelper" value="<?= $event->noOfHelper ?>" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Start date :</td>

                            <td>            
                                <input type="text" id="start" name="startDate" value="<?= $event->startDate ?>" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>            
                            <td>End date :</td>
                            <td>            
                                <input type="text" id="end" name="endDate" value="<?= $event->endDate ?>" class='form-control'/><br>
                            </td>
                        </tr>
                        <tr>            
                            <td>Contact No (+60) :  </td>
                            <td>
                                <input type="text"  placeholder="Optional" pattern="[0-9]{9}" value="<?= $event->contactNo ?>" class='form-control' name="contactNo"/> Format : 162152296<br>
                            </td>
                        </tr>
                        <tr>
                            <td>Event Picture : </td>
                            <td>        
                                <img id="preview-image" src="data:image/jpeg;base64, <?= base64_encode($event->image); ?>"/>
                                <input type="file" name="myfile"/>
                                <input type="hidden" name="myfile2" value="<?= base64_encode($event->image); ?>">
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <input type="hidden" name="eventID" value="<?= $event->eventID ?>" />
                                <button type="submit" class='btn btn-primary' name="updateEvent">Save</button>
                                <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
                            </td>
                        </tr>

                    </table>

                </form>
                <?php
            }
            ?>
        </div>

    </body>
</html>
