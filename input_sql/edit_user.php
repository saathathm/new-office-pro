<?php
#Connect to the database
include_once 'AppManager.php';
$pm = AppManager::getPM();
$query = "SELECT * FROM user WHERE (id='" . $_REQUEST['id'] . "');";
$result = $pm->run($query);

$ind_value = $result[0];
//if (isset($_POST['update_submit'])) {
//     
//    $rid = $_POST['rid'];
//    $name = $_POST['name'];
//    $surname = $_POST['surname'];
//    $address = $_POST['address'];
//    $suburb = $_POST['suburb'];
//    $state = $_POST['state'];
//    $zip = $_POST['zip'];
//    $home_phone = $_POST['home_phone'];
//    $business_phone = $_POST['business_phone'];
//    $alt_phone = $_POST['alt_phone'];
//    $status = $_POST['status'];
//    $comments = $_POST['comments'];
//    $constultant = $_POST['constultant'];
//    $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":home_phone" => $home_phone, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":rid" => $rid);
//    $pm->run("UPDATE  contacts set name =:name,surname =:surname,address =:address,suburb=:suburb,state=:state,zip=:zip,home_phone=:home_phone,business_phone=:business_phone,alt_phone=:alt_phone,status=:status,comments=:comments,constultant=:constultant where id=:rid", $param);
//}
?>
<form action="update_user.php" method="POST">
    <div class="row">
        <div class="span4">
            <table class="table">
                <tr> <th>ID</th><td><input type="search" name="rid2" value="<?php echo $ind_value['id']; ?>" readonly></td></tr>
                <tr><th>Name</th><td><input type="search" name="name" value="<?php echo $ind_value['name']; ?>" required></td></tr>
                <tr><th>Surname</th><td><input type="search" name="surname" value="<?php echo $ind_value['surname']; ?>" required></td></tr>
                <tr><th>Username</th><td><input type="search" name="username" value="<?php echo $ind_value['username']; ?>" required readonly></td></tr>
                <tr><th>Password</th><td><input type="search" name="password" value="<?php echo $ind_value['passphrase']; ?>" required ></td></tr>
                <tr><th>Email</th><td><input type="email" name="email" value="<?php echo $ind_value['email']; ?>" required></td></tr>
                <tr><th>Mobile</th><td><input type="search" name="mobile" value="<?php echo $ind_value['mobile']; ?>" required></td></tr>
                <tr><th>Role</th><td><select  name="role">
                            <option value="admin" <?php
if ($ind_value['role'] == "admin") {
    echo 'selected="selected"';
}
?>>Administrator</option>
                            <option value="user" <?php
                                    if ($ind_value['role'] == "user") {
                                        echo 'selected="selected"';
                                    }
?> >User</option>
                        </select></td>
                </tr>
                <tr>
                    <th align="right">Enabled:</th>
                    <td><select 

                            id="usr_enabled" name="enabled">
                            <option  value="0" <?php
                                    if ($ind_value['enabled'] == 0) {
                                        echo 'selected="selected"';
                                    }
?>>No</option>
                            <option  value="1" <?php
                                    if ($ind_value['enabled'] == 1) {
                                        echo 'selected="selected"';
                                    }
?>>Yes</option>
                        </select> <br> <small>*Disabled users cannot log in.</small></td>
                </tr>
            </table>
        </div>
        <div class="span4">
            <table class="table">
                 <tr><th></th><td> <label>Access Privilege</label></td></tr>
               
                <tr><th>Input Page</th><td><input type="checkbox" name="inputpage" value="1" <?php
                                    if ($ind_value['access_input'] == 1) {
                                        echo "checked";
                                    }
?> ></td></tr>
                <tr><th>Manual Page</th><td><input type="checkbox" name="manual" value="1" <?php
                        if ($ind_value['access_manual'] == 1) {
                            echo "checked";
                        }
?>></td></tr>
                <tr><th>Manual2 Page</th><td><input type="checkbox" name="manual2" value="1" <?php
                        if ($ind_value['access_manual2'] == 1) {
                            echo "checked";
                        }
?>></td></tr>
                <tr><th>Search Page</th><td><input type="checkbox" name="searchpage" value="1" <?php
                        if ($ind_value['access_search'] == 1) {
                            echo "checked";
                        }
?>></td></tr>
                <tr><th>Admin Panel</th><td><input type="checkbox" name="adminpanel" value="1" <?php
                        if ($ind_value['access_admin'] == 1) {
                            echo "checked";
                        }
?>></td></tr>
                <tr><th></th><td> <label>Predefined Time</label></td></tr>
                <tr><th>From</th><td><div class="time_pick"><input type="text" name="from" id="from" value="<?php echo date("g:i A", strtotime($ind_value['access_from'])); ?>" readonly></div></td></tr>
                <tr><th>To</th><td><div class="time_pick"><input type="text" id="to" name="to"  value="<?php echo date("g:i A", strtotime($ind_value['access_to'])); ?>" readonly ></div></td></tr>
            </table>
        </div>
    </div> 
    <div class="row">
        <div class="span4">
            <input type="hidden" name="rid" value="<?php echo $ind_value['id']; ?>">
            <input type="submit" class="btn  btn-primary" value="Update" name="update_submit">
        </div>
    </div>
</form>


<script>
    $('#from').timepicki();
    $("#to").timepicki();
</script>


