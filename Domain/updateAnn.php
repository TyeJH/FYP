<?php
include_once '../Domain/Validation.php';
include_once '../Domain/Announcement.php';
include_once '../DataAccess/AnnounceDA.php';

if(isset($_POST['annid'])){
    $ann = new AnnounceDA();
    $list = $ann->retrieveJSON($_POST['annid']);
    echo json_encode($list);
}