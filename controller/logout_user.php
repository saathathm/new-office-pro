<?php
session_start();
if($_SESSION['emp_type']==3){header("Location:login.php");} 
require_once '../model/attendance.php';
 $admin_id=$_SESSION['emp_id'];
 $emp_id=$_REQUEST['employee_id'];
 $id=$_REQUEST['id'];
 $time=date("H:i",strtotime($_REQUEST['time']));
 $obj=new attendance();
 $result=$obj->checkEmployeeLogout($emp_id,$id);
 $count=mysql_num_rows($result); 
 if($count==1){
  $obj->addLogoutTime($emp_id,$id,$time,$admin_id);
  header("Location:../view/view_attendance.php");   
  }
else{header("Location:../view/view_attendance.php");}
?>
