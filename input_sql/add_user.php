<?php
include 'admin.php';

if (isset($_POST['btnsubmit'])) {
    $from = trim($_POST['from']);
    $to = trim($_POST['to']);
    if($from == "" || $to == ""){
         echo '<div class="alert alert-error" style="display: ">Time Field cannot be empty</div>';
         
    }else{
     $password = trim($_POST['password']); 
    $from = (date('H:i', strtotime($from)));
    $to = (date('H:i', strtotime($to)));
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = trim($_POST['username']);
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $enabled = $_POST['enabled'];
    $inputpage = $_POST["inputpage"] = isset($_POST["inputpage"]) ? $_POST["inputpage"] : 0;
    $manual = $_POST["manual"] = isset($_POST["manual"]) ? $_POST["manual"] : 0;
    $manual2 = $_POST["manual2"] = isset($_POST["manual2"]) ? $_POST["manual2"] : 0;
    $searchpage = $_POST["searchpage"] = isset($_POST["searchpage"]) ? $_POST["searchpage"] : 0;
    $adminpanel = $_POST["adminpanel"] = isset($_POST["adminpanel"]) ? $_POST["adminpanel"] : 0;

    $param = array(":username" => $username);
    $count =$pm->getCount("SELECT count(id) as c FROM user WHERE username =:username", $param);
    if($count==0){


    $param = array(":name" => $name, ":surname" => $surname, ":username" => $username, ":email" => $email, ":mobile" => $mobile, ":role" => $role, ":enabled" => $enabled, ":inputpage" => $inputpage, ":manual" => $manual, ":manual2" => $manual2, ":searchpage" => $searchpage, ":adminpanel" => $adminpanel,":from"=>$from,":to"=>$to,"password"=>$password);
    $pm->run("INSERT INTO user(name,surname,username,email,mobile,role,enabled,access_input,access_manual,access_manual2,access_search,access_admin,access_from,access_to,passphrase) VALUES(:name,:surname,:username,:email,:mobile,:role,:enabled,:inputpage,:manual,:manual2,:searchpage,:adminpanel,:from,:to,:password)", $param);
     echo '<div class="alert alert-success" style="display: ">User added successfully</div>';
}
else{ echo '<div class="alert alert-error" style="display: ">Username already exist</div>';}
    }
}
?>
<div class="container">
    <div class="row">
        <div class="span6">
            <?php if (isset($_GET['type']) and $_GET['type'] == "insert") { ?>
        <div class="alert alert-info" style="display: ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            User Added Successfully</div>
    <?php } ?>
             <ul class="breadcrumb">
        <li class="active"><i class="glyphicon glyphicon-user"></i>Add User</li>
    </ul>
    <form action="" id="formAdd" method="post" name="formAdd" class="form-horizontal">
                    <table class="table table-bordered table-hover table-striped">
                        <tbody>

                            <tr>
                                <th align="right">Name:</th>
                                <td><input type="search" id="usr_name" name="name" required> <font
                                        color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <th align="right">Surname:</th>
                                <td><input type="search" 
                                           value=""

                                           size="50" maxlength="255" id="usr_surname" name="surname" required> <font
                                           color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <th align="right">Email:</th>
                                <td><input type="email" value="" id="usr_email" name="email" required> <font
                                           color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <th align="right">Username</th>
                                <td><input type="search" value=""

                                           size="30" maxlength="20" id="usr_username"
                                           name="username" required> <font
                                           color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <th align="right">Password:</th>
                                <td><input type="password" autocomplete="off"
                                            id="usr_password" name="password" required> <font
                                           color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <th align="right">Role:</th>
                                <td><select 

                                            id="usr_role" name="role">

                                        <option value="admin" >Administrator</option>

                                        <option value="user" selected="selected" >User</option>
                                    </select> <font color="#FF0000">*</font></td>
                            </tr>
                            <tr>
                                <th align="right">Enabled:</th>
                                <td><select 
                                            id="usr_enabled" name="enabled">
                                        <option value="0">No</option>
                                        <option selected="" value="1">Yes</option>
                                    </select> <br> <small>*Disabled users cannot log in.</small></td>
                            </tr>
                            <tr>
                                <th align="right">Phone Mobile:</th>
                                <td><input type="text" value="" size="30" maxlength="20" id="usr_phone_mobile" name="mobile" required><font
                                           color="#FF0000">*</font></td>
                            </tr>

                            <tr><th>Access Privilege</th><td>
                                    <input type="checkbox" name="inputpage" value="1" >Input Page<br>
                                    <input type="checkbox" name="manual" value="1" >Manual Page<br>
                                    <input type="checkbox" name="manual2" value="1" >Manual2 Page<br>
                                    <input type="checkbox" name="searchpage" value="1" >Search Page<br>
                                    <input type="checkbox" name="adminpanel" value="1" >Admin Panel<br>
                                </td> 
                            </tr>
                             <tr style="width:100px"><th>Predefined Time</th><td>
                                      <div class="time_pick">
                                   <input type="text"  name="from" id="from" placeholder="From" readonly required>
                                      </div>
                                     <br>
                                      <div class="time_pick">
                                   <input type="text"  name="to" id="to" placeholder="To" readonly required>
                                      </div>
                                 </td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td align="left"><input type="submit" class="btn btn-primary"
                                                        value="Save" name="btnsubmit"> 
                                    <input type="hidden" name="ks_token" id="ks_token" value="6100d4dc8981bcc3664c07c784e58f4d" />
                                    <input type="hidden" name="ks_scriptname" value="list" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
        </div>
        <div class="span6">
            
        </div>
    </div>
   
</div>
<?php include 'footer.php'; ?>
<script src="js/timepicker/timepicki.js">
</script>
<script>
    $('#from').timepicki();
    $("#to").timepicki();
</script>