<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include 'user.php';
?>
<script>
     $(document).ready(function(){
     $("[rel=tooltip]").tooltip({ placement:'right'});
});
</script>
<table class="table table-hover rbborder">
    <thead style="background-color:#000; color:#fff;" ><td colspan="9">My Leave History</td></thead>
   <thead style="background-color:#000; color:#fff;" >
         <th>Leave Type</th>
         <th>Applied Date</th>
         <th>From</th>
         <th>To</th>
         <th>Total Hours</th>
         <th>Reason</th>
         <th>Rejected Reason</th>
         <th>Approval</th>
         <th>Withdraw</th>
   </thead>
   <?php 
        require_once '../model/leave.php';
        $obj=new leave();
        $result=$obj->getLeaveHistory($_SESSION['emp_id']);   
        while($val=mysql_fetch_assoc($result)){
   ?> 
    <tr>
   
    <td><?php echo $val['leave_type'] ?></td>
    <td><?php echo $val['applied_date'] ?></td>
    <td><?php echo $val['leave_from'] ?></td>
    <td><?php echo $val['leave_to'] ?></td>
<td><?php echo $val['total_hours'] ?></td>

    <td><?php echo $val['reason'] ?></td>
    <td><?php echo $val['rejected_reason'] ?></td>
    <td><?php if($val['approval']=="approved"){ echo'<span class="label label-success">'.$val['approval'].'</span>';} 
            elseif($val['approval']=="rejected"){echo'<span class="label label-important">'.$val['approval'].'</span>';}
            else{echo'<span class="label label-info">'."pending".'</span>';}
            ?>
    </td>
    <td><?php if($val['approval']==''){ ?><a href="../controller/withdraw_leave.php?app_id=<?php echo $val['app_id']; ?>" rel="tooltip" title="click to cancel the leave request"><span class="label label-inverse">Withdraw</span></a><?php } ?></td>
    </tr>
         <?php } ?>
</table>       