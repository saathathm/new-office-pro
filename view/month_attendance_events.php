<?php
$_SESSION['staff_id'];
$m=CURRENT_MONTH_N;
$Y=CURRENT_YEAR;
 $date=date("$Y-$m-$i");
 $first_second = date('Y-m-01');
 $last_second  = date('Y-m-t');
 $dates_array = array();
 $step = '+1 day'; $format = 'Y-m-d';
 $current = strtotime($first_second);
 $last = strtotime($last_second);
 while($current <= $last ) { 
 if (date("D", $current) != "Sun" && date("D", $current)!= "Sat")
 $dates_array[] = date($format,$current);
 $current = strtotime($step, $current);
    }
      $total_weekdays=count($dates_array);
      $objGen=new GeneralFunction();
      $result=$objGen->staffAttendanceDetail($date,$_SESSION['staff_id']);
      $value=  mysql_fetch_assoc($result);
      $result1=$objGen->getLeaveDetail($date,$_SESSION['staff_id']);
      $value1=  mysql_fetch_assoc($result1);
      $result2=$objGen->getMonthlyWorkingHoursDetailIndividual($_SESSION['staff_id'],$m,$Y);
      $value2=  mysql_fetch_assoc($result2);
      $result3=$objGen->getExtraTimemonthly($_SESSION['staff_id'],$m,$Y);
      $value3=  mysql_fetch_assoc($result3);
     
      $result4=$objGen->getOffDay($m,$Y);
      $value4=  mysql_fetch_assoc($result4);
      $count4=  mysql_num_rows($result4);
      $result5=$objGen->getSumLeaveDetail($_SESSION['staff_id'],$m,$Y); 
      $value5=mysql_fetch_assoc($result5);
      
        echo '<br>'. '<span class="label label-success">'."Login Time"." &nbsp". $value['login_time'].'</span>'.'<br>';
       if(!empty($value1)){
        echo '<span class="label label-info">'."Leave Type"." &nbsp". $value1['leave_type'].'</span>';
       }
     ($leave_total_hours=$value5['total_hours']*3600);
     $total_works_hour_month=($total_weekdays-$count4)*8*3600;
    // $holiday_hours=$count4*8*3600;
     $must_work_month=$total_works_hour_month-$leave_total_hours;
       $total_working_hours=$value2['diff']+$value3['extra_time_month'];
       $hours1 =floor($must_work_month / (60 * 60));
                            $divisor_for_minutes1 = $must_work_month % (60 * 60);
                            $minutes1 =floor($divisor_for_minutes1 / 60);
       $hours2 =floor($total_working_hours / (60 * 60));
                            $divisor_for_minutes2 = $total_working_hours % (60 * 60);
                            $minutes2 =floor($divisor_for_minutes2 / 60);
      echo '<span class="label label-warning">'."Must Work Month"." &nbsp". $hours1.":".$minutes1.'</span>';
      echo '<span class="label label-inverse">'."Total worked Hours"." &nbsp". $hours2.":".$minutes2.'</span>';
      
    

      
      
?>
