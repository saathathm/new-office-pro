<?php
session_start();
if(!isset($_SESSION['emp_type']) OR $_SESSION['emp_type']==3){header("Location:login.php");}
require_once '../model/attendance.php';
require_once '../model/employee.php';
include 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
$obj=new attendance();
$obj1=new employee();
$result=$obj->checkLogoutTime1($_SESSION['emp_id']); //check employee who loggedout or not
$count=mysql_num_rows($result);
  if (isset($_REQUEST['f']) && $_REQUEST['f']=='1') {
    echo '<div class="alert alert-error">
      Time overlapping
        </div>';}
?>
<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
	<script src="assest/js/time_picker.js"></script>
        <link href="assest/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="assest/facebox/facebox.js" type="text/javascript"></script>
<script>
 function addNote($emp_id){
        $("#reason"+$emp_id).toggle();
         
        }
         $(document).ready(function(){
    $("[rel=tooltip]").tooltip({ placement: 'right'});
});
</script>

<div class="">
   
<table class="table table-hover rbborder">
<thead style="background-color:#000; color:#fff;" >     
            <th>Logout</th>
            <th>Logged out by</th>
            <th>Edited by</th>
            <th>Approved by</th>
            <th>In</th>
            <th>Out</th>
            <th>Note</th>
            <th>Approval</th>
            <th>Edit</th>
            <th>Option</th>
</thead>
       <?php 
       if(@$_REQUEST['date4']==""){
          @$_REQUEST['date4']=$date;
}
    
$employee_id=@$_REQUEST['employee_id'];
$result1=$obj->getAllAttendanceDetailByDay($employee_id,@$_REQUEST['date4']); 
while($value=mysql_fetch_assoc($result1)){
    $logout_by=$value['logout_by'] ;
    $edit_by=$value['edit_by'] ;
    $result2=$obj1->getEmployee($logout_by);
    $value2= mysql_fetch_assoc($result2);
    $result3=$obj1->getEmployee($edit_by);
    $value3= mysql_fetch_assoc($result3);
    
       ?>
        <?php if($value['logout_time']==0){?>
        <tr class="error">
            <td><?php if(isset($_SESSION['emp_type']) AND $_SESSION['emp_type']==1 OR $_SESSION['emp_type']==2) { ?>
            <a href="logout_user.php?employee_id=<?php echo $value['emp_id']; ?>&&id=<?php echo $value['id']; ?>" rel="facebox"><img src="images/exit.png" width="20" height="20"></a>
              <?php }  ?>
            </td>
            <td><?php echo $value2['name'];?></td>
            <td><?php echo $value3['name'];?></td>
            <td><?php echo $value['approved_by']; ?></td>
            <td><?php echo date("h:i a",strtotime($value['login_time'])); ?></td> 
            <td></td>
            <td><?php echo $value['login_note']; ?></td>
            <td><?php echo $value['status']; ?></td>
            <td><a href="update_attendance.php?id=<?php echo $value['id']; ?>&&employee_id=<?php echo $employee_id; ?>&&login_time=<?php echo $value['login_time']; ?>&&logout_time=<?php echo $value['logout_time']; ?>&&date=<?php echo $value['date']; ?>&&action=individual" rel="facebox"><img src="images/pencil.png" height="25" width="25"></a></td>
            
            <td><?php if(($value['status']=="pending" || $value['status']=="rejected")) { ?>
        <a href="../controller/approve_pending_attendance.php?id=<?php echo  $value['id']; ?>&&employee_id=<?php echo $employee_id; ?>&&date=<?php echo $value['date']; ?>&&action=individual">
            <img src="images/tick.png" height="18" width="18"/>
        </a>
   
    </a><?php } if($value['status']=="approved" && $value['login_note']!="") {?>
        <a href="../controller/reject_pending_attendance.php?id=<?php echo  $value['id']; ?>&&employee_id=<?php echo $employee_id; ?>&&date=<?php echo $value['date']; ?>&&action=individual">
            <img src="images/cross.png" height="18" width="18"/>
        </a><?php } ?>
    </td>
        </tr>
        <?php } else { ?>
     <tr>   
            <td><a href="logout_user.php?employee_id=<?php echo $value['emp_id']; ?>&&id=<?php echo $value['id']; ?>" rel="facebox"></a></td>
             <td><?php echo $value2['name'];?></td>
             <td><?php echo $value3['name'];?></td>
            <td><?php echo $value['approved_by']; ?></td>
            <td><?php echo date("h:i a",strtotime($value['login_time'])); ?></td> 
            <td><?php echo date("h:i a",strtotime($value['logout_time'])); ?></td>
            <td><?php echo $value['login_note']; ?></td>
            <td><?php echo $value['status']; ?></td>
            <td><a href="update_attendance.php?id=<?php echo $value['id']; ?>&&employee_id=<?php echo $employee_id; ?>&&login_time=<?php echo $value['login_time']; ?>&&logout_time=<?php echo $value['logout_time']; ?>&&date=<?php echo $value['date']; ?>&&action=individual" rel="facebox"><img src="images/pencil.png" height="25" width="25" rel="tooltip" title="click to edit In and Out time"></a></td>
            <td><?php if(($value['status']=="pending" || $value['status']=="rejected")) { ?>
        <a href="../controller/approve_pending_attendance.php?id=<?php echo  $value['id']; ?>&&employee_id=<?php echo $employee_id; ?>&&date=<?php echo $value['date']; ?>&&action=individual">
            <img src="images/tick.png" height="18" width="18" rel="tooltip" title="click to approve the note">
        </a><?php } if($value['status']=="approved" && $value['login_note']!="") {?>
  
   
        <a href="../controller/reject_pending_attendance.php?id=<?php echo  $value['id']; ?>&&employee_id=<?php echo $employee_id; ?>&&date=<?php echo $value['date']; ?>&&action=individual">
            <img src="images/cross.png" height="18" width="18" rel="tooltip" title="click to reject the note">
        </a><?php } ?>
    </td>
     </tr>
                 <?php } ?>
            <?php } ?>
    </table>
 </div>


