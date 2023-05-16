<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
require_once '../model/leave.php';
require_once '../model/employee.php';
require_once '../model/attendance.php';
require_once("excelwriter.class.php");
?>
 <script type="text/javascript">
function download()
{
	window.location='report.xls';
}
</script>   
   <div class="container">
       
    <form action="" method="get" >
       <input type="text" id="date2" name="date2" placeholder="Select date">
       <input type="submit" class="btn btn-primary" value="Show" > 
   </form>
        <table class="table rbborder">
     <?php if(isset($_REQUEST['date2'])){$date=$_REQUEST['date2'];} ?>        
            <h4>Working Hours Reports On <?php echo $date ?></h4>
     <tr style="background-color:#000; color:#fff;" >
          <th>Employee Name</th>
          <th>Must Work/Hours Worked</th>
     </tr> 
    
    <?php
         $excel=new ExcelWriter("report.xls");
         if($excel==false)	
         echo $excel->error;
        $myHeader=array("<b>Working Hours Reports On</b>&nbsp"."<b>".$date."</b>");
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
        
        //get current day working hours + prayer time
        $result1=$obj1->getWorkingHoursIndividual($date,$val['emp_id']);   
        $val1=mysql_fetch_assoc($result1);
        $valextratime=mysql_fetch_assoc($obj1->getExtraTime($val['emp_id'], $date));
        $countextra= $valextratime['extra_time'];
        $seconds1=$val1['diff']+$countextra;
      
       
      //check employee status 
      $emp_id=$val['emp_id'];
      $result3=$obj1->getAttendanceSummary($date,$emp_id); 
      $val3=mysql_fetch_assoc($result3);
      $count3=  mysql_num_rows($result3);
      $result6=$obj2->getHalfDayLeaveDetail($emp_id,$date);      
      $value10=mysql_fetch_assoc($obj2->getShortLeaveHours($emp_id,$date));
      $value11=mysql_fetch_assoc($obj2->getHalfLeaveHours($emp_id,$date));
      $count_leave=mysql_num_rows($obj2->dayLeaveDetail($emp_id, $date));
    
             $count6=mysql_num_rows($result6);
             $result5=$obj2->getShortLeaveDetail($emp_id,$date);  //
             $count5=mysql_num_rows($result5); 
                        
                            $hours = floor($seconds1 / (60 * 60));
                            $divisor_for_minutes = $seconds1 % (60 * 60);
                            $minutes =floor($divisor_for_minutes / 60);
                          
    ?> 
  <tr>
        <td><?php echo $val['name'] ?></td>
         <!--get current day working hours -->
        <td><?php  
        switch (true) {
            case ($count_leave>0):
                $ti="Leave";
              echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span class="label label-info">Leave</span>';  
            break;
        
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
        $time22=$hours.".".$minutes;
        $myArr=array($val['name'],$ti,$time22);
	$excel->writeLine($myArr);
        }
        ?>
        </td>
     </tr>
        </table>
     
        <!--get weekly working hours -->
   <script>
$(function() {
		$( "#date2" ).datepicker({
			
			changeMonth: true,
                        changeYear:false,
			numberOfMonths: 1
			});
});
       
</script>
</div> 
 <h1 align="center"><button onClick="download();" class="btn btn-primary">Download Excel Report</button></h1>
  
    
 

