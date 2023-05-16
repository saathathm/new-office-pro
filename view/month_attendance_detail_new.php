<?php
include_once 'user.php';
include_once '../model/leave.php';
include_once '../model/employee.php';
include '../model/gen_function.php';

if (isset($_REQUEST['date'])) {
    $_SESSION['date'] = $_REQUEST['date'];
}
if (isset($_SESSION['date'])) {
    $date = $_SESSION['date'];
} else {
    $date = time();
}
if (isset($_REQUEST['emp_id'])) {
    $_SESSION['staff_id'] = $_REQUEST['emp_id'];
} else {
    $_SESSION['staff_id'] = $_SESSION['emp_id'];
}

$Y=date("Y",$date);
$m=date("m",$date);

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
$result5 = $objGen->getSumLeaveDetailNew($_SESSION['staff_id'],$m,$Y);
$value5 = mysqli_fetch_assoc($result5);
$leave_total_hours = $value5['total_hours'] * 3600;//qq

$result2 = $objGen->getMonthlyWorkingHoursDetailIndividual($_SESSION['staff_id'],$m,$Y);
$value2 = mysqli_fetch_assoc($result2);
$result3 = $objGen->getExtraTimemonthly($_SESSION['staff_id'], $m, $Y);
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
<form class="form-horizontal" action="" method="get">
    <div class="control-group">
        <label class="control-label" for="inputEmail">Staff Name</label>
        <select name="emp_id" id="emp_id">
            <option></option>
            <?php
            $result_emp = $obj->getAllEmployee();
            while ($value_emp = mysqli_fetch_assoc($result_emp)) {
                //if($val2['leave_id']==3){continue;}
                ?>   
                <option value="<?php echo $value_emp['emp_id']; ?>">
                    <?php echo $value_emp['name']; ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" name="submit" class="btn btn-primary" value="View Staff"> 
    </div>

</form>

<div class="span12 "><table align="center"><tr><td><?php
            $result_name = $obj->getEmployee($_SESSION['staff_id']);
            $value_name = mysqli_fetch_assoc($result_name);
            echo"Detailed Report-<b>" . "&nbsp" . $value_name['name'] . "</b>";
            ?></td></tr></table></div>
<div class="span12"><span class="label label-warning">Must Work Month  <?php echo $hours1.":".$minutes1; ?> </span>
<span class="label label-inverse">Total worked Hours  <?php echo $hours2.":".$minutes2; ?> </span>
</div>

<?php

$action = "month_attendance_detail";
$include_file_path = "month_attendance_events_new.php";

include 'Calendar.php';

$cal = new Calendar($date, $_SESSION['staff_id']);
$cal->makeCalendar($action, $include_file_path);
$date = time();
?>
   
