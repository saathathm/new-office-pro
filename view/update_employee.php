<?php 
session_start();
if(!isset($_SESSION['emp_type'])){header("Location:login.php");}
include_once '../model/employee.php';
$obj=new employee();
$result=$obj->getEmployee($_REQUEST['employee_id']);
$value=  mysql_fetch_assoc($result);
?>

    <div class="container rbborder" >
    <div style="margin-left: 200px">
    <form action="../controller/update_employee.php" method="post" class=" span6" id="employee">
    <table align="center" class="table table-hover">
                    <tr>
                    <td>First Name</td>
                    <td><input type="text" name="name" id="name" value="<?php echo $value['name']; ?>"></td>
                    </tr>
                    <tr>
                    <td>User Name</td>
                    <td><input type="text" name="uname" id="uname" value="<?php echo $value['user_name']; ?>"></td>
                    </tr>
                    <tr>
                    <td>Password</td>
                    <td><input type="text" name="pass" id="pass" value="<?php echo $value['password']; ?>"></td>
                    </tr>
                    <tr>
                    <td>Email</td>
                    <td><input type="text" name="email" id="email" value="<?php echo $value['email']; ?>"></td>
                    </tr>
                    <tr>
                    <td>Phone No</td>
                    <td><input type="text" name="p_no" id="p_no" value="<?php echo $value['p_no']; ?>"></td>
                    </tr>
                      <tr>
                    <td>User Role</td>
                   <td><select name="emp_type">
                      
                            <option></option>
                            <?php
                           
                            $result1 = $obj->getEmployeeType();
                            while ($value1 = mysql_fetch_assoc($result1)) {
                                ?>
                                <option value="<?php echo $value1['emp_type_id']; ?>" <?php if($value1['emp_type_id']==$value['emp_type']){echo 'selected="selected"';} ?>>
                                    <?php echo $value1['emp_type']; ?>  
                                </option>
                            <?php } ?>
                        </select> </td>
                    </tr>

                <tr><td>
                        <input type="submit" value="Update" class="btn btn-primary" id="submit">
                        <input type="hidden" value="<?php echo $_REQUEST['employee_id']; ?>" name="employee_id" >
                    </td>
                    <td>
                        <input type="reset" value="Clear" class="btn btn-danger"></td>
                </tr>
    </table>
    </form>
    </div>
    </div>
       


