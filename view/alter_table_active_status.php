<?php
//require_once '../model/conn.php';
 $db=new dbcon();
 $sql="INSERT INTO `leave_type` (
`leave_id` ,
`leave_type` ,
`no_of_days`
)
VALUES (
'5', 'short', ''
)";

 $result=$db->query($sql);
 if($result){echo "success";}
?>
