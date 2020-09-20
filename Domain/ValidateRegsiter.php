<?php
include_once '../Domain/Admin.php';
include_once '../DataAccess/AdminDA.php';
include_once'../Domain/Validation.php';

if (isset($_POST['rSubmit'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['adminid']);
    $positon = $val->test_input($_POST['position']);
    $pass = $val->test_input($_POST['pass']);
    $cpass = $val->test_input($_POST['cpass']);
    $staff = $val->test_input($_POST['staffid']);

    if (empty($id) || empty($positon) || empty($pass) || empty($cpass) || empty($staff)) {
        echo'cannot leave it empty';
    }else{
        if($val->passwordIsValid($pass)==true){
            if($val->passwordIsValid($cpass)==true){
                if($pass==$cpass){
                    $create = new AdminDA();
                    if($create->checkStaffID($staff)){
                        $ad= new Admin($id,$positon,$pass,$staff); 
                        $create->regsiter($ad);
                        echo '<script>alert("Account Register Successfully");location.href = "../UI/HomePage.php";</script>';
                    } else {
                        echo'Invalid Staff ID';
                    }
                }else{
                    echo'Password and Confirm Password must match';
                }
            }else{
                echo'Confirm Password invalid format';
            }
        }else{
                echo'Password invalid format';
            }
    }
} else if (isset($_POST['sSubmit'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['id']);
    $name = $val->test_input($_POST['username']);
    $pass = $val->test_input($_POST['pass']);
    $cpass = $val->test_input($_POST['cpass']);
    $stud = $val->test_input($_POST['studid']);

    if(empty($id)||empty($name)||empty($pass)||empty($cpass)||empty($stud)){
        
    }
}else{
    header("Location:../UI/HomePage.php");
}

