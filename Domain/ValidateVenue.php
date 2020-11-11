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

    $venda = new VenueDA();
    if ($nul == 'Update') {
        $namedb = $venda->retrieve($id);
        if ($name != $namedb->venueName) {
            if ($venda->checkName($name)) {
                $venue = new Venue($id, $name, $desc, $status);
                $venda->update($venue);
                $_SESSION['venmessage'] = 'Data Updated';
                echo '<script>location.href = "../UI/VenueList.php";</script>';
            } else {
                echo '<script>alert("Update Failed. Venue name duplicate.");location.href = "../UI/VenueList.php";</script>';
            }
        } else {
            echo '<script>location.href = "../UI/VenueList.php";</script>';
        }
    } else {
        if ($venda->checkName($name)) {
            $venue = new Venue($id, $name, $desc, $status);
            $venda->regsiter($venue);
            $_SESSION['venmessage'] = 'Data Inserted';
            echo '<script>location.href = "../UI/VenueList.php";</script>';
        } else {
            echo '<script>alert("Update Failed. Venue name duplicate.");location.href = "../UI/VenueList.php";</script>';
        }
    }
}

