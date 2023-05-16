<?php
$action="admin";
$include_file_path="events.php";
include 'user.php';
include 'Calendar.php';
?>

<div class="container">
    <?php
if(isset($_GET['date'])){
	$date = $_GET['date'];}
else{
	$date = time();}
$cal = new Calendar($date);
$cal->makeCalendar($action,$include_file_path);
?>
</div>