<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
if(isset($_REQUEST['date2'])){$date=$_REQUEST['date2'];}
 
require_once '../model/leave.php';
require_once '../model/employee.php';
require_once '../model/attendance.php';
require_once("excelwriter.class.php");
  $time = strtotime($date);
        $day = date('w',$time);
        if($day==0){$day=6;  $time=strtotime(date("Y-m-d",(strtotime('-1 day',strtotime($date))))); }
        

         //$day=6;
        $time += ((7*@$week)+1-$day)*24*3600;
        $start = date('Y-n-j',$time);
        $time += 6*24*3600;
        $end = date('Y-n-j',$time);
?>
<script type="text/javascript">
function download()
{
	window.location='report.xls';
}
</script>
<div class="container">
    <form action="" method="get" >
       <input type="text" id="date2" name="date2" placeholder="Select date" value="<?php echo $date; ?>">
       <input type="submit" class="btn btn-primary" value="Show" > 
     </form>
    From <p class="text-warning"><?php echo $start; ?></p>To &nbsp;<p class="text-warning"><?php echo $end; ?></p>
    <table class="table rbborder">
        <thead style="background-color:#000; color:#fff;" >
            <th>Employee Name</th>
            <th>Must work/Hours Worked Weekly(H:M)</th>
        </thead>
<?php 
  $excel=new ExcelWriter("report.xls");
        if($excel==false)	
        echo $excel->error;
        $myHeader=array("<b>Reports From</b>&nbsp"."<b>".$start."</b>&nbsp"."<b>To</b>&nbsp"."<b>".$end."</b>");
        $mySpace=array("");
        $myArr=array("<b>Name</b>","<b>Must Work(H:M)</b>","<b>Hours Worked</b>","<b>Signature</b>");
        $excel->writeLine($myHeader);
        $excel->writeLine($mySpace);
        $excel->writeLine($myArr);
        
        $obj=new employee();
        $obj1=new attendance();
        $obj2=new leave();
        $result=$obj->getAllEmployee();
        while($val=mysql_fetch_assoc($result)){
        //get start date and end date of a WEEK
         $time = strtotime($date);
        $day = date('w',$time);
         if($day==0){$day=6;  $time=strtotime(date("Y-m-d",(strtotime('-1 day',strtotime($date))))); }
        $time += ((7*@$week)+1-$day)*24*3600;
        $start = date('Y-n-j',$time);
        $time += 6*24*3600;
        $end = date('Y-n-j',$time);
       
       //current week working hours
       $result2=$obj1->getWeeklyWorkingHoursIndividual($start,$end,$val['emp_id']);
      
       $value2=  mysql_fetch_assoc($result2);
        $valextratime=mysql_fetch_assoc($obj1->getExtraTimeweekly($val['emp_id'],$start,$end));
         $value_extra_time_week=$valextratime['extra_time_week'];
       $seconds2=$value2['diff']+$value_extra_time_week."<br>";     
       
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
                        
                           
                          //weekly  
                            $hours2 =floor($seconds2 / (60 * 60));
                            $divisor_for_minutes2 = $seconds2 % (60 * 60);
                            $minutes2 =floor($divisor_for_minutes2 / 60);
    ?> 
   <tr>
        <td><?php echo $val['name'] ?></td>
         <!--get current day working hours -->
        
        <!--get weekly working hours -->
        <td><?php
       
  if(isset($count9) && $count9!=0){//get total leaves of particular week
  while($leave=mysql_fetch_assoc($result9)){
                                 $from=strtotime($leave['leave_from']);
                                 $to=strtotime($leave['leave_to']);
                                 $time =strtotime($date);
      $day = date('w',$time);
       if($day==0){$day=6;  $time=strtotime(date("Y-m-d",(strtotime('-1 day',strtotime($date))))); }
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
       
        
   </tr>
<?php 

        $time22=$hours2.".".$minutes2;
        $myArr=array($val['name'],$ti,$time22);
        $excel->writeLine($myArr);  unset($_SESSION['leave']);
} ?>
</table>     
           
</div>
<script>
$(function() {
		$( "#date2" ).datepicker({
			
			changeMonth: true,
                        changeYear:false,
			numberOfMonths: 1
			});
});
       
</script>
<h1 align="center"><button onClick="download();" class="btn btn-primary">Download Excel Report</button></h1>