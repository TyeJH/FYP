<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';
include_once '../Domain/Transaction.php';
session_start();
require 'header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Event History</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
        <!--Data Table-->
        <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

        <!--Display Modal-->
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js' type='text/javascript'></script>

    </head>
    <body>
        <?php
        if (isset($_SESSION['current'])) {
            if ($_SESSION['current'] == "Society") {
                $society = $_SESSION['result'];
                ?>
                <div class="container">
                    <br>
                    <h1 style="text-align: center;font-size: 50px;">Account History</h1>
                    <hr>
                    <br>
                    <?php
                    $a = new SocietyDA();
                    $b = $a->getTrans($society->societyID);
                    ?>
                    <table id="acchistory" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="25%">Transaction ID</th>
                                <th width="25%">Transaction Date</th>
                                <th width="24%">Credit/Debit Amount (RM)</th>
                                <th width="40%">Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($b)) {
                                foreach ($b as $history) {
                                    $date = date('d-M-Y', strtotime($history->transDate));
                                    echo"<tr>";
                                    echo "<td>" . $history->transID . "</td>";
                                    echo "<td>" . $date . "</td>";
                                    echo "<td>" . $history->amount . "</td>";
                                    echo "<td>" . $history->purpose . "</td>";
                                    echo"</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <!--Add Feedback Details-->
                    <a onClick='openGenerateReportForm()'  class='btn btn-info m-r-1em'>Generate Report</a>
                    <script>
                        function openGenerateReportForm() {
                            $('#generateReport_modal').modal('show');
                        }
                        function closeGenerateReportForm() {
                            $('#generateReport_modal').modal('close');
                        }
                        function filter() {
                            if (document.generateAccHistoryForm.type.value == 'All') {
                                document.generateAccHistoryForm.startDate.disabled = true;
                                document.generateAccHistoryForm.endDate.disabled = true;
                                document.generateAccHistoryForm.startDate.value = '';
                                document.generateAccHistoryForm.endDate.value = '';
                            } else {
                                document.generateAccHistoryForm.startDate.disabled = false;
                                document.generateAccHistoryForm.endDate.disabled = false;
                            }
                        }
                        function verifySubmit() {
                            if (document.generateAccHistoryForm.type.value == 'customDate') {
                                if (document.generateAccHistoryForm.startDate.value == '') {
                                    alert('Please select starting date.');
                                    return false;
                                }
                                if (document.generateAccHistoryForm.endDate.value == '') {
                                    alert('Please select ending date.');
                                    return false;
                                }

                            }
                        }
                        $(document).ready(function () {
                            $('#acchistory').DataTable();
                        });
                    </script>

                    <div id="generateReport_modal" class="modal fade">  
                        <div class="modal-dialog">  
                            <div class="modal-content">  
                                <div class="modal-header">  
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>  
                                    <h4 class="modal-title">Generate Report</h4>  
                                </div>  
                                <div class="modal-body">
                                    <form method="POST" id="generateReport_id" target='_blank' name='generateAccHistoryForm' onSubmit='return verifySubmit()'action="../Domain/GenerateSocietyAccountHistoryReport.php"> 
                                        <table>
                                            <tr>
                                                <td>
                                                    Please select
                                                    <br>
                                                </td>
                                                <td>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Type:
                                                </td>
                                                <td>
                                                    All <input onclick='filter()'type="radio" id="all" name="type" value="All" checked>
                                                    Custom Date<input onclick='filter()'type="radio" id="customDate" name="type" value="customDate">
                                                </td>
                                            </tr>
                                            <tr>

                                                <td>
                                                    Start Date:
                                                </td>
                                                <td>
                                                    <input type="date" id="startDate" onChange='setEndDateMin(this.value)' value="<?= $schedule->startDate ?>" name="startDate" disabled/>
                                                    <script type="text/javascript">
                                                        function setEndDateMin(value) {
                                                            var endDate = document.getElementById('endDate');
                                                            endDate.min = value;
                                                        }
                                                        //startDate.min = new Date().toISOString().split("T")[0];
                                                    </script>
                                                </td>
                                            </tr>
                                            <tr>   
                                                <td>
                                                    End Date:
                                                </td>
                                                <td>
                                                    <input type="date" id="endDate" onChange='setStartDateMax(this.value)' value="<?= $schedule->endDate ?>" name="endDate" disabled />
                                                    <script type="text/javascript">
                                                        function setStartDateMax(value) {
                                                            var startDate = document.getElementById('startDate');
                                                            startDate.max = value;
                                                        }
                                                        //endDate.min = new Date().toISOString().split("T")[0];
                                                    </script>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>    
                                                    <br>
                                                    <input type="submit" class="btn btn-info" value="Generate" name="societyGenerateAccHistoryReport" id="societyGenerateAccHistoryReport"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>  
                                </div>  
                                <div class="modal-footer">  
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                                </div>  
                            </div>  
                        </div>  
                    </div>


                </div>
                <?php
            }
        } else {
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>

    </body>
</html>

