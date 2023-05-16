<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
require_once '../model/leave.php';
if($_SESSION['emp_type']==1){
include_once 'admin.php';}
else{include_once 'user.php';}
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
$obj=new leave();
?>
<div class="">
   <table class="table rbborder" style="font-size:13px" >
<tr style="background-color:#000; color:#fff;" >
            <th>Leave Type</th>
            <th>Applied Date</th>
            <th>Leave From</th>
            <th>Leave To</th>
            <th>No of days</th>
            <th>Status</th>
</tr>
       <?php 
        $emp_id=$_REQUEST['employee_id'];
        $result=$obj->getLeaveHistory($emp_id); 
        while($value=mysql_fetch_assoc($result)){
       ?>
       <tr>
            <td><?php echo $value['leave_type']; ?></td>
            <td><?php echo $value['applied_date']; ?></td>
            <td><?php echo $value['leave_from']; ?></td>
            <td><?php echo $value['leave_to']; ?></td>
            <td><?php echo $value['total_hours']/8; ?></td>
            <td><?php if($value['approval']=="approved"){ echo'<span class="label label-success">'.$value['approval'].'</span>';} 
            elseif($value['approval']=="rejected"){echo'<span class="label label-important">'.$value['approval'].'</span>';}
            else{echo'<span class="label label-info">'."pending".'</span>';}
            ?>
            </td>
            
       </tr>
       <?php } ?>
    </table>
</div>
 



