<?php //time keeping
ob_start();
session_start();
require_once'../model/leave.php';
$emp_type_in=$_REQUEST['emp_type_in'];  
 $app_id=$_REQUEST['app_id'];  
if($_SESSION['emp_id']==$emp_type_in){header("location:../view/view_leave_new.php?f=1"); }
else{
$obj=new leave();
$result=$obj->approveLeaveNew($app_id);
if($result){
header('Location:../view/view_leave_new.php?s=1');
}else{header('Location:../view/view_leave_new.php?f=2');}
ob_flush();
}
?>
