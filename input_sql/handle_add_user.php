<?php

include_once 'AppManager.php';
$pm = AppManager::getPM();
include('connect.php');
#Connect to the database
//connection String

$connect = mysql_connect($hostname, $username, $password)
        or die('Could not connect: ' . mysql_error());

//Select The database
$bool = mysql_select_db($database, $connect);
if ($bool === False) {
    print "Can't find $database!";
}

if (isset($_POST['btnsubmit'])) {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];
    $enabled = $_POST['enabled'];
    $inputpage = $_POST["inputpage"] = isset($_POST["inputpage"]) ? $_POST["inputpage"] : 0;
    $manual = $_POST["manual"] = isset($_POST["manual"]) ? $_POST["manual"] : 0;
    $manual2 = $_POST["manual2"] = isset($_POST["manual2"]) ? $_POST["manual2"] : 0;
    $searchpage = $_POST["searchpage"] = isset($_POST["searchpage"]) ? $_POST["searchpage"] : 0;
    $adminpanel = $_POST["adminpanel"] = isset($_POST["adminpanel"]) ? $_POST["adminpanel"] : 0;



    $param = array(":name" => $name, ":surname" => $surname, ":username" => $username, ":email" => $email, ":mobile" => $mobile, ":role" => $role, ":enabled" => $enabled, ":inputpage" => $inputpage, ":manual" => $manual, ":manual2" => $manual2, ":searchpage" => $searchpage, ":adminpanel" => $adminpanel);
    $pm->run("INSERT INTO user(name,surname,username,email,mobile,role,enabled,access_input,access_manual,access_manual2,access_search,access_admin) VALUES(:name,:surname,:username,:email,:mobile,:role,:enabled,:inputpage,:manual,:manual2,:searchpage,:adminpanel)", $param);
    header("location:add_user.php?type=insert");
}
?>
