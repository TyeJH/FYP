<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'AttendancePDF.php';
session_start();
//For particular schedule.
if (isset($_POST['eventID']) && isset($_POST['scheduleID'])) {

    $pdf = new AttendancePDF('P','mm','A4');
    $pdf->eventID = $_POST['eventID'];
    $pdf->scheduleID = $_POST['scheduleID'];
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $pdf->scheduleTitle($pdf->scheduleID);
    $pdf->displayContent($pdf->scheduleID);
    $pdf->displaySummaryPerSession();
    $pdf->displayEndOfReport();
    $pdf->Output();
}
//Display overall attendance
if (isset($_POST['eventID'])) {

    $pdf = new AttendancePDF('P','mm','A4');
    $pdf->eventID = $_POST['eventID'];
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $scheduleDA = new ScheduleDA();
    $scheduleArray = $scheduleDA->retrieve($pdf->eventID);
    if ($scheduleArray != null) {
        foreach ($scheduleArray as $schedule) {
            $pdf->scheduleTitle($schedule->scheduleID);
            $pdf->displayContent($schedule->scheduleID);
            $pdf->displaySummaryPerSession();
        }
    } else {
        $pdf->displayNoRecordFound();
    }
    $pdf->displayGrandSummry();
    $pdf->displayEndOfReport();
    $pdf->Output();
}

