<?php
//include_once '../Domain/Admin.php';
//include_once '../Domain/Society.php';
//include_once '../Domain/Student.php';
//session_start();
//require 'header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Change password</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  

    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Change password</h1>
            </div>
            <p><span>1) Passwords must contain:</span></p>
            <ul>
                <li><span>a minimum of 1 alphabet and</span></li>
                <li><span>a minimum of 1 numeric character [0-9] and</span></li>
                <li><span>a minimum of 1 special character (symbol)</span></li>
                <li><span>Passwords must be at least 8 characters in length.</span></li>
            </ul>
            <form action="../Domain/updateAcc.php" name="changePasswordForm" id="changePasswordForm" method="POST" onSubmit="return verifySubmit(this)">
                <table>
                    <tr>
                        <td>
                            Current Password:
                        </td>
                        <td>
                            <input type="password" name="currentPassword" placeholder="Current Password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            New Password:
                        </td>
                        <td>
                            <input type="password" name="newPassword" id="newPassword" placeholder="New Password" maxlength="25" onKeyUp="StrengthPassword2(this.value)" onClick="verifyPwd(this)">
                            <div style="float:right;padding:2px ;"><div id="PswColor2" style=" background-color:#FFC000; border:1px solid #c5c5c5; width:200px; padding:1px; height:25px; text-align:center" valign="center">Password Strength Level</div>                
                    </tr>
                    <tr>
                        <td>
                            Confirm Password:
                        </td>
                        <td>
                            <input type="password" name="confirmPassword" placeholder="Confirm Password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td style="height: 50px;">
                            <button type="submit" class="btn btn-success" name="updatePassword">Save</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>

    <script>
        function verifySubmit() {
            if (document.changePasswordForm.currentPassword.value == '') {
                alert('Please fill in the current password.');
                return false;
            }
            if (document.changePasswordForm.newPassword.value == '' || document.changePasswordForm.confirmPassword.value == '') {
                alert('Please fill in the new password.');
                return false;
            }
            if (document.changePasswordForm.newPassword.value != document.changePasswordForm.confirmPassword.value) {
                alert('The password is not match.');
                return false;
            }
            if (document.changePasswordForm.currentPassword.value == document.changePasswordForm.newPassword.value) {
                alert('New password cannot same as current.');
                return false;
            }
        }
        function StrengthPassword2(passwd)
        {
            var intScore = 0
            var strVerdict = "weak"
            var oldPassword = document.changePasswordForm.currentPassword.value;

            var BadPassword = new Array("asdfg1234", "2222222222222222", "8888888888888888", "aaaaa11111", "asdf1234", "abcd1111", "abcd2222", "1111111111111111", "11111111111111111", "111111111111111111", "1111111111111111111", "11111111111111111111", "1111111111111111111111111", "aaaa1111", "1111aaaa", "abc12345", "abc12346", "abcd1234", "abcd12345", "abcd123456", "abcde123", "abcde1234", "abcdef12", "abcde12345", "abcdef123456", "12345abc", "1234abcd", "123abcde", "123abcdef", "1234abcde", "12345abcdef");
            var DisableSubmit = true;
            // PASSWORD LENGTH
            /*	if (passwd.length<5)                         // length 4 or less
             {
             intScore = (intScore+3)
             }
             else if (passwd.length>4 && passwd.length<8) // length between 5 and 7
             {
             intScore = (intScore+6)
             }
             else if (passwd.length>7 && passwd.length<16)// length between 8 and 15
             {
             intScore = (intScore+12)
             }
             else if (passwd.length>15)                    // length 16 or more
             {
             intScore = (intScore+18)
             }
             */

            // PASSWORD LENGTH
            if (passwd.length < 8) {                       // length 4 or less
                intScore = 0;
            } else if (passwd.length > 7 && passwd.length < 16) { // length between 8 and 15
                intScore = (intScore + 12);
            } else if (passwd.length > 15) {                   // length 16 or more
                intScore = (intScore + 12);
            }


            // LETTERS (Not exactly implemented as dictacted above because of my limited understanding of Regex)
            if (passwd.match(/[a-z]/))                              // [verified] at least one lower case letter
            {
                intScore = (intScore + 1);
            }

            if (passwd.match(/[A-Z]/))                              // [verified] at least one upper case letter
            {
                intScore = (intScore + 1);
            }

            // NUMBERS
            if (passwd.match(/\d+/))                                 // [verified] at least one number
            {
                intScore = (intScore + 5);
            }

            /*if (passwd.match(/(.*[0-9].*[0-9].*[0-9])/))             // [verified] at least three numbers
             {
             intScore = (intScore+5)
             }*/

            // SPECIAL CHAR
            if (passwd.match(/.[~`!@#$%^&*()_\-+={\[}\]\\|;:'",<.>\/?]/))            // [verified] at least one special character
            {
                intScore = (intScore + 5);
            }

            // [verified] at least two special characters
            if (passwd.match(/(.*[~`!@#$%^&*()_\-+={\[}\]\\|;:'",<.>\/?].*[~`!@#$%^&*()_\-+={\[}\]\\|;:'",<.>\/?])/))
            {
                intScore = (intScore + 5);
            }

            // COMBOS
            if (passwd.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))        // [verified] both upper and lower case
            {
                intScore = (intScore + 2);
            }

            if (passwd.match(/([a-zA-Z])/) && passwd.match(/([0-9])/)) // [verified] both letters and numbers
            {
                intScore = (intScore + 2);
            }

            // [verified] letters, numbers, and special characters
            if (passwd.match(/([a-zA-Z0-9].*[~`!@#$%^&*()_\-+={\[}\]\\|;:'",<.>\/?])|([~`!@#$%^&*()_\-+={\[}\]\\|;:'",<.>\/?].*[a-zA-Z0-9])/))
            {
                intScore = (intScore + 2);
            }

            if (intScore < 16)
            {
                document.getElementById("PswColor2").style.backgroundColor = "#FFC000";
                strVerdict = "Very weak";
            } else if (intScore > 15 && intScore < 25)
            {
                strVerdict = "Weak";
                document.getElementById("PswColor2").style.backgroundColor = "#FFDE00";
            } else if (intScore > 24 && intScore < 35)
            {
                strVerdict = "Mediocre";
                document.getElementById("PswColor2").style.backgroundColor = "#D8FF00";
            } else if (intScore > 34 && intScore < 45)
            {
                strVerdict = "Strong";
                document.getElementById("PswColor2").style.backgroundColor = "#4EFF00";
            } else
            {
                strVerdict = "Stronger";
                document.getElementById("PswColor2").style.backgroundColor = "#00FFD8";

            }
            if (intScore > 24 && passwd.length > 7)
                DisableSubmit = false;

            for (i = 0; i < BadPassword.length; i++) {
                if (BadPassword[i] == document.changePasswordForm.newPassword.value.toLowerCase()) {
                    strVerdict = "Weak";
                    document.getElementById("PswColor2").style.backgroundColor = "#FFDE00";
                    DisableSubmit = true;
                }
            }
            if (oldPassword == document.changePasswordForm.newPassword.value) {
                strVerdict = "Same password detected!";
                document.getElementById("PswColor2").style.backgroundColor = "#FFDE00";
                DisableSubmit = true;
            }
            document.changePasswordForm.updatePassword.disabled = DisableSubmit;
            document.getElementById("PswColor2").innerHTML = strVerdict;
        }
    </script>
</html>
