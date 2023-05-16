<?php 
 $emp_id=$_REQUEST['emp_id']; 
 include_once '../model/employee.php'; 
 include_once '../model/leave.php'; 

$obj=new employee();
$obj1=new leave();
$result=$obj->getEmployee($emp_id);

echo $count_indi_leave= mysql_num_rows($result2=$obj1->getIndividualLeave($emp_id));
$value=  mysql_fetch_assoc($result);
if($count_indi_leave>0){
 $result1=$obj1->getIndividualLeave($emp_id);   
}
else{
    $result1=$obj1->getLeave();
}
?>
<div class="container-fluid">
<div class="row-fluid">
   
     <div class="span12 rbborder">
        <form method="post" action="../controller/update_leave.php">
        <table class="table well">
            <thead style="background-color:#000; color:#fff;"><th>Annual</th><th>Casual</th><th>Medical</th><th>Short</th></thead>
        <?php 
        if($count_indi_leave>0){
              $row = array();
        while($row[]= mysql_fetch_assoc($result1)); print_r($row); ?>
       
        <td><input type="text" name="annual"  value="<?php   echo $row[0]['annual']; ?>"></td>
        <td><input type="text" name="casual"  value="<?php   echo $row[0]['casual']; ?>"></td>
        <td><input type="text" name="medical" value="<?php   echo $row[0]['medical']; ?>"></td>
        <td><input type="text" name="short"   value="<?php   echo $row[0]['short_leave']; ?>"></td> 
       <?php  }else{
        $row = array();
        while($row[] = mysql_fetch_row($result1));         print_r($row); ?>
      
        <td><input type="text" name="annual"  value="<?php   echo $row[0][2]; ?>"></td>
        <td><input type="text" name="casual"  value="<?php   echo $row[1][2]; ?>"></td>
        <td><input type="text" name="medical" value="<?php   echo $row[2][2]; ?>"></td>
        <td><input type="text" name="short"   value="<?php   echo $row[3][2]; ?>"></td>   
         <?php  } ?>
        </table>
        <input type="text" name="emp_id" value="<?php echo $emp_id; ?>">
        <button class="btn btn-primary">Edit</button></a>
         </form>
     </div>
     
</div>
</div>
