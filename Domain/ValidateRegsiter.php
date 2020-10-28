<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/AdminDA.php';
include_once '../DataAccess/StudentDA.php';

session_start();

if (isset($_POST['staffSubmit'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['adminid']);
    $pass = $val->test_input($_POST['pass']);
    $cpass = $val->test_input($_POST['cpass']);

    if (empty($id) || empty($pass) || empty($cpass)) {
        echo'cannot leave it empty';
    } else {
        if ($val->passwordIsValid($pass)) {
            if ($val->passwordIsValid($cpass)) {
                if ($pass == $cpass) {
                    $create = new AdminDA();
                    if ($create->checkID($id)) {
                        $ad = new Admin($id, $pass);
                        $create->register($ad);
                        unset($_SESSION['status']);
                        $_SESSION['role']='staff';
                        echo '<script>alert("Account Register Successfully");location.href = "../UI/Login.php";</script>';
                    } else {
                        echo'Account had been registered';
                    }
                } else {
                    echo'Password and Confirm Password must match';
                }
            } else {
                echo'Confirm Password invalid format';
            }
        } else {
            echo'Password invalid format';
        }
    }
} else if (isset($_POST['studentSubmit'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['id']);
    $pass = $val->test_input($_POST['pass']);
    $cpass = $val->test_input($_POST['cpass']);
    $stud = $val->test_input($_POST['studid']);

    if (empty($id) || empty($pass) || empty($cpass) || empty($stud)) {
        echo "cannot empty";
    } else {
        if ($val->passwordIsValid($pass)) {
            if ($val->passwordIsValid($cpass)) {
                if ($pass == $cpass) {
                    $create = new StudentDA();
                    if ($create->checkUniID($stud)) {
                        if ($create->checkStudID($stud)) {
                            $st = new Student($id, $pass, $stud);
                            $create->register($st);
                            unset($_SESSION['status']);
                            $_SESSION['role']='student';
                            echo '<script>alert("Account Register Successfully");location.href = "../UI/Login.php";</script>';
                        } else {
                            echo'Account had been registered';
                        }
                    } else {
                        echo'Invalid Student ID';
                    }
                } else {
                    echo'Password and Confirm Password must match';
                }
            } else {
                echo'Confirm Password invalid format';
            }
        } else {
            echo'Password invalid format';
        }
    }
} else {
    header("Location:../UI/HomePage.php");
}

    