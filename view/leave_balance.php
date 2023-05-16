<?php
function Leave_balance($emp_id, $where_in,$currentyear) {
echo $where_in;
   
    $newLeaveobj = new newLeave();
    $result_taken_leave = $newLeaveobj->getTakenLeave($emp_id, $where_in,$currentyear);
   while ($value_taken_leave_array[] = mysqli_fetch_array($result_taken_leave));
  
    $count_indi_leave = ($result2 = $newLeaveobj->getIndividualLeave($emp_id))->num_rows; 

    if ($count_indi_leave > 0) {
        $result1 = $newLeaveobj->getIndividualLeave($emp_id);
        $value_ini_leave = ($result1)->fetch_assoc();


        $common_leave_array[1] = $value_ini_leave['annual'];
        $common_leave_array[2] = $value_ini_leave['casual'];
        $common_leave_array[3] = $value_ini_leave['medical'];
        $common_leave_array[5] = $value_ini_leave['short_leave'];
    } else {        
        $result1 = $newLeaveobj->getLeave();
        while ($value_common_leave[] = ($result1)->num_rows);
         
        $common_leave_array[1] = $value_common_leave[0][2];  //as annual
        $common_leave_array[2] = $value_common_leave[1][2];  //as casual
        $common_leave_array[3] = $value_common_leave[2][2];   //as medical
        $common_leave_array[5] = $value_common_leave[3][2];   //short_leave
       
    }

//
   return array($common_leave_array, $value_taken_leave_array);
}
function levae_balance_for_detail($emp_id,$where_in,$current_year){  
   $newLeaveobj = new newLeave();
    $result_taken_leave = $newLeaveobj->getTakenLeaveForDetail($emp_id, $where_in,$current_year);
    while ($value_taken_leave_array[] = mysqli_fetch_array($result_taken_leave));

    $count_indi_leave = ($result2 = $newLeaveobj->getIndividualLeave($emp_id))->num_rows;

    if ($count_indi_leave > 0) {
        $result1 = $newLeaveobj->getIndividualLeave($emp_id);
        $value_ini_leave = ($result1)->fetch_assoc();


        $common_leave_array[1] = $value_ini_leave['annual'];
        $common_leave_array[2] = $value_ini_leave['casual'];
        $common_leave_array[3] = $value_ini_leave['medical'];
        $common_leave_array[5] = $value_ini_leave['short_leave'];
    } else {
        $result1 = $newLeaveobj->getLeave();
        while ($value_common_leave[] = mysqli_fetch_row($result1));

        $common_leave_array[1] = $value_common_leave[0][2];  //as annual
        $common_leave_array[2] = $value_common_leave[1][2];  //as casual
        $common_leave_array[3] = $value_common_leave[2][2];   //as medical
        $common_leave_array[5] = $value_common_leave[3][2];   //short_leave
    }

    return array($common_leave_array, $value_taken_leave_array); 
}

?>
