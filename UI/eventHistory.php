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
                    <hr>
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
                                <th width="30%">Attendance Report</th>
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
                                                echo "<td>";
                                                echo "<form target='_blank' action='../Domain/GenerateAttendanceReport.php' method='Post'>";
                                                echo "<input type='hidden' value='$historyList->eventID' name='eventID'>";
                                                echo "<input style='border:1px solid;'type='image' src='../image/attendanceIcon.jpg' alt='Submit' width='48' height='48'>";
                                                echo "</form>";
                                                echo "</td>";
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
                                                        echo "<td>";
                                                        echo "<form target='_blank' action='../Domain/GenerateAttendanceReport.php' method='Post'>";
                                                        echo "<input type='hidden' value='$historyList->eventID' name='eventID'>";
                                                        echo "<input style='border:1px solid;'type='image' src='../image/attendanceIcon.jpg' alt='Submit' width='48' height='48'>";
                                                        echo "</form>";
                                                        echo "</td>";
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
                    <h1 style="text-align: center;font-size: 50px;">History</h1>
                    <hr>
                    <br>
                    <?php
                    include_once '../DataAccess/ParticipantsDA.php';
                    include_once '../DataAccess/HelpersDA.php';
                    include_once '../DataAccess/SocietyEventDA.php';
                    include_once '../DataAccess/ScheduleDA.php';
                    $pda = new ParticipantsDA();
                    $hda = new HelpersDA();
                    $part = $pda->retrievePartHistory($stud->studID);
                    $help = $hda->retrieveHelpHistory($stud->studID);
                    $seda = new SocietyEventDA();
                    $sda = new ScheduleDA();
                    ?>
                    <table id="eventhistory" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="20%">Event ID</th>
                                <th width="30%">Event Name</th>
                                <th width="25%">Date Attended</th>
                                <th width="25%">Participants / Helper</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($part)) {
                                foreach ($part as $partList) {
                                    $history = $sda->retrieveHistory($partList->eventID);
                                    $future = $sda->retrieveFuture($partList->eventID);
                                    if (!empty($history)) {
                                        foreach ($history as $historyList) {
                                            if (empty($future)) {
                                                $joined = $sda->retrieveByScheduleID($partList->scheduleID);
                                                $eName = $seda->retrieveByEventID($partList->eventID);
                                                if (!empty($joined)) {
                                                    $jDate = date("d-M-Y", strtotime($joined->startDate));
                                                    if (!empty($eName)) {
                                                        echo"<tr>";
                                                        echo "<td>" . $historyList->eventID . "</td>";
                                                        echo "<td>" . $eName->eventName . "</td>";
                                                        echo "<td>" . $jDate . "</td>";
                                                        echo "<td> Participants </td>";
                                                        echo"</tr>";
                                                    }
                                                }
                                            } else {
                                                foreach ($future as $futureList) {
                                                    if ($historyList->eventID != $futureList->eventID) {
                                                        $joined = $sda->retrieveByScheduleID($partList->scheduleID);
                                                        $eName = $seda->retrieveByEventID($partList->eventID);
                                                        if (!empty($joined)) {
                                                            $jDate = date("d-M-Y", strtotime($joined->startDate));
                                                            if (!empty($eName)) {
                                                                echo"<tr>";
                                                                echo "<td>" . $historyList->eventID . "</td>";
                                                                echo "<td>" . $eName->eventName . "</td>";
                                                                echo "<td>" . $jDate . "</td>";
                                                                echo "<td> Participants </td>";
                                                                echo"</tr>";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if (!empty($help)) {
                                foreach ($help as $helpList) {
                                    $history = $sda->retrieveHistory($helpList->eventID);
                                    $future = $sda->retrieveFuture($helpList->eventID);
                                    if (!empty($history)) {
                                        foreach ($history as $historyList) {
                                            if (empty($future)) {
                                                $eName = $seda->retrieveByEventID($helpList->eventID);
                                                $sDate = date("d-M-Y", strtotime($historyList->startDate));
                                                $eDate = date("d-M-Y", strtotime($historyList->endDate));
                                                if (!empty($eName)) {
                                                    echo"<tr>";
                                                    echo "<td>" . $historyList->eventID . "</td>";
                                                    echo "<td>" . $eName->eventName . "</td>";
                                                    echo"<td>" . $sDate . " - " . $eDate . "</td>";
                                                    echo "<td> Helpers </td>";
                                                    echo"</tr>";
                                                }
                                            } else {
                                                foreach ($future as $futureList) {
                                                    if ($historyList->eventID != $futureList->eventID) {
                                                        $eName = $seda->retrieveByEventID($helpList->eventID);
                                                        $sDate = date("d-M-Y", strtotime($historyList->startDate));
                                                        $eDate = date("d-M-Y", strtotime($historyList->endDate));
                                                        if (!empty($eName)) {
                                                            echo"<tr>";
                                                            echo "<td>" . $historyList->eventID . "</td>";
                                                            echo "<td>" . $eName->eventName . "</td>";
                                                            echo"<td>" . $sDate . " - " . $eDate . "</td>";
                                                            echo "<td> Helpers </td>";
                                                            echo"</tr>";
                                                        }
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
            }
        } else {
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body>
</html>
