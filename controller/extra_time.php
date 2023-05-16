<?php

require_once '../model/attendance.php';
$obj = new attendance();
$emp_id = $_REQUEST['emp_id'];
$extra_status = $_REQUEST['extra_status'];
$extra_time = $_REQUEST['extra_time'];
$date=$_REQUEST['idate'];

$result = $obj->getExtraTime($emp_id, $date);
$count = mysql_num_rows($result);
if ($count == 1) {
$result = $obj->UpdateExtraTime($emp_id,$extra_time,$date,$extra_status); 
  header("Location:../view/addExtraTime.php?date3=$date");
} else {

    $result = $obj->InsertExtraTime($emp_id,$extra_time,$date,$extra_status);
    header("Location:../view/addExtraTime.php?date3=$date");
}
?>
