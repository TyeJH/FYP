<?php

include_once '../Domain/Student.php';
require_once 'StudHistoryPDF.php';
session_start();

if (isset($_POST['printid'])) {

    $pdf = new StudHistoryPDF('P', 'mm', 'A4');
    $pdf->userID = $_SESSION['result']->studID;
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $pdf->displayContent();
    $pdf->displayEndOfReport();
    $pdf->Output();
}

