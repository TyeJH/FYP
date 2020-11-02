<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Society.php';
include_once '../DataAccess/SocietyEventDA.php';
session_start();
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
        <title>HomePage Events</title>
        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#eventTable').DataTable();
            });
        </script> 
    </head>
    <body>
<!--        original table class <table id='eventTable' class ='table table-hover table-responsive table-bordered'>-->
        <div class='container'>
            <div class='page-header'>
                <h1>Events Happening</h1>
            </div>
            <?php
            //table clsas removed table-responsive
            echo "<table id='eventTable' class ='table table-hover  table-bordered'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $eventDA = new SocietyEventDA();
            $eventArray = $eventDA->retrieve();
            if ($eventArray == null) {
                echo "<tr>";
                echo "<td colspan='7' style=color:red;text-align:center;>No records found.</td>";
                echo "</tr>";
            } else {
                foreach ($eventArray as $event) {
                    echo "<tr>";
                    echo "<td>{$event->eventName}</td>";
                    echo "<td> <a href = 'EventDetails.php?eventID={$event->eventID}' class='btn btn-primary m-r-1em'>View</a> ";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            ?>
            <a href="HomePage.php" class="btn btn-danger">Back</a>
        </div>

    </body>
</html>
