<?php
include_once '../Domain/SessionManagement.php';
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Venue.php';
session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Create Venue</title>
    </head>
    <body>
        <h1>Create New Venue</h1>
        <?php
        $ven = new Venue();
        $vID = $ven->generateRandomId();
        ?>
        <form action="../Domain/ValidateVenue.php" method="POST">
            <label>Venue ID</label><input type="text" name="vid" value="<?= $vID?>" readonly=""><br>
            <label>Venue Name</label><input type="text" name="vName" placeholder="Enter Venue Name"><br>
            <label>Venue Desc</label><textarea name="vDesc" placeholder="Enter Venue Description" style="resize: none;"></textarea><br>
            <input type="submit" name="vSubmit" value="Submit"> <input type="reset" name="reset" value="Cancel">
        </form>
    </body>
</html>
