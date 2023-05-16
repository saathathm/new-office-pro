<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include_once 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
require_once '../model/leave.php';
require_once '../model/employee.php';
require_once '../model/attendance.php';
?>
<div class="container">
    <table class="table rbborder">
        <thead style="background-color:#000; color:#fff;" >
            <th>Employee Name</th>
            <th>Must work/Today(H:M)</th>
            <th>Must work/Weekly(H:M)</th>
             <th>Status</th>
        </thead>
<?php 
        $obj=new employee();
        $obj1=new attendance();
        $obj2=new leave();
        $result=$obj->getAllEmployee();
        while($val=mysql_fetch_assoc($result)){
        //get start date and end date of a WEEK
       // $time = strtotime($date);
       // $day = date('w',$time);
       // $time += ((7*@$week)+1-$day)*24*3600;
       // $start = date('Y-n-j',$time);
       // $time += 6*24*3600;
      //  echo $end = date('Y-n-j',$time);

$time = strtotime($date);
        $day = date('w',$time);
        if($day==0){$day=6;  $time=strtotime(date("Y-m-d",(strtotime('-1 day',strtotime($date))))); }
        

         //$day=6;
        $time += ((7*@$week)+1-$day)*24*3600;
        $start = date('Y-n-j',$time);
        $time += 6*24*3600;
        $end = date('Y-n-j',$time);

        //current day working hours
        $valextratime=mysql_fetch_assoc($obj1->getExtraTime($val['emp_id'], $date));
        $countextra= $valextratime['extra_time'];
         $valextratime=mysql_fetch_assoc($obj1->getExtraTimeweekly($val['emp_id'],$start,$end));
         $value_extra_time_week=$valextratime['extra_time_week'];
        
        $result1=$obj1->getWorkingHoursIndividual($date,$val['emp_id']);   
        $val1=mysql_fetch_assoc($result1);
        $seconds1=$val1['diff']+$countextra;
       //current week working hours
       $result2=$obj1->getWeeklyWorkingHoursIndividual($start,$end,$val['emp_id']);
       $value2=  mysql_fetch_assoc($result2);    
       $seconds2=$value2['diff']+$value_extra_time_week;     
       
      //check employee status 
      $emp_id=$val['emp_id'];
      $result3=$obj1->getAttendanceSummary($date,$emp_id); 
      $val3=mysql_fetch_assoc($result3);
      $count3=  mysql_num_rows($result3);
      $result6=$obj2->getHalfDayLeaveDetail($emp_id,$date);      
      $result7=$obj2->getShortLeaveDetailWeek($start,$end,$emp_id);
      $result8=$obj2->getHalfDayLeaveDetailWeek($emp_id,$start,$end);
      $result9=$obj2->getLeaveDetailWeek($emp_id, $start, $end);
      $value10=mysql_fetch_assoc($obj2->getShortLeaveHours($emp_id,$date));
      $value11=mysql_fetch_assoc($obj2->getHalfLeaveHours($emp_id,$date));
      
    
             $count6=mysql_num_rows($result6);
             $count7=mysql_num_rows($result7);
             $count8=mysql_num_rows($result8);//changed
             $count9=mysql_num_rows($result9);
             
             $value7=mysql_fetch_assoc($result7);
             $value8=mysql_fetch_assoc($result8);
             
             $result5=$obj2->getShortLeaveDetail($emp_id,$date);  //
             $count5=mysql_num_rows($result5); 
                         if($count3==0){   //if count=0 employee's are not in office
         
                            $result4=$obj2->getLeaveDetail($emp_id,$date);
                            $count4=mysql_num_rows($result4);
                            if($count4>0){
                                          $emp_status='<span class="label label-info">On Leave</span>';
                                                
                                         }
                                            else{$emp_status='<span class="label label-inverse">Drop Out</span>';
                                                        
                                                        }
                                     }
                                 else{
                                                if($val3['logout_time']==0){
                                 $emp_status='<span class="label label-success">Logged In</span>';}
                                                else{$emp_status='<span class="label label-important">Logged Out</span>';}
                                     }
                            $hours = floor($seconds1 / (60 * 60));
                            $divisor_for_minutes = $seconds1 % (60 * 60);
                            $minutes =floor($divisor_for_minutes / 60);
                          //weekly  
                            $hours2 =floor($seconds2 / (60 * 60));
                            $divisor_for_minutes2 = $seconds2 % (60 * 60);
                            $minutes2 =floor($divisor_for_minutes2 / 60);
    ?> 
   <tr>
        <td><?php echo $val['name'] ?></td>
		
         <!--get current day working hours -->
        <td><?php  
        switch (true) {
            case ($count5>0 && $count6>0):
              $t1011=($value10['s_hours']+$value11['h_hours'])*3600; //convert to seconds
               $tmustwork=28800-$t1011;
               include_once 'functions.php'; 
               $ti=  get_hours($tmustwork);
               echo $ti;
               if($seconds1>$tmustwork){echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours.":".$minutes.'</span>';}
               else{echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours.":".$minutes.'</span>';}
                break;
            case ($count5>0):
                  $t10=$value10['s_hours']*3600;
                  $tmustwork=28800-$t10;
                   include_once 'functions.php'; 
               $ti=  get_hours($tmustwork);
               echo $ti;
                   if($seconds1>$tmustwork){echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours.":".$minutes.'</span>';}
               else{echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours.":".$minutes.'</span>';}
                break;
            case ($count6>0):
                  $t11=$value11['h_hours']*3600;
                  $tmustwork=28800-$t11; 
                   include_once 'functions.php'; 
               $ti=  get_hours($tmustwork);
               echo $ti;
                  if($seconds1>$tmustwork){echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours.":".$minutes.'</span>';}
               else{echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours.":".$minutes.'</span>';}
                break;
            default:
                $tmustwork=28800;
                include_once 'functions.php'; 
               $ti=  get_hours($tmustwork);
               echo $ti;
                 if($seconds1>28800){echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours.":".$minutes.'</span>';}
               else{  echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours.":".$minutes.'</span>';}
                break;
        }
       
        ?>
        </td>
        <!--get weekly working hours -->
        <td><?php
       
  if(isset($count9) && $count9!=0){//get total leaves of particular week
  while($leave=mysql_fetch_assoc($result9)){
                                 $from=strtotime($leave['leave_from']);
                                 $to=strtotime($leave['leave_to']);
                                 $time =strtotime($date);
     // $day = date('w',$time);
     // $time += ((7*@$week)+1-$day)*24*3600;
    //  $start = date('Y-n-j',$time);
    //  $time += 6*24*3600;
     // $end = date('Y-n-j',$time);

$time = strtotime($date);
        $day = date('w',$time);
        if($day==0){$day=6;  $time=strtotime(date("Y-m-d",(strtotime('-1 day',strtotime($date))))); }
        

         //$day=6;
        $time += ((7*@$week)+1-$day)*24*3600;
        $start = date('Y-n-j',$time);
        $time += 6*24*3600;
        $end = date('Y-n-j',$time);

                                 $start= strtotime($start);
//                                  $end= strtotime($end);
                                 $end= strtotime(date("Y-m-d",$start)." +4 day");
                                 
 if($start>=$from && $end>=$to){
 include_once  'functions.php';
 $t=total_leave($start,$to);
 }
 elseif ($start>=$from  && $end<$to) {
 include_once  'functions.php';
 $t=total_leave($start,$end); 
 }
 elseif ($start<$from  && $end>=$to) {
 include_once  'functions.php';
 $t=total_leave($from,$to); 
 }
 elseif($start<$from && $end<$to){
 include_once  'functions.php';
 $t=total_leave($from,$end);
 }
 else{ 
 include 'functions.php';
 }       
}//while loop end                
       }//end if condition      
        ?>
   <?php
switch (true) {
       case ($count7!=0 && $count8!=0 && $count9!=0):
           //echo "three";
           $c7=$value7['s_total_hours']*3600;
           $c8=$value8['h_total_hours']*3600;
           $c9=array_sum($_SESSION['leave'])*28800;
           $total_seconds=$c7+$c8+$c9;
           $must_work=144000-$total_seconds;
            include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
           if($seconds2>$must_work){
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
               echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }break;
       
        case ($count7!=0 && $count8!=0):
          //echo "short half";
          $c7=$value7['s_total_hours']*3600;
          $c8=$value8['h_total_hours']*3600;
          $total_seconds=$c7+$c8;
          $must_work=144000-$total_seconds;
           include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
          if($seconds2>$must_work){
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }break;
       
       case ($count7!=0  && $count9!=0):
          // "short leave";
           $c7=$value7['s_total_hours']*3600;
           $c9=array_sum($_SESSION['leave'])*28800;
           $total_seconds=$c7+$c9;
           $must_work=144000-$total_seconds;
            include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
           
           if($seconds2>$must_work){
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
               echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }break;
       
        case ($count8!=0 && $count9!=0):
           //echo "half leave";
           $c8=$value8['h_total_hours']*3600;
           $c9=array_sum($_SESSION['leave'])*28800;
           $total_seconds=$c8+$c9;
           $must_work=144000-$total_seconds;
            include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
           if($seconds2>$must_work){
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
                echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }break;
       
         case ($count7!=0):
           //echo "short";
            $c7=$value7['s_total_hours']*3600;
            $total_seconds=$c7;
            $must_work=144000-$total_seconds;
             include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
            if($seconds2>$must_work){
            echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
                echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }break;
         
          case ($count8!=0):
           //echo "half";
           $c8=$value8['h_total_hours']*3600;
           $total_seconds=$c8;
           $must_work=144000-$total_seconds;
            include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
           if($seconds2>$must_work){
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
                echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }break;
         
          case ($count9!=0):
           // "leave";
             $c9=array_sum($_SESSION['leave'])*28800;
             $total_seconds=$c9;
             $must_work=144000-$total_seconds;
              include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
           if($seconds2>$must_work){
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
                echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }break;
default:
         $must_work=144000;
    include_once 'functions.php'; 
               $ti=  get_hours($must_work);
               echo $ti;
if($seconds2>144000){
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-success">'.$hours2.':'.$minutes2.'</span>'; 
           }else{
                echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-important">'.$hours2.':'.$minutes2.'</span>'; 
           }
           break;
           }
           ?>
            
        </td>
          <td><?php echo $emp_status; ?> </td>
        
   </tr>
<?php unset($_SESSION['leave']); } ?>
</table>     
           
</div>
