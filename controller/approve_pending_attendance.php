<?php //time keeping
session_start();

@$emp_type_in=$_REQUEST['emp_type_in'];
 $emp_id_in=$_REQUEST['emp_id_in'];

 if(!$_SESSION['emp_type']){header("Location:login.php");}
require_once '../model/attendance.php';
 @$id=$_REQUEST['id']; 
 @$date=$_REQUEST['date']; 
 @$employee_id=$_REQUEST['employee_id'];
 @$action=$_REQUEST['action']; 
 $emp_name=$_SESSION['name']; 
 
if(isset($_SESSION['emp_type']) AND $_SESSION['emp_type']==1 OR $_SESSION['emp_type']==2) { 
if($_SESSION['emp_id']==$emp_id_in){
   header("location:../view/working_hours.php?f=1");}
  else{
$obj=new attendance();
$result=$obj->approvePendingAttendance($id,$emp_name);
if($result){
    if($action=="all"){header("location:../view/working_hours.php");}
    else{header("location:../view/view_attendance_backup.php?employee_id=".$employee_id."&&date4=".$date);}
}
else{
    
}
}}
else{}
?>
