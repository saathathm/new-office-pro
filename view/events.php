<?php
include_once '../model/leave.php';
$m=CURRENT_MONTH_N;
$Y=CURRENT_YEAR;
$date=date("$Y-$m-$i");

$emp_id=$_SESSION['emp_id'];
switch ($action) {
  case 'individual':
        
        $obj=new leave();
        $result=$obj->calendarEventIndividual($date,$emp_id);
        $msg="";
while($value=  ($result)->fetch_assoc()){
     $msg_hours=$value['total_hours'];
 if($value['approval']==1){ $msg="Approved";} 
  if($value['approval']==2){ $msg="Rejected";}
   if($value['approval']==0){ $msg="Pending";} 
   
if($value['leave_id']==1){
echo '<a href="view_exe.php?employee_id='.$emp_id.'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-info btn-block"  width="100%">'.$msg.'&nbsp'. $msg_hours.'</div></a>'; 
}
elseif($value['leave_id']==2){
echo '<a href="view_exe.php?employee_id='.$emp_id.'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-success btn-block"  width="100%">'.$msg.'&nbsp'. $msg_hours.'</div></a>'; 
}
elseif($value['leave_id']==3){
echo '<a href="view_exe.php?employee_id='.$emp_id.'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-warning btn-block"  width="100%" >'.$msg.'&nbsp'. $msg_hours.'</div></a>'; 
}
elseif($value['leave_id']==5){
   echo '<a href="view_exe.php?employee_id='.$emp_id.'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-inverse btn-block" width="100%">'.$msg.'&nbsp'. $msg_hours.'</div></a>'; 
}
elseif($value['leave_id']==6){
   echo '<a href="view_exe.php?employee_id='.$emp_id.'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-danger btn-block" width="100%">'.$msg.'&nbsp'. $msg_hours.'</div></a>'; 
}


}
 break;
case 'admin':
    $obj=new leave();
$result=$obj->calendarEvent(date("$Y-$m-$i"));
while($value=  ($result)->fetch_assoc()){
    $msg_hours=$value['total_hours'];
    $msg_app="";
    if($value['approval']==0){$msg_app="P";}
elseif ($value['approval']==1) {$msg_app="A";}
else{$msg_app="R";}
if($value['leave_id']==1){
echo '<a href="view_exe.php?employee_id='.$value['emp_id'].'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-info btn-block"  width="100%">'.$value['name'].'&nbsp'.$msg_hours.'&nbsp'.$msg_app.'</div></a>'; 
}
elseif($value['leave_id']==2){
echo '<a href="view_exe.php?employee_id='.$value['emp_id'].'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-success btn-block"  width="100%">'.$value['name'].'&nbsp'.$msg_hours.'&nbsp'.$msg_app.'</div></a>'; 
}
elseif($value['leave_id']==3){
echo '<a href="view_exe.php?employee_id='.$value['emp_id'].'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-warning btn-block"  width="100%" >'.$value['name'].'&nbsp'.$msg_hours.'&nbsp'.$msg_app.'</div></a>'; 
}
elseif($value['leave_id']==6){
   
echo '<a href="view_exe.php?employee_id='.$value['emp_id'].'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-danger btn-block" width="100%">'.$value['name'].'&nbsp'.$msg_hours.'&nbsp'.$msg_app.'</div></a>'; 

}
else{
    echo '<a href="view_exe.php?employee_id='.$value['emp_id'].'&leave_id='.$value['leave_id'].'" rel="facebox"><div class="btn btn-inverse btn-block"  width="100%">'.$value['name'].'&nbsp'.$msg_hours.'&nbsp'.$msg_app.'</div></a>'; }


}
        break;
        
    default:
       break;
 
}


?>
