<?php
session_start();
require_once '../model/login.php';
$uname = $_POST['uname'];
$pass = $_POST['pword'];
// print_r($uname);
// print_r($pass);
// print_r("Here");
// die;
// die;
$pre_user = preg_match("/'/", $uname);
$pre_pass = preg_match("/'/", $pass);
if ($pre_user == 1 || $pre_pass == 1) {
    header('Location:../view/login.php?f=1');
    exit();
}
$obj = new login();
$result = $obj->getUser($uname, $pass);
$num = ($result)->num_rows;
if ($num == 0) {
    header('Location:../view/login.php');
} else {

    $value =  $result->fetch_assoc();
    $value['emp_type'];
    $_SESSION['name'] = $value['name'];
    $_SESSION['emp_type'] = $value['emp_type'];
    $_SESSION['emp_id'] = $value['emp_id'];

    header("Location:../view/attendance.php");
}
