<?php
@session_start();
if(isset($_SESSION['emp_type']) && ($_SESSION['emp_type'])!=1 && $_SESSION['emp_type']!=2 ){header("Location:login.php");}
include 'user.php';
 
if (isset($_REQUEST['f']) && $_REQUEST['f'] == '1') {
    echo '<div class="alert alert-error">
          Cannot handle your details.
          </div>';
}
?>
<div class="">
    <table class="table table-hover rbborder">
        <thead style="background-color:#000; color:#fff;" ><td colspan="8">Approval For Pending Attendance</td></thead>
        <thead style="background-color:#000; color:#fff;" >
            <th>Name</th>
            <th>In</th>
            <th>Out</th>
            <th>Date</th>
            <th>Note</th>
  <?php if(isset($_SESSION['emp_type']) AND $_SESSION['emp_type']==1 OR $_SESSION['emp_type']==2) { ?>       
            <th>Approve</th>
            <th>Reject</th>
  <?php } ?>
        </thead>
        <?php 
        require_once '../model/attendance.php';
        $obj=new attendance();
        $result=$obj->getPendingAttendanceDetail();   
        while($val=mysql_fetch_assoc($result)){
         
            ?> 
         <tr>
  
    <td><?php echo $val['name'] ?></td>
    <td><?php echo date("h:i a",strtotime($val['login_time'])); ?></td>
    <td><?php echo date("h:i a",strtotime($val['logout_time'])); ?></td>
    <td><?php echo $val['date'] ?></td>
    <td><?php echo $val['login_note'] ?></td>
    <?php if(isset($_SESSION['emp_type']) AND $_SESSION['emp_type']==1 OR $_SESSION['emp_type']==2) { ?>
    <td>
    <a href="../controller/approve_pending_attendance.php?id=<?php echo $val['id'] ?>&&action=all&&emp_type_in=<?php echo $val['emp_type']; ?>&&emp_id_in=<?php echo $val['emp_id']; ?>">
    <img src="images/tick.png" height="18" width="18"/>
    </a>
    </td>
    <td>
        <a href="../controller/reject_pending_attendance.php?id=<?php echo $val['id'] ?>&&action=all&&emp_type_in=<?php echo $val['emp_type']; ?>&&emp_id_in=<?php echo $val['emp_id']; ?>">
            <img src="images/cross.png" height="18" width="18"/>
        </a>
    </td>
    <?php } ?>
     </tr>
    <?php } ?>
    
   </table> 
</div>