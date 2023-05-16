<?php
include_once 'user.php';
if(isset($_REQUEST['date'])){
 $_SESSION['date']=$_REQUEST['date'];}
include_once '../model/leave.php';
include_once '../model/employee.php';
include '../model/gen_function.php';
$obj=new employee();
 if(isset($_REQUEST['emp_id'])){$_SESSION['staff_id']=$_REQUEST['emp_id'];}
?>
<form class="form-horizontal" action="" method="get">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Staff Name</label>
               <select name="emp_id" id="emp_id">
                        <option></option>
                        <?php
                       
                        $result_emp = $obj->getAllEmployee();
                        while ($value_emp = mysql_fetch_assoc($result_emp)) {
                              //if($val2['leave_id']==3){continue;}
                            ?>   
                            <option value="<?php echo $value_emp['emp_id']; ?>">
                                <?php echo $value_emp['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                 <input type="submit" name="submit" class="btn btn-primary" value="View Staff"> 
            </div>
           
        </form>

    <div class="span12 "><table align="center"><tr><td><?php
    $result_name = $obj->getEmployee($_SESSION['staff_id']);
            $value_name=  mysql_fetch_assoc($result_name);
            echo"Detailed Report-<b>"."&nbsp".  $value_name['name']."</b>";
    
    ?></td></tr></table></div>
    
<?php       
            $action = "month_attendance_detail";
$include_file_path = "month_attendance_events.php";

include 'Calendar.php';
if (isset($_SESSION['date'])) {
    $date = $_SESSION['date'];
} else {
    $date = time();
}
$cal = new Calendar($date, $_SESSION['staff_id']);
$cal->makeCalendar($action, $include_file_path);
$date = time();
 
?>
   
