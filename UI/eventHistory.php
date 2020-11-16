<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';

session_start();
require 'header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Event History</title>
        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    </head>
    <body>
        <?php
        if (isset($_SESSION['current'])) {
            if ($_SESSION['current'] == "Society") {
                $society = $_SESSION['result'];
                ?>
                <div class="container">
                    <br>
                    <h1 style="text-align: center;font-size: 50px;">History</h1>
                    <br>
                    <?php
                    include_once '../DataAccess/ScheduleDA.php';
                    include_once '../DataAccess/SocietyEventDA.php';
                    $seda = new SocietyEventDA();
                    $event = $seda->retrieveBySocietyID($society->societyID);
                    $sda = new ScheduleDA();
                    ?>
                    <table id="eventhistory" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="33%">Event ID</th>
                                <th width="37%">Event Name</th>
                                <th width="30%">Event Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($event)) {
                                foreach ($event as $eventList) {
                                    $history = $sda->retrieveHistory($eventList->eventID);
                                    $future = $sda->retrieveFuture($eventList->eventID);
                                    if (!empty($history)) {
                                        foreach ($history as $historyList) {
                                            if (empty($future)) {
                                                $sDate = date("d-M-Y", strtotime($historyList->startDate));
                                                $eDate = date("d-M-Y", strtotime($historyList->endDate));
                                                echo"<tr>";
                                                echo "<td>" . $historyList->eventID . "</td>";
                                                echo "<td>" . $eventList->eventName . "</td>";
                                                echo "<td>" . $sDate . " - " . $eDate . "</td>";
                                                echo"</tr>";
                                            } else {
                                                foreach ($future as $futureList) {
                                                    if ($historyList->eventID != $futureList->eventID) {
                                                        $sDate = date("d-M-Y", strtotime($historyList->startDate));
                                                        $eDate = date("d-M-Y", strtotime($historyList->endDate));
                                                        echo"<tr>";
                                                        echo "<td>" . $historyList->eventID . "</td>";
                                                        echo "<td>" . $eventList->eventName . "</td>";
                                                        echo "<td>" . $sDate . " - " . $eDate . "</td>";
                                                        echo"</tr>";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#eventhistory').DataTable();
                    });
                </script>
                <?php
            } else if ($_SESSION['current'] == "Student") {
                $stud = $_SESSION['result'];
                ?>
                <div class="container">
                    <br>
                    <h2>History</h2>
                    <br>
                    <?php
                    include_once '../DataAccess/ParticipantsDA.php';
                    include_once '../DataAccess/SocietyEventDA.php';
                    $try = new ParticipantsDA();
                    $abc = $try->retrieveStudentEvent($stud->studID);
                    $a = new SocietyEventDA();
                    ?>
                    <table id="eventhistory" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="50%">Event ID</th>
                                <th width="50%">Event Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($abc)) {
                                foreach ($abc as $history) {
                                    echo"<tr>";
                                    echo "<td>" . $history->eventID . "</td>";
                                    $b = $a->retrieveByEventID($history->eventID);
                                    if (!empty($b)) {
                                        echo "<td>" . $b->eventName . "</td>";
                                        echo"</tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#eventhistory').DataTable();
                    });
                </script>
                <?php
            }
        } else {
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body>
</html>
