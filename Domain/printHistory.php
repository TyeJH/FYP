<?php
require_once '../Domain/HistoryPDF.php';
session_start();

if(isset($_POST['printid'])){
    echo $_POST['printid'];
}else{
    echo'bye';
}


