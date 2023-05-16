<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
require_once '../model/attendance.php';
date_default_timezone_set('Asia/Colombo');
?>
<script type="text/javascript">
    
 $(document).ready(function(){
    
   $('#submit').click(function(){
       var time1=$('#time1').val();
      var x=0;
 if(time1==""){
           
           $('#time1').css('border-color','red');
           $('#time1').css('background-color','#ffddcc');
           $('#time1_error').html("<font color='red'>Please select the time");
           x++;
         }
   
else{
    
   
    $('#time1').css('border-color','#2aff00');
           $('#time1').css('background-color','white');
          $('#time1_error').html("");

}
   if(x!=0 ){return false;}
}) 
})
</script>
<div class="container span5">
<form  method="post" action="../controller/logout_user.php">

    <div class="control-group">
    <label class="control-label">Logout</label>
    <div class="controls">
      <input type="text" id="time1" placeholder="Logout Time" class="time1" name="time"><div id="time1_error"></div>
    </div>
  </div>
      
    
   <div class="control-group">
    <label class="control-label" for="Date"></label>
    <div class="controls">
      <input type="submit" id="submit" class="btn btn-primary" value="Logout">
      <input type="hidden"  value="<?php echo $_REQUEST['employee_id'];?>" name="employee_id">
       <input type="hidden"  value="<?php echo $_REQUEST['id'];?>" name="id">
    </div>
  </div>
  </form>
</div>
<script>
$(function() {
	            
        $('#time1').timepicker({
        timeFormat: 'hh:mm tt'});
		
	});
     
</script>


