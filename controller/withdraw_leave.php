<?php
session_start();
include_once '../model/leave.php';
$app_id =$_REQUEST['app_id'];
$obj=new leave();
$obj->deleteLeave($app_id);
header("location:../view/view_leave_history.php");
?>
