<?php //time keeping
ob_start();
session_start();
$emp_type_in=$_REQUEST['emp_type_in']; 
require_once'../model/leave.php';
$app_id=$_REQUEST['app_id'];
if($_SESSION['emp_id']==$emp_type_in){header("location:../view/view_leave.php?f=1"); }
else{
$obj=new leave();
$result=$obj->approvedLeave($app_id);
if($result){
header('Location:../view/view_leave.php?s=1');
}else{header('Location:../view/view_leave.php?f=2');}
ob_flush();
}
?>
