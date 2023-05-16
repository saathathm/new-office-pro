<?php
session_start();
//if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
//if(($_SESSION['emp_type']!=1) AND ($_SESSION['emp_type']!=2 )){header("Location:login.php");}
//$_SESSION['emp_type'];
include_once '../model/employee.php';
include_once 'user.php';
include_once '../model/attendance.php';
include_once '../model/leave.php';
include_once '../model/new_leave.php';
include_once 'leave_balance.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
$current_year = date('Y');
$obj1=new attendance();
$obj2=new employee();
$obj3=new leave();
?>
<script>
$('body').on('hidden', '.modal', function () {
  $(this).removeData('modal');
});
</script>
<div class="container">
<table class="table rbborder">
      <tr style="background-color:#000; color:#fff;" >
            <th>Name</th>
            <th colspan="2" style="background-color: #F89406;">Casual(entitlement/leave taken)</th>
            <th colspan="2" style="background-color: #3A87AD;">Medical(entitlement/leave taken)</th>
            <th colspan="2" style="background-color: #468847;">Annual(entitlement/leave taken)</th>
            <th>Detail</th>
	<th>Total Remaining Leave</th>
       </tr>
       <?php 
        $result_leave_type=$obj3->getLeave();
        while($value=  mysqli_fetch_array($result_leave_type)){$value_leave_id[]=$value['leave_id'];} 
        $where_in = implode(',', $value_leave_id); 
        $result2=$obj2->getAllEmployeeDetail(); //get all active employee's details
        while($value=($result2)->fetch_assoc()){
         $emp_id=$value['emp_id'];  
        $staff_name=$value['name'];
       // $result5=$obj3->getLeaveDetailNew($emp_id);
        $rrr=  levae_balance_for_detail($emp_id,$where_in,$current_year);      
       // $rrr[$emp_id][]=$value5['total_hours'];
        $annual=0; $casual=0; $medical=0; $short_leave=0;
       foreach ($rrr[1] as $array_value) {
          if($array_value[0]==1){$annual=$array_value[1];} 
           if($array_value[0]==2){$casual=$array_value[1];} 
            if($array_value[0]==3){$medical=$array_value[1];} 
             if($array_value[0]==5){$short_leave=$array_value[1];} 
       }
 ?>
       <tr>
        
           <td><?php echo $value['name'];  ?></td>
            <td style="background-color: #F89406;" ><?php echo $rrr[0][1];  ?></td>
            <td><?php  echo $annual/8;  ?></td>
            <td style="background-color: #3A87AD;"><?php echo $rrr[0][2];  ?></td>
            <td><?php  echo $casual/8; ?></td>
            <td style="background-color: #468847;"><?php echo $rrr[0][3]; ?></td>
            <td><?php echo $medical/8?></td>
           <!-- <td><?php echo $rrr[0][5]. "/"; echo $short_leave ?></td> -->
            <td><a data-toggle="modal" href="test_modal.php?id=<?php echo $emp_id ?>" data-target="#myModal">Click me</a>
            <td><?php echo ($rrr[0][1]+$rrr[0][2]+$rrr[0][3])-($annual/8+$casual/8+$medical/8) ?></td>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal title</h4>
        </div>
          <div class="modal-body">
              
          </div>
            <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</td>
       </tr>
        <?php   } ?>
    </table>
 </div>
  
  



