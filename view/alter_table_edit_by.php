<?php
require_once '../model/conn.php';
 $db=new dbcon();
//$sql=" ALTER TABLE `leave_detail` ADD `total_hours` FLOAT NOT NULL AFTER `leave_to`"; 
// $sql="ALTER TABLE `leave_type` ADD `no_of_days` INT( 10 ) NOT NULL AFTER `leave_type`"; 
//$sql="ALTER TABLE `attendance_log` ADD `edit_by` INT( 10 ) NOT NULL AFTER `logout_by`";
// $sql="ALTER TABLE `attendance_log` ADD `approved_by` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `login_note`"; 
 
      //  $sql="update employee set user_name='admin',password='admin' where emp_id=1";
       
 $sql="CREATE TABLE IF NOT EXISTS `extra_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `extra_time` int(11) NOT NULL,
  `date` date NOT NULL,
  `extra_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
 $result=$db->query($sql);
       if($result){
                      echo 'success';}
?>
