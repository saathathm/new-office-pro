<?php
include_once '../model/employee.php';
 if(isset($_REQUEST['submit'])){
 $name=$_POST['name'];
 $uname=$_POST['uname'];
 $pass=$_POST['pass'];
 $email=$_POST['email'];
 $p_no=$_POST['p_no'];
 $emp_type=$_POST['emp_type'];

$obj=new employee();
$result=$obj->addEmployee($name,$uname,$pass,$email,$p_no,$emp_type);
  

header("Location:../view/add_employee.php?s=1");
 }
?>
