<?php
include_once '../Domain/Validation.php';
include_once '../Domain/Society.php';
include_once '../DataAccess/SocietyDA.php';

if(isset($_POST['socid'])){
    $soc = new SocietyDA();
    $list = $soc->retrieveJSON($_POST['socid']);
    echo json_encode($list);
}