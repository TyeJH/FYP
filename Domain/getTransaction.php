<?php
include_once '../Domain/Validation.php';
include_once '../Domain/Society.php';
include_once '../Domain/Admin.php';
include_once '../Domain/Transaction.php';
include_once '../DataAccess/SocietyDA.php';
?>

<!--Data Table-->
<link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<?php
if (isset($_POST['socid'])) {
    $output = '';
    $val = new Validation();
    $id = $val->test_input($_POST['socid']);

    $society = new SocietyDA();
    $trans = $society->getTrans($id);
    $output .= '  
        <div class="table-responsive">  
            <table id="aTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Credit/Debit Amount (RM)</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>';
    if (!empty($trans)) {
        foreach ($trans as $his) {
            $output .= '
        <tr>
            <td width="27%">' . $his->transID . '</td>  
            <td width="30%">' . number_format($his->amount, 2) . '</td>  
            <td width="40%">' . $his->purpose . '</td>  
        </tr>';
        }
    }
    $output .= '</tbody></table></div>';
    echo $output;
}
?>
<script>
    $(document).ready(function () {
        $('#aTable').DataTable();
    });
</script>