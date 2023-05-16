<?php
include_once 'conn.php';
class employee{
    
    function addEmployee($name,$uname,$pass,$email,$p_no,$emp_type){
    $db=new dbcon();
    $sql="insert into employee(name,user_name,password,email,p_no,emp_type)value('$name','$uname','$pass','$email','$p_no','$emp_type')";
    $result=$db->query($sql);
    return $result;
   }
   function getEmployee($emp_id){
    $db=new dbcon();
    $sql="select* from employee where emp_id='$emp_id'";
    $result=$db->query($sql);
    return $result;
   }
   function getEmployeeForApprove($emp_id){
    $db=new dbcon();
    $sql="select* from employee where emp_id='$emp_id'";
    $result=$db->query($sql);
    return $result;
   }
   function getAllEmployeeDetail(){
    $db=new dbcon();
    $sql="select* from employee,employee_type where employee.emp_type=employee_type.emp_type_id and employee.active_status='yes' ";
    $result=$db->query($sql);
    return $result;
   }
   function getAllEmployeeDetail2(){
    $db=new dbcon();
    $sql="select* from employee,employee_type where employee.emp_type=employee_type.emp_type_id";
    $result=$db->query($sql);
    return $result;
   }
   function getEmployeeType(){
    $db=new dbcon();
    $sql="select* from employee_type ";
    $result=$db->query($sql);
    return $result;
   }
    function updateEmployeeDetail($name,$uname,$pass,$email,$p_no,$emp_id,$emp_type)
    {   
         $db=new dbcon();
        $sql="update employee set name='$name',user_name='$uname',password='$pass',email='$email',p_no='$p_no',emp_type='$emp_type' where emp_id='$emp_id'";
        $result=$db->query($sql);
        return $result;
        }
        function getAllEmployee(){
    $db=new dbcon();
    $sql="select* from employee where active_status='yes'";
    $result=$db->query($sql);
    return $result;
   }
   function activeEmployee($employee_id)
    {   
         $db=new dbcon();
        $sql="update employee set active_status='yes' where emp_id='$employee_id'";
        $result=$db->query($sql);
        return $result;
        }
         function deactiveEmployee($employee_id)
    {   
         $db=new dbcon();
        $sql="update employee set active_status='no' where emp_id='$employee_id'";
        $result=$db->query($sql);
        return $result;
        }
}
?>