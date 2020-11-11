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
    $status = $val->test_input($_POST['vstatus']);
    $nul = $_POST['venueid'];
    
    if ($nul == 'Update') {
        $venue = new Venue($id, $name, $desc,$status);
        $venda = new VenueDA();
        $venda->update($venue);
        $_SESSION['venmessage'] = 'Data Updated';
        echo '<script>location.href = "../UI/VenueList.php";</script>';
    } else {
        $venue = new Venue($id, $name, $desc,$status);
        $venda = new VenueDA();
        $venda->regsiter($venue);
        $_SESSION['venmessage'] = 'Data Inserted';
        echo '<script>location.href = "../UI/VenueList.php";</script>';
    }
}

