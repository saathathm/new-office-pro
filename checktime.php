<?php
// date_default_timezone_set('Asia/Colombo');
// echo  $date=date("Y-m-d").'<br>';
 // echo $login=date("H:i:s");

// date_default_timezone_set('Asia/Colombo');

// if (date_default_timezone_get()) {
    // echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
// }

// if (ini_get('date.timezone')) {
    // echo 'date.timezone: ' . ini_get('date.timezone');
// }

$tz = 'Asia/Colombo';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
echo $dt->format('d.m.Y, H:i:s');
 
 ?>