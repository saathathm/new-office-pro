<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include_once '../model/attendance.php';
$employee_id=$_POST['employee_id'];
$id=$_POST['id'];
$date=$_POST['date'];
$from =date("H:i",strtotime($_POST['from']));
$to =date("H:i",strtotime($_POST['to'])); 
$action =$_POST['action'];
$admin_id= $_SESSION['emp_id'];
$obj=new attendance();
$result1=$obj->checkOverlapNote2($employee_id,$from,$to,$date,$id); 
$count= mysql_num_rows($result1); 
if($count==0){

$result=$obj->updateAttendanceDetail($id,$employee_id,$admin_id,$date,$from,$to);
if($result){
    if($action=="all"){
header("Location:../view/review_attendance.php?date3=$date");
    }
    else{header("Location:../view/view_attendance_backup.php?employee_id=".$employee_id."&&date4=".$date);}
    
}
else{
    }
}
else{
     if($action=="all"){
         header("Location:../view/review_attendance.php?date3=".$date."&&f=1");
    }
    else{header("Location:../view/view_attendance_backup.php?employee_id=".$employee_id."&&date4=".$date."&&f=1");}
     }
    
    
    
?>
