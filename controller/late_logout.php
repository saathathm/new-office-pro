<?php
require_once '../model/attendance.php';

//        echo  $id=$_REQUEST['id'];
$emp_id = $_REQUEST['employee_id'];
$action = $_REQUEST['action'];
$time = date("H:i", strtotime($_REQUEST['time']));
switch ($action) {
    case 'Logout':
        late_logout($emp_id, $time);
    break;
default:
    break;
}
       
       
   function late_logout($emp_id,$time){ 
   $obj=new attendance();
   $count=mysql_num_rows($obj->checkLogoutTime($emp_id)); 
    if($count!=0){
      $result=$obj->updateLateLogoutTime($emp_id,$time);
     header("Location:../view/attendance.php");   
      
    }

     else{
         echo "you have logged out";
     }          
    }             
                      
?>
