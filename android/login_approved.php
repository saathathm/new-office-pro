<?php
/**
 * Login Approved
 */

//header('Content-type: application/json');
require_once("connection.php");



$emp_id = $_POST['emp_id'];
$date=date("Y-m-d");
$login=date("H:i:s");


$res = $sql->query("SELECT * FROM attendance_log WHERE emp_id='$emp_id' AND logout_time=0 AND date='$date'");

if(!$res->num_rows > 0){
	if($sql->query("INSERT INTO attendance_log(emp_id,login_time,date,status) VALUES ('$emp_id', '$login', '$date', 'approved')"))
		echo "{\"code\": 1}";
	else
		echo "{\"code\": 2}";
}
else
	echo "{\"code\": 0}";

?>