<?php
@session_start();
if(isset($_SESSION['emp_type']) && ($_SESSION['emp_type'])!=1 && $_SESSION['emp_type']!=2 ){header("Location:login.php");}
include_once 'user.php';
?>
<div class="rbborder">  
<form action="../controller/deleteemployeedetail.php" method="post" >
<table class="table">
   <tr style="background-color:#000; color:#fff;" >
        <th>Name </th>
        <th>Email</th>
        <th>Phone No</th>
        <th>Employee Type</th>
        <th>Update</th>
        <th>Active Status</th>
    </tr>
<tbody>
<?php include_once '../model/employee.php'; 

$obj=new employee();
$result=$obj->getAllEmployeeDetail2();
while($value=mysql_fetch_assoc($result)){

    ?>
   
<tr>
    <td><?php  echo $value['name']; ?></td> 
    <td><?php  echo $value['email']; ?></td>
    <td><?php  echo $value['p_no']; ?></td>
    <td><?php  echo $value['emp_type']; ?></td>
    <td><a href="update_employee.php?employee_id=<?php echo $value['emp_id']; ?>" rel="facebox"><img src="images/update.png" width="30" width="30" rel="tooltip" title="click to update staff detail"></a></td>
    <td><?php  echo $value['active_status']; ?>
    <?php if($value['active_status']!="yes") { ?>
        <a href="../controller/active_employee.php?employee_id=<?php echo  $value['emp_id']; ?>&&action=active">
            <img src="images/tick.png" height="18" width="18" rel="tooltip" title="click to activate the staff">
        </a><?php } else { ?>
    
   
        <a href="../controller/active_employee.php?employee_id=<?php echo  $value['emp_id']; ?>&&action=deactive">
            <img src="images/cross.png" height="18" width="18" rel="tooltip" title="click to deactivate the staff">
        </a><?php } ?>
    </td>
</tr>

<?php } ?>
</tbody>
</table>
      <input type="hidden" name="action" value="all" >
      <hr>

  </form>
  </div>
