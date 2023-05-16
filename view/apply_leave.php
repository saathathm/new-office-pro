<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include_once 'user.php';
include_once '../model/leave.php';
include_once '../model/employee.php';
$obj=new employee();
$result=$obj->getEmployee(@$_SESSION['emp_id']);
$value= mysql_fetch_assoc($result);
if (isset($_REQUEST['s']) && $_REQUEST['s']=='1') {
    echo '<div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Failed to submit.
        </div>';}
        if (isset($_REQUEST['f']) && $_REQUEST['f']=='1') {
    echo '<div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Failed to submit.Short leave exceeded for this month.
        </div>';}
        if (isset($_REQUEST['s']) && $_REQUEST['s']=='2') {
    echo '<div class="alert alert-info">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Your leave request has been sent to admin approval
        </div>';}

        ?>
<script>
//$(function(){ // DOM ready
//
//    $('[name=leaveType]').change(function(){
//      $('#hide').show()
//      $('[data-panel='+ this.value +']').hide(); 
//    });
//});
$(function () {
  $("#leave_type").change(function() {
    var val = $(this).val();
    if(val==4 || val==5) {
        $("#hide").hide();
        $("#ddays").hide();
        $("#hours").prop("checked", true)
       
    }
    else{
        $("#hide").show();
         $("#ddays").show();
        $("#days").prop("checked", true)
    }
  });
});

</script>
<script type="text/javascript">
$(document).ready(function(){
 $('#submit').click(function(){ 
       var leave_type=$('#leave_type').val()
       var from=$('#lfrom').val();
       var to=$('#lto').val();
	     var duration=$('#duration').val();
       var note=$('#note').val();
       var x=0;
   if(leave_type==5 || leave_type==4){
     var to=$('#lto').val(from);   
   }
   else{
  }
if(leave_type==""){
           
           $('#leave_type').css('border-color','red');
           $('#leave_type').css('background-color','#ffddcc');
           $('#leave_type_error').html("<font color='red'>Please select the leave type");
           x++;
         }
else{
           $('#leave_type').css('border-color','#2aff00');
           $('#leave_type').css('background-color','white');
           $('#leave_type_error').html("");

}
  if(from==""){
           
           $('#from').css('border-color','red');
           $('#from').css('background-color','#ffddcc');
           $('#from_error').html("<font color='red'>Please choose the date");
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
           $('#to_error').html("<font color='red'>Please choose the date");
           x++;
         }
   
else{
           $('#to').css('border-color','#2aff00');
           $('#to').css('background-color','white');
           $('#to_error').html("");

}
if(duration==""){
           
           $('#duration').css('border-color','red');
           $('#duration').css('background-color','#ffddcc');
           $('#duration_error').html("<font color='red'>Please enter the duration");
           x++;
         }
   
else{
           $('#duration').css('border-color','#2aff00');
           $('#duration').css('background-color','white');
           $('#duration_error').html("");

}
    if(note==""){
           
           $('#note').css('border-color','red');
           $('#note').css('background-color','#ffddcc');
           $('#note_error').html("<font color='red'>Please enter the reason");
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

<div class="row">
<h3> If you want to apply half day please select half day option from drop down menu</h3>
    <div class="span6" style="padding-top:60px ">
        <table class="table">
            <tr style="background-color:#000; color:#fff;" >
                <td>Apply Leave Request</td>
            </tr>
        </table>
        <form class="form-horizontal" action="../controller/apply_leave.php" method="POST">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Name</label>
                <div class="controls">
                    <span class="label label-success"><?php echo $value['name']; ?></span>
                </div>
            </div>
  
            <div class="control-group">
                <label class="control-label" for="inputEmail">Leave Type</label>
                <div class="controls">
                    <select name="leaveType" id="leave_type">
                        <option></option>
                        <?php
                        $obj2 = new leave();
                        $result2 = $obj2->getLeave();
                        while ($val2 = mysql_fetch_assoc($result2)) {
                            ?>   
                            <option value="<?php echo $val2['leave_id']; ?>">
                                <?php echo $val2['leave_type']; ?>
                            </option>
                        <?php } ?>
                    </select><div id="leave_type_error"></div>
                </div>
            </div>
  
            <div class="control-group">
                <label class="control-label" for="inputEmail">Leave From</label>
                <div class="controls">
                    <input type="text" name="from" id="lfrom" value=""> <div id="from_error"></div>
                </div>
            </div>
  
            <div class="control-group" id="hide" data-panel="5">
                <label class="control-label" for="inputEmail">Leave To</label>
                <div class="controls">
                    <input type="text" name="to" id="lto" value=""> <div id="to_error"></div> 
                </div>
            </div>
  
            <div class="control-group" id="dhours">
                <label class="control-label" for="inputEmail">Hours</label>
                <div class="controls">
                    <input type="radio" name="duration" value="hours" id="hours"></td>
                </div>
            </div>
                
            <div class="control-group" id="ddays">
                <label class="control-label" for="inputEmail">Days</label>
                <div class="controls">
                    <input type="radio" name="duration" value="days" checked id="days">
                </div>
            </div>
                
            <div class="control-group">
                <label class="control-label" for="inputEmail">Duration</label>
                <div class="controls">
                    <input type="text" name="total_duration" id="duration"><div id="duration_error"></div>
                </div>
            </div> 
                
            <div class="control-group">
                <label class="control-label" for="inputEmail">Reason</label>
                <div class="controls">
                    <textarea name="reason" rows="2" cols="10" id="note"></textarea> 
                    <div id="note_error"></div>
                </div>
            </div> 
  
            <div class="control-group">
                
                <div class="controls">
                    <input type="hidden" name="emp_id" value="<?php echo $_SESSION['emp_id']; ?>"/>
                    <input type="submit" value="Apply" class="btn btn-primary" id="submit" >
                </div>
            </div>
        </form>
    </div> 
    <div class=" span10"><?php
            $action = "individual";
            include 'Calendar.php';
            if (isset($_GET['date']))
                $date = $_GET['date'];
            else
                $date = time();
            $cal = new Calendar($date, $_SESSION['emp_id']);
            $cal->makeCalendar($action);
            ?></div>
</div>
<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
<!--        datepicker start-->
         <script> 
	$(function() {
		$( "#lfrom" ).datepicker({
			
			changeMonth: true,
                        dateFormat:'yy-mm-dd',
                         beforeShowDay: $.datepicker.noWeekends , //dont enable weekends
			
			onClose: function( selectedDate ) {
				$( "#lto" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#lto" ).datepicker({
			
			changeMonth: true,
                        dateFormat:'yy-mm-dd',
			 beforeShowDay: $.datepicker.noWeekends , //dont enable weekends
			onClose: function( selectedDate ) {
				$( "#lfrom" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	});
 
 </script><!--        datepicker end-->