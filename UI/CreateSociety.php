<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
include_once '../Domain/Venue.php';
include_once '../DataAccess/SocietyDA.php';
include_once '../Domain/Society.php';
session_start();
require 'header.php';
?>
<!DOCTYPE html>
<html> 
    <head>  
        <title>Society Page</title>  
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
                if ($_SESSION['result']->adminID == 'DSA') {
                    ?>
                    <div id="bigcontainer">
                        <br><br>
                        <div class="container" style="width:700px;">  
                            <h3 align="center"><b>Society</b></h3>  
                            <br>  
                            <div> 
                                <!--Add Button-->
                                <div align="right">  
                                    <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-success">Add</button>  
                                </div>  
                                <br />
                                <!--Display All Society List-->
                                <div id="societytable">
                                    <?php
                                    if (isset($_SESSION['societymessage'])) {
                                        echo '<label class="text-success">' . $_SESSION['societymessage'] . '</label>';
                                        unset($_SESSION['societymessage']);
                                    }
                                    ?>
                                    <table id="sTable" class="table table-bordered">  
                                        <thead>
                                            <tr>  
                                                <th width="70%">Society Name</th>  
                                                <th width="15%">Edit</th>  
                                                <th width="15%">View</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $societyda = new SocietyDA();
                                            $test = $societyda->getAll();
                                            if (!empty($test)) {
                                                foreach ($test as $society) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $society->societyName ?></td>
                                                        <td><input type="button" name="edit" value="Edit" id="<?= $society->societyID ?>" class="btn btn-warning btn-xs edit_data" /></td>  
                                                        <td><input type="button" name="view" value="View" id="<?= $society->societyID ?>" class="btn btn-info btn-xs view_data" /></td>
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

                    <!--Display Society Details-->
                    <div id="dataModal" class="modal fade">  
                        <div class="modal-dialog">  
                            <div class="modal-content">  
                                <div class="modal-header">  
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                    <h4 class="modal-title">Society Details</h4>  
                                </div>  
                                <div class="modal-body" id="societydetail">
                                </div>  
                                <div class="modal-footer">  
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                                </div>  
                            </div>  
                        </div>  
                    </div>

                    <!--Add/Edit Society Details-->
                    <div id="add_data_Modal" class="modal fade">  
                        <div class="modal-dialog">  
                            <div class="modal-content">  
                                <div class="modal-header">  
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                    <h4 class="modal-title">Society Details</h4>  
                                </div>  
                                <div class="modal-body">
                                    <?php
                                    $soc = new Society();
                                    $sID = $soc->generateRandomId();
                                    ?>
                                    <form method="POST" id="insert_form">  
                                        <label>Society ID</label>  
                                        <input type="text" name="sid" id="sid" class="form-control" value="<?= $sID ?>" readonly=""/>  
                                        <br />  
                                        <label>Society Name</label> 
                                        <input type="text" name="sname" id="sname" class="form-control" placeholder="Enter Society Name">
                                        <br />  
                                        <label>Society Desc</label> 
                                        <textarea name="sdesc" id="sdesc" class="form-control" placeholder="Enter Society Description" style="resize: none;"></textarea> 
                                        <input type="hidden" name="sacc" id="sacc" class="form-control" value="0.00"></textarea> 
                                        <br />
                                        <label>Society Password</label> 
                                        <input type="password" name="spass" id="spass" class="form-control" placeholder="Enter Society Password" style="resize: none;"></textarea> 
                                        <br />
                                        <input type="hidden" name="societyid" id="societyid"/>
                                        <input type="submit" name="sSubmit" id="insert" value="Insert" class="btn btn-success" />  
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
                            $('#sTable').DataTable();
                            //    Display Insert Form
                            $('#add').click(function () {
                                $('#insert').val("Insert");
                                $('#insert_form')[0].reset();
                            });

                            //        Edit Society Details
                            $(document).on('click', '.edit_data', function () {
                                var socid = $(this).attr("id");
                                $.ajax({
                                    url: "../Domain/updateSociety.php",
                                    method: "POST",
                                    data: {socid: socid},
                                    dataType: "json",
                                    success: function (data) {
                                        $('#sid').val(data.societyID);
                                        $('#sname').val(data.societyName);
                                        $('#sdesc').val(data.societyDesc);
                                        var acc = Number.parseFloat(data.societyAcc);
                                        $('#sacc').val(acc.toFixed(2));
                                        $('#spass').val(data.societyPass);
                                        $('#societyid').val('Update');
                                        $('#insert').val("Update");
                                        $('#add_data_Modal').modal('show');
                                    }
                                });
                            });

                            //        Submit Society Details
                            $('#insert_form').on("submit", function (event) {
                                event.preventDefault();
                                if ($('#sname').val() === "")
                                {
                                    alert("Society Name is required");
                                } else if ($('#sdesc').val() === '')
                                {
                                    alert("Society Description is required");
                                } else if ($('#spass').val() === '')
                                {
                                    alert("Society Password is required");

                                } else
                                {
                                    $.ajax({
                                        url: "../Domain/ValidateSociety.php",
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

                            //        View Society Details
                            $(document).on('click', '.view_data', function () {
                                var socid = $(this).attr("id");
                                if (socid !== '')
                                {
                                    $.ajax({
                                        url: "../Domain/getSociety.php",
                                        method: "POST",
                                        data: {socid: socid},
                                        success: function (data) {
                                            $('#societydetail').html(data);
                                            $('#dataModal').modal('show');
                                        }
                                    });
                                }
                            });
                        });
                    </script>
                    <?php
                } else {
                    ?>
                    <div id="bigcontainer">
                        <br><br>
                        <div class="container" style="width:700px;">  
                            <h3 align="center"><b>Society</b></h3>  
                            <br>  
                            <div>  
                                <br />
                                <!--Display All Society List-->
                                <div id="societytable">
                                    <?php
                                    if (isset($_SESSION['societymessage'])) {
                                        echo '<label class="text-success">' . $_SESSION['societymessage'] . '</label>';
                                        unset($_SESSION['societymessage']);
                                    }
                                    if (isset($_SESSION['errmessage'])) {
                                        echo '<label class="text-danger">' . $_SESSION['errmessage'] . '</label>';
                                        unset($_SESSION['errmessage']);
                                    }
                                    ?>
                                    <table id="sTable" class="table table-bordered">  
                                        <thead>
                                            <tr>  
                                                <th width="70%">Society Name</th>
                                                <th width="15%">Transaction History</th>
                                                <th width="15%">Edit</th>  
                                                <th width="15%">View</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $societyda = new SocietyDA();
                                            $test = $societyda->getAll();
                                            if (!empty($test)) {
                                                foreach ($test as $society) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $society->societyName ?></td>
                                                        <td><input type="button" name="trans" value="History" id="<?= $society->societyID ?>" class="btn btn-info btn-xs trans_data" /></td>  
                                                        <td><input type="button" name="edit" value="Edit" id="<?= $society->societyID ?>" class="btn btn-warning btn-xs edit_data" /></td>
                                                        <td><input type="button" name="view" value="View" id="<?= $society->societyID ?>" class="btn btn-info btn-xs view_data" /></td>
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

                    <!--Display Society Details-->
                    <div id="dataModal" class="modal fade">  
                        <div class="modal-dialog">  
                            <div class="modal-content">  
                                <div class="modal-header">  
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                    <h4 class="modal-title">Society Details</h4>  
                                </div>  
                                <div class="modal-body" id="societydetail">
                                </div>  
                                <div class="modal-footer">  
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                                </div>  
                            </div>  
                        </div>  
                    </div>
                    
                    <!--Display Account History-->
                    <div id="dataModal1" class="modal fade">  
                        <div class="modal-dialog">  
                            <div class="modal-content">  
                                <div class="modal-header">  
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                    <h4 class="modal-title">Account History</h4>  
                                </div>  
                                <div class="modal-body" id="accHistory">
                                </div>  
                                <div class="modal-footer">  
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                                </div>  
                            </div>  
                        </div>  
                    </div>

                    <!--Add/Edit Society Details-->
                    <div id="add_data_Modal" class="modal fade">  
                        <div class="modal-dialog">  
                            <div class="modal-content">  
                                <div class="modal-header">  
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                    <h4 class="modal-title">Society Details</h4>  
                                </div>  
                                <div class="modal-body">
                                    <form method="POST" id="insert_form">  
                                        <label>Society ID</label>  
                                        <input type="text" name="sid" id="sid" class="form-control" value="<?= $sID ?>" readonly=""/>  
                                        <br />  
                                        <label>Society Name</label> 
                                        <input type="text" name="sname" id="sname" class="form-control" readonly="">
                                        <input type="hidden" name="sdesc" id="sdesc" class="form-control">
                                        <br />  
                                        <label>Society Account</label>
                                        <input type="text" name="sacc" id="sacc" class="form-control" readonly=""> 
                                        <input type="hidden" name="spass" id="spass" class="form-control">
                                        <br />
                                        <label>Credit/Debit</label>  
                                        <input type="text" name="samt" id="samt" class="form-control" placeholder="Enter amount (RM)"/>  
                                        <br /> 
                                        <label>Purpose</label>  
                                        <input type="text" name="spur" id="spur" class="form-control" placeholder="Enter purpose"/>  
                                        <br /> 
                                        <input type="hidden" name="societyid" id="societyid"/>
                                        <input type="submit" name="sSubmit" id="insert" value="Insert" class="btn btn-success" />  
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
                            $('#sTable').DataTable();
                           
                            //Edit Society Details
                            $(document).on('click', '.edit_data', function () {
                                var socid = $(this).attr("id");
                                $.ajax({
                                    url: "../Domain/updateSociety.php",
                                    method: "POST",
                                    data: {socid: socid},
                                    dataType: "json",
                                    success: function (data) {
                                        $('#sid').val(data.societyID);
                                        $('#sname').val(data.societyName);
                                        $('#sdesc').val(data.societyDesc);
                                        var acc = Number.parseFloat(data.societyAcc);
                                        $('#sacc').val(acc.toFixed(2));
                                        $('#spass').val(data.societyPass);
                                        $('#societyid').val('Update');
                                        $('#insert').val("Update");
                                        $('#add_data_Modal').modal('show');
                                    }
                                });
                            });

                            //Submit Society Details
                            $('#insert_form').on("submit", function (event) {
                                event.preventDefault();
                                var validate = /^[+-]?\d+(\.\d{2})?$/;
                                if ($('#samt').val() === '')
                                {
                                    alert("Credit or Debit Amount is required");
                                } else if (!validate.test($('#samt').val()))
                                {
                                    alert("Credit or Debit Amount can only contains number");
                                } else if ($('#spur').val() === '')
                                {
                                    alert("Purpose cannot leave it empty");
                                } else
                                {
                                    $.ajax({
                                        url: "../Domain/ValidateSociety.php",
                                        method: "POST",
                                        data: $('#insert_form').serialize(),
                                        beforeSend: function () {
                                            $('#insert').val("Updating");
                                        },
                                        success: function (data) {
                                            $('#insert_form')[0].reset();
                                            $('#add_data_Modal').modal('hide');
                                            $('#bigcontainer').html(data);
                                        }
                                    });
                                }
                            });

                            //        View Society Details
                            $(document).on('click', '.view_data', function () {
                                var socid = $(this).attr("id");
                                if (socid !== '')
                                {
                                    $.ajax({
                                        url: "../Domain/getSociety.php",
                                        method: "POST",
                                        data: {socid: socid},
                                        success: function (data) {
                                            $('#societydetail').html(data);
                                            $('#dataModal').modal('show');
                                        }
                                    });
                                }
                            });
                            
                            //        View Society Details
                            $(document).on('click', '.trans_data', function () {
                                var socid = $(this).attr("id");
                                if (socid !== '')
                                {
                                    $.ajax({
                                        url: "../Domain/getTransaction.php",
                                        method: "POST",
                                        data: {socid: socid},
                                        success: function (data) {
                                            $('#accHistory').html(data);
                                            $('#dataModal1').modal('show');
                                        }
                                    });
                                }
                            });
                        });
                    </script>
                    <?php
                }
            }
        } else {
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body>
</html> 


