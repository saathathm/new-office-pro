<!--view-->

<?php include_once 'header.php';

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
                $('#uname_error').html("<font color='red'>Please enter the User Name");
                x++;
            } else {
                $('#uname').css('border-color', '#2aff00');
                $('#uname').css('background-color', '#ffffff');
                $('#uname_error').html("");
            }
            if (pass == "") {
                $('#pass').css('border-color', 'red');
                $('#pass').css('background-color', '#ffddcc');
                $('#pass_error').html("<font color='red'>Please enter the Pass Word");
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



<!--<script>

var myVar=setInterval(function(){myTimer()},1000);



function myTimer()

{

var d=new Date();

var t=d.toLocaleTimeString();

document.getElementById("demo").innerHTML=t;

}

</script>-->





<div class="span4 offset6 rbborder" style="margin-top: 100px">

    <form method="post" action="../controller/login.php"> <!--form start-->

        <table align="center" class="">
            <tr>
                <td> <label>Username</label></td>
                <td><input type="text" name="uname" id="uname">
                    <div id="uname_error"></div>
                </td>
            </tr>
            <tr>
                <td> <label>Password</label></td>
                <td><input type="password" name="pword" id="pass">
                    <div id="pass_error"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Login" class="btn btn-primary" id="submit"></td>
            </tr>

        </table>

    </form> <!--form end-->

</div>