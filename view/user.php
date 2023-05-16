<?php
@session_start();
if (!isset($_SESSION['emp_type'])) {
    header("Location:login.php");
}
include_once 'header.php';
require_once '../model/attendance.php';
require_once '../model/leave.php';
$obj = new attendance();
$obj1 = new leave();

$result = $obj->checkLogoutTime1($_SESSION['emp_id']); //check employee who loggedout or not
$count = $result->num_rows;
?>
<div class="navbar navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="overview_new.php">Imara</a>
        <div class="nav-collapse collapse">
            <ul class="nav">  
                
                <li class="active"><a href="overview_new.php">Home</a></li>  

                <?php if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] == 1 || $_SESSION['emp_type'] == 2) { ?> 
                    <li class="dropdown" id="accountmenu">  
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Employee<b class="caret"></b></a>  
                        <ul class="dropdown-menu">  
                            <li><a href="add_employee.php">Add Employee</a></li>  
                            <li><a href="view_employee.php">View Employee</a></li>  
                        </ul>  
                    </li><?php } ?>
                <li class="dropdown" id="accountmenu">  
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Attendance<b class="caret"></b></a>  
                    <ul class="dropdown-menu">  
                        <?php if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] == 2 || $_SESSION['emp_type'] == 3) { ?> 
                            <li><a href="attendance.php">My Attendance</a></li>  

                        <?php } ?>
                        <?php if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] == 1 || $_SESSION['emp_type'] == 2) { ?> 
                            <li class="divider"></li> 
                            <li><a href="view_attendance.php">View Attendance</a></li> 
                            <li><a href="addExtraTime.php">Add Extra Time</a></li>  
                            <li><a href="working_hours.php">Approval For Pending Attendance</a></li>  
                            <li><a href="review_attendance.php">Review Attendance</a></li> <?php } ?> 
                    </ul>  
                </li>
                <li class="dropdown" id="accountmenu">  
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Leave<b class="caret"></b></a>  
                    <ul class="dropdown-menu">  
                        <?php if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] == 2 || $_SESSION['emp_type'] == 3) { ?> 
                            <li><a href="apply_leave_new.php">Apply Leave</a></li>  
                            <li><a href="view_leave_history_new.php">My Leave History</a></li>  
				 <li><a href="view_leave_summary.php">View Leave Details</a></li>  

                        <?php } ?>
                        <?php if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] == 1 || $_SESSION['emp_type'] == 2) { ?> 
                            <li class="divider"></li>  
                            <li><a href="view_leave_new.php">View Leave Request</a></li>  
                              
                            <li><a href="viewCalendar.php">View Leave Summary</a></li> 
                            <li><a href="apply_leave_by_admin.php">Apply Leave by Admin</a></li>     
                                <?php } ?>   
                    </ul>  
                </li>
                <li class="dropdown" id="accountmenu">  
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports<b class="caret"></b></a>  
                    <ul class="dropdown-menu">  
                        <li><a href="view_working_hours_new.php">Working Hours</a></li>  
                        <li><a href="working_hours_week_new.php">Working By Week</a></li>  
                        <li><a href="working_hours_month_new.php">Working Hours By Month</a></li>
                        <li><a href="month_attendance_detail_new.php">Monthly Attendance/Leave Summary</a></li>  

                    </ul>  
                </li>
                 <?php if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] == 1 || $_SESSION['emp_type'] == 2) { ?> 
                <li class="dropdown" id="accountmenu">  
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings<b class="caret"></b></a>  
                    <ul class="dropdown-menu">  
                        <li><a href="setting_leave.php">Common Leave Setting</a></li>  
                        <li><a href="employee_profile.php">Individual Leave Setting</a></li>  
                        <li><a href="add_off_day.php">Add Off Day</a></li>
                        <li><a href=".php"></a></li>  

                    </ul>  
                </li>
                <?php } ?>
                <li class="dropdown" id="accountmenu">  
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span>You are logged in as: <strong><?php if (isset($_SESSION['name'])) { ?><?php
                        echo $_SESSION['name'];
                    }
                        ?></strong></span></a>  
                    <ul class="dropdown-menu">  
                        <li><a href="logoff.php">Log out</a></li>  

                    </ul>  
                </li>
            </ul>  

            <div class="btn-group"></div>
            <span class="login-blurb"> 
                <a href="add_note.php" rel="facebox" ><img src="images/note_1.png" height="70" width="70"></a></span> 
            <?php if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] != 1) { ?>                           
                <?php if ($count != 1) { ?>
                    <span class="login-blurb"><a href="../controller/attendance.php?emp_id=<?php echo $_SESSION['emp_id']; ?>&&action=login_approved"><div id="buzzer"><div></div></div></a></span> 
                <?php } else { ?>
                    <span class="login-blurb"><a href="../controller/attendance.php?emp_id=<?php echo $_SESSION['emp_id']; ?>&&action=logout_approved"><div id="buzzer" class="act"><div class="act"></div></div></a></span> 
                <?php } ?>
            <?php } ?>

        </div><!--/.nav-collapse -->
</div>
        <?php
        if (isset($_SESSION['emp_type']) AND $_SESSION['emp_type'] == 1 || $_SESSION['emp_type'] == 2) {
            $attendance_pending = $obj->getPendingAttendanceDetail();
            $count_pending_attendance =$attendance_pending->num_rows;
            if ($count_pending_attendance > 0) {
                echo '<a href="working_hours.php"><img src="images/mes.png" width="25"></a>' . "&nbsp";
            }
            $leave_request_pending = $obj1->getEmpLeaveRequestNew();
           $count_leave_request = $leave_request_pending->num_rows;
            if ($count_leave_request > 0) {
                echo '<a href="view_leave_new.php"><img src="images/Message_attention.png" width="25"></a>';
            }
        }
        ?>
    </div>
</div>
