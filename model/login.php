<?php
require_once 'conn.php';
class login
{
  function getUser($uname, $pass)
  {
    $uname =  str_replace("'", "", $uname);
    $pass =  str_replace("'", "", $pass);
    $sql = "select * from employee where user_name='$uname' AND password='$pass' and active_status='yes'";
    $db = new dbcon();          //dbcon() is class of database connection
    $result = $db->query($sql);
    return $result;
  }
}
