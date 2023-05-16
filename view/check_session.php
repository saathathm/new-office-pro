<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
if($_SESSION['emp_type']==1){
include_once 'admin.php';}
else{include_once 'user.php';}
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
$time = date("H:i:s");
?>
<script>
 function getreason($app_id){
        $("#reason"+$app_id).toggle();
                            }
</script>
<div class="container">
        <table class="table rbborder">
            <h4>Working Hours Reports On <?php echo $date ?></h4>
     <tr>
          <th>in</th>
          <th>out</th>
          th>note</th>
          <th>by</th>
          <th>status</th>
           <th>date</th>
           <th>diff</th>
     </tr>
<?php 
        require_once '../model/attendance.php';
        $obj=new attendance();
        $result=$obj->getAllDetail();   
        while($val=mysql_fetch_assoc($result)){
?> 
   <tr>
        <td><?php echo $val['login_time'] ?></td>
          <td><?php echo $val['logout_time'] ?></td>
           <td><?php echo $val['login_note'] ?></td>
            <td><?php echo $val['logout_by'] ?></td>
            <td><?php echo $val['status'] ?></td>
            <td><?php echo $val['date'] ?></td>
            <td><?php echo gmdate("d:H:i", $val['diff']) ?></td>
   </tr>
<?php } ?>
    
              </table>     
      
</div>
        