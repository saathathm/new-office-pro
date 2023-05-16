<?php
include_once 'AppManager.php';
$pm = AppManager::getPM();

$query = "SELECT * FROM contacts WHERE (id='".$_REQUEST['p']."');";
$result = $pm->run($query);
$ind_value = $result[0];
?>
<form action="" method="POST" id="form1">
    <div class="row">
        <div class="span4">



            <table class="table">
                <tr> <th>ID</th><td><input type="search" name="rid2" value="<?php echo $ind_value['id']; ?>" readonly></td></tr>

                <tr><th>Name</th><td><input type="search" name="name" value="<?php echo $ind_value['name']; ?>" required></td></tr>
                <tr><th>Surname</th><td><input type="search" name="surname" value="<?php echo $ind_value['surname']; ?>"></td></tr>
                <tr><th>Address</th><td><input type="search" name="address" value="<?php echo $ind_value['address']; ?>"></td></tr>
                <tr><th>Suburb</th><td><input type="search" name="suburb" value="<?php echo $ind_value['suburb']; ?>"></td></tr>
                <tr><th>State</th><td><input type="search" name="state" value="<?php echo $ind_value['state']; ?>"></td></tr>
                <tr><th>Zip</th><td><input type="search" name="zip" value="<?php echo $ind_value['zip']; ?>"></td></tr>
                <tr><th>Mobile</th><td><input type="search" name="mobile" value="<?php echo $ind_value['mobile']; ?>"></td></tr>
                <tr><th>Alt Phone</th><td><input type="search" name="alt_phone" value="<?php echo $ind_value['alt_phone']; ?>"></td></tr>
                <tr><th>Home Phone</th><td><input type="search" name="home_phone" value="<?php echo $ind_value['home_phone']; ?>"></td></tr>
            </table>
        </div>
    </div> 
    <div class="row">
        <div class="span4">
            <input type="hidden" name="par_id" value="<?php echo $_REQUEST['par_id']; ?>">
            <input type="hidden" name="rid" value="<?php echo $ind_value['id']; ?>">
            <?php
            foreach ($ind_value as $key => $value) {
                echo '<input type="hidden" name="arr_ind[' . $key . ']" value="' . $value . '">';
            }
            ?>
<!--            <input type="submit" class="btn btn-large btn-primary" value="Update" name="update_submit">-->
        </div>
    </div>
</form>




