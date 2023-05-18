<?php
ob_start();
date_default_timezone_set('Asia/Colombo');
require_once '../model/new_leave.php';
require_once '../model/cpanel.php';
$obj = new newLeave();
$obj1 = new Cpanel();
include_once '../view/leave_balance.php';
$currentyear = date("Y");

$redirect_path = "apply_leave_by_admin";
echo $emp_id = $_POST['emp_id'];
//get entitlement leaves and leave taken by employee
$result_leave_type = $obj->getLeave();

while ($value = mysqli_fetch_array($result_leave_type)) {
    $value_leave_id[] = $value['leave_id'];
}
$where_in = implode(',', $value_leave_id);
$rrr = Leave_balance($emp_id, $where_in, $currentyear);
//get staff's taken leave
// $result_taken_leave = $obj->getTakenLeave($emp_id, $where_in,$currentyear);
//   while ($value_taken_leave_array[] = mysqli_fetch_array($result_taken_leave));
//   $count_indi_leave = mysqli_num_rows($result2 = $obj->getIndividualLeave($emp_id)); 
//    if ($count_indi_leave > 0) {
//        $result1 = $obj->getIndividualLeave($emp_id);
//        $value_ini_leave = mysqli_fetch_assoc($result1);
//
//
//        $common_leave_array[1] = $value_ini_leave['annual'];
//        $common_leave_array[2] = $value_ini_leave['casual'];
//        $common_leave_array[3] = $value_ini_leave['medical'];
//        $common_leave_array[5] = $value_ini_leave['short_leave'];
//    } else {        
//        $result1 = $obj->getLeave();
//        while ($value_common_leave[] = mysqli_fetch_row($result1));
//         
//        $common_leave_array[1] = $value_common_leave[0][2];  //as annual
//        $common_leave_array[2] = $value_common_leave[1][2];  //as casual
//        $common_leave_array[3] = $value_common_leave[2][2];   //as medical
//        $common_leave_array[5] = $value_common_leave[3][2];   //short_leave
//    }


$leave_type = $_POST['leaveType'];
echo $appliedDate = $_POST['appliedDate'];
$duration = $_POST['duration'];
///// assign full day,half day and short hours
if ($leave_type == 1) {
    $temp_leave_type = 1;
}
if ($leave_type == 2) {
    $temp_leave_type = 2;
}
if ($leave_type == 3) {
    $temp_leave_type = 3;
}
if ($leave_type == 6) {
    $temp_leave_type = 6;
}
if ($duration == "fday") {
    $total_duration = 8;
}
if ($duration == "hday") {
    $total_duration = 4;
    $temp_leave_type = 4;
}
if ($leave_type == 5) {
    $total_duration = 1.5;
    $temp_leave_type = 5;
}

//////leave duration
$from = $_POST['from'];
$to = $_POST['to'];
$month = date("m", strtotime($from));
$year = date("Y", strtotime($from));
$reason = $_POST['reason'];
/////////////////////////
//get date range array excluding weekends
$dates_array = array();
$step = '+1 day';
$format = 'Y-m-d';
$current = strtotime($from);
$last = strtotime($to);
while ($current <= $last) {
    if (date("D", $current) != "Sun" && date("D", $current) != "Sat")
        $dates_array[] = date($format, $current);
    $current = strtotime($step, $current);
}
///get off day date array
$getOffDayWeek = $obj1->getSpecificOffDayWeek($from, $to);
$countOffDayWeek = mysqli_num_rows($getOffDayWeek);
$array_off_day = array();
while ($value_off_day = mysqli_fetch_assoc($getOffDayWeek)) {
    $array_off_day[] = $value_off_day['date'];
}
///
$date_diff = array_intersect($dates_array, $array_off_day);

///remove off day dates
foreach ($date_diff as $key => $value) {
    unset($dates_array[$key]);
}
$count_applied_leave_array = count($dates_array);
if (empty($dates_array)) {
    header("location:../view/$redirect_path.php?l=2");
    exit();
}
///////////////
//check short leave execeeded
$total_apply_leave_duration = $count_applied_leave_array * $total_duration;
$annual = 0;
$casual = 0;
$medical = 0;
$leave_duration = 0;
foreach ($rrr[1] as $array_value) {
    if ($array_value[0] == $leave_type) {
        $leave_duration = $array_value[1];
    }
}
echo "--" . $leave_duration;
// $common_leave_array[$leave_type] * 8;

if ($leave_type == 1 || $leave_type == 2 || $leave_type == 3) {   // echo 'ld--'.$leave_duration.'tal--'.$total_apply_leave_duration.'ta--'.$rrr[0][$leave_type] * 8; die;
    if ($leave_duration + $total_apply_leave_duration <= $rrr[0][$leave_type] * 8) {
    } else {
        header("location:../view/$redirect_path.php?l=1");
        exit();
    }
}
$count1 = mysqli_num_rows($obj->checkShortLeaveExceeded($emp_id, $month, $year));
//////////////////
//check leave balance exceeded

$result = $obj->checkLeaveOverlap($emp_id, $from, $to);
while ($value = mysqli_fetch_assoc($result)) {
    $leave_array[] = $value['leave_on'];
    $total_hours[] = $value['total_hours'];
}
$date_diff = @array_intersect($dates_array, $leave_array);

if (!$date_diff) { //no over laps
    if ($temp_leave_type == 5) {
        if ($count1 <= 1) {
            $obj->applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason, $dates_array);
            header("location:../view/$redirect_path.php?s=2");
        } else {
            header("location:../view/$redirect_path.php?f=1");
        }
    } else {
        $obj->applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason, $dates_array);
        header("location:../view/$redirect_path.php?s=2");
    }
} else { //overlap dates 
    if ($temp_leave_type == 5 || $temp_leave_type == 4) {
        if (!in_array(8, $total_hours)) {
            $count1 = mysqli_num_rows($obj->checkShortLeaveExceeded($emp_id, $month, $year));
            $count2 = mysqli_num_rows($obj->checkHalfDayLeave($emp_id, $from));
            $count3 = mysqli_num_rows($obj->checkShortLeave($emp_id, $from));
            switch ($temp_leave_type) {
                case 5:

                    if ($count1 >= 2) {
                        header("location:../view/$redirect_path.php?f=1");
                    }  //short leave execeeded of current month
                    elseif ($count2 >= 2) {
                        header("location:../view/$redirect_path.php?s=1");
                    } // alert failed to submit
                    else {
                        $obj->applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason, $dates_array);
                        header("location:../view/$redirect_path.php?s=2");
                    }
                    break;
                case 4:

                    if ($count2 >= 2) {
                        header("location:../view/$redirect_path.php?s=1");
                    } elseif ($count2 == 0 && $count3 > 2) {
                        header("location:../view/$redirect_path.php?s=1");
                    } elseif ($count2 == 1 && $count3 >= 1) {
                        header("location:../view/$redirect_path.php?s=1");
                    } else {
                        $obj->applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason, $dates_array);
                        header("location:../view/$redirect_path.php?s=2");
                    }
                    break;
                case (1 || 2 || 3):
                    header("location:../view/$redirect_path.php?s=1");
                    break;
                default:
                    break;
            }
        } else {
            header("location:../view/$redirect_path.php?s=1");
        }
    } else {
        header("location:../view/$redirect_path.php?s=1");
    }
}
ob_flush();
