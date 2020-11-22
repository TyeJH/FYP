<?php

require_once '../Domain/Society.php';
require_once '../Domain/Admin.php';
require_once '../Domain/SocietyAccountHistoryPDF.php';

session_start();

if (isset($_POST['printid'])) {
    $pdf = new SocietyAccountHistoryPDF('P', 'mm', 'A4');
    $pdf->societyID = $_POST['printid'];
    $pdf->type = 'All';
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $pdf->displayContent();
    $pdf->displayEndOfReport();
    $pdf->Output();
}

if (isset($_POST['societyGenerateAccHistoryReport'])) {

    $pdf = new SocietyAccountHistoryPDF('P', 'mm', 'A4');
    $pdf->societyID = $_SESSION['result']->societyID;
    if (isset($_POST['type']) == 'All') {
        $pdf->type = 'All';
    } else {
        $pdf->type = 'customDate';
        $pdf->startDate = $_POST['startDate'];
        $pdf->endDate = $_POST['endDate'];
    }

    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $pdf->displayContent();
    $pdf->displayEndOfReport();
    $pdf->Output();
}

