<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Venue.php';
include_once '../Domain/Announcement.php';
include_once '../DataAccess/VenueDA.php';
include_once '../DataAccess/AnnounceDA.php';
include_once '../Domain/Society.php';
session_start();
require '../UI/header.php';
?>
<!DOCTYPE html>

<html>
    <head>  
        <title>Announcement Page</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />  

        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  
    </head>
    <body>
        <?php
        if (isset($_SESSION['current'])) {
            if ($_SESSION['current'] == "Admin") {
                ?>
                <div id="bigcontainer">
                    <div class="container" style="width:700px;">  
                        <h3 align="center"><b>Announcement</b></h3>  
                        <br>  
                        <div> 
                            <!--Add Announcement Button-->
                            <div align="right">  
                                <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-success">Add</button>  
                            </div>  
                            <br />
                            <!--Display All Announcement List-->
                            <div id="anntable">
                                <?php
                                if (isset($_SESSION['annmessage'])) {
                                    echo '<label class="text-success">' . $_SESSION['annmessage'] . '</label>';
                                    unset($_SESSION['annmessage']);
                                }
                                ?>
                                <table id="aTable" class="table table-bordered">  
                                    <thead>
                                        <tr>  
                                            <th width="70%">Announcement Title</th>  
                                            <th width="10%">Edit</th>  
                                            <th width="10%">View</th>
                                            <th width="10%">Delete</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $annda = new AnnounceDA();
                                        $test = $annda->getAllByAdmin($_SESSION['result']->adminID);
                                        if (!empty($test)) {
                                            foreach ($test as $ann) {
                                                ?>
                                                <tr>
                                                    <td><?= $ann->annTitle ?></td>
                                                    <td><input type="button" name="edit" value="Edit" id="<?= $ann->annID ?>" class="btn btn-warning btn-xs edit_data" /></td>  
                                                    <td><input type="button" name="view" value="View" id="<?= $ann->annID ?>" class="btn btn-info btn-xs view_data" /></td>
                                                    <td><input type="button" name="delete" value="Delete" id="<?= $ann->annID ?>" class="btn btn-danger btn-xs delete_data" /></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>  
                    </div>
                </div>

                <!--Display Announcement Details-->
                <div id="dataModal" class="modal fade">  
                    <div class="modal-dialog">  
                        <div class="modal-content">  
                            <div class="modal-header">  
                                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                <h4 class="modal-title">Announcement Details</h4>  
                            </div>  
                            <div class="modal-body" id="anndetail">
                            </div>  
                            <div class="modal-footer">  
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                            </div>  
                        </div>  
                    </div>  
                </div>

                <!--Add Announcement Details-->
                <div id="add_data_Modal" class="modal fade">  
                    <div class="modal-dialog">  
                        <div class="modal-content">  
                            <div class="modal-header">  
                                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                <h4 class="modal-title">Announcement Details</h4>  
                            </div>  
                            <div class="modal-body">
                                <?php
                                $anno = new Announcement();
                                $aID = $anno->generateRandomId();
                                date_default_timezone_set("Asia/Kuala_Lumpur");
                                $annDate = date('d-M-Y');
                                ?>
                                <form method="POST" id="insert_form">  

                                    <input type="hidden" name="aid" id="aid" class="form-control" value="<?= $aID ?>" readonly=""/>  
                                    <br>  
                                    <label>Announcement Title</label> 
                                    <input type="text" name="atitle" id="atitle" class="form-control" placeholder="Enter Announcement Title"><br>  
                                    <br>  
                                    <label>Announcement Details</label> 
                                    <textarea name="acontent" id="acontent" class="form-control" placeholder="Enter Announcement Details" style="resize: none;"></textarea> 
                                    <br>
                                    <label>Announcement Date:</label>
                                    <input type="text" name="adate" id="adate" class="form-control" value="<?= $annDate ?>" readonly=""><br>
                                    <br>
                                    <label>Announcement Author:</label>
                                    <input type="text" name="aauthor" id="aauthor" class="form-control" value="<?= $_SESSION['result']->adminID ?>" readonly=""><br>
                                    <br>
                                    <input type="hidden" name="announceid" id="announceid"/>
                                    <input type="submit" name="aSubmit" id="insert" value="Insert" class="btn btn-success" />  
                                </form>  
                            </div>  
                            <div class="modal-footer">  
                                <button type="button" class="btn btn-default" id="close" data-dismiss="modal" >Close</button>  
                            </div>  
                        </div>  
                    </div>  
                </div>
                <script src=" https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" type="text/javascript"></script>
                <script>
                    $(document).ready(function () {
                        $('#aTable').DataTable();

                        //    Display Insert Form
                        $('#add').click(function () {
                            $('#insert').val("Insert");
                            $('#insert_form')[0].reset();
                        });

                        //        Refresh Page after close modal
                        $('#close').click(function () {
                            location.reload();
                        });
                                
                        //        Edit Announcement Details
                        $(document).on('click', '.edit_data', function () {
                            var annid = $(this).attr("id");
                            $.ajax({
                                url: "../Domain/updateAnn.php",
                                method: "POST",
                                data: {annid: annid},
                                dataType: "json",
                                success: function (data) {
                                    var str = moment(data.annDate).format(" DD-MMM-yyyy");
                                    $('#aid').val(data.annID);
                                    $('#atitle').val(data.annTitle);
                                    $('#acontent').val(data.annContent);
                                    $('#adate').val(str);
                                    $('#aauthor').val(data.adminID);
                                    $('#announceid').val("Update");
                                    $('#insert').val("Update");
                                    $('#add_data_Modal').modal('show');
                                }
                            });
                        });

                        //        Delete Announcement Details
                        $(document).on('click', '.delete_data', function () {
                            var annid = $(this).attr("id");
                            $.ajax({
                                url: "../Domain/updateAnn.php",
                                method: "POST",
                                data: {annid: annid},
                                dataType: "json",
                                success: function (data) {
                                    var str = moment(data.annDate).format(" DD-MMM-yyyy");
                                    $('#aid').val(data.annID);
                                    $('#atitle').val(data.annTitle);
                                    $('#acontent').val(data.annContent);
                                    $('#adate').val(str);
                                    $('#aauthor').val(data.adminID);
                                    $('#aid, #atitle, #acontent, #adate, #aauthor').attr("readonly", "readonly");
                                    $('#announceid').val("Delete");
                                    $('#insert').val("Delete");
                                    $('#insert').attr("class", "btn btn-danger");
                                    $('#add_data_Modal').modal('show');
                                }
                            });
                        });

                        //        Submit Announcement Details
                        $('#insert_form').on("submit", function (event) {
                            event.preventDefault();
                            if ($('#atitle').val() === "")
                            {
                                alert("Announcement Title is required");
                            } else if ($('#acontent').val() === '')
                            {
                                alert("Announcement Details is required");
                            } else if ($('#adate').val() === '')
                            {
                                alert("Announcement Date is required");
                            } else if ($('#aauthor').val() === '')
                            {
                                alert("Announcement Author is required");
                            } else
                            {
                                $.ajax({
                                    url: "../Domain/ValidateAnn.php",
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

                        //        View Announcement Details
                        $(document).on('click', '.view_data', function () {
                            var annid = $(this).attr("id");
                            if (annid !== '')
                            {
                                $.ajax({
                                    url: "../Domain/getAnn.php",
                                    method: "POST",
                                    data: {annid: annid},
                                    success: function (data) {
                                        $('#anndetail').html(data);
                                        $('#dataModal').modal('show');
                                    }
                                });
                            }
                        });
                    });
                </script>
                <?php
            } else if ($_SESSION['current'] == "Society") {
                ?>
                <div id="bigcontainer">
                    <br><br>
                    <div class="container" style="width:700px;">  
                        <h3 align="center">Announcement</h3>  
                        <br>  
                        <div > 
                            <br />
                            <!--Display All Announcement List-->
                            <div id="anntable">
                                <table id="aTable" class="table table-bordered">  
                                    <thead>
                                        <tr>  
                                            <th width="55%">Announcement Title</th>  
                                            <th width="30%">Announcement Date</th>
                                            <th width="10%">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $annda = new AnnounceDA();
                                        $test = $annda->getAll();
                                        if (!empty($test)) {
                                            foreach ($test as $ann) {
                                                $date = date("d-M-Y", strtotime($ann->annDate));
                                                ?>
                                                <tr>
                                                    <td><?= $ann->annTitle ?></td>
                                                    <td><?= $date ?></td>
                                                    <td><input type="button" name="view" value="View" id="<?= $ann->annID ?>" class="btn btn-info btn-xs view_data" /></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>  
                    </div>
                </div>

                <!--Display Announcement Details-->
                <div id="dataModal" class="modal fade">  
                    <div class="modal-dialog">  
                        <div class="modal-content">  
                            <div class="modal-header">  
                                <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                <h4 class="modal-title">Announcement Details</h4>  
                            </div>  
                            <div class="modal-body" id="anndetail">
                            </div>  
                            <div class="modal-footer">  
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                            </div>  
                        </div>  
                    </div>  
                </div>
                <script>
                    $(document).ready(function () {
                        $('#aTable').DataTable();
                        //        View Announcement Details
                        $(document).on('click', '.view_data', function () {
                            var annid = $(this).attr("id");
                            if (annid !== '')
                            {
                                $.ajax({
                                    url: "../Domain/getAnn.php",
                                    method: "POST",
                                    data: {annid: annid},
                                    success: function (data) {
                                        $('#anndetail').html(data);
                                        $('#dataModal').modal('show');
                                    }
                                });
                            }
                        });
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
