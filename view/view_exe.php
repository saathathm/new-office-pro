<div class="container">
    <table class="table rbborder">
        <tr>
            <th>Leave Type</th>
            <th>Applied Date</th>
            <th>Leave From</th>
            <th>Leave To</th>
            <th>No of days</th>
            <th>Status</th>
        </tr>
        <?php
        require_once '../model/leave.php';
        $obj = new leave();
        $emp_id = $_REQUEST['employee_id'];
        $leave_id = $_REQUEST['leave_id'];
        $result = $obj->getLeaveHistoryNew($emp_id);
        while ($value = mysql_fetch_assoc($result)) {
            $result_hours = $obj->getEmpTotalLeavesHours($value['id']);
            $total_hours=array();
            $leave_on=array();
            while ($value_hours = mysql_fetch_assoc($result_hours)) {
                $total_hours[] = $value_hours['total_hours'];
                $leave_on[] = $value_hours['leave_on'];
            }
            if ($leave_id != $value['leave_id']) {
                continue;
            }
            
            ?>
            <tr>
                <td><?php echo $value['leave_type']; ?></td>
                <td><?php echo $value['applied_date']; ?></td>
                <td><?php echo $leave_on[0]; ?></td>
                <td><?php
            if (count($leave_on) == 1) {
                echo $leave_on[0];
            } elseif (count($leave_on) > 1) {
                echo end($leave_on);
            }
            ?></td>
                 <td><?php if ($value['leave_id'] == 5) {
            echo array_sum($total_hours) . " Hours";
        } else {
            echo (array_sum($total_hours) / 8) . " Days";
        } ?></td>
                <th><?php
                if ($value['approval'] == 1) {
                    echo'<span class="label label-success">Approved</span>';
                } elseif ($value['approval'] == 2) {
                    echo'<span class="label label-important">Rejected</span>';
                } else {
                    echo'<span class="label label-info">' . "Pending" . '</span>';
                }
                ?>
                </th>

            </tr>
<?php } ?>
    </table>
</div>
