<?php
session_start();
if (!isset($_SESSION['emp_type'])) {
    header("Location:login.php");
}
include_once 'user.php';
include_once '../model/leave.php';
include_once '../model/employee.php';
$obj = new employee();
$result = $obj->getEmployee(@$_SESSION['emp_id']);
$value = ($result)->fetch_assoc();
if (isset($_REQUEST['s']) && $_REQUEST['s'] == '1') {
    echo '<div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Failed to submit.
        </div>';
}
if (isset($_REQUEST['s']) && $_REQUEST['s'] == '12') {
    echo '<div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Failed to submit.Leave request overlaping.
        </div>';
}
if (isset($_REQUEST['f']) && $_REQUEST['f'] == '1') {
    echo '<div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Failed to submit.Short leave exceeded for this month.
        </div>';
}
if (isset($_REQUEST['s']) && $_REQUEST['s'] == '2') {
    echo '<div class="alert alert-info">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Your leave request has been sent to admin approval
        </div>';
}
if (isset($_REQUEST['l']) && $_REQUEST['l'] == '1') {
    echo '<div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Failed to submit.Leave Execeeded.
        </div>';
}
if (isset($_REQUEST['l']) && $_REQUEST['l'] == '2') {
    echo '<div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">x</button>
         Failed to submit.Off day
        </div>';
}
?>
<script>
    
    $(function () {
    
        $("#leave_type").change(function() {
            var val = $(this).val();
            if(val==5) {
                $("#hide").fadeOut();
               
            }
            else{
                $("#hide").fadeIn();
               
            }
        });
        //////
        $("#leave_type").change(function() {
            var val = $(this).val();
            if(val==1 || val==2 ||val==6) { //add the val which leave type has half and full day
                $("#dddd").fadeIn();
                // $("#ddays").show();
                $("#fday").prop("checked", true)
       
            }
            else{
                $("#dddd").fadeOut();
                $("#fday").prop("checked", true)
                
            }
        });
        $("#hday").change(function() {
            $("#hide").fadeOut();
    
        });
        $("#fday").change(function() {
            $("#hide").fadeIn();
    
        });
    })

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#submit').click(function(){ 
            var leave_type=$('#leave_type').val()
            var from=$('#lfrom').val();
            var hday=$('#hday').val();
            var fday=$('#fday').val();
        
            var to=$('#lto').val();
            var note=$('#note').val();
            var duration=$('#duration').val();
            var x=0;
            if(leave_type==5){
                var to=$('#lto').val(from);   
            }
            if(document.getElementById('hday').checked) {
                var to=$('#lto').val(from);   
  
            }else if(document.getElementById('fday').checked) {
  
            }
            //  if(fday=="fday"){var to=$('#lto').val(from);   }
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
           
                $('#lfrom').css('border-color','red');
                $('#lfrom').css('background-color','#ffddcc');
                $('#from_error').html("<font color='red'>Please choose the date");
                x++;
            }
   
            else{
                $('#lfrom').css('border-color','#2aff00');
                $('#lfrom').css('background-color','white');
                $('#from_error').html("");

            }
            if(to==""){
           
                $('#lto').css('border-color','red');
                $('#lto').css('background-color','#ffddcc');
                $('#to_error').html("<font color='red'>Please choose the date");
                x++;
            }
   
            else{
                $('#lto').css('border-color','#2aff00');
                $('#lto').css('background-color','white');
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
    <div class="span6" style="padding-top:60px ">
        <table class="table">
            <tr style="background-color:#000; color:#fff;" >
                <td>Apply Leave Request</td>
            </tr>
        </table>
        <form class="form-horizontal" action="../controller/apply_leave2.php" method="POST">
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
                        while ($val2 = ($result2)->fetch_assoc()) {
                            ?>   
                            <option value="<?php echo $val2['leave_id']; ?>">
                                <?php echo $val2['leave_type']; ?>
                            </option>
                        <?php } ?>
                    </select><div id="leave_type_error"></div>
                </div>
            </div>
            <div id="dddd">
                <div class="control-group" id="dhours">
                    <label class="control-label text-error" for="inputEmail">Half Day</label>
                    <div class="controls">
                        <input type="radio" name="duration" value="hday" id="hday"></td>
                    </div>
                </div>

                <div class="control-group" id="ddays">
                    <label class="control-label text-info" for="inputEmail">Full Day</label>
                    <div class="controls">
                        <input type="radio" name="duration" value="fday" checked id="fday">
                    </div>
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
    <div class=" span10">
        <?php
        $result3 = $obj2->planAnnualLeave($_SESSION['emp_id'], date("Y"));
        $value3 = ($result3)->fetch_assoc();
        echo $value3['no_of_days'];
        $count = ($result3)->num_rows;
        //  if($count<2){echo "You have a message".'<a href="planAnnualLeave.php" rel="facebox"><img src="images/mes.png" width="25"></a>';}
        $include_file_path = "events.php";
        $action = "individual";
        include 'Calendar.php';
        if (isset($_REQUEST['date']))
            $date = $_REQUEST['date'];
        else
            $date = time();
        $cal = new Calendar($date, $_SESSION['emp_id']);
        $cal->makeCalendar($action, $include_file_path);
        ?>
    </div>
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