<?php
session_start();
include_once 'AppManager.php';
$pm = AppManager::getPM();
if (isset($_POST['rid'])) {
    $par_id = trim($_POST['par_id']);
    $rid = trim($_POST['rid']);
    $name = trim(strtoupper($_POST['name']));
    $surname = trim(strtoupper($_POST['surname']));
    $address = trim(strtoupper($_POST['address']));
    $suburb = trim(strtoupper($_POST['suburb']));
    $state = trim(strtoupper($_POST['state']));
    $zip = trim(strtoupper($_POST['zip']));
    $home_phone = trim($_POST['home_phone']);
    $mobile = trim($_POST['mobile']);
    $alt_phone = trim($_POST['alt_phone']);
//    $status = $_POST['status'];
//    $comments = $_POST['comments'];
//    $constultant = $_POST['constultant'];
    $param = array(":name" => $name, ":surname" => $surname, ":address" => $address, ":suburb" => $suburb, ":state" => $state, ":zip" => $zip, ":home_phone" => $home_phone, ":mobile_phone" => $mobile, ":alt_phone" => $alt_phone, ":rid" => $rid);
    $pm->run("UPDATE  contacts set name =:name,surname =:surname,address =:address,suburb=:suburb,state=:state,zip=:zip,home_phone=:home_phone,mobile=:mobile_phone,alt_phone=:alt_phone where id=:rid", $param);
    if (array_key_exists($par_id, $_SESSION['session_data'])) {
        unset($_SESSION['session_data'][$par_id]);
    } else {
        
    }

    // echo '<td>1</td><td>'.$name.'</td><td>'.$surname.'</td><td>'.$address.'</td><td>BRISBANEA</td><td>NT</td><td>8741</td><td>0</td><td>638416074</td><td>845301525</td><td>1</td><td><button id="'.$rid.'" class="btnDelete" type="button">Launch modal</button></td>';
}
?>
