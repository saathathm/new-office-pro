<?php

//time kee
include_once 'conn.php';

class newLeave {

    function getLeave() {
        $db = new dbcon();
        $sql = "select * from leave_type";
        $result = $db->query($sql);
        return $result;
    }

    function getIndividualLeave($emp_id) {
        $db = new dbcon();
        $sql = "select * from individual_leave_setting where emp_id='$emp_id' and is_active=1";
        $result = $db->query($sql);
        return $result;
    }

    function getTakenLeave($emp_id, $where_in,$currentyear) {
        $db = new dbcon();
        $sql = "SELECT leave_id,sum(total_hours) as total_hours FROM staff_leave_detail sl, staff_leave_date sd WHERE  sl.emp_id='$emp_id' and sl.approval!=2 and sl.id=sd.app_id  and YEAR(leave_on) ='$currentyear' and sl.leave_id IN ($where_in)group by leave_id";
        $result = $db->query($sql);
        return $result;
    }
function getTakenLeaveForDetail($emp_id, $where_in,$current_year) {
        $db = new dbcon();
       $sql = "SELECT leave_id,sum(total_hours) as total_hours FROM staff_leave_detail sl, staff_leave_date sd WHERE  sl.emp_id='$emp_id' and sl.approval=1 and sl.id=sd.app_id and YEAR(leave_on) ='$current_year' and sl.leave_id IN ($where_in)group by leave_id";
        $result = $db->query($sql);
        return $result;
    }

    function insertIndividualLeave($emp_id, $annual, $casual, $medical, $short) {
        $db = new dbcon();
        $sql = "insert into individual_leave_setting(emp_id,annual,casual,medical,short_leave) value('$emp_id','$annual','$casual','$medical','$short')";
        $result = $db->query($sql);
        return $result;
    }

    function updateIndividualLeave($emp_id, $annual, $casual, $medical, $short) {
        $db = new dbcon();
        $sql = "update individual_leave_setting set annual='$annual',casual='$casual',medical='$medical',short_leave='$short' where emp_id='$emp_id'";
        $result = $db->query($sql);
        return $result;
    }

    function getLeaveType($leave_id) {
        $db = new dbcon();
        $sql = "select * from leave_type where leave_id='$leave_id'";
        $result = $db->query($sql);
        return $result;
    }

    function applyLeave($emp_id, $leave_type, $appliedDate, $from, $to, $total_duration, $reason, $dates_array) {
        $db = new dbcon();
        
        $sql = "insert into staff_leave_detail(emp_id,leave_id,applied_date,reason) value('$emp_id','$leave_type','$appliedDate','$reason')";
        $result = $db->query($sql);

        // $last_insert_id = mysqli_insert_id();
        $sql = "SELECT app_id FROM staff_leave_date order by app_id DESC";
        $app_id = mysqli_fetch_assoc($db->query($sql));
        $last_insert_id = ++$app_id['app_id'];
        
        foreach ($dates_array as $leave_on) {
            //  echo $leave_on;
            $sql = "insert into staff_leave_date(app_id,leave_on,total_hours) value('$last_insert_id','$leave_on','$total_duration')";
            $result = $db->query($sql);
            // print_r($last_insert_id);
            // print_r('//');
            // print_r($leave_on);
            // print_r('//');
            // print_r($total_duration);
            // print_r('//');
        }
    }

    function checkLeaveOverlap($emp_id, $from, $to) {  //put approval!=rejected
        $db = new dbcon();
        $sql = "SELECT leave_on,leave_id,total_hours FROM staff_leave_detail,staff_leave_date WHERE staff_leave_date.leave_on between '$from' and '$to' and staff_leave_detail.emp_id='$emp_id'  and staff_leave_detail.id=staff_leave_date.app_id";
        $result = $db->query($sql);
        return $result;
    }

    function getEmpLeavesforApprove() {
        $db = new dbcon();
        $sql = "SELECT * FROM staff_leave_detail sl,employee e,leave_type l where  sl.emp_id=e.emp_id and sl.leave_id=l.leave_id order by sl.id DESC";
        $result = $db->query($sql);
        return $result;
    }

    // function getEmpLeavesforApprove() {
    //     $db = new dbcon();
    //     $sql = "SELECT * FROM staff_leave_detail sl,employee e,leave_type l, staff_leave_date sld, leave_detail ld where  sl.emp_id=e.emp_id and sl.leave_id=l.leave_id and e.emp_id = ld.emp_id and ld.app_id = sld.app_id order by sld.app_id DESC";
    //     $result = $db->query($sql);
    //      return $result;
    // }

    function getEmpTotalLeavesHours($id) {
        $db = new dbcon();
        $sql = "SELECT * FROM staff_leave_date where app_id='$id'";
        $result = $db->query($sql);
        return $result;
    }

    function getEmpLeaveRequest() {
        $db = new dbcon();
        $sql = "SELECT app_id FROM `leave_detail` where approval='' and total_hours!=''";
        $result = $db->query($sql);
        return $result;
    }

    function approvedLeave($app_id) {
        $sql = "update leave_detail set approval='approved',rejected_reason='' where app_id='$app_id'";
        $db = new dbcon();
        $result = $db->query($sql);
        return $result;
    }

    function rejectLeave($app_id, $reject_reason) {
        $db = new dbcon();
        $sql = "update leave_detail set approval='rejected', rejected_reason='$reject_reason' where app_id=$app_id";
        $result = $db->query($sql);
        return $result;
    }

    function getLeaveHistory($emp_id) {
        $db = new dbcon();
        $sql = "SELECT * FROM `leave_detail`,`leave_type`,`employee` where  leave_detail.leave_id = leave_type.leave_id && 
          leave_detail.emp_id=employee.emp_id && leave_detail.emp_id='$emp_id' group by app_id";
        $result = $db->query($sql);
        return $result;
    }

    function getLeaveDetail($emp_id, $date3) {
        $db = new dbcon();
        $sql = "SELECT * FROM leave_detail 
            WHERE (`leave_from`<='$date3'
                AND `leave_to`>='$date3') AND emp_id='$emp_id' AND approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

    function getStaffLeaveDetail($emp_id, $date) {
        $db = new dbcon();
        $sql = "SELECT * FROM staff_leave_detail sl,staff_leave_date sd WHERE
              sl.id=sd.app_id AND
              sd.leave_on='$date' AND sl.emp_id='$emp_id'AND sl.approval=1 ";
        $result = $db->query($sql);
        return $result;
    }

    function getLeaveDetail2($emp_id) {
        $db = new dbcon();
        $sql = "SELECT *,sum((5 * (DATEDIFF(`leave_to`,`leave_from`) DIV 7) + MID('0123444401233334012222340111123400012345001234550', 7 * WEEKDAY(`leave_from`) + WEEKDAY(`leave_to`) + 1, 1))) as no_days FROM `leave_detail` WHERE emp_id='$emp_id' and approval='Approved'";
        $result = $db->query($sql);
        return $result;
    }

    function getLeaveDetail3($emp_id) {
        $db = new dbcon();
        $sql = "SELECT * FROM `leave_detail` WHERE emp_id='$emp_id' and approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

    function getShortLeaveDetail($emp_id, $date) {
        $db = new dbcon();
        $sql = "SELECT * FROM `leave_detail` WHERE emp_id='$emp_id' and leave_from='$date' and approval='approved' and leave_id='5'";
        $result = $db->query($sql);
        return $result;
    }

    function getShortLeaveHours($emp_id, $date) {
        $db = new dbcon();
        $sql = "SELECT sum(`total_hours`) as s_hours FROM `leave_detail` WHERE emp_id='$emp_id' and leave_from='$date' and approval='approved' and leave_id='5'";
        $result = $db->query($sql);
        return $result;
    }

    function getHalfLeaveHours($emp_id, $date) {
        $db = new dbcon();
        $sql = "SELECT sum(`total_hours`) as h_hours FROM `leave_detail` WHERE emp_id='$emp_id' and leave_from='$date' and approval='approved' and leave_id='4'";
        $result = $db->query($sql);
        return $result;
    }

    function getHalfDayLeaveDetail($emp_id, $date) {
        $db = new dbcon();
        $sql = "SELECT * FROM `leave_detail` WHERE emp_id='$emp_id' and leave_from='$date' and approval='approved' and leave_id='4'";
        $result = $db->query($sql);
        return $result;
    }

    function getShortLeaveDetailWeek($start, $end, $emp_id) {
        $db = new dbcon();
        $sql = "SELECT SUM(total_hours) as s_total_hours  FROM `leave_detail` WHERE emp_id='$emp_id' and (leave_from between '$start' and '$end') and approval='approved' and leave_id='5' group by leave_id";
        $result = $db->query($sql);
        return $result;
    }

    function getHalfDayLeaveDetailWeek($emp_id, $start, $end) {
        $db = new dbcon();
        $sql = "SELECT SUM(total_hours) as h_total_hours FROM `leave_detail` WHERE emp_id='$emp_id' and (leave_from between '$start' and '$end') and approval='approved' and leave_id='4' group by leave_id";

        $result = $db->query($sql);
        return $result;
    }

    function getLeaveDetailWeek($emp_id, $start, $end) {
        $db = new dbcon();
        $sql = "SELECT * FROM `leave_detail` WHERE emp_id='$emp_id' and leave_id<=3 and approval='approved' and
        (((`leave_from` <'$start') AND (`leave_to`>'$end'))
        ||( `leave_from`  between '$start' and '$end') || (`leave_to`  between '$start' and '$end'))";

        $result = $db->query($sql);
        return $result;
    }

    function check_date($from, $to) {
        $from = date("Y-m-d", $from);
        $to = date("Y-m-d", $to);
        $no_days = 0;
        $numbers_of_days = 1;
        while ($from != $to) {
            $start_time = strtotime($from);
            $dw = date("w", $start_time);
            if ($dw != 0 && $dw != 6) {
                $no_days++;
            }
            $from = date("Y-m-d", (strtotime("+$numbers_of_days days" . $from)));
        }
        return $no_days;
    }

    function getAllLeaveDetail($emp_id) {
        $db = new dbcon();
        $sql = "SELECT leave_detail.leave_id,sum(leave_detail.`total_hours`) as total_hours FROM `leave_detail`,leave_type WHERE emp_id='$emp_id' and leave_detail.leave_id=leave_type.leave_id group by leave_detail.`leave_id`";
        $result = $db->query($sql);
        return $result;
    }

    function getAnnualLeaveDetail($emp_id) {
        $db = new dbcon();
        $sql = "SELECT leave_detail.leave_id,sum(leave_detail.`total_hours`) as total_hours FROM `leave_detail`,leave_type WHERE emp_id='$emp_id' and leave_detail.leave_id=leave_type.leave_id and leave_detail.leave_id='3' and leave_detail.approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

    function getMedicalLeaveDetail($emp_id) {
        $db = new dbcon();
        $sql = "SELECT leave_detail.leave_id,sum(leave_detail.`total_hours`) as total_hours FROM `leave_detail`,leave_type WHERE emp_id='$emp_id' and leave_detail.leave_id=leave_type.leave_id and leave_detail.leave_id=2 and leave_detail.approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

    function getCasualLeaveDetail($emp_id) {
        $db = new dbcon();
        $sql = "SELECT leave_detail.leave_id,sum(leave_detail.`total_hours`) as total_hours FROM `leave_detail`,leave_type WHERE emp_id='$emp_id' and leave_detail.leave_id=leave_type.leave_id and leave_detail.leave_id=1 and leave_detail.approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

    function getShortLeaveDetail2($emp_id) {
        $db = new dbcon();
        $sql = "SELECT leave_detail.leave_id,sum(leave_detail.`total_hours`) as total_hours FROM `leave_detail`,leave_type WHERE emp_id='$emp_id' and leave_detail.leave_id=leave_type.leave_id and leave_detail.leave_id=5 and leave_detail.approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

    function getLeaveDetailNew($emp_id) {
        $db = new dbcon();
        $sql = "SELECT sl.leave_id,SUM(sd.total_hours) as total_hours FROM staff_leave_detail sl,staff_leave_date sd WHERE sl.id=sd.app_id AND sl.emp_id='$emp_id' AND  sl.approval=1 GROUP BY sl.leave_id";
        $result = $db->query($sql);
        return $result;
    }

    function eventcalander() {
        $db = new dbcon();
        $sql = "select *from leave detail";
    }

    function getAllLeaveDetailHours($emp_id) {
        $db = new dbcon();
        $sql = "SELECT leave_detail.leave_id,sum(leave_detail.`total_hours`) as total_hours FROM `leave_detail`,leave_type WHERE emp_id='$emp_id' and leave_detail.leave_id=leave_type.leave_id and leave_detail.leave_id=5 and leave_detail.approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

    function checkShortLeaveExceeded($emp_id, $month, $year) {
        $db = new dbcon();
        $sql = "select * from staff_leave_detail,staff_leave_date where emp_id='$emp_id' and staff_leave_detail.id=staff_leave_date.app_id and MONTH(leave_on)='$month' and YEAR(leave_on)='$year' and leave_id='5'";
        $result = $db->query($sql);
        return $result;
    }

    function checkHalfDayLeave($emp_id, $from) {
        $db = new dbcon();
        $sql = "select * from staff_leave_detail,staff_leave_date where staff_leave_detail.emp_id='$emp_id'  and  staff_leave_detail.id=staff_leave_date.app_id and staff_leave_date.leave_on='$from' and staff_leave_date.total_hours='4'";

        $result = $db->query($sql);
        return $result;
    }

    function checkShortLeave($emp_id, $from) {
        $db = new dbcon();
        $sql = "select * from staff_leave_detail,staff_leave_date where staff_leave_detail.emp_id='$emp_id'  and  staff_leave_detail.id=staff_leave_date.app_id and staff_leave_date.leave_on='$from' and staff_leave_date.total_hours='1.5'";
        $result = $db->query($sql);
        return $result;
    }

    function deleteLeave($app_id) {
        $db = new dbcon();
        $sql = "delete from leave_detail where app_id='$app_id' and approval=''";
        $result = $db->query($sql);
        return $result;
    }

    function calendarEvent($date) {
        $db = new dbcon();
        $sql = "select * from leave_detail,employee where  employee.emp_id=leave_detail.emp_id AND (leave_detail.leave_from<='$date' AND leave_detail.leave_to>='$date') AND approval='approved'";
        $result = $db->query($sql);
        return $result;
    }

   // function calendarEventIndividual($date, $emp_id) {
      //  $db = new dbcon();
      //  $sql = "select * from leave_detail,employee where  employee.emp_id=leave_detail.emp_id AND (leave_detail.leave_from<='$date' AND leave_detail.leave_to>='$date') AND leave_detail.emp_id='$emp_id' AND approval='approved'";
      //  $result = $db->query($sql);
      //  return $result;
   // }
function calendarEventIndividual($date, $emp_id) {
        $db = new dbcon();
        $sql = "SELECT *
FROM staff_leave_detail sl, employee e, staff_leave_date sd
WHERE sl.emp_id = e.emp_id AND sl.emp_id='$emp_id'
AND sl.id = sd.app_id AND sd.leave_on='$date'";
        $result = $db->query($sql);
        return $result;
    }

    function planAnnualLeave($emp_id, $year) {
        $db = new dbcon();
        $sql = "SELECT * FROM `leave_detail`,`leave_type`,`employee` where  leave_detail.leave_id = leave_type.leave_id && 
          leave_detail.emp_id=employee.emp_id && leave_detail.emp_id='$emp_id' && YEAR(leave_detail.leave_from)='$year' && leave_detail.leave_id='3'";
        $result = $db->query($sql);
        return $result;
    }

    function dayLeaveDetail($emp_id, $date) {// din not complete
        $db = new dbcon();
        $sql = "SELECT * FROM `leave_detail` WHERE emp_id='$emp_id' and (leave_from<='$date' and leave_to>='$date') and approval='approved' and (leave_id='1' or leave_id='2' or leave_id='3') group by app_id";
        $result = $db->query($sql);
        return $result;
    }

    function getSpecificDayLeaveHours($emp_id, $date) {
        $db = new dbcon();
        $sql = "SELECT sum(total_hours) as total_hours FROM `staff_leave_detail`,`staff_leave_date` WHERE emp_id='$emp_id' and staff_leave_detail.id=staff_leave_date.app_id and leave_on='$date' and approval=1  group by app_id";
        $result = $db->query($sql);
        return $result;
    }

    function getWeekLeaveHours($emp_id, $start, $end) {
        $db = new dbcon();
        $sql = "SELECT sum(total_hours) as total_hours_week FROM `staff_leave_detail`,`staff_leave_date` WHERE emp_id='$emp_id' and
      leave_on between '$start' and '$end' and  staff_leave_detail.id=staff_leave_date.app_id and approval=1";
        $result = $db->query($sql);
        return $result;
    }

}
?>


