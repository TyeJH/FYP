<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        session_unset();
        session_destroy();
        echo '<script>alert("Logout Successfully.");location.href = "../UI/HomePage.php";</script>';
        ?>
    </body>
</html>
