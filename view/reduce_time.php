<?php 
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
$logout_time=$_REQUEST['logout_time'];
$login_time=$_REQUEST['login_time'];
$id=$_REQUEST['id'];
?>
<script type="text/javascript">
    
 $(document).ready(function(){
    
   $('#submit').click(function(){
     
      
       var to=$('#to').val();
       var x=0;
 

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
       
<form class="form-horizontal" method="post" action="../controller/reduce_time.php">
    <div class="control-group">
        <label class="control-label" for="Date">Date</label>
        <div class="controls">
            <input type="text" id="date" readonly  name="date" value="<?php echo $_REQUEST['date']; ?>"><div id="date_error"></div>
        </div>
    </div>
   
             <div class="control-group">
    <label class="control-label">To</label>
  <div class="controls">
       <input type="text" class="time" placeholder="To"  name="to" id="to" value="<?php echo date("h:i a",strtotime($_REQUEST['logout_time'])); ?>"><div id="to_error"></div>
       <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>"/>
         <input type="hidden" name="from" value="<?php echo $login_time; ?>"/>
         <input type="hidden" name="logout_time" value="<?php echo $logout_time; ?>"/>
       <input type="hidden" name="id" value="<?php echo $id; ?>"/>
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