<?php
session_start();
if ($_SESSION['current'] != 'Society') {
    unset($_SESSION['current']);
    $_SESSION['role'] = 'society';
    header('location:Login.php');
}
require 'header.php';
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>

    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <title>Apply New Event</title>

    </head>

    <style>

        .container {
            border-radius: 20px;
            /*            background-color: #f2f2f2;*/
            margin: 0 auto;
            padding: 30px;
        }

    </style>

    <body>
        <div class="container">
            <?php
            if (isset($_SESSION['successMsg'])) {
                echo "<div class='alert alert-success'><strong>Success! </strong>" . $_SESSION['successMsg'] . '</div>';
                unset($_SESSION['successMsg']);
            }
            if (isset($_SESSION['errorMsg'])) {
                echo "<div class='alert alert-danger'><strong>Failed! </strong>" . $_SESSION['errorMsg'] . '</div>';
                unset($_SESSION['errorMsg']);
            }
            //File converted into base64 and stored in text file.
            $myfile = fopen("../applicationFormContent.txt", "r") or die("Unable to open file!");
            $content = fread($myfile, filesize("../applicationFormContent.txt"));
            fclose($myfile);
            ?>
            <h2>Apply New Event</h2>
            <p>Hi Event Organizer,</p>
            <p>Step 1
                <a title="Application Form" download="Application Form.docx" href="data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,<?php echo $content; ?>">Click here to download the application form</a>
            </p>
            <p>Step 2 Fill in the application form</p>
            <p>Step 3 Rename your file with your Event Title</p>
            <p>Step 4 Upload the application form in ".docx" or ".pdf" format</p>
            <form action="../Domain/CreateDocument.php" method="post" enctype="multipart/form-data">
                <div class="row justify-content-center">
                    <h3>Submit Here</h3>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="myfile">
                        <label class="custom-file-label" for="customFile">Choose file</label>     
                    </div>
                    <div class=”row”>
                        <div class=”col-xs-6 col-md-4”>       
                             <br><button class="btn btn-primary" type="submit" onclick="return confirm('Would you like to submit now?')" name="apply">Submit</button>
                            <a href='EventOrganizerHome.php' class='btn btn-danger'>Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>

    </body>
</html>


