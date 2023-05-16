<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include_once 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
if(isset($_REQUEST['date2'])){$date=$_REQUEST['date2'];}
include_once '../model/new_leave.php';
include_once  '../model/employee.php';
include_once  '../model/attendance.php';
include_once  '../model/cpanel.php';
include ("excelwriter.class.php");
 //get start date and end date of a WEEK
        $time = strtotime($date);
        $day = date('w',$time);
        if($day==0){$day=6;  $time=strtotime(date("Y-m-d",(strtotime('-1 day',strtotime($date))))); }
        $time += ((7*@$week)+1-$day)*24*3600;
        $start = date('Y-n-j',$time);
        $time += 6*24*3600;
        $end = date('Y-n-j',$time);
?>
<script type="text/javascript">
function download_excel()
{
	window.location='report.xls';
}
</script>
<form action="working_hours_week_trail.php" method="get" >
       <input type="text" id="date2" name="date2" placeholder="Select date" value="<?php echo $date; ?>">
       <input type="submit" class="btn btn-primary" value="Show" > 
     </form>
    From <p class="text-warning"><?php echo $start; ?></p>To &nbsp;<p class="text-warning"><?php echo $end; ?></p>
<div class="container">
    <table class="table  rbborder">
        <thead style="background-color:#000; color:#fff;" >
            <th>Employee Name</th>
        
            <th colspan="2">Must work/Weekly(H:M)</th>
            
        </thead>
<?php 
        $obj=new employee();
        $obj1=new attendance();
        $obj2=new newLeave();
        $obj3=new Cpanel();
       ////////////////// 
       
        //current day working hours
       $getOffDay=$obj3->getSpecificOffDay($date);
       $getOffDayWeek=$obj3->getSpecificOffDayWeek($start,$end);
       $countOffDay= mysql_num_rows($getOffDay);
       $countOffDayWeek= mysql_num_rows($getOffDayWeek);
  
     /////////////// 
        $excel=new ExcelWriter("report.xls");
        if($excel==false)	
        echo $excel->error;
        $myHeader=array("<b>Reports From</b>&nbsp"."<b>".$start."</b>&nbsp"."<b>To</b>&nbsp"."<b>".$end."</b>");
        $mySpace=array("");
        $myArr=array("<b>Name</b>","<b>Must Work(H:M)</b>","<b>Hours Worked</b>","<b>Signature</b>");
        $excel->writeLine($myHeader);
        $excel->writeLine($mySpace);
        $excel->writeLine($myArr);
        
        $hours_of_work_day=28800; 
        $hours_of_work_week=144000;
         if(isset($countOffDayWeek) && $countOffDayWeek!=0)  {$hours_of_work_week=$hours_of_work_week-($countOffDayWeek*$hours_of_work_day);}  
        if(isset($countOffDay) && $countOffDay!=0)  {$hours_of_work_day=0;} 
       
        $result=$obj->getAllEmployee();
        while($val=mysql_fetch_assoc($result)){ 
       
       $valextratime=mysql_fetch_assoc($obj1->getExtraTimeweekly($val['emp_id'],$start,$end));
       $value_extra_time_week=$valextratime['extra_time_week'];
        
//       $gwhi=$obj1->getWorkingHoursIndividual($date,$val['emp_id']);   
//       $valuegwhi=mysql_fetch_assoc($gwhi);
//       $seconds1=$valuegwhi['diff']+$countextra;
       //current week working hours
       $result2=$obj1->getWeeklyWorkingHoursIndividual($start,$end,$val['emp_id']);
       $value2=  mysql_fetch_assoc($result2);    
       $seconds2=$value2['diff']+$value_extra_time_week;     
       
      //check employee status 
      $emp_id=$val['emp_id'];
      $gas=$obj1->getAttendanceSummary($date,$emp_id); 
      $valuegas=mysql_fetch_assoc($gas);
      $countgas=  mysql_num_rows($gas);
     
      
       $gwlh=$obj2->getWeekLeaveHours($emp_id, $start, $end);
       $valuegwlh=  mysql_fetch_assoc($gwlh);
   
      $gsdlh=$obj2->getSpecificDayLeaveHours($emp_id,$date);
      $valuegsdlh=  mysql_fetch_assoc($gsdlh);
      $countSpecificDayLeaveHours= mysql_num_rows($gsdlh);

                            $hours = floor($seconds1 / (60 * 60));
                            $divisor_for_minutes = $seconds1 % (60 * 60);
                            $minutes =floor($divisor_for_minutes / 60);
//                          //weekly  
                            $hours2 =floor($seconds2 / (60 * 60));
                            $divisor_for_minutes2 = $seconds2 % (60 * 60);
                            $minutes2 =floor($divisor_for_minutes2 / 60);
    ?> 
   <tr>
        <td><?php echo $val['name'] ?></td>
         <!--get current day working hours -->
       
        <!--get weekly working hours -->
        <td width="20">
        <?php 
         
                 $total_hours_week= $valuegwlh['total_hours_week'];
                  $must_work_week=($hours_of_work_week-$total_hours_week*3600);
                        $hours_week = floor($must_work_week / (60 * 60));
                        $divisor_for_minutes = $must_work_week % (60 * 60);
                        $minutes_week = floor($divisor_for_minutes / 60);
                          echo $ti =$hours_week.":".$minutes_week;
                      
                  
      
             echo "</td>";
   echo "<td>"; 
  
        if($seconds2>$must_work_week){
        echo '<span class="label label-success">'.$hours2.':'.$minutes2.'</span>';                        
                                     }
        else{  
                        echo '<span class="label label-important">'.$hours2.':'.$minutes2.'</span>';  
            } 
   echo "</td>";
        ?>
 </tr>
<?php 
 $time22=$hours2.".".$minutes2;
 echo 'hhhh';
        $myArr=array($val['name'],$ti,$time22);
        $excel->writeLine($myArr);

} ?>
</table>     
           
</div>
<script>
$(function() {
		$("#date2").datepicker({
			changeMonth: true,
                        changeYear:false,
			numberOfMonths: 1
			});
});
       
</script>
<h1 align="center"><button onClick="download_excel();" class="btn btn-primary">Download Excel Report</button></h1>