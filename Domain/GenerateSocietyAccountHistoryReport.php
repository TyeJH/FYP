<?php

require_once '../Domain/Society.php';
require 'SocietyAccountHistoryPDF.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

