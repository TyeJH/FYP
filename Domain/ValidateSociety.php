<?php

include_once '../Domain/Validation.php';
include_once '../Domain/Society.php';
include_once '../DataAccess/SocietyDA.php';
include_once '../Domain/Admin.php';
include_once '../Domain/Transaction.php';

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

            if ($nul == 'Update') {
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
            $amt = $val->test_input($_POST['samt']);
            $pur = $val->test_input($_POST['spur']);
            $date = $val->test_input($_POST['sdate']);

            $nul = $_POST['societyid'];
            $dbDate = date('Y-m-d', strtotime($date));

            if ($nul == 'Update') {
                $socda = new SocietyDA();
                $tran = new Transaction($tid = "", $dbDate, $amt, $pur, $id);
                $acc = $acc + $amt;
                if ($acc < 0) {
                    $_SESSION['errmessage'] = 'Account Overlimit. Cannot withdraw';
                    echo '<script>location.href = "../UI/CreateSociety.php";</script>';
                } else {
                    $society = new Society($id, $name, $desc, $pass, $acc);
                    $socda->creditDebit($tran);
                    $socda->update($society);
                    $_SESSION['societymessage'] = 'Account Balance Updated';
                    echo '<script>location.href = "../UI/CreateSociety.php";</script>';
                }
            }
        }
    }
}

