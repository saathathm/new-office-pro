<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include_once '../model/attendance.php';

 $id=$_POST['id'];   
 $date=$_POST['date'];
 $from =date("H:i",strtotime($_POST['from']));
 $logout_time =date("H:i",strtotime($_POST['logout_time']));
 $to =date("H:i",strtotime($_POST['to'])); 
 $employee_id= $_SESSION['emp_id'];
 if($logout_time<$to){ header("Location:../view/attendance.php?f=3&date3=$date");}
elseif ($from>$to) {header("Location:../view/attendance.php?f=4&date3=$date");}
 else{
 $obj=new attendance();
 $result=$obj->reduceTime($id,$employee_id,$date,$to);
 if($result){header("Location:../view/attendance.php?s=2&date3=$date");}
 }
    
    
    
?>
