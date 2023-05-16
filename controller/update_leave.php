<?php

session_start();
echo $emp_id = $_REQUEST['emp_id'];
$_SESSION['staff_id'] = $emp_id;
$annual = $_REQUEST['annual'];
$casual = $_REQUEST['casual'];
$medical = $_REQUEST['medical'];
$short = $_REQUEST['short'];

require_once '../model/leave.php';
$obj = new leave();

$count = mysql_num_rows($obj->getIndividualLeave($emp_id));
if ($count > 0) {
    $result = $obj->updateIndividualLeave($emp_id, $annual, $casual, $medical, $short);
    if ($result) {
        header("location:../view/employee_profile.php?show_staff=" . $emp_id);
    } else {
        echo 'failed';
    }
} else {
    $result = $obj->insertIndividualLeave($emp_id, $annual, $casual, $medical, $short);
    if ($result) {
        header("location:../view/employee_profile.php?show_staff=" . $emp_id);
    }
}
?>
