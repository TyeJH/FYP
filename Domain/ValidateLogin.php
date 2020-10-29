<?php

include_once '../DataAccess/AdminDA.php';
include_once '../DataAccess/StudentDA.php';
include_once '../DataAccess/SocietyDA.php';
include_once '../Domain/Validation.php';

session_start();

if (isset($_POST['staffSubmit'])) {
    $val = new Validation();
    $aID = $val->test_input($_POST['adminid']);
    $apass = $val->test_input($_POST['adminpass']);

    if (empty($aID) || empty($apass)) {
        echo "Cannot leave it empty";
    } else {
        $db = new AdminDA();
        $result = $db->login($aID);
        if ($apass == $result->password) {
            $_SESSION['result'] = $result;
            $_SESSION['current'] = "Admin";
            unset($_SESSION['role']);
            echo'<script>alert("Login Successfully");location.href = "../UI/HomePage.php";</script>';
        } else {
            echo "password invalid";
        }
    }
} else if (isset($_POST['societySubmit'])) {
    $val = new Validation();
    $scID = "SOC" . $val->test_input($_POST['societyid']);
    $scpass = $val->test_input($_POST['societypass']);

    if (empty($scID) || empty($scpass)) {
        echo "Cannot leave it empty";
    } else {
        $db = new SocietyDA();
        $result = $db->login($scID);
        if ($scpass == $result->societyPass) {
            $_SESSION['result'] = $result;
            $_SESSION['current'] = "Society";
            unset($_SESSION['role']);
            echo'<script>alert("Login Successfully");location.href = "../UI/EventOrganizerHome.php";</script>';
        } else {
            echo "password invalid";
        }
    }
} else if (isset($_POST['studentSubmit'])) {
    $val = new Validation();
    $stID = "STU" . $val->test_input($_POST['userid']);
    $stpass = $val->test_input($_POST['studentpass']);

    if (empty($stID) || empty($stpass)) {
        echo "Cannot leave it empty";
    } else {
        $db = new StudentDA();
        $result = $db->login($stID);
        if ($stpass == $result->password) {
            $_SESSION['result'] = $result;
            $_SESSION['current'] = "Student";
            unset($_SESSION['role']);
            echo'<script>alert("Login Successfully");location.href = "../UI/HomePage.php";</script>';
        }
    }
} else {
    header("Location:../UI/HomePage.php");
}



