<?php
include_once '../model/cpanel.php';
$m=CURRENT_MONTH_N;
$Y=CURRENT_YEAR;
 $date=date("$Y-$m-$i");
$obj=new Cpanel();
$result=$obj->getOffDayCalendar($date);
$count=  mysql_num_rows($result);
if($count==1){
      echo '<div class="btn btn-info btn-block"  width="100%">Holiday</div>';     
        }





?>
