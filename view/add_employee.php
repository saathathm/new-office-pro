<?php 
session_start();
if(isset($_SESSION['emp_type']) && ($_SESSION['emp_type'])!=1 && $_SESSION['emp_type']!=2 ){header("Location:login.php");}
include 'user.php';
include_once '../model/employee.php';
if (isset($_REQUEST['s']) && $_REQUEST['s']=='1') {
    echo '<div class="alert alert-success">
      User added Successfully
        </div>';
    } 
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#submit').click(function(){
            var name=$('#name').val();
            var uname=$('#uname').val();
            var pass=$('#pass').val();
            var tele=$('#tele').val();
            var email=$('#email').val();
            var emp_type=$('#emp_type').val();
            var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
            var x=0;
            if(name==""){
                
                $('#name').css('border-color','red');
                $('#name').css('background-color','#ffddcc');
                $('#name_error').html("<font color='red'>Please enter the Name");
                x++;
            }
            
            else{
                
                
                $('#name').css('border-color','#2aff00');
                $('#name').css('background-color','white');
                $('#name_error').html("");
                
            }
            if(uname==""){
                
                $('#uname').css('border-color','red');
                $('#uname').css('background-color','#ffddcc');
                $('#uname_error').html("<font color='red'>Please enter the User Name");
                x++;
            }
            
            else{
                
                
                $('#uname').css('border-color','#2aff00');
                $('#uname').css('background-color','#ffffff');
                $('#uname_error').html("");
                
            }
            if(pass==""){
                
                $('#pass').css('border-color','red');
                $('#pass').css('background-color','#ffddcc');
                $('#pass_error').html("<font color='red'>Please enter the PassWord");
                x++;
            }
            
            else{
                
                
                $('#pass').css('border-color','#2aff00');
                $('#pass').css('background-color','#ffffff');
                $('#pass_error').html("");
                
            }
            
            
            if(tele==""){
                
                $('#tele').css('border-color','red');
                $('#tele').css('background-color','#ffddcc');
                $('#tele_error').html("<font color='red'>Please enter the Mobile No");
                x++;
            }
            
            else{
                $('#tele').css('border-color','#2aff00');
                $('#tele').css('background-color','#ffffff');
                $('#tele_error').html("");
            }
            if(email==""){
                
                $('#email').css('border-color','red');
                $('#email').css('background-color','#ffddcc');
                $('#email_error').html("<font color='red'>Please enter the Email");
                x++;
            }
            
            else{
                if(!pattern.test(email)){ $('#email').css('border-color','red');
                    $('#email').css('background-color','#ffddcc');
                    $('#email_error').html("<font color='red'>Invalid Email");
                    x++;}
                else{
                    $('#email').css('border-color','#2aff00');
                    $('#email').css('background-color','#ffffff');
                    $('#email_error').html("");
                }}
            
            
            if(emp_type==""){
                
                $('#emp_type').css('border-color','red');
                $('#emp_type').css('background-color','#ffddcc');
                $('#emp_type_error').html("<font color='red'>Select Employee Type");
                x++;
            }
            
            else{
               
                $('#emp_type').css('border-color','#2aff00');
                $('#emp_type').css('background-color','white');
                $('#emp_type_error').html("");
                
            }
            if(x!=0 ){return false;}
        }) 
    })
</script>
<div class="container rbborder" >
    <div style="margin-left:0">
        <form action="../controller/add_employee.php" method="post"  id="employee">
            <table align="center" class="table table-hover">
                 <thead style="background-color:#000; color:#fff;" ><td>Add Employee Details</td><td></td></thead>
                <tr>
                    <td>First Name</td>
                    <td><input type="text" name="name" id="name"><div id="name_error"></div></td>
                </tr>
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="uname" id="uname"><div id="uname_error"></div></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="text" name="pass" id="pass"><div id="pass_error"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" id="email"><div id="email_error"></td>
                </tr>
                <tr>
                    <td>Phone No</td>
                    <td><input type="text" name="p_no" id="tele"><div id="tele_error"></div></td>
                </tr>
                <tr>
                    <td>Employee Type</td>
                            <td><select name="emp_type" id="emp_type">
                      
                            <option></option>
                            <?php
                            $obj = new employee();
                            $result = $obj->getEmployeeType();
                            while ($value = mysql_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $value['emp_type_id']; ?>">
                                    <?php echo $value['emp_type']; ?>  
                                </option>
                            <?php } ?>
                        </select> <div id="emp_type_error"></div></td>
                </tr>
                <tr><td>
                        <input type="submit" value="Add" class="btn btn-primary" id="submit" name="submit"></td>
                    <td>
                        <input type="reset" value="Clear" class="btn btn-danger"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

