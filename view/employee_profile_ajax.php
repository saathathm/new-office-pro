<?php
include_once '../model/employee.php'; 
include_once '../model/leave.php'; 
$obj=new employee();
$obj1=new leave();
$result = $obj->getEmployee($_REQUEST['emp_id']);
$value=  mysql_fetch_assoc($result);
?>
<script>
$('a[rel*=facebox]').facebox({
        loadingImage : 'facebox/loading.gif',
        closeImage   : 'facebox/closelabel.png'
        
      })
</script>
<div class="row-fluid">
    <div class="span4 ">
        <table class="table well">
            <thead style="background-color:#000; color:#fff;"><th colspan="2">Personal Detail</th></thead>
            <tr><th>Name</th><td><?php echo $value['name']; ?></td></tr><tr><th>Email</th><td><?php echo $value['email']; ?></tr><tr><th>Phone</th><td><?php echo $value['p_no']; ?></tr><tr><th>DOB</th></tr>
            <td>dfsf</td>
        </table>
    </div>
     <div class="span4 ">
        <table class="table well">
            <thead style="background-color:#000; color:#fff;"><th>Annual</th><th>Casual</th><th>Medical</th><th>Short</th></thead>
        <?php 
        $result=$obj->getEmployee($_REQUEST['emp_id']);
        $count_indi_leave= mysql_num_rows($result2=$obj1->getIndividualLeave($_REQUEST['emp_id']));
        $value=  mysql_fetch_assoc($result);
        if($count_indi_leave>0){
        $result3=$obj1->getIndividualLeave($_REQUEST['emp_id']);   
                                }
else{
    $result1=$obj1->getLeave();
}
        if($count_indi_leave>0){
              $row = array();
        while($row[] = mysql_fetch_assoc($result3)); ?>
       
        <td><?php   echo $row[0]['annual']; ?></td>
        <td><?php   echo $row[0]['casual']; ?></td>
        <td><?php   echo $row[0]['medical']; ?></td>
        <td><?php   echo $row[0]['short_leave']; ?></td> 
         </table>
         <input type="text" name="emp_id" value="<?php echo $_REQUEST['emp_id']; ?>">
         <a href="update_leave.php?emp_id=<?php echo $_REQUEST['emp_id'] ?>" rel="facebox"><button class="btn btn-primary">Edit</button></a>
       
       <?php  }else{
        $row = array();
        while($row[] = mysql_fetch_array($result1)); ?>
       
        <td><?php   echo $row[0][2]; ?></td>
        <td><?php   echo $row[1][2]; ?></td>
        <td><?php   echo $row[2][2]; ?></td>
        <td><?php   echo $row[3][2]; ?></td>   
        </table>
         <input type="text" name="emp_id" value="<?php echo $_REQUEST['emp_id']; ?>">
         <a href="update_leave.php?emp_id=<?php echo $_REQUEST['emp_id'] ?>" rel="facebox"><button class="btn btn-primary">Edit</button></a>
          
     </div>
      <div class="span4">
      </div>
    </div>

<?php } ?>