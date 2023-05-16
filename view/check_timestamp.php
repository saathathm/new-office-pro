

<?php 
        require_once '../model/attendance.php';
        $obj=new attendance();
        $result=$obj->getTimeStampDetail();   
        while($val=mysql_fetch_assoc($result)){
       echo $val['login_time']."<br>";
       echo $val['logout_time']."<br>";
//        echo $diff=strtotime($out)-strtotime($out);
        }
        
//     $seconds=96000;   
//    
//
//   
//    $hours = floor($seconds / (60 * 60));
//    $divisor_for_minutes = $seconds % (60 * 60);
//    $minutes = floor($divisor_for_minutes / 60);
//    $divisor_for_seconds = $divisor_for_minutes % 60;
//    $seconds = ceil($divisor_for_seconds);
 
    // return the final array
   
        ?>
       
 