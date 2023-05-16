<?php //time keeping
 ob_start();
session_start();
$emp_type_in=$_REQUEST['emp_type_in'];
require_once '../model/leave.php';
$app_id=$_REQUEST['app_id'];
$reject_reason=$_REQUEST['reason'];
if($_SESSION['emp_id']==$emp_type_in){ header("location:../view/view_leave.php?f=1"); }
else{
$obj=new Leave();
$result=$obj->rejectLeave($app_id,$reject_reason);
if($result){
header("location:../view/view_leave.php?s=2");
}else{
header("location:../view/view_leave.php?f=3");    
}
ob_flush();
}
?>
