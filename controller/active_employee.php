<?php
include_once '../model/employee.php';

$employee_id=$_REQUEST['employee_id'];
$action=$_REQUEST['action'];
switch ($action) {
    case 'active':
active($employee_id);

        break;
    case 'deactive':
deactive($employee_id);

        break;

    default:
        break;
}
function active($employee_id){
    $obj=new employee();
  $result=$obj->activeEmployee($employee_id);  
  if($result){
   header("Location:../view/view_employee.php?s=1");   
  }else{
   header("Location:../view/view_employee.php?f=1");   
  }
}
function deactive($employee_id){
    $obj=new employee();
  $result=$obj->deactiveEmployee($employee_id);  
  if($result){
   header("Location:../view/view_employee.php?s=2");   
  }else{
   header("Location:../view/view_employee.php?f=2");   
  }
}
?>
