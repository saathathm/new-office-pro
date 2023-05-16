<?php
include_once 'conn.php';
 class GeneralFunction{
 function staffAttendanceDetail($date,$emp_id){
    $db=new dbcon();
    $sql="select * from attendance_log al,employee e where  al.date='$date' and al.emp_id='$emp_id' and  al.emp_id=e.emp_id and e.active_status='yes' and al.status='approved' order by al.login_time asc";
    $result=$db->query($sql);
    return $result;
   }
   function getLeaveDetail($date,$emp_id){
    $db=new dbcon();
    $sql="SELECT * FROM leave_detail ld,leave_type lt,employee e where  ld.leave_id = lt.leave_id && 
          ld.emp_id=e.emp_id && ld.emp_id='$emp_id' && ld.leave_from='$date' and ld.approval='approved' group by ld.app_id";
      $result=$db->query($sql); 
      return $result;
    }
    function getSumLeaveDetail($emp_id,$month,$year){
    $db=new dbcon();
     $sql="SELECT sum(total_hours) as total_hours FROM leave_detail ld,leave_type lt,employee e where  ld.leave_id = lt.leave_id and 
          ld.emp_id=e.emp_id and ld.emp_id='$emp_id' and MONTH(leave_from)='$month' and YEAR(leave_from)='$year' and ld.approval='approved'";
      $result=$db->query($sql); 
      return $result;
    }
    function getMonthlyWorkingHoursDetailIndividual($emp_id,$month,$year){
    $db=new dbcon();
   $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and  `logout_time`!=0 and MONTH(date)='$month' and YEAR(date)='$year' and status='approved' and attendance_log.emp_id='$emp_id'";
    $result=$db->query($sql);
    return $result;
   }
   function getExtraTimemonthly($emp_id,$month,$year){
    $db=new dbcon();
    $sql="select sum(extra_time) as extra_time_month from extra_time where emp_id='$emp_id' and MONTH(date)='$month' and YEAR(date)='$year'";
    $result=$db->query($sql);
    return $result;
   }
   function getOffDay($month,$year){
    $db=new dbcon();
    $sql="SELECT * FROM off_day where MONTH(date)='$month' and YEAR(date)='$year'"; 
    $result=$db->query($sql);
    return $result;
   }
  function getLeaveDetailNew($date, $emp_id) {
        $db = new dbcon();
        $sql = "SELECT lt.leave_type,sd.total_hours
FROM staff_leave_detail sl, employee e, staff_leave_date sd,leave_type lt
WHERE sl.emp_id = e.emp_id AND sl.emp_id='$emp_id' AND sl.leave_id = lt.leave_id AND sl.approval='1' 
AND sl.id = sd.app_id AND sd.leave_on='$date'";
        $result = $db->query($sql);
        return $result;
    }
    function getSumLeaveDetailNew($emp_id, $month, $year) {
        $db = new dbcon();
     $sql = "SELECT sum(total_hours) as total_hours FROM staff_leave_detail ld,leave_type lt,employee e,staff_leave_date sd 
            where  ld.leave_id = lt.leave_id and 
          ld.emp_id=e.emp_id and ld.emp_id='$emp_id' and MONTH(leave_on)='$month' and YEAR(leave_on)='$year' and ld.approval=1 and ld.id=sd.app_id";
        $result = $db->query($sql);
        return $result;
    }
 function getCurrentMonthWorkingDays($Y,$m) {
 $query_date = "$Y-$m-01";
        $last_query=date('Y-m-t', strtotime($query_date));
        $first_second = date($query_date);
        $last_second = date($last_query);

        $dates_array = array();
        $step = '+1 day';
        $format = 'Y-m-d';
        $current = strtotime($first_second);
        $last = strtotime($last_second);
        while ($current <= $last) {
            if (date("D", $current) != "Sun" && date("D", $current) != "Sat")
                $dates_array[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates_array;
    }
}
?>
