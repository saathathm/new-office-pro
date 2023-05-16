<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include_once 'header.php';
require_once '../model/attendance.php';
date_default_timezone_set('Asia/Colombo');
$obj=new attendance();
$value=  mysql_fetch_assoc($obj->checkLogoutTime($_SESSION['emp_id']));
$missing_date=$value['date'];
if (isset($_REQUEST['e']) && $_REQUEST['e'] == '1') {
    echo '<div class="alert">
          <H4>Warning!</H4> You have not logged out on '.$missing_date.'.Please enter the out time.
          </div>';
}
?>
<script type="text/javascript">
$(document).ready(function(){
 $('#submit').click(function(){ 
   var time1=$('#time1').val(); 
   if(time1==""){
       
           $('#time1').css('border-color','red');
           $('#time1').css('background-color','#ffddcc');
           $('#time1_error').html("<font color='red'>Please set the logout time.");
           return false;
   }
   else{}
 })
 })
</script> 
<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
<script src="assest/js/time_picker.js"></script>
  <div class="container rbborder">
  <form class="form-horizontal" method="get" action="../controller/late_logout.php">
  <div class="control-group">
  <label class="control-label" for="Date">Logout</label>
  <div class="controls">
      <input type="text" id="time1" placeholder="Out Time" class="time1" name="time"><div id="time1_error"></div>
  </div>
  </div>
    <div class="control-group">
    <label class="control-label" for="Date"></label>
    <div class="controls">
    <input type="submit"  class="btn btn-primary" value="Logout" name="action" id="submit"><br><br>
    <input type="hidden"  value="<?php echo $_REQUEST['employee_id'];?>" name="employee_id">
    <input type="hidden"  value="<?php echo $_REQUEST['id'];?>" name="id">
    </div>
    </div>
  </form>
        </div>
<script>
$(function() {
		$(".date").datepicker({
			defaultDate: "+1w",
			changeMonth: true,
                        changeYear:false,
			numberOfMonths: 1
			
		});
		
	});
         $('#time1').timepicker({
        timeFormat: 'hh:mm tt'});
</script>


