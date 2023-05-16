<?php
@session_start();
function total_leave($from,$to){
   $from=date("Y-m-d",$from); 
   $to=date("Y-m-d",$to) ;
   $no_days=0;
    $numbers_of_days=1;
while($from!=$to){
    $start_time=strtotime($from);
    $dw=date("w", $start_time);
    if($dw!=0 && $dw!=6){
     $no_days++;
    }
    $from=date("Y-m-d" ,(strtotime("+$numbers_of_days days".$from)));
}  
$_SESSION['leave'][]=$no_days+1;
    return $no_days+1;   
}



function get_hours($total_seconds){
     $hours2 = floor($total_seconds / (60 * 60));
                            $divisor_for_minutes2 = $total_seconds % (60 * 60);
                            $minutes2 = floor($divisor_for_minutes2 / 60);

                            return $hours2.":".$minutes2;
}

?>
