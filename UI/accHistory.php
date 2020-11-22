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
                    <br>
                    <form style="height:20px;" method="POST" target="_blank" action="../Domain/GenerateSocietyAccountHistoryReport.php">
                        <input type="submit" class="btn btn-info" value="Print" name="print" id="print" style="margin-left: 95%;"/>
                        <input type='hidden' name='printid' id='printid' value='<?= $society->societyID ?>'/>
                    </form>
                </div>
                <script>
                    $(document).ready(function () {
                        $('#acchistory').DataTable();
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
