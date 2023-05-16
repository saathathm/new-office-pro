<?php

include_once 'conn.php';

class Cpanel {

    function add_time($add_time) {
        $db = new dbcon();
        $sql = "insert into office_time (start_time) values ('$add_time')";
        $result = $db->query($sql);
    }

    function get_office_time() {
        $db = new dbcon();
        $sql = "select * from office_time";
        $result = $db->query($sql);
        return $result;
    }

    function update_leave($leave_id, $leave_type, $no_of_days) {
        $db = new dbcon();
        $sql = "update leave_type set leave_type='$leave_type', no_of_days='$no_of_days' where leave_id='$leave_id'";
        $result = $db->query($sql);
        return $result;
    }

    function insertOffDay($date) {
        $db = new dbcon();
        $sql = "insert into off_day(date) value('$date')";
        $result = $db->query($sql);
        return $result;
    }
    function deleteOffDay($off_id) {
        $db = new dbcon();
        $sql = "DELETE FROM off_day WHERE id='$off_id'";
        $result = $db->query($sql);
        return $result;
    }

    function getOffDay() {
        $db = new dbcon();
        $sql = "SELECT * FROM off_day";
        $result = $db->query($sql);
        return $result;
    }

    function getOffDayCalendar($date) {
        $db = new dbcon();
        $sql = "SELECT * FROM off_day WHERE date='$date'";
        $result = $db->query($sql);
        return $result;
    }

    function getSpecificOffDay($date) {
        $db = new dbcon();
        $sql = "SELECT * FROM off_day where date='$date'";
        $result = $db->query($sql);
        return $result;
    }

    function getSpecificOffDayWeek($start, $end) {
        $db = new dbcon();
        $sql = "SELECT * FROM off_day where date between '$start' and '$end'";
        $result = $db->query($sql);
        return $result;
    }
	 function get_employee_detais($id){
         $db = new dbcon();
        $sql = "SELECT * FROM employee where emp_id=$id";
        $result = $db->query($sql);
        return $result;
    }


}

?>
