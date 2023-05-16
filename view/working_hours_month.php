<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
$time = date("H:i:s");
require_once("excelwriter.class.php");
require_once '../model/attendance.php';
require_once '../model/employee.php';
$obj1=new employee();
?>
<script type="text/javascript">
function download()
{
	window.location='report.xls';
}
</script>
<div class="container">
   <form action="working_hours_month.php" method="get" >
       <input type="text" id="date1" name="date" placeholder="Select Month">
       
       <input type="submit" class="btn btn-primary" value="Show"> 
   </form>
<?php  
 
if(isset($_REQUEST['date'])) {$year=date('Y', strtotime(@$_REQUEST['date']));
                                $month=date('m', strtotime(@$_REQUEST['date']));
                                $nmonth=date('F', strtotime(@$_REQUEST['date']));
                                }
                                else{$year=date('Y', strtotime($date));
                                     $month=date('m', strtotime($date));
                                     $nmonth=date('F', strtotime($date));
                                     }
                                
                                ?>
        <table class="table rbborder">
        <h5>Reports On<?php echo "&nbsp".$year."&nbsp".$nmonth; ?></h5>
        <tr style="background-color:#000; color:#fff;" >
          <th>Employee Name</th>
          <th>Working Hours(H:M)</th>
        </tr>
            <?php 
            //export excel report
         $excel=new ExcelWriter("report.xls");
         if($excel==false)	
         echo $excel->error;
         $myHeader=array("<b>Reports On</b>&nbsp"."<b>".$year."</b>&nbsp"."&nbsp"."<b>".$nmonth."</b>");
        $mySpace=array("");
        $myArr=array("<b>Name</b>","<b>Hours Worked</b>","<b>Signature</b>");
        $excel->writeLine($myHeader);
        $excel->writeLine($mySpace);
        $excel->writeLine($myArr);
        
     
        $obj=new attendance();
        $result1=$obj1->getAllEmployee();
        while($val1=mysql_fetch_assoc($result1)){
        $result=$obj->getMonthlyWorkingHoursDetailIndividual($val1['emp_id'],$month,$year);   
        $val=mysql_fetch_assoc($result);
        $valextratime=mysql_fetch_assoc($obj->getExtraTimemonthly($val['emp_id'],$month,$year));
        $value_extra_time_month=$valextratime['extra_time_month'];
        $seconds=$val['diff']+$value_extra_time_month;
        ?> 
         <tr>
        
        <td><?php echo $val1['name'] ?></td>
        <td><?php $hours = floor($seconds / (60 * 60));
                    $divisor_for_minutes = $seconds % (60 * 60);
                    $minutes = floor($divisor_for_minutes / 60);
                    $divisor_for_seconds = $divisor_for_minutes % 60;
                    $seconds = ceil($divisor_for_seconds); 
                    echo $hours.":".$minutes;
                    ?>
       </td>
       </tr>
         <?php  
         $time=$hours.".".$minutes;
       
          $myArr=array($val['name'],$time);
		$excel->writeLine($myArr);   }?>
    
     </table>     
</div>
<style>
 .ui-datepicker-calendar {
  display: none;
 }
</style>
<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
<script>
$(function() {
		$("#date1").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        changeYear:true,
                        showButtonPanel: true,
                        dateFormat: 'MM yy',
			numberOfMonths: 1,
                        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        },
        beforeShow : function(input, inst) {
          var tmp = $(this).val().split('/');
          $(this).datepicker('option','defaultDate',new Date(tmp[1],tmp[0]-1,1));
          $(this).datepicker('setDate', new Date(tmp[1], tmp[0]-1, 1));
        }
			
		});
});
 </script>
<h1 align="center"><button onClick="download();" class="btn btn-primary">Download Excel Report</button></h1>