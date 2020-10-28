<?php
include_once '../Domain/Validation.php';
include_once '../Domain/Venue.php';
include_once '../DataAccess/VenueDA.php';

if(isset($_POST['venueid'])){
    $venue = new VenueDA();
    $list = $venue->retrieveJSON($_POST['venueid']);
    echo json_encode($list);
}