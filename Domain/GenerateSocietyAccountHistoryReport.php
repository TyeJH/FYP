<?php
require_once '../Domain/Society.php';
require 'SocietyAccountHistoryPDF.php';

session_start();

if(isset($_POST['printid'])){
    $pdf = new SocietyAccountHistoryPDF('P','mm','A4');
    $pdf->societyID = $_SESSION['result']->societyID;
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $pdf->displayContent();
    $pdf->displayEndOfReport();
    $pdf->Output();
}
