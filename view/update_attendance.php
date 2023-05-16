<?php 
session_start();
if(!isset($_SESSION['emp_type']) OR $_SESSION['emp_type']==3){header("Location:login.php");}
$id=$_REQUEST['id'];
$employee_id=$_REQUEST['employee_id'];
$action=$_REQUEST['action'];
?>
<script type="text/javascript">
    
 $(document).ready(function(){
    
   $('#submit').click(function(){
       var date=$('#date').val();
       var from=$('#from').val();
       var to=$('#to').val();
       var x=0;
 if(date==""){
           
           $('#date').css('border-color','red');
           $('#date').css('background-color','#ffddcc');
           $('#date_error').html("<font color='red'>Please select the date");
           x++;
         }
else{
            $('#date').css('border-color','#2aff00');
            $('#date').css('background-color','white');
            $('#date_error').html("");

}
if(from==""){
           
           $('#from').css('border-color','red');
           $('#from').css('background-color','#ffddcc');
           $('#from_error').html("<font color='red'>Please select the time");
           x++;
         }
   
else{
           $('#from').css('border-color','#2aff00');
           $('#from').css('background-color','white');
           $('#from_error').html("");
}
if(to==""){
           
           $('#to').css('border-color','red');
           $('#to').css('background-color','#ffddcc');
           $('#to_error').html("<font color='red'>Please select the time");
           x++;
         }
   
else{
            $('#to').css('border-color','#2aff00');
            $('#to').css('background-color','white');
            $('#to_error').html("");
}
if(x!=0 ){return false;}
}) 
})
</script>
       
<form class="form-horizontal" method="post" action="../controller/update_attendance.php">
    <div class="control-group">
        <label class="control-label" for="Date">Date</label>
        <div class="controls">
            <input type="text" id="date" placeholder="Date" class="date" name="date" value="<?php echo $_REQUEST['date']; ?>"><div id="date_error"></div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">From</label>
        <div class="controls">
            <input type="text" class="time" placeholder="From"  name="from" id="from" value="<?php echo date("h:i a", strtotime($_REQUEST['login_time'])); ?>"><div id="from_error"></div>
        </div>
    </div>
             <div class="control-group">
    <label class="control-label">To</label>
    <div class="controls">
      <input type="text" class="time" placeholder="To"  name="to" id="to" value="<?php if($_REQUEST['logout_time']!=0){ echo date("h:i a",strtotime($_REQUEST['logout_time']));} else { echo ""; } ?>"><div id="to_error"></div>
       <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>"/>
       <input type="hidden" name="id" value="<?php echo $id; ?>"/>
       <input type="hidden" name="action" value="<?php echo $action; ?>"/>
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      
      <button type="submit" class="btn btn-primary" id="submit">Update</button>
    </div>
  </div>
</form>
<script>
$(function() {
		$(".date").datepicker({
			
			changeMonth: true,
                        changeYear:false,
                         maxDate:0,
			numberOfMonths: 1
			});
                 
        $(".time").timepicker({
            
        timeFormat: 'hh:mm tt'});
       });
</script>