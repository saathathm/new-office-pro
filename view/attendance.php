<?php
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
require_once '../model/attendance.php';
include_once 'user.php';
date_default_timezone_set('Asia/Colombo');
$date = date("Y-m-d");
$time=date("H:i:s");
$obj=new attendance();
$result=$obj->checkLogoutTime1($_SESSION['emp_id']); //check employee who loggedout or not
$count=$result->num_rows;
$in=date("h:i a",@$_REQUEST['in']);
$out=date("h:i a",@$_REQUEST['out']);
$emp_id=$_SESSION['emp_id'];
 if (isset($_REQUEST['e']) && $_REQUEST['e']=='2') {
    echo '<div class="alert alert-success">
      Login Successfully
        </div>';                                    }
if (isset($_REQUEST['s']) && $_REQUEST['s']=='2') {
    echo '<div class="alert alert-success">
       Successfully reduce the out time
        </div>'; }
if (isset($_REQUEST['e']) && $_REQUEST['e']=='3') {
    echo '<div class="alert alert-success">
      Logout Successfully
        </div>';}
if (isset($_REQUEST['f']) && $_REQUEST['f']=='1') {
    echo '<div class="alert alert-error">
        Note  time overlapping
        </div>';}
if (isset($_REQUEST['f']) && $_REQUEST['f']=='2') {
    echo '<div class="alert alert-error">
    <H4>Error !  </H4>'.$in.'  cannot be greater than '.$out.' on your note.
        </div>';}
if (isset($_REQUEST['f']) && $_REQUEST['f']=='3') {
    echo '<div class="alert alert-error">
    <H4>Error !  </H4> Only can reduce the out time.
        </div>';}
if (isset($_REQUEST['f']) && $_REQUEST['f']=='4') {
    echo '<div class="alert alert-error">
    <H4>Error ! </H4> cannot be reduce out time less than in time .
        </div>';}
 ?>
<!--<script>
 function addNote($emp_id){
        $("#reason"+$emp_id).toggle();
                          }
</script>-->
<div class="">
  <table class="table table-hover rbborder">
      <thead style="background-color:#000; color:#fff;" >
           <td colspan="4">
               <form method="get" action="attendance.php">
               <input type="text" class="date" name="date3" placeholder="Select date" value="<?php if(isset($_REQUEST['date3'])) {?><?php echo $_REQUEST['date3']; }?>">
               <input type="submit"  name="submit" value="Show" class="btn btn-primary">
               </form>
           </td>
       </thead>
       <thead style="background-color:#000; color:#fff;" >
                <th>In</th>
                <th>Out</th>
                <td>Duration(H:M)</td>
                <th>Approval</th>
       </thead>
       <?php 
       if(@$_REQUEST['date3']==""){
       $_REQUEST['date3']=$date;}
       $result1=$obj->getWorkingHoursSession($_SESSION['emp_id'],$_REQUEST['date3']);
       $prayer_time=$obj->getExtraTime($_SESSION['emp_id'],$_REQUEST['date3']);    //get attendance detail
       $count_prayer_time=  $prayer_time->num_rows;
       $value_prayer_time=  $prayer_time->fetch_assoc();
       $p_seconds=0;
       if($count_prayer_time>0){  $p_seconds=$value_prayer_time['extra_time'];}
       while($value=($result1->fetch_assoc())){
      
      if($value['logout_time']!=date("H:i:s", strtotime("12:00 AM"))){
       $seconds=$value['diff'];
          //$stime1=strtotime($value['login_time']);
          //$stime=strtotime($time);
         $_SESSION['arrayHours'][]=$value['diff'];
          
      }
      else{
         $result2=$obj->getCurrentWorkingHoursSession($_SESSION['emp_id'],@$_REQUEST['date3'],$time); 
         $value2=($result2->fetch_assoc());
         $_SESSION['arrayHours'][]=$value2['diff'];
          
         
      }
      $hours = floor(@$seconds / (60 * 60));
                    $divisor_for_minutes = @$seconds % (60 * 60);
                    $minutes = floor($divisor_for_minutes / 60);
                    $divisor_for_seconds = $divisor_for_minutes % 60;
                    $seconds = ceil($divisor_for_seconds); 
       ?>
       <tr>
            <td><?php echo date("h:i a",strtotime($value['login_time'])); ?></td> 
            <td><?php if($value['logout_time']!=date("H:i:s", strtotime("12:00 AM"))){echo '<a href="reduce_time.php?logout_time='.$value['logout_time'].'&&login_time='.$value['login_time'].'&&date='.$_REQUEST['date3'].'&&id='.$value['id'].'"  rel="facebox">'; echo date("h:i a",strtotime($value['logout_time'])); echo '</a>';} else { echo "--:--"; } ?></td>
            <td><?php if($value['logout_time']!=date("H:i:s", strtotime("12:00 AM"))){
                    
                    
                    echo $hours.":".$minutes;
            } else{echo "--:--";}?>
                
            </td>
            <td><?php if($value['status']=='pending') { ?><span class="label label-important"><?php echo $value['status']; ?></span><?php } else if($value['status']=='rejected') { ?><span class="label label-warning"><?php echo $value['status']; ?></span><?php } else{ ?>
                <span class="label label-success"><?php echo $value['status']; ?></span><?php } ?>
            </td>
        </tr>
    <?php }         $seconds=@array_sum($_SESSION['arrayHours'])+$p_seconds;
    
                    $hours = floor($seconds / (60 * 60));
                    $divisor_for_minutes = $seconds % (60 * 60);
                    $minutes = floor($divisor_for_minutes / 60);
                    $divisor_for_seconds = $divisor_for_minutes % 60;
                    $seconds = ceil($divisor_for_seconds); 
                    echo '<span class="label label-info" style="font-size:14px">'."Total Duration&nbsp". $hours.":".$minutes.'</span>';
                    if($count_prayer_time>0){
                                                echo '&nbsp'. '<span class="label label-success" style="font-size:14px">'."Prayer Time ".($p_seconds/60). "min Added". '</span>';}
                    unset($_SESSION['arrayHours']); ?>
    </table>
 </div>
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
    