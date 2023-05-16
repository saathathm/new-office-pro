<?php

function getLeaveBalance($emp_id, $where_in) {
  echo $where_in; die;
    $objleave = new newLeave();
    $result_taken_leave = $objleave->getTakenLeave($emp_id, $where_in);
    while ($value_taken_leave_array[] = mysql_fetch_array($result_taken_leave));
    $count_indi_leave = mysql_num_rows($result2 = $objleave->getIndividualLeave($emp_id));
    if ($count_indi_leave > 0) {
        $result1 = $objleave->getIndividualLeave($emp_id);
        $value_ini_leave = mysql_fetch_assoc($result1);

        $common_leave_array[1] = $value_ini_leave['annual'];
        $common_leave_array[2] = $value_ini_leave['casual'];
        $common_leave_array[3] = $value_ini_leave['medical'];
        $common_leave_array[5] = $value_ini_leave['short_leave'];
    } else {
        $result1 = $objleave->getLeave();
        while ($value_common_leave[] = mysql_fetch_row($result1));

        $common_leave_array[1] = $value_common_leave[0][2];  //as annual
        $common_leave_array[2] = $value_common_leave[1][2];  //as casual
        $common_leave_array[3] = $value_common_leave[2][2];   //as medical
        $common_leave_array[5] = $value_common_leave[3][2];   //short_leave
    }
    return [$value_taken_leave_array,$common_leave_array];
}

?>
