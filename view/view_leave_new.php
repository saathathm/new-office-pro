<?php
session_start();
if(isset($_SESSION['emp_type']) && ($_SESSION['emp_type'])!=1 && $_SESSION['emp_type']!=2 ) {
    header("Location:login.php");
}
include 'user.php';
//include_once 'leave_balance.php';
if (isset($_REQUEST['f']) && $_REQUEST['f'] == '1') {
    echo '<div class="alert alert-error">
          <button type="button" class="close" data-dismiss="alert">x</button>
      Cannot handle your details.
        </div>';
}
if (isset($_REQUEST['s']) && $_REQUEST['s'] == '1') {
    echo '<div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">x</button>
      Leave request has been approved successfully.
        </div>';
}
if (isset($_REQUEST['s']) && $_REQUEST['s'] == '2') {
    echo '<div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">x</button>
      Leave request has been rejected successfully.
        </div>';
}
?>
<script>
    function getreason($id){
        $("#reason"+$id).toggle();
      
    }
</script>
<table class="table table-hover rbborder" style="font-size:13Px" height="100px" width="100px" overflow: scroll>
    <thead style="background-color:#000; color:#fff;" >
    <td colspan="12">Approval For Leave Request</td></thead>
<thead style="background-color:#000; color:#fff;">
<th></th>
<th>Name</th>
<th>Leave Type</th>
<th>Applied Date</th>
<th>Leave From</th>
<th>Leave To</th>
<th>Total Duration</th>
<th>Reason</th>
<th>Rejected Reason</th>
<th>Leave Approval</th>
<th>Option</th>
</thead>
<?php
require_once '../model/new_leave.php';
$obj = new newLeave();
$result = $obj->getEmpLeavesforApprove();
while ($val = mysql_fetch_assoc($result)) {

    $empid = $val['emp_id'];
    $leave_id = $val['leave_id'];
    $result_hours = $obj->getEmpTotalLeavesHours($val['id']);

    while ($value_hours = mysql_fetch_assoc($result_hours)) {
        $total_hours[] = $value_hours['total_hours'];
        $leave_on[] = $value_hours['leave_on'];
    }
    ?> 
    <tr>
        <td><?php echo $val['id']; ?></td>         
        <td><?php echo $val['name']; ?></td>
        <td><?php echo $val['leave_type']; ?></td>
        <td style="background-color: #FFFF99;"><?php echo $val['applied_date']; ?></td>
        <td style="background-color: #99FF99;"><?php echo $leave_on[0]; ?></td>
        <td style="background-color: #99FF99;"><?php
    if (count($leave_on) == 1) {
        echo $leave_on[0];
    } elseif (count($leave_on) > 1) {
        echo end($leave_on);
    }
    ?></td>
        <td><?php
    if ($leave_id == 5) {
        echo array_sum($total_hours) . " Hours";
    } else {
        echo (array_sum($total_hours) / 8) . " Days";
    }
    ?></td>
        <td><?php echo $val['reason']; ?></td>
        <td><?php echo $val['rejected_reason']; ?></td>
        <td><?php
        if ($val['approval'] == 1) {
            echo'<span class="label label-success">Approved</span>';
        } elseif ($val['approval'] == 2) {
            echo'<span class="label label-important">Rejected</span>';
        } else {
            echo'<span class="label label-info">' . "New" . '</span>';
        }
        ?>
        </td>
        <td>

            <a href="../controller/approve_leave_new.php?app_id=<?php echo $val['id'] ?>&&emp_type_in=<?php echo $val['emp_id']; ?>">
                <img src="images/tick.png" height="18" width="18" rel="tooltip" title="click to approve the leave request"/>
            </a>

            <img src="images/cross.png" height="18" width="18" onclick="getreason(<?php echo $val['id'] ?>)"  rel="tooltip" title="click to reject the leave request"/>
            <form style="display:none" method="POST" id="reason<?php echo $val['id'] ?>" action="../controller/reject_leave_new.php">
                <textarea  name="reason" rows="2" cols="20"></textarea>
                <input type="hidden" name="app_id" value="<?php echo $val['id'] ?>"/>
                <input type="hidden" name="emp_type_in" value="<?php echo $val['emp_id'] ?>"/>
                <input type="submit" value="Reject" class="btn btn-primary">
            </form>

        </td>
    </tr>
    <?php
    unset($total_hours);
    unset($leave_on);
}
?>
</table> 
