<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';
include_once '../DataAccess/StudentDA.php';
session_start();
require 'header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['current'])) {
            if ($_SESSION['current'] == "Admin") {
                $admin = $_SESSION['result'];
                ?>
                <div class="container">
                    <br>
                    <p style="text-align: center; font-size: 30px; font-weight: bold;">Admin Profile</p>
                    <table class='table table-hover table-bordered'>
                        <tr>
                            <th>Admin ID</th>
                            <td><input type="text" name="aID" value="<?= $admin->adminID ?>" readonly="" style="border:none;outline:none"></td>
                        </tr>
                        <tr>
                            <th>Admin Password</th>
                            <td><input type="password" name="password" class="pass" value="<?= $admin->password ?>" readonly="" style="border: none;outline:none"></td>
                        </tr>
                    </table>
                    <button onclick="show()" class="btn btn-info">Change Password</button>
                </div>
                <?php
            } else if ($_SESSION['current'] == "Society") {
                $society = $_SESSION['result'];
                ?>
                <div class="container">
                    <form action="../Domain/updateAcc.php" method="POST">
                        <b style="font-size: 30px;">Society Profile</b>
                        <a href="#" class="edit">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        <br>
                        <table  class='table table-hover table-bordered'>
                            <tr>
                                <th>Society ID</th>
                                <td><input type="text" name="sID" value="<?= $society->societyID ?>" readonly="" style="border:none;outline: none;width: 100%;"></td>
                            </tr>
                            <tr>
                                <th>Society Name</th>
                                <td><input type="text" name="sName" class="name" value="<?= $society->societyName ?>" readonly="" style="border:none;outline:none;width: 100%;"></td>
                            </tr>
                            <tr>
                                <th>Society Description</th>
                                <td><textarea name="sDesc" class="desc" readonly="" style="border:none;outline:none;resize: none; width: 100%;"><?= $society->societyDesc ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Society Account</th>
                                <td><input type="text" name="sAcc" class="acc" value="<?= $society->societyAcc ?>" readonly="" style="border:none;outline:none;width: 100%;"></td>
                            </tr>
                            <tr>
                                <th>Society Password</th>
                                <td><input type="password" name="sPass" class="pass" value="<?= $society->societyPass ?>" readonly="" style="border: none;outline: none"></td>
                            </tr>
                        </table>
                        <input type="submit" name="societyUpdate" value="Save" class="save btn btn-success" style="display: none"/>
                        <input type="reset" value="Cancel" class="cancel btn btn-danger" style="display: none"/> 
                    </form>
                    <button onclick="show()" class="btn btn-info">Change Password</button>
                </div>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.name, .desc').removeAttr("readonly");
                        $('.name, .desc').attr("style", "border:1px solid;outline:1px solid");
                        $('.name').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.name, .desc').attr("style", "border:none;outline:none");
                        $('.name, .desc').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.name, .desc').attr("style", "border:none;outline:none");
                        $('.name, .desc').attr("readonly", "readonly");
                    });
                </script>
                <?php
            } else if ($_SESSION['current'] == "Student") {
                $stud = $_SESSION['result'];
                ?>
                <div class="container">
                    <form action="../Domain/updateAcc.php" method="POST">
                        <b style="font-size: 30px;">Student Profile</b>
                        <a href="#" class="edit">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                            unset($_SESSION['error']);
                        }
                        $studda=new StudentDA();
                        $fname=$studda->retrieveStudentDetails($stud->studID);
                        ?>
                        <table class='table table-hover table-bordered'>
                            <tr>
                                <th>Username</th>
                                <td><input type="text" name="uname" class="uname" value="<?= $stud->username ?>" readonly="" style="border:none; outline: none"></td>
                            </tr>
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text" name="fname" class="fname" value="<?= $fname['studName'] ?>" readonly="" style="border:none; outline: none"></td>
                            </tr>
                            <tr>
                                <th>User Email</th>
                                <td><input type="email" name="email" class="email" value="<?= $stud->studEmail ?>" readonly="" style="border: none; outline:none"></td>
                            </tr>
                            <tr>
                                <th>User Password</th>
                                <td><input type="password" name="password" class="pass" value="<?= $stud->password ?>" readonly="" style="border: none; outline:none"></td>
                            </tr>
                            <tr>
                                <th>Student ID:</th>
                                <td><input type="text" name="studid" value="<?= $stud->uniStudID ?>" readonly="" style="border: none; outline:none"></td>
                            </tr>                         
                        </table>
                        <input type="hidden" name="uID" value="<?= $stud->studID ?>"/>
                        <input type="submit" name="studentUpdate" value="Save" class="save btn btn-success" style="display: none"/>
                        <input type="reset" value="Cancel" class="cancel btn btn-danger" style="display: none"/>
                    </form>
                    <button onclick="show()" class="btn btn-info">Change Password</button>
                </div>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.uname, .email').removeAttr("readonly");
                        $('.uname, .email').attr("style", "border:1px solid;outline:1px solid");
                        $('.uname').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.uname, .email').attr("style", "border:none;outline:none");
                        $('.uname, .email').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.uname, .email').attr("style", "border:none;outline:none");
                        $('.uname, .email').attr("readonly", "readonly");
                    });
                </script>
                <?php
            }
        } else {
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>
        <div id="chgpass" style="display: none;">
            <?php
            include_once '../UI/ChangePassword.php';
            ?>
        </div>
        <script>
            function show() {
                var x = document.getElementById("chgpass");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>
    </body>
</html>
