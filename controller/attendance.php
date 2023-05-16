<?php
session_start();
require_once '../model/attendance.php';
  $action=$_REQUEST['action']; 
 $emp_id=$_REQUEST['emp_id']; 
//for without note login
date_default_timezone_set('Asia/Colombo');
 $date=date("Y-m-d");
 $login=date("H:i:s");
//with note login
 $from=date("H:i",strtotime(@$_REQUEST['from']));
 $to=date("H:i",strtotime(@$_REQUEST['to'])); 
 $date2=@$_REQUEST['date'];
 $note=@$_REQUEST['note'];
 $str_from=strtotime($from);
 $str_to=strtotime($to);

switch ($action) {
    case 'login_approved':
     addLoginTime($emp_id,$login,$date);

         break;
     case 'logout_approved':
     addLogoutTime($emp_id,$login,$date);

         break;

     case 'add_note':
     addNote($emp_id,$from,$to,$date2,$note,$str_from,$str_to);

         break;

    default:
        break;
} 
function addLoginTime($emp_id,$login,$date){
                $obj=new attendance();
                $result=$obj->getAttendanceDetail($emp_id,$date);
                $count=mysql_num_rows($result);
                if($count===0){$obj->addLoginTime($emp_id,$login,$date);
                header("Location:../view/attendance.php?e=1");
                }   
                    else{
                            $obj=new attendance();
                            $result1=$obj->checkLogoutTime($emp_id);
                            $count1=mysql_num_rows($result1);
  
                                if($count1===0){$obj->addLoginTime($emp_id,$login,$date);
                                header("Location:../view/attendance.php?e=2");
                                }
                                else{header("Location:../view/attendance.php");}
                        }    
     
    
                                             }
 function addLogoutTime($emp_id,$login,$date){
                $obj=new attendance();
                $result1=$obj->checkLogoutTime($emp_id);
                $count=  mysql_num_rows($result1);
                $value=  mysql_fetch_assoc($result1);
                $login_time=$value['login_time'];
                $login_date=$value['date']; 
                $time = strtotime($login_date);
                $final = date("Y-m-d", strtotime("+1 day", $time)); 
                $id=$value['id']; //login logout session id
                                    if($count!=0){
                                    if($value['date']==$date){
                                    $result=$obj->updateLogoutTime($emp_id,$login,$date);

                                        if(!$result){}   
                                        else{
                                         header("Location:../view/attendance.php?e=3");   
                                                }    
                                                              }
                                       else{
                                           
                                       header("Location:../view/late_logout.php?id=$id && employee_id=$emp_id && e=1");}}
                                           else{header("Location:../view/attendance.php");   } 
                                       }

 function addNoteLoginTime($emp_id,$time,$date2,$note){
                $obj=new attendance();
                $result=$obj->getAttendanceDetail($emp_id);
                $count=mysql_num_rows($result);
                if($count===0){$obj->addNoteLoginTime($emp_id,$time,$date2,$note);}   
                    else{
                            $obj=new attendance();
                            $result1=$obj->checkLogoutTime($emp_id);
                             $count1=mysql_num_rows($result1);
  
                                if($count1===0){$obj->addNoteLoginTime($emp_id,$time,$date2,$note);}
                                else{}
                        }    
     
     
}
function addNoteLogoutTime($emp_id,$time,$date2,$note){
                $obj=new attendance();
                $result=$obj->updateNoteLogoutTime($emp_id,$time,$date2,$note);
//                $count=mysql_num_rows($result);
                if(!$result){}   
                    else{}    
     }
function addNote($emp_id,$from,$to,$date2,$note,$str_from,$str_to){
      if ($str_from > $str_to)
{
 header("Location:../view/attendance.php?f=2&&in=$str_from&&out=$str_to"); 
   
}
else{
 
                $obj=new attendance();
                $result1=$obj->checkOverlapNote($emp_id,$from,$to,$date2); 
                $count= mysql_num_rows($result1); 
                if($count==0){
                $result=$obj->addNoteLoginTime($emp_id,$from,$to,$date2,$note);  
                   header("Location:../view/attendance.php");   
                }
                else{header("Location:../view/attendance.php?f=1");}}
                   }                                           
 ?>
