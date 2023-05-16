<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}

require_once '../model/employee.php';
require_once '../model/attendance.php';
require_once '../model/leave.php';

include 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");

$obj1=new attendance();
$obj2=new employee();
$obj3=new leave();
 
?>
<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
	
<script>
// function addNote($emp_id){
//        $("#reason"+$emp_id).toggle();
//         
//        }
        window.setTimeout(function() {
    $(".alert-message").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
</script>


<div class="">
   <table class="table table-hover rbborder">
        <thead style="background-color:#000; color:#fff;" >
           <td colspan="5">
               <form method="get" action="view_attendance.php">
                    <input type="text" placeholder="Select date"class="date" name="date3" value="<?php echo @$_REQUEST['date3']; ?>">
                    <input type="submit"  name="submit" value="Show" class="btn btn-primary">
               </form>
           </td>
       </thead>
       <thead style="background-color:#000; color:#fff;" >
            <th>Name</th>
            <th>Status</th>
            <th>Last Login</th>
            <?php if(isset($_SESSION['emp_type']) AND $_SESSION['emp_type']==1 OR $_SESSION['emp_type']==2) { ?><th>Detail</th><?php } ?>
            <th>Approval</th>
       </thead>
       <?php 
      if(@$_REQUEST['date3']==""){
         @$_REQUEST['date3']=$date;}
         @$_REQUEST['date3'];
         $result1=$obj2->getAllEmployeeDetail(); //get all employee's details
         while($value=mysql_fetch_assoc($result1)){
         $emp_id=$value['emp_id'];
         $result=$obj1->getAttendanceSummary(@$_REQUEST['date3'],$emp_id); 
         $val=mysql_fetch_assoc($result);
         $count=  mysql_num_rows($result);
                        if($count==0){   //if count=0 employee's are not in office
         
                            $result2=$obj3->getLeaveDetail($emp_id,@$_REQUEST['date3']);  
                            $count2=  mysql_num_rows($result2);
                                            
                                            if($count2>0){
                                            $emp_status='<span class="label label-info">On Leave</span>';
                                                         }
                                                        else{$emp_status='<span class="label label-inverse">Drop Out</span>';
                                                        
                                                        }
                                     }
                                 else{
                                     if($val['logout_time']==0){
                                 $emp_status='<span class="label label-success">Logged In</span>';}
                                 else{$emp_status='<span class="label label-important">Logged Out</span>';}
                                     }
        $result3=$obj1->getspecificDatePendingAttendanceDetail(@$_REQUEST['date3'],$emp_id);
        $value3=mysql_fetch_assoc($result3);
        
       ?>
       <tr>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $emp_status; ?> </td>
            <td><?php if(isset($val['login_time'])){ echo date("h:i a",strtotime($val['login_time']));} else{echo "";} ?> </td>
            <?php if(isset($_SESSION['emp_type']) AND $_SESSION['emp_type']==1 OR $_SESSION['emp_type']==2) { ?>
            <td><a href="view_attendance_backup.php?employee_id=<?php echo $emp_id; ?>&date4=<?php echo $_REQUEST['date3']; ?>&employee_name=<?php echo $value['name'];  ?>"><img src="images/Button_go.png" width="25" height="25"></a></td>
            <?php } ?>
             <td><?php echo $value3['status']; ?></td>
       </tr>
        <?php } ?>
    </table>
 </div>
 
<script>
$(function() {
		$(".date").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        changeYear:false,
                        maxDate:0,
			numberOfMonths: 1
                                      });
		});
        $('#time1').timepicker();
</script>


