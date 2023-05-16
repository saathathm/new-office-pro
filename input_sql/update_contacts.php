<?php
session_start();
include 'timezone.inc.php';
include_once 'AppManager.php';
$pm = AppManager::getPM();

if (isset($_POST['update_submit'])) {
    $arr_ind = $_POST['arr_ind'];

    $rid = $_POST['rid'];
    $name = trim(strtoupper($_POST['name']));
    $surname = trim(strtoupper($_POST['surname']));
    $address = trim(strtoupper($_POST['address']));
    $suburb = trim(strtoupper($_POST['suburb']));
    $state = trim(strtoupper($_POST['state']));
    $zip = trim($_POST['zip']);
    $home_phone = trim($_POST['home_phone']);
    $business_phone = trim($_POST['business_phone']);
    $alt_phone = trim($_POST['alt_phone']);
    $status = trim(strtoupper($_POST['status']));
    $comments = trim(strtoupper($_POST['comments']));
    $last_update = date("Y-m-d H:i:s", time());
    $constultant = trim(strtoupper($_POST['constultant']));
    $original_data = $pm->run("SELECT * FROM contacts WHERE id='$rid'");
    $original_data = serialize($original_data);
    if ($_SESSION['userrole'] == 'admin') {
        $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":home_phone" => $home_phone, ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":rid" => $rid);
        $pm->run("UPDATE  contacts set name =:name,surname =:surname,address =:address,suburb=:suburb,state=:state,zip=:zip,home_phone=:home_phone,business_phone=:business_phone,alt_phone=:alt_phone,status=:status,comments=:comments,constultant=:constultant where id=:rid", $param);

        header("location:search_page.php?rid=$rid&q=success&search_submit=Search");
    }
    if ($_SESSION['userrole'] == 'user') {
        $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":mobile" => $arr_ind['mobile'], ":mobile2" => $arr_ind['mobile2'], ":home_phone" => $home_phone, ":home_phone2" => $arr_ind['home_phone2'], ":business_phone" => $business_phone, ":alt_phone" => $alt_phone, ":business_name" => $arr_ind['business_name'], ":business_address" => $arr_ind['business_address'], ":business_zip" => $arr_ind['business_zip'], ":import" => $arr_ind['import'], ":output" => $arr_ind['output'], ":last_update" => $last_update, ":status" => $status, ":comments" => $comments, ":constultant" => $constultant, ":active" => $arr_ind['active']);
        $last_id = $pm->insertAndGetLastRowId("INSERT INTO manual_check2(`name`, `surname`, `address`, `suburb`, `state`, `zip`, `mobile`, `mobile2`, `home_phone`, `home_phone2`, `business_phone`, `alt_phone`, `business_name`, `business_address`, `business_zip`, `import`, `output`, `last_update`, `status`, `comments`, `constultant`, `active`) 
                VALUES(:name, :surname , :address, :suburb, :state, :zip, :mobile, :mobile2, :home_phone, :home_phone2, :business_phone, :alt_phone, :business_name, :business_address, :business_zip, :import, :output, :last_update, :status, :comments, :constultant, :active)", $param);
        $user =  @$_SESSION['username'];
        $pm->run("insert into rec_move(`from_table`,`from`,`to`,`date`,`user`,`original_data`) values('contacts','$rid','$last_id','$last_update','$user','$original_data')");
        header("location:search_page.php?rid=$rid&q=success&search_submit=Search&m=app");
    }
}
?>
