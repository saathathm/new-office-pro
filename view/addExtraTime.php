<?php
@session_start();
if(!isset($_SESSION['emp_type']) OR $_SESSION['emp_type']==3){header("Location:login.php");}
include 'user.php';
require_once '../model/attendance.php';
require_once '../model/employee.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
if(@$_REQUEST['date3']!=""){
      $date =$_REQUEST['date3'];}
$obj=new attendance();
$obj2=new employee();
$countSession=$obj->countSession($date);
$valueCount=mysql_fetch_assoc($countSession);

$maxcount=$valueCount['c'];
$result2=$obj2->getAllEmployee();
  
echo '<table  class="table">'; ?>
   <thead style="background-color:#000; color:#fff;" >
       
           <td colspan="<?php echo 2*$maxcount+2?>">
               
               <form method="get" action="addExtraTime.php">
               <input type="text" class="date" name="date3" placeholder="Select date" value="<?php echo $date; ?>">
               <input type="submit"  name="submit" value="Show" class="btn btn-primary"><br>
              <?php echo "<b>Add Extra Time On</b>"."&nbsp".$date; ?>
              </form>
           </td>
       </thead>
     
 <thead style="background-color:#000; color:#fff;" ><th>Name</th><?php for($x=1; $x<=$maxcount; $x++){echo "<th>Time In</th><th>Time Out</th>"; }?><th>Add Time</th></thead>
  <?php     
 while($val=mysql_fetch_assoc($result2)){
    echo '<tr>';
        echo '<td>';
         echo $val['name'];
      $emp_id= $val['emp_id'];
            echo '</td>';
         
$result=$obj->getAllAttendanceDetail($date,$val['emp_id']); //check employee who loggedout or not
$countIndividual=  mysql_fetch_assoc($obj->countSessionIndividual($date,$val['emp_id']));
$countci=$countIndividual['ci'];
$valextratime=mysql_fetch_assoc($obj->getExtraTime($val['emp_id'], $date));
$countextra= count($valextratime['extra_status']) ;
 while($val=mysql_fetch_assoc($result)){
        echo '<td>';
         echo date("h:i a",strtotime($val['login_time']));
          echo '</td>';
         
            echo '<td>';
             if($val['logout_time']!=date("H:i:s", strtotime("12:00 AM"))){
                    
                echo date("h:i a",strtotime($val['logout_time']));     
                   
            } else{echo "--:--";}            echo '</td>';
            
         
            } if(2*$maxcount-2*$countci!=0){ ?>

  <td colspan="<?php echo(2*$maxcount-2*$countci);   ?>">
  </td>
  <td>
             <?php   if($valextratime['extra_status']==0 && $countextra==1 ) { ?>
                <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=1&extra_time=<?php echo 2400; ?>"> <span class="label label-success">40 min</span> </a><?php } elseif($valextratime['extra_status']==1 && $countextra==1) { ?>
            <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=0&extra_time=<?php echo 1200; ?>"> <span class="label label-success">20 min</span> </a> <?php } else{ ?>
             <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=1&extra_time=<?php echo 2400; ?>"> <span class="label label-success">40 min</span> </a>
            <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=0&extra_time=<?php echo 1200; ?>"> <span class="label label-success">20 min</span> </a> 
           <?php } ?>
            </td> <?php } else { ?>
            <td>
             <?php   if($valextratime['extra_status']==0 && $countextra==1 ) { ?>
                <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=1&extra_time=<?php echo 2400; ?>"> <span class="label label-success">40 min</span> </a><?php } elseif($valextratime['extra_status']==1 && $countextra==1) { ?>
            <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=0&extra_time=<?php echo 1200; ?>"> <span class="label label-success">20 min</span> </a> <?php } else{ ?>
             <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=1&extra_time=<?php echo 2400; ?>"> <span class="label label-success">40 min</span> </a>
            <a href="../controller/extra_time.php?emp_id=<?php echo $emp_id; ?>&idate=<?php echo $date; ?>&extra_status=0&extra_time=<?php echo 1200; ?>"> <span class="label label-success">20 min</span> </a> 
           <?php } ?>
            </td> <?php } ?>
</tr>       
 
<?php }
echo '</table>';  
     
?>

<script>
    $(function() {
        $(".date").datepicker({
            
            changeMonth: true,
            changeYear:false,
            maxDate:0,
            numberOfMonths: 1
        });
        
        $('#time1').timepicker({
            timeFormat: 'hh:mm tt'});
    });
</script>
    



    