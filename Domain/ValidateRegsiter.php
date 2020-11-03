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
        $_SESSION['error'] = 'Please fill in all the blanks';
        header("Location:../UI/Register.php");
    } else {
        if ($val->passwordIsValid($pass)) {
            if ($val->passwordIsValid($cpass)) {
                if ($pass == $cpass) {
                    $create = new AdminDA();
                    if ($create->checkID($id)) {
                        $ad = new Admin($id, $pass);
                        $create->register($ad);
                        unset($_SESSION['status']);
                        $_SESSION['role'] = 'staff';
                        echo '<script>alert("Account Register Successfully");location.href = "../UI/Login.php";</script>';
                    } else {
                        $_SESSION['error'] = 'Account had been registered';
                        header("Location:../UI/Register.php");
                    }
                } else {
                    $_SESSION['error'] = 'Password and Confirm Password must match';
                    header("Location:../UI/Register.php");
                }
            } else {
                $_SESSION['error'] = 'Confirm Password invalid format';
                header("Location:../UI/Register.php");
            }
        } else {
            $_SESSION['error'] = 'Password invalid format';
            header("Location:../UI/Register.php");
        }
    }
} else if (isset($_POST['studentSubmit'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['id']);
    $email = $val->test_input($_POST['email']);
    $pass = $val->test_input($_POST['pass']);
    $cpass = $val->test_input($_POST['cpass']);
    $stud = $val->test_input($_POST['studid']);

    if (empty($id) || empty($pass) || empty($cpass) || empty($email) || empty($stud)) {
        $_SESSION['error'] = 'Please fill in all the blanks';
        header("Location:../UI/Register.php");
    } else {
        if ($val->passwordIsValid($pass)) {
            if ($val->passwordIsValid($cpass)) {
                if ($pass == $cpass) {
                    $create = new StudentDA();
                    if (!($create->checkID($id))) {
                        if ($create->checkUniID($stud)) {
                            if ($create->checkStudID($stud)) {
                                $st = new Student($id, $pass, $email, $stud);
                                $create->register($st);
                                unset($_SESSION['status']);
                                $_SESSION['role'] = 'student';
                                echo '<script>alert("Account Register Successfully");location.href = "../UI/Login.php";</script>';
                            } else {
                                $_SESSION['error'] = 'Account had been registered';
                                header("Location:../UI/Register.php");
                            }
                        } else {
                            $_SESSION['error'] = 'Invalid Student ID';
                            header("Location:../UI/Register.php");
                        }
                    } else {
                        $_SESSION['error'] = 'Username had been registered';
                        header("Location:../UI/Register.php");
                    }
                } else {
                    $_SESSION['error'] = 'Password and Confirm Password must match';
                    header("Location:../UI/Register.php");
                }
            } else {
                $_SESSION['error'] = 'Confirm Password invalid format';
                header("Location:../UI/Register.php");
            }
        } else {
            $_SESSION['error'] = 'Password invalid format';
            header("Location:../UI/Register.php");
        }
    }
} else {
    header("Location:../UI/HomePage.php");
}

    