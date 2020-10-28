<?php

include_once '../Domain/Validation.php';
include_once '../Domain/Venue.php';
include_once '../DataAccess/VenueDA.php';

session_start();

if (!empty($_POST)) {
    $val = new Validation();
    $id = $val->test_input($_POST['vid']);
    $name = $val->test_input($_POST['vName']);
    $desc = $val->test_input($_POST['vDesc']);
    $nul = $_POST['venueid'];
    if ($nul != '') {
        $venue = new Venue($id, $name, $desc);
        $venda = new VenueDA();
        $venda->update($venue);
        $_SESSION['message'] = 'Data Updated';
        echo '<script>location.href = "../UI/VenueList.php";</script>';
    } else {
        $venue = new Venue($id, $name, $desc);
        $venda = new VenueDA();
        $venda->regsiter($venue);
        $_SESSION['message'] = 'Data Inserted';
        echo '<script>location.href = "../UI/VenueList.php";</script>';
    }
}

