<?php
session_start();
if (!isset($_SESSION['emp_type'])) {
    header("Location:login.php");
}
include_once 'user.php';
include_once '../model/cpanel.php';
$obj = new Cpanel();
?>
<div class="row-fluid">
    <div class="span6">
        <table>
           <form class="form-horizontal" action="../controller/off_day.php" method="get">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Holiday On</label>
                <div class="controls">
                    <input type="text" name="from" id="lfrom" value=""> 
                </div>
            </div>
            <input type="hidden" name="action" value="add">  
            <input type="submit" name="submit" class="btn btn-primary" value="Add"> 
        </form>
    
         <?php
        $result = $obj->getOffDay();
        while ($row = mysql_fetch_assoc($result)) {?>
            <tr><td> <?php  echo $row['date']; ?></td><td><a href="../controller/off_day.php?off_id=<?php echo $row['id']; ?> & action=delete"><img src="images/cross.png" width="25px"></a></td></tr>
 <?php }
        ?>
    
        </table>
    </div> 
    
    <div class="span6">
        <?php
            $action="off_day_calendar";
            $include_file_path="off_day_calendar.php";
          
            include 'Calendar.php';
            if (isset($_REQUEST['date']))
                $date = $_REQUEST['date'];
            else
            $date = time();
            $cal = new Calendar($date,$_SESSION['emp_id']);
            $cal->makeCalendar($action,$include_file_path);
        ?>
    </div>
</div>
<div class="row">
    <div class="span2">
       
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