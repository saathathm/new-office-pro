<?php
ob_start();
session_start();
include_once '../model/leave.php';
$app_id =$_REQUEST['app_id']; 
$obj=new leave();
$obj->withdrawLeaveNew($app_id);
header("location:../view/view_leave_history_new.php");
ob_flush();
?>
