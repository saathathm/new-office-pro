<?php
session_start();
  $arr =$_SESSION['session_data'][6];
  print_r($arr);
  if(!array_key_exists(6,$_SESSION['session_data'])){
      echo 'ddddd';
  }
?>
