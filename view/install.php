<?php
//require_once '../model/conn.php';


       $db=new dbcon();
       $sql="CREATE TABLE IF NOT EXISTS `attendance_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `emp_id` int(10) NOT NULL,
  `login_time` time NOT NULL,
  `logout_time` time NOT NULL,
  `date` date NOT NULL,
  `login_note` varchar(100) CHARACTER SET utf8 NOT NULL,
  `logout_by` int(10) NOT NULL,
  `status` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;
";
      
     $db->query($sql);
         
 $sql="CREATE TABLE IF NOT EXISTS `employee` (
  `emp_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `user_name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `p_no` varchar(20) CHARACTER SET utf8 NOT NULL,
  `emp_type` int(3) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
";
      
     $db->query($sql);
     $sql="CREATE TABLE IF NOT EXISTS `employee_type` (
  `emp_type_id` int(3) NOT NULL AUTO_INCREMENT,
  `emp_type` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`emp_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
";
      
     $db->query($sql);
 $sql="CREATE TABLE IF NOT EXISTS `leave_detail` (
  `app_id` int(10) NOT NULL AUTO_INCREMENT,
  `emp_id` int(10) NOT NULL,
  `leave_id` int(10) NOT NULL,
  `applied_date` date NOT NULL,
  `leave_from` date NOT NULL,
  `leave_to` date NOT NULL,
  `reason` varchar(100) NOT NULL,
  `approval` text NOT NULL,
  `rejected_reason` varchar(100) NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
";
      
 $db->query($sql);
 $sql="CREATE TABLE IF NOT EXISTS `leave_type` (
  `leave_id` int(10) NOT NULL,
  `leave_type` text NOT NULL,
  `no_of_days` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";
      
     $db->query($sql);
     $sql="INSERT INTO `employee_type` (`emp_type_id`, `emp_type`) VALUES
(1, 'super_admin'),
(2, 'admin'),
(3, 'user');
";
      
     $db->query($sql);
     $sql="INSERT INTO `leave_type` (`leave_id`, `leave_type`, `no_of_days`) VALUES
(1, 'casual', 7),
(2, 'medical', 7),
(3, 'vacation', 7);
";
      
     $db->query($sql);
      $sql="INSERT INTO `employee` (`emp_id`, `name`, `user_name`, `password`, `email`, `p_no`, `emp_type`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', '', 1),
(2, 'employee1', 'employee1', 'employee1', 'employee1', '', 2),
(10, 'e5', 'e5', 'e5', 'e5', '', 3);
";
      
     $db->query($sql);
          
          
   
?>
