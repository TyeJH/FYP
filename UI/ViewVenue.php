<?php
include_once '../Domain/SessionManagement.php';
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Venue.php';
include_once '../DataAccess/VenueDA.php';
session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>View Venue</title>
    </head>
    <body>
        <h1>View Venue</h1>
        <form action="" method="POST">
            <table border="1px solid">
                <tr>
                    <th>Venue ID</th>
                    <th>Venue Name</th>
                    <th>Venue Description</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                $ven = new VenueDA();
                $test = $ven->getAll();
                foreach ($test as $venue) {
                    ?>
                    <tr>
                        <td><input type="text" name="venueID" class="id" value="<?= $venue->venueID ?>" readonly="" style="border:none; outline: none"></td>
                        <td><input type="text" name="venueName" class="name" value="<?= $venue->venueName ?>" readonly="" style="border:none; outline: none"></td>
                        <td><input type="text" name="venueDesc" class="desc" value="<?= $venue->venueDesc ?>" readonly="" style="border:none; outline: none"></td>
                        <td>
                            <a href="#" class="edit">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </a>
                            <input type="submit" name="venueUpdate" value="Save" class="saveUpdate" style="display: none"/>
                            <input type="reset" value="Cancel" class="cancelUpdate" style="display: none"/>
                        </td>
                        <td>
                            <a href="#" class="delete">
                                <svg width='1em' height'1em' viewBox='0 0 16 16' class='bi bi-trash-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/>
                                </svg>
                            </a>
                            <input type="submit" name="venueDelete" value="Save" class="saveDelete" style="display: none"/>
                            <input type="reset" value="Cancel" class="cancelDelete" style="display: none"/>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </form>
        <script>
            $('.edit').click(function () {
                $(this).siblings('.saveUpdate, .cancelDelete').show();
                $('.name,.desc').removeAttr("readonly");
                $('.name,.desc').attr("style", "border:1px solid;outline:1px solid");
                $('.name,.desc').focus();
            });
            $('.cancelUpdate').click(function () {
                $(this).siblings('.save').hide();
                $(this).hide();
                $('.name,.desc').attr("style", "border:none;outline:none");
                $('.name,.desc').attr("readonly", "readonly");
            });
            $('.saveUpdate').click(function () {
                $(this).siblings('.cancel').hide();
                $(this).hide();
                $('.name,.desc').attr("style", "border:none;outline:none");
                $('.name,.desc').attr("readonly", "readonly");
            });
        </script>
    </body>
</html>
