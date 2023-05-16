<?php 
session_start();
//$emp_id=$_SESSION['emp_id'];
include_once 'user.php';
include_once '../model/employee.php'; 
include_once '../model/leave.php'; 
$obj=new employee();
$obj1=new leave();
?>
<script>
    function show_staff(val){
    $(document).ready(function(){
    var emp_id=val;
   
    $("#div1").load("employee_profile_ajax.php?emp_id="+emp_id);
     $('a[rel*=facebox]').facebox({
        loadingImage : 'facebox/loading.gif',
        closeImage   : 'facebox/closelabel.png'
        
      })
});    
    }
    function showUser(){

var e = document.getElementById("emp_type");
var emp_id = e.options[e.selectedIndex].value;
$(document).ready(function(){
  
    $("#div1").load("employee_profile_ajax.php?emp_id="+emp_id);
     $('a[rel*=facebox]').facebox({
        loadingImage : 'facebox/loading.gif',
        closeImage   : 'facebox/closelabel.png'
        
      })
});
    }
</script>

<select name="emp_type" id="emp_type" onchange="showUser()">
           <option></option>
                            <?php
                            $obj = new employee();
                            $result = $obj->getAllEmployeeDetail();
                            while ($value = mysql_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $value['emp_id']; ?>">
                                    <?php echo $value['name']; ?>  
                                </option>
                            <?php } ?>
                        </select>

<div class="container-fluid" id="div1">
</div>
<?php if(isset($_SESSION['staff_id'])){  echo '<script> show_staff('.$_SESSION['staff_id'].'); </script>';  } ?>

<!--<script>
window.setTimeout(function() {
    $('#al').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 5000);
</script>-->
