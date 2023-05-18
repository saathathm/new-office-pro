<?php
session_start();
if (isset($_SESSION['emp_type'])) {
  header("Location:overview_new.php");
}
include_once 'header2.php';

?>

<script>
  $(document).ready(function() {

    $('#submit').click(function() {


      var uname = $('#uname').val();
      var pass = $('#pass').val();
      var x = 0;
      if (uname == "") {

        $('#uname').css('border-color', 'red');
        $('#uname').css('background-color', '#ffddcc');
        $('#uname_error').html("<font color='red'>Please enter the Username");
        x++;
      } else {
        $('#uname').css('border-color', '#2aff00');
        $('#uname').css('background-color', '#ffffff');
        $('#uname_error').html("");
      }
      if (pass == "") {

        $('#pass').css('border-color', 'red');
        $('#pass').css('background-color', '#ffddcc');
        $('#pass_error').html("<font color='red'>Please enter the Password");
        x++;
      } else {
        $('#pass').css('border-color', '#2aff00');
        $('#pass').css('background-color', '#ffffff');
        $('#pass_error').html("");
      }
      if (x != 0) {
        return false;
      }
    })
  })
</script>


<div class="container-fluid" style="background-color: grey; height:100vh">

  <center>
    <div id="login-wraper" style="margin-top: 6rem;">
      <form method="post" action="../controller/login.php" class="form login-form">
        <img src="bootstrap/LogoRgb.png" width="42%">

        <div class="body" style="margin-top: 5rem;">

          <div class="input-prepend">
            <span class="add-on"><i class="icon-user"></i></span>
            <input type="text" class="span4" style="border-color:aquamarine;" name="uname" id="uname" placeholder="Username">
          </div>
          <span id="uname_error" class="help-inline"></span>

          <div class="input-prepend">
            <span class="add-on"><i class="icon-lock"></i></span>
            <input type="password" class="span4" style="border-color:aquamarine;" name="pword" id="pass" placeholder="Password">
          </div>
          <span id="pass_error" class="help-inline"></span>

        </div>

        <div class="footer">
          <button type="submit" id="submit" class="btn btn-primary">Login</button>
        </div>

      </form>
    </div>
  </center>
</div>