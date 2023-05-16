<?php

//$date_string = "2013-09-16";
////echo "Weeknummer: " . date("W", strtotime($date_string));
////$date_string = "2013-09-08";
////echo $ts=strtotime($date_string);// convert to time stamp
////echo $time=date("Y-m-d",$ts);    //time satmp into date
//echo "Weeknummer: " . date("W", strtotime($date_string));
//$time = strtotime($date_string);
//    $day = date('w', $time);
//    $time += ((7*$week)+1-$day)*24*3600;
//   echo $start = date('Y-n-j', $time);
//    $time += 6*24*3600;
//    echo $end = date('Y-n-j', $time);
  
//   
//  
//
//
//$mydate = strtotime($date_string);
////or get it from mysql_query( 'SELECT UNIXDATE(datefield) FROM table' )
//
////get weekday with monday==0, sunday==6
//$weekday = ((int)date( 'w', $mydate ) + 6 ) % 7;
//
////get first monday on or before given date
//$prevmonday = $mydate - $weekday * 24 * 3600;
//
////format date
//echo 'Monday of this week: '.date( 'l j F Y', $prevmonday );


//$DateTime d = DateTime.Today;
//
// int offset = d.DayOfWeek - DayOfWeek.Monday;
//
// DateTime lastMonday = d.AddDays(-offset);
// DateTime nextSunday = lastMonday.AddDays(6);
function is_phone($number, $lengths = null)
  {
  if (!is_array($lengths)) {
  $lengths = array(7, 10, 11);
  }
  $number = preg_replace('/D+/', '', $number);
  return in_array(strlen($number), $lengths);
 
  }
  $number=0777424342;
echo is_phone($number);
  
  ?>
