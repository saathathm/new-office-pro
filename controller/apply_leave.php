<?php
ob_start();
require_once '../model/leave.php';
$emp_id=$_POST['emp_id'];
$leave_type=$_POST['leaveType'];
date_default_timezone_set('Asia/Colombo');
$appliedDate=date("Y-m-d");
$total_duration=$_POST['total_duration']; 
$duration=$_POST['duration'];
if($duration=="days"){
$total_duration=$total_duration*8; 
}
 else{$total_duration;}
 $from=$_POST['from'];
 $month=date("m", strtotime($from));
 $year=date("Y", strtotime($from));
 $to=$_POST['to'];
 $reason=$_POST['reason'];
 
 //check leave balance exceeded
 $obj=new Leave();
 $result=$obj->checkLeaveOverlap($emp_id,$from,$to);
 $count=mysql_num_rows($result);
 if ($count == 0) {

    if ($leave_type == 5) {
        $count = mysql_num_rows($obj->checkShortLeaveExceeded($emp_id, $month, $year));
        if ($count < 2) {
$obj->applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason);
header("location:../view/apply_leave.php?s=2");
        } else {
            header("location:../view/apply_leave.php?f=1");
        }
    } else {
$obj->applyLeave($emp_id,$leave_type,$appliedDate,$from,$to,$total_duration,$reason);
header("location:../view/apply_leave.php?s=2");
    }
} else {//overlap dates
   while($value= mysql_fetch_assoc($result)){$arr[]= $value['leave_id']; }
    //header("location:../view/apply_leave.php?s=1");
if (in_array(1,$arr) || in_array(2,$arr) || in_array(3,$arr) ) {
     header("location:../view/apply_leave.php?s=1");
}
else{//not leave id 1,2,3
   
    $count1 = mysql_num_rows($obj->checkShortLeaveExceeded($emp_id,$month,$year));
    $count2=mysql_num_rows($obj->checkHalfDayLeave($emp_id,$from));
    switch ($leave_type) {
        case 5:
            if($count1>=2)  { header("location:../view/apply_leave.php?f=1");}
            elseif($count2==2){header("location:../view/apply_leave.php?s=1");}
            else{$obj->applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason);
            header("location:../view/apply_leave.php?s=2");
            }
            break;
        case 4:
        $length=count(array_keys($arr,5));
            if($count2>=2){ header("location:../view/apply_leave.php?s=1");}
            elseif($count2==1 && $length==2) {header("location:../view/apply_leave.php?s=1");}
            else{$obj->applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason);
              header("location:../view/apply_leave.php?s=2");
            }
            break;
            case (1 || 2 || 3):
                header("location:../view/apply_leave.php?s=1");
                   break;
        default:
            break;
    }
}
}
ob_flush();
?>

