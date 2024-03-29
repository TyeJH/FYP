<?php

include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';
include_once '../Domain/Validation.php';
include_once '../DataAccess/AdminDA.php';
include_once '../DataAccess/SocietyDA.php';
include_once '../DataAccess/StudentDA.php';

session_start();

if (isset($_POST['societyUpdate'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['sID']);
    $name = $val->test_input($_POST['sName']);
    $desc = $val->test_input($_POST['sDesc']);
    $pass = $val->test_input($_POST['sPass']);
    $acc = $val->test_input($_POST['sAcc']);

    if (empty($name) || empty($desc)) {
        $_SESSION['error'] = 'Please fill in all the empty box';
        header("Location:../UI/UserProfile.php");
    } else {
        $soc = new Society($id, $name, $desc, $pass, $acc);
        $socda = new SocietyDA();
        $socda->update($soc);
        $_SESSION['result'] = $soc;
        echo '<script>alert("Society Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
    }
} else if (isset($_POST['studentUpdate'])) {
    $val = new Validation();
    $id = $val->test_input($_POST['uID']);
    $name = $val->test_input($_POST['uname']);
    $pass = $val->test_input($_POST['password']);
    $email = $val->test_input($_POST['email']);
    $studid = $val->test_input($_POST['studid']);

    if (empty($name) || empty($email)) {
        $_SESSION['error'] = 'Please fill in all the empty box';
        header("Location:../UI/UserProfile.php");
    } else {
        $studa = new StudentDA();

        if ($name == $_SESSION['result']->username && $email == $_SESSION['result']->studEmail) {
            header("Location:../UI/UserProfile.php");
        } else if ($name !== $_SESSION['result']->username && $email == $_SESSION['result']->studEmail) {
            if ($studa->checkUsername($name)) {
                $stu = new Student($id, $name, $pass, $email, $studid);
                $studa->update($stu);
                $_SESSION['result'] = $stu;
                echo '<script>alert("User Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
            } else {
                $_SESSION['error'] = 'Username had been registered';
                header("Location:../UI/UserProfile.php");
            }
        } else if ($name == $_SESSION['result']->username && $email !== $_SESSION['result']->studEmail) {
            if ($studa->checkEmail($email)) {
                $stu = new Student($id, $name, $pass, $email, $studid);
                $studa->update($stu);
                $_SESSION['result'] = $stu;
                echo '<script>alert("User Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
            } else {
                $_SESSION['error'] = 'Email had been used';
                header("Location:../UI/UserProfile.php");
            }
        } else {
            if ($studa->checkUsername($name)) {
                if ($studa->checkEmail($email)) {
                    $stu = new Student($id, $name, $pass, $email, $studid);
                    $studa->update($stu);
                    $_SESSION['result'] = $stu;
                    echo '<script>alert("User Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
                } else {
                    $_SESSION['error'] = 'Email had been used';
                    header("Location:../UI/UserProfile.php");
                }
            } else {
                $_SESSION['error'] = 'Username had been registered';
                header("Location:../UI/UserProfile.php");
            }
        }

//        if ($name == $_SESSION['result']->username) {
//            if ($email == $_SESSION['result']->studEmail) {
//                header("Location:../UI/UserProfile.php");
//            } else {
//                if ($studa->checkEmail($email)) {
//                    $stu = new Student($id, $name, $pass, $email, $studid);
//                    $studa->update($stu);
//                    $_SESSION['result'] = $stu;
//                    echo '<script>alert("User Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
//                } else {
//                    $_SESSION['error'] = 'Email had been used';
//                    header("Location:../UI/UserProfile.php");
//                }
//            }
//        } else if ($email == $_SESSION['result']->studEmail) {
//            if ($name == $_SESSION['result']->username) {
//                header("Location:../UI/UserProfile.php");
//            } else {
//                if ($studa->checkUsername($name)) {
//                    $stu = new Student($id, $name, $pass, $email, $studid);
//                    $studa->update($stu);
//                    $_SESSION['result'] = $stu;
//                    echo '<script>alert("User Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
//                } else {
//                    $_SESSION['error'] = 'Username had been registered';
//                    header("Location:../UI/UserProfile.php");
//                }
//            }
//        } else {
//            if ($studa->checkUsername($name)) {
//                if ($studa->checkEmail($email)) {
//                    $stu = new Student($id, $name, $pass, $email, $studid);
//                    $studa->update($stu);
//                    $_SESSION['result'] = $stu;
//                    echo '<script>alert("User Details Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
//                } else {
//                    $_SESSION['error'] = 'Email had been used';
//                    header("Location:../UI/UserProfile.php");
//                }
//            } else {
//                $_SESSION['error'] = 'Username had been registered';
//                header("Location:../UI/UserProfile.php");
//            }
//        }
    }
}

//Update Password
if (isset($_POST['updatePassword'])) {
    if ($_SESSION['current'] == 'Admin') {
        $val = new Validation();
        $currentPassword = $val->test_input($_POST['currentPassword']);
        $newPassword = $val->test_input($_POST['newPassword']);
        $confirmPassword = $val->test_input($_POST['confirmPassword']);

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo '<script>alert("Please enter all details.");location.href = "../UI/UserProfile.php";</script>';
        } else if (!($val->comparePass($currentPassword, $_SESSION['result']->password))) {
            echo '<script>alert("Incorrect Password.");location.href = "../UI/UserProfile.php";</script>';
        } else if ($newPassword != $confirmPassword) {
            echo '<script>alert("Password not match.");location.href = "../UI/UserProfile.php";</script>';
        } else {
            if ($val->passwordIsValid($newPassword)) {
                $adm = new Admin($_SESSION['result']->adminID, $val->securePassword($newPassword));
                $admda = new AdminDA();
                $admda->update($adm);
                $_SESSION['result'] = $adm;
                echo '<script>alert("Password Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
            } else {
                echo '<script>alert("Password invalid format.");location.href = "../UI/UserProfile.php";</script>';
            }
        }
    } else if ($_SESSION['current'] == 'Society') {
        $val = new Validation();
        $currentPassword = $val->test_input($_POST['currentPassword']);
        $newPassword = $val->test_input($_POST['newPassword']);
        $confirmPassword = $val->test_input($_POST['confirmPassword']);

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo '<script>alert("Please enter all details.");location.href = "../UI/UserProfile.php";</script>';
        } else if (!($val->comparePass($currentPassword, $_SESSION['result']->societyPass))) {
            echo '<script>alert("Incorrect Password.");location.href = "../UI/UserProfile.php";</script>';
        } else if ($newPassword != $confirmPassword) {
            echo '<script>alert("Password not match.");location.href = "../UI/UserProfile.php";</script>';
        } else {
            if ($val->passwordIsValid($newPassword)) {
                $soc = new Society($_SESSION['result']->societyID, $_SESSION['result']->societyName, $_SESSION['result']->societyDesc, $val->securePassword($newPassword), $_SESSION['result']->societyAcc);
                $socda = new SocietyDA();
                $socda->update($soc);
                $_SESSION['result'] = $soc;
                echo '<script>alert("Password Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
            } else {
                echo '<script>alert("Password invalid format.");location.href = "../UI/UserProfile.php";</script>';
            }
        }
    } else if ($_SESSION['current'] == 'Student') {
        $val = new Validation();
        $currentPassword = $val->test_input($_POST['currentPassword']);
        $newPassword = $val->test_input($_POST['newPassword']);
        $confirmPassword = $val->test_input($_POST['confirmPassword']);

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo '<script>alert("Please enter all details.");location.href = "../UI/UserProfile.php";</script>';
        } else if (!($val->comparePass($currentPassword, $_SESSION['result']->password))) {
            echo '<script>alert("Incorrect Password.");location.href = "../UI/UserProfile.php";</script>';
        } else if ($newPassword != $confirmPassword) {
            echo '<script>alert("Password not match.");location.href = "../UI/UserProfile.php";</script>';
        } else {
            if ($val->passwordIsValid($newPassword)) {
                $stu = new Student($_SESSION['result']->studID, $_SESSION['result']->username, $val->securePassword($newPassword), $_SESSION['result']->studEmail, $_SESSION['result']->uniStudID);
                $studa = new StudentDA();
                $studa->update($stu);
                $_SESSION['result'] = $stu;
                echo '<script>alert("Password Updated Successfully");location.href = "../UI/UserProfile.php";</script>';
            } else {
                echo '<script>alert("Password invalid format.");location.href = "../UI/UserProfile.php";</script>';
            }
        }
    } else {
        header("Location:../UI/HomePage.php");
    }
}

//Reset Password
if (isset($_POST['resetPassword'])) {
    if (isset($_SESSION['reset'])) {
        $val = new Validation();
        $newPassword = $val->test_input($_POST['newPassword']);
        $confirmPassword = $val->test_input($_POST['confirmPassword']);

        if (empty($newPassword) || empty($confirmPassword)) {
            echo '<script>alert("Please enter all details.");location.href = "../UI/ResetPassword.php";</script>';
        } else if ($newPassword != $confirmPassword) {
            echo '<script>alert("Password not match.");location.href = "../UI/ResetPassword.php";</script>';
        } else {
            if ($val->passwordIsValid($newPassword)) {
                $stu = new Student($_SESSION['reset']->studID, $_SESSION['reset']->username, $val->securePassword($newPassword), $_SESSION['reset']->studEmail, $_SESSION['reset']->uniStudID);
                $studa = new StudentDA();
                $studa->update($stu);
                unset($_SESSION['reset']);
                $_SESSION['role'] = 'student';
                echo '<script>alert("Password Reset Successfully");location.href = "../UI/Login.php";</script>';
            } else {
                echo '<script>alert("Password format invalid");location.href = "../UI/ResetPassword.php";</script>';
            }
        }
    } else {
        header("Location:../UI/HomePage.php");
    }
}

    



