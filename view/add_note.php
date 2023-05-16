<?php 
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}

?>
<script type="text/javascript">
    
 $(document).ready(function(){
    
   $('#submit').click(function(){
       var date=$('#date').val();
       var from=$('#from').val();
       var to=$('#to').val();
       var note=$('#note').val();
      
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
           $('#from_error').html("<font color='red'>Please choose the time");
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
           $('#to_error').html("<font color='red'>Please choose the time");
           x++;
         }
   
else{
    
   
    $('#to').css('border-color','#2aff00');
           $('#to').css('background-color','white');
          $('#to_error').html("");

}
    if(note==""){
           
           $('#note').css('border-color','red');
           $('#note').css('background-color','#ffddcc');
           $('#note_error').html("<font color='red'>Please enter the note");
           x++;
         }
   
else{
    
   
    $('#note').css('border-color','#2aff00');
           $('#note').css('background-color','white');
          $('#note_error').html("");

}
    
      if(x!=0 ){return false;}
}) 
})
</script>
        <div class="row"><div class="span10"></div></div>    
   <form class="form-horizontal" method="post" action="../controller/attendance.php">
  <div class="control-group">
    <label class="control-label" for="Date">Date</label>
    <div class="controls">
        <input type="text" id="date" placeholder="Date" class="date" name="date"><div id="date_error"></div>
    </div>
  </div>
             <div class="control-group">
    <label class="control-label">From</label>
    <div class="controls">
      <input type="text" class="time" placeholder="From"  name="from" id="from"><div id="from_error"></div>
    </div>
  </div>
             <div class="control-group">
    <label class="control-label">To</label>
    <div class="controls">
      <input type="text" class="time" placeholder="To"  name="to" id="to"><div id="to_error"></div>
       <input type="hidden"  name="action" value="add_note">
       <input type="hidden" name="emp_id" value="<?php echo $_SESSION['emp_id']; ?>"/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" >Note</label>
    <div class="controls">
       <textarea  name="note" rows="4" cols="20" id="note"></textarea><div id="note_error"></div><br>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      
      <button type="submit" class="btn btn-primary" id="submit">Add</button>
    </div>
  </div>
</form>
       
<script>
$(function() {
		$("#date").datepicker({
			
			changeMonth: true,
                        changeYear:false,
			numberOfMonths: 1
		});	
		 $('.time').timepicker({
       
	timeFormat: 'hh:mm tt'});
       });
</script>