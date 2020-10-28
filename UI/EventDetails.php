<?php require '../DataAccess/SocietyEventDA.php'; ?>
<?php require '../Domain/CreateParticipant.php'; ?>

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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
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
    <script type="text/javascript">
        function JSalert() {
            swal("Congrats!", ", Thanks for joining our event. An email had send to you!", "success");
        }
    </script>
    <body>

        <div class='container'>
            <div class='page-header'>
                <h1>Event Details</h1>
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
                            <td>Participants Allowed : </td>
                            <td>
                                <?= $event->noOfParticipant ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Helper Needed : </td>
                            <td>  
                                <?= $event->noOfHelper ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Start date :</td>

                            <td>            
                                <?= $event->startDate ?>
                            </td>
                        </tr>
                        <tr>            
                            <td>End date :</td>
                            <td>            
                                <?= $event->endDate ?>
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

                            </td>
                            <td>
                                <input type="hidden" name="eventID" value="<?= $event->eventID ?>" />
                                <button onclick="JSalert()" type="submit" class='btn btn-primary' name="participate">Participate Now !</button>
                                <button onclick="JSalert()" type="submit" class='btn btn-primary' name="applyHelper">Register as Helper!</button>
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
