<?php

include_once 'AppManager.php';
$pm = AppManager::getPM();
include('connect.php');
#Connect to the database
//connection String

$connect = mysql_connect($hostname, $username, $password)
        or die('Could not connect: ' . mysql_error());

//Select The database
$bool = mysql_select_db($database, $connect);
if ($bool === False) {
    print "Can't find $database!";
}

if (isset($_POST['add_list'])) {
    $list = $_POST['list'];
    
    $param = array(":list" => $list);
    $pm->run("INSERT INTO status_list(list) VALUES(:list)", $param);
    header("location:admin_panel.php");
}
?>
