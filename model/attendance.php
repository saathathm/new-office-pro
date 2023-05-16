<?php

include_once 'conn.php';
class attendance{
    
    function addLoginTime($emp_id,$login,$date){
    $db=new dbcon();
    $sql="insert into attendance_log(emp_id,login_time,date,status)value('$emp_id','$login','$date','approved')";
    $db->query($sql);
   }
   function addNoteLoginTime($emp_id,$from,$to,$date2,$note){
    $db=new dbcon();
    $sql="insert into attendance_log(emp_id,login_time,logout_time,date,login_note,status)value('$emp_id','$from','$to','$date2','$note','pending')";
    $db->query($sql);
   }
   function checkOverlapNote($emp_id,$from,$to,$date2){
    $db=new dbcon();
    $sql="SELECT `id` FROM `attendance_log` WHERE emp_id='$emp_id' and date='$date2' and status!='rejected' and 
        (((login_time <'$from') AND (logout_time>'$to'))
        ||( login_time  between '$from' and '$to') || (logout_time  between '$from' and '$to') )
         GROUP BY `id`";
    
    $result=$db->query($sql);
    return $result;
   }
   function checkOverlapNote2($employee_id,$from,$to,$date,$id){
    $db=new dbcon();
    $sql="SELECT `id` FROM `attendance_log` WHERE emp_id='$employee_id' and date='$date' and status!='rejected' and id!='$id' and status!='rejected' and
        (((login_time <'$from') AND (logout_time>'$to'))
        ||( login_time  between '$from' and '$to') || (logout_time  between '$from' and '$to') )
         GROUP BY `id`";
   
    $result=$db->query($sql);
    return $result;
   }
   
   function getAttendanceDetail($emp_id,$date3){
    $db=new dbcon();
    $sql="select * from attendance_log where emp_id='$emp_id' AND date='$date3' ORDER BY `attendance_log`.`login_time` ASC";
    $result=$db->query($sql);
    return $result;
   }
   function getAllAttendanceDetailByDay($employee_id,$date4){
    $db=new dbcon();
    $sql="select * from attendance_log,employee where date='$date4' and employee.emp_id=attendance_log.emp_id and attendance_log.emp_id='$employee_id'";
    $result=$db->query($sql);
    return $result;
   }
    function getAllAttendanceDetail($date,$emp_id){
    $db=new dbcon();
    $sql="select * from attendance_log where date='$date' and emp_id='$emp_id' ORDER BY login_time ASC";
    $result=$db->query($sql);
    return $result;
   }
   function getAttendanceSummary($date3,$emp_id){
    $db=new dbcon();
    $sql="select * from attendance_log where emp_id='$emp_id' and date='$date3' and login_note='' and status='approved' order by id desc limit 1";
     
    $result=$db->query($sql);
    return $result;
   }
   function checkLogoutTime($emp_id){
    $db=new dbcon();
    $sql="select * from attendance_log where emp_id='$emp_id' AND logout_time='0'";
    $result=$db->query($sql);
    
    return $result;
   }
   function checkLogoutTime1($emp_id){
    $db=new dbcon();
    $sql="select * from attendance_log where emp_id='$emp_id' AND logout_time='0'";
    $result=$db->query($sql);
    
    return $result;
   }
    function updateLogoutTime($emp_id,$login,$date){
    $db=new dbcon();
    $sql="update attendance_log set logout_time='$login' where  emp_id='$emp_id' and logout_time='0' and date='$date'";
    $result=$db->query($sql);
    return $result;
   }
    function updateLateLogoutTime($emp_id,$time){
    $db=new dbcon();
    $sql="update attendance_log set logout_time='$time' where  emp_id='$emp_id' and logout_time='0'";
    $result=$db->query($sql);
    return $result;
   }
   function updateNoteLogoutTime($emp_id,$time,$date2,$note){
    $db=new dbcon();
    $sql="update attendance_log set logout_time='$time',logout_note='$note' where date='$date2' and emp_id='$emp_id' and logout_time='0'";
    $result=$db->query($sql);
    return $result;
   }
   function getPendingAttendanceDetail(){
    $db=new dbcon();
    $sql="select * from attendance_log,employee where attendance_log.status='pending' and attendance_log.emp_id=employee.emp_id";
    $result=$db->query($sql);
    return $result;
   }
   function approvePendingAttendance($id,$emp_name){
    $db=new dbcon();
    $sql="update attendance_log set status='approved',approved_by='$emp_name' where id='$id'";
    $result=$db->query($sql);
    return $result;
   }
   function getWorkingHoursDetail($date){
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and `logout_time`!=0 and date='$date' and status='approved' group by emp_id";
    $result=$db->query($sql);
    return $result;
   }
   function getWorkingHoursDetailIndividual($date,$emp_id){
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and `logout_time`!=0 and date='$date' and status='approved' and attendance_log.emp_id='$emp_id'";
    $result=$db->query($sql);
    return $result;
   }
   function getMonthlyWorkingHoursDetail($month,$year){
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and `logout_time`!=0 and MONTH(date)='$month' and YEAR(date)='$year' and status='approved' group by emp_id";
    $result=$db->query($sql);
    return $result;
   }
   function getMonthlyWorkingHoursDetailIndividual($emp_id,$month,$year){
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and  `logout_time`!=0 and MONTH(date)='$month' and YEAR(date)='$year' and status='approved' and attendance_log.emp_id='$emp_id'";
    $result=$db->query($sql);
    return $result;
   }
    function getWeeklyWorkingHoursDetail($start,$end){
       
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and `logout_time`!=0 and status='approved' and date between '$start' and '$end' group by emp_id";
    $result=$db->query($sql);
    return $result;
   }
   function checkEmployeeLogout($emp_id,$id){
       
    $db=new dbcon();
    $sql="SELECT * from attendance_log where emp_id='$emp_id' and id='$id' and logout_time='0' and status!='pending'";
    $result=$db->query($sql);
    return $result;
   }
   function addLogoutTime($emp_id,$id,$time,$admin_id){
       
    $db=new dbcon();
    $sql="UPDATE attendance_log set logout_time='$time',logout_by='$admin_id' where emp_id='$emp_id' and id='$id'";
    $result=$db->query($sql);
    return $result;
   }
   function addLateLogoutTime($emp_id,$id,$time){
       
    $db=new dbcon();
    $sql="UPDATE attendance_log set logout_time='$time' where emp_id='$emp_id' and id='$id'";
    $result=$db->query($sql);
    return $result;
   }
   function getWorkingHoursIndividual($date,$emp_id){
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`,`login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and `logout_time`!=0 and date='$date' and status='approved' and attendance_log.emp_id='$emp_id' group by emp_id";
    $result=$db->query($sql);
    return $result;
   }
   function getWeeklyWorkingHoursIndividual($start,$end,$emp_id){
       
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and `logout_time`!=0 and status='approved' and attendance_log.emp_id='$emp_id' and date between '$start' and '$end'";
    $result=$db->query($sql);
    return $result;
   }
   function rejectPendingAttendance($id,$emp_name){
    $db=new dbcon();
    $sql="update attendance_log set status='rejected',approved_by='$emp_name' where id='$id'";
    $result=$db->query($sql);
    return $result;
   }
   function reviewPendingAttendance($date3){
    $db=new dbcon();
    $sql="select * from attendance_log,employee where  attendance_log.date='$date3' and  attendance_log.emp_id=employee.emp_id and employee.active_status='yes' order by employee.name asc";
    $result=$db->query($sql);
    return $result;
   }
   function updateAttendanceDetail($id,$employee_id,$admin_id,$date,$from,$to){
    $db=new dbcon();
    $sql="update attendance_log set status='approved',login_time='$from',logout_time='$to',date='$date',edit_by='$admin_id' where id='$id' and emp_id='$employee_id'";
    $result=$db->query($sql);
    return $result;
   }
   function reduceTime($id,$employee_id,$date,$to){
    $db=new dbcon();
    $sql="update attendance_log set logout_time='$to' where id='$id' and emp_id='$employee_id' and date='$date'";
    $result=$db->query($sql);
    return $result;
   }
   function getDateRangeWorkingHoursIndividual($start,$end,$emp_id){
       
    $db=new dbcon();
    $sql="SELECT employee.name,attendance_log.emp_id,SUM(TIME_TO_SEC(TIMEDIFF(`logout_time`, `login_time`))) as diff FROM `attendance_log`,employee WHERE attendance_log.emp_id=employee.emp_id and `logout_time`!=0 and status='approved' and attendance_log.emp_id='$emp_id' and date between '$start' and '$end'";
    
    $result=$db->query($sql);
    return $result;
   }
   function getspecificDatePendingAttendanceDetail($date3,$emp_id){
    $db=new dbcon();
    $sql="select * from attendance_log,employee where attendance_log.status='pending' and attendance_log.emp_id=employee.emp_id and attendance_log.date='$date3' and attendance_log.emp_id='$emp_id' ";
    $result=$db->query($sql);
    return $result;
   }
   function getTimeStampDetail(){
    $db=new dbcon();
    $sql="select * from attendance_log where emp_id='2'";
    $result=$db->query($sql);
    return $result;
   }
   function getWorkingHoursSession($emp_id,$date){
    $db=new dbcon();
    $sql="SELECT *,TIME_TO_SEC(TIMEDIFF(`logout_time`,`login_time`)) as diff FROM `attendance_log` WHERE  date='$date'   and status!='rejected' and emp_id='$emp_id' group by id ORDER BY `attendance_log`.`login_time` ASC";
    $result=$db->query($sql);
    return $result;
   }
   function getCurrentWorkingHoursSession($emp_id,$date,$time){
    $db=new dbcon();
    $sql="SELECT *,TIME_TO_SEC(TIMEDIFF('$time',`login_time`)) as diff FROM `attendance_log` WHERE  date='$date'  and emp_id='$emp_id' and logout_time='0' group by id ORDER BY `attendance_log`.`login_time` ASC";
    $result=$db->query($sql);
    return $result;
   }
//    old
//   function getExtraTime($emp_id,$date){
//     $db=new dbcon();
//     $sql="select * from extra_time where emp_id='$emp_id' and date='$date'";
//     $result=$db->query($sql);
//     return $result;
//    }
// new
function getExtraTime($emp_id, $date) {
    $db = new dbcon();
    $sql = "SELECT * FROM extra_time WHERE emp_id='$emp_id' AND date='$date'";
    // print_r($emp_id);
    // print_r($date);
    // print_r($sql);
    $result = $db->query($sql);
    if ($result) {
        // print_r($result); // Print the contents of $row
        $row = mysqli_fetch_assoc($result);
        // print_r($row); // Print the contents of $row
        return $row;
    } else {
        return null;
    }
}


   function getExtraTimeweekly($emp_id,$start,$end){
    $db=new dbcon();
    $sql="select sum(extra_time) as extra_time_week from extra_time where emp_id='$emp_id' and (date between '$start' and '$end')";
    $result=$db->query($sql);
    return $result;
   }
    function getExtraTimemonthly($emp_id,$month,$year){
    $db=new dbcon();
    $sql="select sum(extra_time) as extra_time_month from extra_time where emp_id='$emp_id' and MONTH(date)='$month' and YEAR(date)='$year'";
    $result=$db->query($sql);
    return $result;
   }
    function InsertExtraTime($emp_id,$extra_time,$date,$extra_status){
    $db=new dbcon();
     $sql="INSERT INTO extra_time(`emp_id`, `extra_time`,`date`, `extra_status`) 
        VALUES ($emp_id,$extra_time,'$date',$extra_status)"; 
    $result=$db->query($sql);
    return $result;
   } 
    function UpdateExtraTime($emp_id,$extra_time,$date,$extra_status){ 
    $db=new dbcon();
    $sql="update extra_time set emp_id='$emp_id',date='$date',extra_time='$extra_time',extra_status='$extra_status' where emp_id='$emp_id' and date='$date'"; 
    $result=$db->query($sql);
    return $result;
   } 
   function countSession($date){
    $db=new dbcon();
    $sql="select c from
(
    select count(*) as c from attendance_log where date='$date' group by emp_id
) tmp
order by c desc limit 1";
    $result=$db->query($sql);
    return $result;
   } 
   function countSessionIndividual($date,$emp_id){
    $db=new dbcon();
    $sql="select ci from
(
    select count(*) as ci from attendance_log where date='$date' and emp_id='$emp_id'
) tmp
order by ci desc limit 1";
    $result=$db->query($sql);
    return $result;
   } 
}
