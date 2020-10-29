<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';

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
                <form action="../Domain/updateAcc.php" method="POST">
                    <b>Admin Profile</b>
                    <a href="#" class="edit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </a>
                    <br>
                    <table>
                        <tr>
                            <th>Admin ID</th>
                            <td><input type="text" name="aID" value="<?= $admin->adminID ?>" readonly="" style="border:none;outline:none"></td>
                        </tr>
                        <tr>
                            <th>Admin Password</th>
                            <td><input type="text" name="password" class="pass" value="<?= $admin->password ?>" readonly="" style="border: none;outline:none"></td>
                        </tr>
                    </table>
                    <input type="submit" name="staffUpdate" value="Save" class="save" style="display: none"/>
                    <input type="reset" value="Cancel" class="cancel" style="display: none"/>
                </form>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.pass').removeAttr("readonly");
                        $('.pass').attr("style", "border:1px solid;outline:1px solid");
                        $('.pass').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                </script>
                <?php
            } else if ($_SESSION['current'] == "Society") {
                $society = $_SESSION['result'];
                ?>
                <form action="../Domain/updateAcc.php" method="POST">
                    <b>Society Profile</b>
                    <a href="#" class="edit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg></a>
                    <br>
                    <table>
                        <tr>
                            <th>Society ID</th>
                            <td><input type="text" name="sID" value="<?= $society->societyID ?>" readonly="" style="border:none;outline: none"></td>
                        </tr>
                        <tr>
                            <th>Society Name</th>
                            <td><input type="text" name="sName" class="name" value="<?= $society->societyName ?>" readonly="" style="border:none;outline:none"></td>
                        </tr>
                        <tr>
                            <th>Society Description</th>
                            <td><input type="text" name="sDesc" class="desc" value="<?= $society->societyDesc ?>" readonly="" style="border:none;outline:none"></td>
                        </tr>
                        <tr>
                            <th>Society Password</th>
                            <td><input type="text" name="sPass" class="pass" value="<?= $society->societyPass ?>" readonly="" style="border: none;outline: none"></td>
                        </tr>
                    </table>
                    <input type="submit" name="societyUpdate" value="Save" class="save" style="display: none"/>
                    <input type="reset" value="Cancel" class="cancel" style="display: none"/>
                </form>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.pass, .name, .desc').removeAttr("readonly");
                        $('.pass, .name, .desc').attr("style", "border:1px solid;outline:1px solid");
                        $('.name').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                </script>
                <?php
            } else if ($_SESSION['current'] == "Student") {
                $stud = $_SESSION['result'];
                ?>
                <form action="../Domain/updateAcc.php" method="POST">
                    <b>Student Profile</b>
                    <a href="#" class="edit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg></a>
                    <br>
                    <table>
                        <tr>
                            <th>User ID</th>
                            <td><input type="text" name="uID" value="<?= $stud->studID ?>" readonly="" style="border:none; outline: none"></td>
                        </tr>
                        <tr>
                            <th>User Password</th>
                            <td><input type="text" name="password" class="pass" value="<?= $stud->password ?>" readonly="" style="border: none; outline:none"></td>
                        </tr>
                        <tr>
                            <th>Student ID:</th>
                            <td><input type="text" name="studid" value="<?= $stud->uniStudID ?>" readonly="" style="border: none; outline:none"></td>
                        </tr>
                    </table>
                    <input type="submit" name="studentUpdate" value="Save" class="save" style="display: none"/>
                    <input type="reset" value="Cancel" class="cancel" style="display: none"/>
                </form>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.pass').removeAttr("readonly");
                        $('.pass').attr("style", "border:1px solid;outline:1px solid");
                        $('.pass').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                </script>
                <?php
            }
        } else {
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body>
</html>
