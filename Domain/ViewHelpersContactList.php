<?php

require_once '../DataAccess/HelpersDA.php';
require_once '../DataAccess/StudentDA.php';
require_once '../DataAccess/SocietyEventDA.php';
require_once '../Domain/Society.php';

session_start();
if (isset($_POST['eventID'])) {
    $helpersDA = new HelpersDA();
    $helperArray = $helpersDA->retrieveByEventIDAndApplyStatus($_POST['eventID'], 'Approved');
    $studentDA = new StudentDA();
    if ($helperArray != null) {
        echo "<table>";
        foreach ($helperArray as $helper) {
            $student = $studentDA->retrieveStudentDetails($helper->userID);
            echo "<tr>";
            echo "<td>&nbsp;{$student['studEmail']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo 'No record found';
    }
}    