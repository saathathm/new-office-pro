<?php
session_start();
if(isset($_SESSION['emp_type']) && ($_SESSION['emp_type'])!=1 && $_SESSION['emp_type']!=2 ){header("Location:login.php");}
include 'user.php';
//include_once 'leave_balance.php';
if (isset($_REQUEST['f']) && $_REQUEST['f']=='1') {
    echo '<div class="alert alert-error">
          <button type="button" class="close" data-dismiss="alert">x</button>
      Cannot handle your details.
        </div>';}
        if (isset($_REQUEST['s']) && $_REQUEST['s']=='1') {
    echo '<div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">x</button>
      Leave request has been approved successfully.
        </div>';}
         if (isset($_REQUEST['s']) && $_REQUEST['s']=='2') {
    echo '<div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert">x</button>
      Leave request has been rejected successfully.
        </div>';}
?>
<script>
 function getreason($app_id){
        $("#reason"+$app_id).toggle();
        
        }
	</script>
        
<table class="table table-hover rbborder" style="font-size:13Px">
    <thead style="background-color:#000; color:#fff;" >
        <td colspan="12">Approval For Leave Request</td></thead>
    <thead style="background-color:#000; color:#fff;" >
<th></th>
                  <th>Name</th>
         <th>Leave Type</th>
         <th>Applied Date</th>
         <th>Leave From</th>
         <th>Leave To</th>
         <th>Total Hours</th>
         <th>Reason</th>
         <th>Rejected Reason</th>
         <th>Leave Approval</th>
        <!-- <th>Leave Balance</th>-->
         <th>Option</th>
    </thead>
 <?php 
        require_once '../model/leave.php';
        $obj=new leave();
        $result=$obj->getEmpLeavesforApprove();   
        while($val=mysql_fetch_assoc($result)){
       // if($val['approval']=="approved"){$val['total_hours']=0;}
        //$result2=leave_balance($val['emp_id'],$val['total_hours'],$val['leave_id']);
        if($_SESSION['emp_type']===1 && $val['emp_type']!=2) {continue;}  
        $empid=$val['emp_id'];
        $leave_id=$val['leave_id'];
          ?> 
         <tr>
     <td><?php echo $val['app_id']; ?></td>
        
    <td><?php echo $val['name']; ?></td>
    <td><?php echo $val['leave_type']; ?></td>
    <td style="background-color: #FFFF99;"><?php echo $val['applied_date']; ?></td>
    <td style="background-color: #D8EBFF;"><?php echo $val['leave_from']; ?></td>
    <td style="background-color: #D8EBFF;"><?php echo $val['leave_to']; ?></td>
    <td><?php echo $val['total_hours']; ?></td>
    <td><?php echo $val['reason']; ?></td>
    <td><?php echo $val['rejected_reason']; ?></td>
    <td><?php if($val['approval']=="approved"){ echo'<span class="label label-success">'.$val['approval'].'</span>';} 
            elseif($val['approval']=="rejected"){echo'<span class="label label-important">'.$val['approval'].'</span>';}
            else{echo'<span class="label label-info">'."new".'</span>';}
            ?>
            </td>
    
   <!-- <td>
     <?php if($result2>56 && ($val['approval']=="" || $val['approval']=="rejected")){echo '<a href="view_exe.php?employee_id='.$empid.'&&leave_id='.$leave_id.'" rel="facebox"><span class="label label-important">exceeded</span></a>';} ?>
    </td>-->
    
    <td>
        <?php if($val['approval']=="rejected" || $val['approval']=="" ) {?>
        <a href="../controller/approve_leave.php?app_id=<?php echo $val['app_id'] ?>&&emp_type_in=<?php echo $val['emp_id']; ?>">
        <img src="images/tick.png" height="18" width="18" rel="tooltip" title="click to approve the leave request"/>
        </a>
        <?php } else{ ?>
        <img src="images/cross.png" height="18" width="18" onclick="getreason(<?php echo $val['app_id'] ?>)"  rel="tooltip" title="click to reject the leave request"/>
        <form style="display:none" method="POST" id="reason<?php echo $val['app_id'] ?>" action="../controller/reject_leave.php">
        <textarea  name="reason" rows="2" cols="20"></textarea>
        <input type="hidden" name="app_id" value="<?php echo $val['app_id'] ?>"/>
        <input type="hidden" name="emp_type_in" value="<?php echo $val['emp_id'] ?>"/>
        <input type="submit" value="Reject" class="btn btn-primary">
        </form>
     <?php } ?>
    </td>
         </tr>
         <?php } ?>
                </table> 
 