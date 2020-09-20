<?php

include_once '../Domain/SessionManagement.php';
include_once '../DataAccess/AdminDA.php';
include_once '../DataAccess/StudentDA.php';
include_once '../DataAccess/SocietyDA.php';
include_once '../Domain/Validation.php';

$session = new SessionManagement();
$session::sessionStarted();

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
            $session::setSession('result', $result);
            $session::setSession('current', 'Admin');
            echo'<script>alert("Login Successfully");location.href = "../UI/HomePage.php";</script>';
            $session::unsetSession('role');
        }
    }
} else if (isset($_POST['societySubmit'])) {
    $val = new Validation();
    $scID = $val->test_input($_POST['societyid']);
    $scpass = $val->test_input($_POST['societypass']);
    if (empty($scID) || empty($scpass)) {
        echo "Cannot leave it empty";
    } else {
        $db = new SocietyDA();
        $result = $db->login($scID);
        if ($scpass == $result->societyPass) {
            $session::setSession('result', $result);
            $session::setSession('current', 'Society');
            $session::unsetSession('role');
            echo'<script>alert("Login Successfully");location.href = "../UI/HomePage.php";</script>';     
        }
    }
} else if (isset($_POST['studentSubmit'])) {
    $val = new Validation();
    $stID = $val->test_input($_POST['userid']);
    $stpass = $val->test_input($_POST['studentpass']);
    if (empty($stID) || empty($stpass)) {
        echo "Cannot leave it empty";
    } else {
        $db = new StudentDA();
        $result = $db->login($stID);
        if ($stpass == $result->password) {
            $session::setSession('result', $result);
            $session::setSession('current', 'Student');
            echo'<script>alert("Login Successfully");location.href = "../UI/HomePage.php";</script>';
            $session::unsetSession('role');
        }
    }
} else {
    header("Location:../UI/HomePage.php");
}



