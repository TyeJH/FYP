<?php
require_once '../Domain/Society.php';
require_once '../Domain/Admin.php';
require_once '../Domain/SocietyAccountHistoryPDF.php';

session_start();

if(isset($_POST['printid'])){
    $pdf = new SocietyAccountHistoryPDF('P','mm','A4');
    $pdf->societyID = $_POST['printid'];
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $pdf->displayContent();
    $pdf->displayEndOfReport();
    $pdf->Output();
}
