
<?php
include_once '../Domain/SessionManagement.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $session = new SessionManagement();
        $session::sessionStarted();

        if ($session::sessionExists('current')) {
            $session::sessionClosed();
        }

        echo '<script>alert("Logout Successfully.");location.href = "../UI/HomePage.php";</script>';
        ?>
    </body>
</html>
