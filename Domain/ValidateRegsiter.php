<?php
include_once '../DataAccess/AdminDA.php';
include_once'../Domain/Validation.php';

if(isset($_POST['rSubmit'])){
    $val = new Validation();
    $id = $val->test_input($_POST['adminid']);
    $positon = $val->test_input($_POST['position']);
    $pass = $val->test_input($_POST['pass']);
    $cpass = $val->test_input($_POST['cpass']);
    $staff = $val->test_input($_POST['staffid']);
    
    echo $id,$positon,$pass,$cpass,$staff;
    
}else if(isset($_POST['sSubmit'])){
    $val = new Validation();
    $id = $val->test_input($_POST['id']);
    $name = $val->test_input($_POST['username']);
    $pass = $val->test_input($_POST['pass']);
    $cpass = $val->test_input($_POST['cpass']);
    $stud = $val->test_input($_POST['studid']);
    
    echo $id,$name,$pass,$cpass,$stud;
}

