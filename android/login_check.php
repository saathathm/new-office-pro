<?php
/**
 * Login Controller
 */

//header('Content-type: application/json');
require_once("connection.php");


$emp_id = $_REQUEST['emp_id'];
$date=date("Y-m-d");
$login=date("H:i:s");

$res = $sql->query("SELECT login_time FROM attendance_log WHERE emp_id='$emp_id' AND logout_time=0 AND date='$date'");

if($res->num_rows != 0){
	$rows = $res->fetch_object();
	echo '{"time": "'.$rows->login_time.'"}';
}
else
	echo "{\"code\": 0}";
?>