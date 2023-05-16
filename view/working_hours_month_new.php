<?php
session_start();
if (!isset($_SESSION['emp_type'])) {
    header("Location:login.php");
}

date_default_timezone_set('Asia/Colombo');
include_once 'user.php';
include_once '../model/leave.php';
include_once '../model/employee.php';
include '../model/gen_function.php';

?>
 <?php
    if (isset($_REQUEST['date'])) {
     $date = $_REQUEST['date'];
}
 else {
    $date = time();
}
 $Y=date("Y",strtotime($date));
 $m=date("m",strtotime($date));  
    ?>
<div class="container">
    <form action="working_hours_month_new.php" method="get" >
        <input type="text" id="date1" name="date" placeholder="Select Month" value="<?php if (isset($_REQUEST['date'])) {
     echo $_REQUEST['date'];
}
 else {
   echo time();
}?>">
        <input type="submit" class="btn btn-primary" value="Show"> 
    </form>
   
    <table class="table rbborder">
        <h5>Reports On<?php echo "&nbsp" . date("M",strtotime($date))   . "&nbsp-" . date("Y",strtotime($date)); ?></h5>
        <tr style="background-color:#000; color:#fff;" >
            <th>Employee Name</th>
            <th>Must Work</th>
            <th>Working Hours(H:M)</th>
        </tr>
        <?php
       
       $obj = new employee();
$objGen = new GeneralFunction(); //qq


$dates_array=$objGen->getCurrentMonthWorkingDays($Y,$m); //qq

////////////////////////////////
$total_weekdays = count($dates_array); //qq
$result4 = $objGen->getOffDay($m,$Y);  //qq
$value4 = mysqli_fetch_assoc($result4); //qq

$count4 = mysqli_num_rows($result4);  //qq
 $total_works_hour_month = ($total_weekdays - $count4) * 8 * 3600; //qq
// $holiday_hours=$count4*8*3600;
 $result = $obj->getAllEmployee();
        while ($val = mysqli_fetch_assoc($result)) {
$result5 = $objGen->getSumLeaveDetailNew($val['emp_id'],$m,$Y);
$value5 = mysqli_fetch_assoc($result5);
$leave_total_hours = $value5['total_hours'] * 3600;//qq

$result2 = $objGen->getMonthlyWorkingHoursDetailIndividual($val['emp_id'], $m, $Y);
$value2 = mysqli_fetch_assoc($result2);
$result3 = $objGen->getExtraTimemonthly($val['emp_id'], $m, $Y);
$value3 = mysqli_fetch_assoc($result3);

$must_work_month = $total_works_hour_month - $leave_total_hours;//qq
$hours1 = floor($must_work_month / (60 * 60)); //qq
$divisor_for_minutes1 = $must_work_month % (60 * 60); //qq
$minutes1 = floor($divisor_for_minutes1 / 60); //qq
$total_working_hours = $value2['diff'] + $value3['extra_time_month'];

$hours2 = floor($total_working_hours / (60 * 60));
$divisor_for_minutes2 = $total_working_hours % (60 * 60);
$minutes2 = floor($divisor_for_minutes2 / 60);
            ?>
        <tr>
            <td>
              <?php  echo $val['name'];?>  
            </td>
             <td>
              <?php echo $hours1.":".$minutes1; ?>  
            </td>
            <td>
              <?php echo $hours2.":".$minutes2; ?>  
            </td>
            
        </tr>
           <?php } ?>
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
