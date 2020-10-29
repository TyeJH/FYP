<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Venue.php';
include_once '../DataAccess/VenueDA.php';
include_once '../Domain/Society.php';
session_start();
require 'header.php';
?>
<!DOCTYPE html>
<html> 
    <head>  
        <title>Venue Page</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    </head>  
    <body>
        <div id="bigcontainer">
            <br><br> 
            <a href="../UI/HomePage.php">Back</a>
            <div class="container" style="width:700px;">  
                <h3 align="center">Venue For Booking</h3>  
                <br>  
                <div class="table-responsive"> 
                    <!--Add Button-->
                    <div align="right">  
                        <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>  
                    </div>  
                    <br />
                    <!--Display All Venue List-->
                    <div id="venuetable">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo '<label class="text-success">' . $_SESSION['message'] . '</label>';
                            unset($_SESSION['message']);
                        }
                        ?>
                        <table class="table table-bordered">  
                            <tr>  
                                <th width="70%">Venue Name</th>  
                                <th width="15%">Edit</th>  
                                <th width="15%">View</th>  
                            </tr>
                            <?php
                            $venueda = new VenueDA();
                            $test = $venueda->getAll();
                            if (!empty($test)) {
                                foreach ($test as $venue) {
                                    ?>
                                    <tr>
                                        <td><?= $venue->venueName ?></td>
                                        <td><input type="button" name="edit" value="Edit" id="<?= $venue->venueID ?>" class="btn btn-info btn-xs edit_data" /></td>  
                                        <td><input type="button" name="view" value="View" id="<?= $venue->venueID ?>" class="btn btn-info btn-xs view_data" /></td>
                                        <?php
                                    }
                                }
                                ?>
                        </table>
                    </div> 
                </div>  
            </div>
        </div>

        <!--Display Venue Details-->
        <div id="dataModal" class="modal fade">  
            <div class="modal-dialog">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                        <h4 class="modal-title">Venue Details</h4>  
                    </div>  
                    <div class="modal-body" id="venuedetail">
                    </div>  
                    <div class="modal-footer">  
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                    </div>  
                </div>  
            </div>  
        </div>

        <!--Add Venue Details-->
        <div id="add_data_Modal" class="modal fade">  
            <div class="modal-dialog">  
                <div class="modal-content">  
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal">&times;</button>  
                        <h4 class="modal-title">Add Venue</h4>  
                    </div>  
                    <div class="modal-body">
                        <?php
                        $ven = new Venue();
                        $vID = $ven->generateRandomId();
                        ?>
                        <form method="POST" id="insert_form">  
                            <label>Venue ID</label>  
                            <input type="text" name="vid" id="vid" class="form-control" value="<?= $vID ?>" readonly=""/>  
                            <br />  
                            <label>Venue Name</label> 
                            <input type="text" name="vName" id="vname" class="form-control" placeholder="Enter Venue Name"><br>  
                            <br />  
                            <label>Venue Desc</label> 
                            <textarea name="vDesc" id="vdesc" class="form-control" placeholder="Enter Venue Description" style="resize: none;"></textarea> 
                            <br />
                            <input type="hidden" name="venueid" id="venueid"/>
                            <input type="submit" name="vSubmit" id="insert" value="Insert" class="btn btn-success" />  
                        </form>  
                    </div>  
                    <div class="modal-footer">  
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                    </div>  
                </div>  
            </div>  
        </div>  
        <script>
            $(document).ready(function () {
                //    Display Insert Form
                $('#add').click(function () {
                    $('#insert').val("Insert");
                    $('#insert_form')[0].reset();
                });

                //        Edit Venue Details
                $(document).on('click', '.edit_data', function () {
                    var venueid = $(this).attr("id");
                    $.ajax({
                        url: "../Domain/updateVenue.php",
                        method: "POST",
                        data: {venueid: venueid},
                        dataType: "json",
                        success: function (data) {
                            $('#vid').val(data.venueID);
                            $('#vname').val(data.venueName);
                            $('#vdesc').val(data.venueDesc);
                            $('#venueid').val(data.venueID);
                            $('#insert').val("Update");
                            $('#add_data_Modal').modal('show');
                        }
                    });
                });

                //        Submit Venue Details
                $('#insert_form').on("submit", function (event) {
                    event.preventDefault();
                    if ($('#vname').val() === "")
                    {
                        alert("Venue Name is required");
                    } else if ($('#vdesc').val() === '')
                    {
                        alert("Venue Description is required");
                    } else
                    {
                        $.ajax({
                            url: "../Domain/ValidateVenue.php",
                            method: "POST",
                            data: $('#insert_form').serialize(),
                            beforeSend: function () {
                                $('#insert').val("Inserting");
                            },
                            success: function (data) {
                                $('#insert_form')[0].reset();
                                $('#add_data_Modal').modal('hide');
                                $('#bigcontainer').html(data);
                            }
                        });
                    }
                });

                //        View Venue Details
                $(document).on('click', '.view_data', function () {
                    var venueid = $(this).attr("id");
                    if (venueid !== '')
                    {
                        $.ajax({
                            url: "../Domain/getVenue.php",
                            method: "POST",
                            data: {venueid: venueid},
                            success: function (data) {
                                $('#venuedetail').html(data);
                                $('#dataModal').modal('show');
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html> 


