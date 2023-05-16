<?php
session_start();
if (!isset($_SESSION['emp_type'])) {
    header("Location:login.php");
}
include_once 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
if(isset($_REQUEST['date2'])){$date=$_REQUEST['date2'];}
require_once '../model/leave.php';
require_once '../model/employee.php';
require_once '../model/attendance.php';
require_once '../model/cpanel.php';
?>
 <form action="" method="get" >
       <input type="text" id="date2" name="date2" placeholder="Select date">
       <input type="submit" class="btn btn-primary" value="Show" > 
 </form>
  <h4>Working Hours Reports On <?php echo $date ?></h4>
<div class="container">
    <table class="table  rbborder">
        <thead style="background-color:#000; color:#fff;" >
        <th>Employee Name</th>
        <th colspan="2">Must work/Today(H:M)</th>
      
       
        </thead>
        <?php
        $obj = new employee();
        $obj1 = new attendance();
        $obj2 = new leave();
        $obj3 = new Cpanel();
        ////////////////// 
        //get start date and end date of a WEEK
        $time = strtotime($date);
        $day = date('w', $time);
        if ($day == 0) {
            $day = 6;
            $time = strtotime(date("Y-m-d", (strtotime('-1 day', strtotime($date)))));
        }
        $time += ((7 * @$week) + 1 - $day) * 24 * 3600;
        $start = date('Y-n-j', $time);
        $time += 6 * 24 * 3600;
        $end = date('Y-n-j', $time);
        //current day working hours
        $getOffDay = $obj3->getSpecificOffDay($date);
        $getOffDayWeek = $obj3->getSpecificOffDayWeek($start, $end);
        $countOffDay = ($getOffDay)->num_rows;
        $countOffDayWeek = ($getOffDayWeek)->num_rows;

        /////////////// 

        $hours_of_work_day = 28800;
        $hours_of_work_week = 144000;
        if (isset($countOffDayWeek) && $countOffDayWeek != 0) {
            $hours_of_work_week = $hours_of_work_week - ($countOffDayWeek * $hours_of_work_day);
        }
        if (isset($countOffDay) && $countOffDay != 0) {
            $hours_of_work_day = 0;
        }

        $result = $obj->getAllEmployee();
        while ($val = ($result)->fetch_assoc()) {

            $valextratime = ($obj1->getExtraTime($val['emp_id'], $date))->fetch_assoc();
            $countextra = $valextratime['extra_time'];
        $valextratime=($obj1->getExtraTimeweekly($val['emp_id'],$start,$end))->fetch_assoc();
       $value_extra_time_week=$valextratime['extra_time_week'];

            $gwhi = $obj1->getWorkingHoursIndividual($date, $val['emp_id']);
            $valuegwhi = ($gwhi)->fetch_assoc();
            $seconds1 = $valuegwhi['diff'] + $countextra;
            //current week working hours
            $result2 = $obj1->getWeeklyWorkingHoursIndividual($start, $end, $val['emp_id']);
            $value2 = ($result2)->fetch_assoc();
            $seconds2 = $value2['diff']+$value_extra_time_week;

            //check employee status 
            $emp_id = $val['emp_id'];
            $gas = $obj1->getAttendanceSummary($date, $emp_id);
            $valuegas = ($gas)->fetch_assoc();
            $countgas = ($gas)->num_rows;


            $gwlh = $obj2->getWeekLeaveHours($emp_id, $start, $end);
            $valuegwlh = ($gwlh)->fetch_assoc();

            $gsdlh = $obj2->getSpecificDayLeaveHours($emp_id, $date);
            $valuegsdlh = ($gsdlh)->fetch_assoc();
            $countSpecificDayLeaveHours = ($gsdlh)->num_rows;


            if ($countgas == 0) {   //if count=0 employee's are not in office
                if ($countOffDay == 1) {
                    $emp_status = '<span class="label label-info">Holiday</span>';
                } else {
                    $result4 = $obj2->getStaffLeaveDetail($emp_id, $date);
                    $count4 = ($result4)->num_rows;
                    if ($countSpecificDayLeaveHours > 0) {
                        $emp_status = '<span class="label label-info">On Leave</span>';
                    } else {
                        $emp_status = '<span class="label label-inverse">Drop Out</span>';
                    }
                }
            } else {
                if ($valuegas['logout_time'] == 0) {
                    $emp_status = '<span class="label label-success">Logged In</span>';
                } else {
                    $emp_status = '<span class="label label-important">Logged Out</span>';
                }
            }
            $hours = floor($seconds1 / (60 * 60));
            $divisor_for_minutes = $seconds1 % (60 * 60);
            $minutes = floor($divisor_for_minutes / 60);
//                          //weekly  
            $hours2 = floor($seconds2 / (60 * 60));
            $divisor_for_minutes2 = $seconds2 % (60 * 60);
            $minutes2 = floor($divisor_for_minutes2 / 60);
            ?> 
            <tr>
                <td><?php echo $val['name'] ?></td>
                <!--get current day working hours -->
                <td width="50"><?php
                $total_hours = $valuegsdlh['total_hours'];

                if ($countOffDay != 0) {
                    echo $must_work = $hours_of_work_day;
                } else {
                     $must_work = ($hours_of_work_day - $total_hours * 3600);
                }
                include_once 'functions.php';
                $ti = get_hours($must_work);
                echo $ti;
                echo "</td>";
                echo "<td>";
                if ($seconds1 > $must_work) {
                    echo '<span class="label label-success">' . $hours . ":" . $minutes . '</span>';
                } else {
                    echo '<span class="label label-important">' . $hours . ":" . $minutes . '</span>';
                } echo "</td>";
            ?>
                </td>
             
            </tr>
<?php } ?>
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
