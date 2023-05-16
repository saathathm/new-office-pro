<?php
@session_start();
if (!isset($_SESSION['emp_type'])) {
  header("Location:login.php");
}
include_once 'header.php';
?>

<div class="">
  <div>
    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="logoff.php">Imara</a>
          <ul class="nav">
            <li class="active"><a href="over_view.php">Home</a></li>
          </ul>

          <div class="btn-group">
            <button class="btn btn-inverse">Employee</button>
            <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="add_employee.php">Add Employee</a></li>
              <li><a href="view_employee.php">View Employee</a></li>
            </ul>
          </div>
          <div class="btn-group">
            <button class="btn btn-inverse">Attendance</button>
            <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="view_attendance.php">View Attendance</a></li>
              <li><a href="working_hours.php">Approval For Pending Attendance</a></li>
              <li><a href="review_attendance.php">Review Attendance</a></li>
            </ul>
          </div>
          <div class="btn-group">
            <button class="btn btn-inverse">Leave</button>
            <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="view_leave.php">View Leave Request</a></li>
              <li><a href="view_leave_summary.php">View Leave Summary</a></li>
            </ul>
          </div>
          <div class="btn-group">
            <button class="btn btn-inverse">Working Hours</button>
            <button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li><a href="view_working_hours.php">Working Hours</a></li>
              <li><a href="working_hours_month.php">Working Hours By Month</a></li>
              <li><a href="working_hours_week.php">Working By Week</a></li>

            </ul>
          </div>
          <div class="btn-group"><embed src=http://flash-clocks.com/free-flash-clocks-blog-topics/free-flash-clock-195.swf width=200 height=100 wmode=transparent type=application/x-shockwave-flash></embed></div>
          <span class="login-blurb"><a href="logoff.php">Log Out</a></span>
          <span class="login-blurb">You are logged in as: <strong><?php if (isset($_SESSION['name'])) { ?><?php echo $_SESSION['name'];
                                                                                                        } ?><strong></span>
        </div><!--/.nav-collapse -->

      </div>
    </div>
  </div>
  <!--            <button id="hideshow">show</button>-->

</div>