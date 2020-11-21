<?php
require_once '../Domain/AccPDF.php';
session_start();

if(isset($_POST['printid'])){
    $pdf = new AccPDF('P','mm','A4');
    $pdf->printid = $_POST['printid'];
    $pdf->AliasNbPages();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->primaryTitle();
    $pdf->displayEndOfReport();
    $pdf->Output();
}else{
    echo'bye';
}
