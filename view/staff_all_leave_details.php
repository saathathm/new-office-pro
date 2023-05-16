<table class="table table-hover rbborder">
    <thead style="background-color:#000; color:#fff;" ><td colspan="10"><?php
if (isset($_REQUEST['employee_name'])) {
    echo $_REQUEST['employee_name'];
}
?> Leave History</td></thead>
<thead style="background-color:#000; color:#fff;" >
<th>ID</th>
<th>Leave Type</th>
<th>Applied Date</th>
<th>From</th>
<th>To</th>
<th>Total Hours</th>
<th>Reason</th>
<th>Rejected Reason</th>
<th>Approval</th>

</thead>
<?php
require_once '../model/leave.php';
$obj = new leave();
$result = $obj->getLeaveHistoryNew($_REQUEST['employee_id']);
while ($val = mysql_fetch_assoc($result)) {
    $result_hours = $obj->getEmpTotalLeavesHours($val['id']);

    while ($value_hours = mysql_fetch_assoc($result_hours)) {
        $total_hours[] = $value_hours['total_hours'];
        $leave_on[] = $value_hours['leave_on'];
    }
    ?> 
    <tr>
        <td><?php echo $val['id'] ?></td>
        <td><?php echo $val['leave_type'] ?></td>
        <td><?php echo $val['applied_date'] ?></td>
        <td><?php echo $leave_on[0]; ?></td>
        <td><?php
        if (count($leave_on) == 1) {
            echo $leave_on[0];
        } elseif (count($leave_on) > 1) {
            echo end($leave_on);
        }
    ?></td>
        <td><?php
        if ($val['leave_id'] == 5) {
            echo array_sum($total_hours) . " Hours";
        } else {
            echo (array_sum($total_hours) / 8) . " Days";
        }
    ?></td>
        <td><?php echo $val['reason'] ?></td>
        <td><?php echo $val['rejected_reason'] ?></td>
        <td><?php
        if ($val['approval'] == 1) {
            echo'<span class="label label-success">Approved</span>';
        } elseif ($val['approval'] == 2) {
            echo'<span class="label label-important">Rejected</span>';
        } else {
            echo'<span class="label label-info">' . "Pending" . '</span>';
        }
    ?>
        </td>

    </tr>
    <?php
    unset($total_hours);
    unset($leave_on);
}
?>
</table>       