<?php

include_once '../model/cpanel.php';
$obj = new Cpanel();
$action = @$_REQUEST['action'];
$date = @$_REQUEST['from'];
$off_id = @$_REQUEST['off_id'];
switch ($action) {
    case 'add':
      if (!empty($date)) {
    $result = $obj->insertOffDay($date);
    $count = mysql_num_rows($result);
    if ($count != 0) {
        header("Location:../view/add_off_day.php");
    } else {
        header("Location:../view/add_off_day.php?f=1");
    }
}

        break;
    case 'delete':
       if ($action == "delete") {
    $obj->deleteOffDay($off_id);
    header("Location:../view/add_off_day.php");
}

        break;

    default:
        break;
}




?>
