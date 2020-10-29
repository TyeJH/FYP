<?php

include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/AdminDA.php';
include_once '../DataAccess/SocietyDA.php';
include_once '../DataAccess/StudentDA.php';

session_start();

if (isset($_POST['staffUpdate'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['aID']);
    $pass = $val->test_input($_POST['password']);
    
    if(empty($pass)){
        echo "password cannot be empty";
    }else{
        if($val->passwordIsValid($pass)){
            $admin = new Admin($id,$pass);
            $adminda = new AdminDA();
            $adminda->update($admin);
            $_SESSION['result']=$admin;
            echo '<script>alert("Password Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
        }else{
            echo "password format invalid";
        }
    }
}else if (isset($_POST['societyUpdate'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['sID']);
    $name = $val->test_input($_POST['sName']);
    $desc = $val->test_input($_POST['sDesc']);
    $pass = $val->test_input($_POST['sPass']);
    
    if(empty($pass)){
        echo "password cannot be empty";
    }else{
        if($val->passwordIsValid($pass)){
            $soc = new Society($id,$name,$desc,$pass);
            $socda = new SocietyDA();
            $socda->update($soc);
            $_SESSION['result']= $soc;
            echo '<script>alert("Society Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
        }else{
            echo "password format invalid";
        }
    }
}else if (isset($_POST['studentUpdate'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['uID']);
    $pass = $val->test_input($_POST['password']);
    $studid = $val->test_input($_POST['studid']);
    
    if(empty($pass)){
        echo "password cannot be empty";
    }else{
        if($val->passwordIsValid($pass)){
            $stu = new Student($id,$pass,$studid);
            $studa = new StudentDA();
            $studa->update($stu);
            $_SESSION['result']= $stu;
            echo '<script>alert("Password Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
        }else{
            echo "password format invalid";
        }
    }
}
    



