<?php
$_SESSION['staff_id'];
$m = CURRENT_MONTH_N;
$Y = CURRENT_YEAR;
//////////////////////////date_array contains without weekends of a current month
$date = date("$Y-$m-$i");
$objGen = new GeneralFunction(); //qq


$result = $objGen->staffAttendanceDetail($date,$_SESSION['staff_id']);
$value = mysqli_fetch_assoc($result);
$result1 = $objGen->getLeaveDetailNew($date,$_SESSION['staff_id']);
echo '<br>' . '<span class="label label-success">' . "Login Time" . " &nbsp" . $value['login_time'] . '</span>' . '<br>';
$leave_type=array();
$total_hours=array();
while($value1 = mysqli_fetch_assoc($result1)){
   echo '<span class="label label-info">' .$value1['leave_type'] ."-". $value1['total_hours'].'</span>' . '<br>';
    
}






if (!empty($leave_type)) {
   // echo '<span class="label label-info">' . "Leave Type" . " &nbsp" .   implode(", ", $leave_type) . '</span>' . '<br>';
}


//echo '<span class="label label-warning">' . "Must Work Month" . " &nbsp" . $hours1 . ":" . $minutes1 . '</span>';
//echo '<span class="label label-inverse">' . "Total worked Hours" . " &nbsp" . $hours2 . ":" . $minutes2 . '</span>';
?>
