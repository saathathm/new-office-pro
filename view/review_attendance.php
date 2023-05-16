<?php
session_start();
if(!isset($_SESSION['emp_type']) OR $_SESSION['emp_type']==3){header("Location:login.php");}
require_once '../model/attendance.php';
include 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
$obj=new attendance();
if (isset($_REQUEST['f']) && $_REQUEST['f']=='1') {
    echo '<div class="alert alert-error">
    Note  time overlaped
        </div>';}
?>
<script>
     $(document).ready(function(){
     $("[rel=tooltip]").tooltip({ placement: 'right'});
});
</script>
<?php
if (@$_REQUEST['date3'] == "") {
    @$_REQUEST['date3'] = $date;
}
?>
<div class="">
    
        <table class="table">
            <thead style="background-color:#000; color:#fff;" >
                <td colspan="4">
                <form method="get" action="review_attendance.php">
                <input type="text" class="date" name="date3" value="<?php echo @$_REQUEST['date3']; ?>">
                <input type="submit"  name="submit" value="Show" class="btn btn-primary">
                </form>
                </td>
            </thead>
      </table>
   <table class="table table-hover rbborder">
   <thead style="background-color:#000; color:#fff;" >
            <th>ID</th>
            <th>Emp ID</th>
            <th>Name</th>
            <th>In</th>
            <th>Out</th>
            <th>Status</th>
            <th>Edit</th>
   </thead>
      <?php 
      $obj=new attendance();
      $result=$obj->reviewPendingAttendance($_REQUEST['date3']);
      while($value=mysql_fetch_assoc($result)){
//           if($_SESSION['emp_type']==1 && $value['emp_type']!=2) {continue;}  
      $id=$value['id'];
      $employee_id=$value['emp_id'];
          ?>
        <tr>
            <td><?php echo $value['id']; ?></td>
            <td><?php echo $value['emp_id']; ?></td>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo date("h:i a",strtotime($value['login_time'])); ?></td>
            <td><?php if($value['logout_time']!=0){ echo date("h:i a",strtotime($value['logout_time']));} else { echo "--:--"; } ?></td>
            <td><?php echo $value['status']; ?></td>
            <td><a href="update_attendance.php?id=<?php echo $id; ?>&&employee_id=<?php echo $employee_id; ?>&&login_time=<?php echo $value['login_time']; ?>&&logout_time=<?php echo $value['logout_time']; ?>&&date=<?php echo $value['date']; ?>&&action=all&&emp_type_in=<?php echo $value['emp_type']; ?>" rel="facebox"><img src="images/pencil.png" height="25" width="25" rel="tooltip" title="click to edit In and Out time"></a></td>
        </tr>
        <?php } ?>
    </table>
 </div>
 
<script>
$(function() {
		$(".date").datepicker({
			
			changeMonth: true,
                        changeYear:false,
			numberOfMonths: 1
			
		});
		
	});
//        $('#time1').timepicker();
</script>
