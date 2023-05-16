<?php
session_start();
include_once 'AppManager.php';
$pm = AppManager::getPM();
$list_arrays = $pm->run("SELECT * from status_list");
$query = "SELECT * FROM manual_check2 WHERE (id='" . $_REQUEST['p'] . "');";
$result = $pm->run($query);
$ind_value = $result[0];
?>
<?php if ($_SESSION['userrole'] == 'admin') { ?>
    <form action="" method="POST" id="form2">
        <div class="row">
            <div class="span4">
                <table class="table">
                    <tr> <th>ID</th><td><input type="search" name="rid2" value="<?php echo $ind_value['id']; ?>" readonly></td></tr>
                    <tr><th>Name</th><td><input type="search" name="name" value="<?php echo $ind_value['name']; ?>"></td></tr>
                    <tr><th>Surname</th><td><input type="search" name="surname" value="<?php echo $ind_value['surname']; ?>"></td></tr>
                    <tr><th>Address</th><td><input type="search" name="address" value="<?php echo $ind_value['address']; ?>"></td></tr>
                    <tr><th>Suburb</th><td><input type="search" name="suburb" value="<?php echo $ind_value['suburb']; ?>"></td></tr>
                    <tr><th>State</th><td><input type="search" name="state" value="<?php echo $ind_value['state']; ?>"></td></tr>
                    <tr><th>Zip</th><td><input type="search" name="zip" value="<?php echo $ind_value['zip']; ?>"></td></tr>
                    <tr><th>Mobile</th><td><input type="search" name="mobile" value="<?php echo $ind_value['mobile']; ?>"></td></tr>
                    <tr><th>Alt Phone</th><td><input type="search" name="alt_phone" value="<?php echo $ind_value['alt_phone']; ?>"></td></tr>
                    <tr><th>Home Phone</th><td><input type="search" name="home_phone" value="<?php echo $ind_value['home_phone']; ?>"></td></tr>
                    <tr><th>Business Phone</th><td><input type="search" name="business_phone" value="<?php echo $ind_value['business_phone']; ?>"></td></tr>
                    <tr><th>Status</th><td><select name="status"><option></option><?php foreach ($list_arrays as $list_array) { ?>
                                    <option  <?php
        if ($list_array['list'] == $ind_value['status']) {
            echo "selected ='selected'";
        }
        ?>><?php echo $list_array['list']; ?></option>
                                    <?php } ?>
                            </select></td></tr>
                    <tr><th>Comments</th><td><input type="search" name="comments" value="<?php echo $ind_value['comments']; ?>"></td></tr>
                    <tr><th>Consultant</th><td><input type="search" name="constultant" value="<?php echo $ind_value['constultant']; ?>"></td></tr>
                </table>
            </div>
        </div> 
        <div class="row">
            <div class="span4">

                <input type="hidden" name="rid" value="<?php echo $ind_value['id']; ?>">

    <!--            <input type="submit" class="btn btn-large btn-primary" value="Update" name="update_submit">-->
            </div>
        </div>
    </form>
<?php } else {
    echo '<div class="alert alert-error" style="display: ">Access Denied</div>';
}
?>