<?php
session_start();
if (!isset($_SESSION['emp_type'])) {
    header("Location:login.php");
}
include_once 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
require_once '../model/leave.php';
require_once '../model/employee.php';
require_once '../model/attendance.php';
require_once '../model/cpanel.php';
?>
<div class="container">
    <table class="table  rbborder">
        <thead style="background-color:#000; color:#fff;">
            <th></th>
            <th>Employee Name</th>
            <th colspan="2">Must work/Today(H:M)</th>
            <th colspan="2">Must work/Weekly(H:M)</th>
            <th>Status</th>
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
        $countOffDay = mysqli_num_rows($getOffDay);
        $countOffDayWeek = mysqli_num_rows($getOffDayWeek);

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
        // print_r($result);
        // die;
        $emp = 1;
        while ($val = mysqli_fetch_assoc($result)) {
            // print_r($val);
            // die;
            $valextratime = ($obj1->getExtraTime($val['emp_id'], $date));
            print_r('valextratime');
            print_r($valextratime);
            // die;
            $countextra = $valextratime['extra_time'];
            $valextratime = mysqli_fetch_assoc($obj1->getExtraTimeweekly($val['emp_id'], $start, $end));
            $value_extra_time_week = $valextratime['extra_time_week'];

            $gwhi = $obj1->getWorkingHoursIndividual($date, $val['emp_id']);
            $valuegwhi = mysqli_fetch_assoc($gwhi);
            $seconds1 = $valuegwhi['diff'] + $countextra;
            //current week working hours
            $result2 = $obj1->getWeeklyWorkingHoursIndividual($start, $end, $val['emp_id']);
            $value2 = mysqli_fetch_assoc($result2);
            $seconds2 = $value2['diff'] + $value_extra_time_week;

            //check employee status
            $emp_id = $val['emp_id'];
            $gas = $obj1->getAttendanceSummary($date, $emp_id);
            $valuegas = mysqli_fetch_assoc($gas);
            $countgas = mysqli_num_rows($gas);


            $gwlh = $obj2->getWeekLeaveHours($emp_id, $start, $end);
            $valuegwlh = mysqli_fetch_assoc($gwlh);

            $gsdlh = $obj2->getSpecificDayLeaveHours($emp_id, $date);
            $valuegsdlh = mysqli_fetch_assoc($gsdlh);
            $countSpecificDayLeaveHours = mysqli_num_rows($gsdlh);

            if ($countgas == 0) {   //if count=0 employee's are not in office
                if ($countOffDay == 1) {
                    $emp_status = '<span class="label label-info">Holiday</span>';
                } else {
                    $result4 = $obj2->getStaffLeaveDetail($emp_id, $date);
                    $count4 = mysqli_num_rows($result4);
                    if ($valuegsdlh['total_hours'] > 0) {
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
                <td><?= $emp; ?></td>
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
                                }
                                echo "</td>";
                                ?>
                </td>
                <!--get weekly working hours -->
                <td width="20">
                    <?php
                    $total_hours_week = $valuegwlh['total_hours_week'];
                    $must_work_week = ($hours_of_work_week - $total_hours_week * 3600);
                    $hours_week = floor($must_work_week / (60 * 60));
                    $divisor_for_minutes = $must_work_week % (60 * 60);
                    $minutes_week = floor($divisor_for_minutes / 60);
                    echo $hours_week . ":" . $minutes_week;


                    echo "</td>";
                    echo "<td>";

                    if ($seconds2 > $must_work_week) {
                        echo '<span class="label label-success">' . $hours2 . ':' . $minutes2 . '</span>';
                    } else {
                        echo '<span class="label label-important">' . $hours2 . ':' . $minutes2 . '</span>';
                    }
                    echo "</td>";
                    ?>
                <td><?php echo $emp_status;
                    ?> </td>

            </tr>

        <?php $emp++;
        } ?>
    </table>

</div>