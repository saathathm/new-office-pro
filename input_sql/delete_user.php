<?php
#Connect to the database
include_once 'AppManager.php';
$pm = AppManager::getPM();

if (isset($_POST['del_user'])) {

    $id = $_POST['user_id'];

    $pm->run("DELETE from user WHERE id=" . $id);
    header("location:list_user.php?type=delete");
}
?>
