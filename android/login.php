<?php
/**
 * Login Controller
 */

//header('Content-type: application/json');
require_once("connection.php");



$user = $_POST['username'];
$pass = $_POST['password'];


$res = $sql->query("SELECT * FROM employee WHERE user_name='$user'");



if($res->num_rows > 0){
	$user = $res->fetch_object();
	if($pass == $user->password){
		unset($user->password);
		echo json_encode($user);
	}
	else
		echo "{\"code\": 2}";
}
else
	echo "{\"code\": 0}";
?>