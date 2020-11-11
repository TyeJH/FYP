<?php

include_once '../Domain/Validation.php';
include_once '../Domain/Society.php';
include_once '../DataAccess/SocietyDA.php';
include_once '../Domain/Admin.php';

session_start();

if (!empty($_POST)) {
    if (isset($_SESSION['result'])) {
        if ($_SESSION['result']->adminID == 'DSA') {
            $val = new Validation();
            
            $id = $val->test_input($_POST['sid']);
            $name = $val->test_input($_POST['sname']);
            $desc = $val->test_input($_POST['sdesc']);
            $pass = $val->test_input($_POST['spass']);
            $acc = $val->test_input($_POST['sacc']);
            $nul = $_POST['societyid'];
            
            $socda = new SocietyDA();

            if ($nul != '') {
                $dbpass = $socda->login($id);
                if ($pass == $dbpass->societyPass) {
                    $society = new Society($id, $name, $desc, $pass, $acc);
                    $socda->update($society);
                    $_SESSION['societymessage'] = 'Society Updated';
                    echo '<script>location.href = "../UI/CreateSociety.php";</script>';
                } else {
                    $society = new Society($id, $name, $desc, $val->securePassword($pass), $acc);
                    $socda->update($society);
                    $_SESSION['societymessage'] = 'Society Updated';
                    echo '<script>location.href = "../UI/CreateSociety.php";</script>';
                }
            } else {
                $soc = new Society($id, $name, $desc, $val->securePassword($pass), $acc);
                $socda->regsiter($soc);
                $_SESSION['societymessage'] = 'Society Created';
                echo '<script>location.href = "../UI/CreateSociety.php";</script>';
            }
        } else {
            $val = new Validation();
            $id = $val->test_input($_POST['sid']);
            $name = $val->test_input($_POST['sname']);
            $desc = $val->test_input($_POST['sdesc']);
            $pass = $val->test_input($_POST['spass']);
            $acc = $val->test_input($_POST['sacc']);
            $nul = $_POST['societyid'];

            if ($nul != '') {
                $society = new Society($id, $name, $desc, $pass, $acc);
                $socda = new SocietyDA();
                $socda->update($society);
                $_SESSION['societymessage'] = 'Account Balance Updated';
                echo '<script>location.href = "../UI/CreateSociety.php";</script>';
            }
        }
    }
}

