<?php
session_start();
include_once '../model/employee.php';
$name=$_POST['name'];
$uname=$_POST['uname'];
$pass=$_POST['pass'];
$email=$_POST['email'];
$p_no=$_POST['p_no'];
$emp_id=$_POST['employee_id'];
$emp_type=$_POST['emp_type'];

$obj=new employee();
$result=$obj->updateEmployeeDetail($name,$uname,$pass,$email,$p_no,$emp_id,$emp_type);
header("Location:../view/view_employee.php?r=1");
?>
