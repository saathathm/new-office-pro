<?php
include_once 'AppManager.php';
$pm = AppManager::getPM();

if(isset($_POST['update_submit'])){
    $password = trim($_POST['password']); 
     $from = trim($_POST['from']); 
    $to = trim($_POST['to']);
    $from = (date('H:i', strtotime($from)));
    $to = (date('H:i', strtotime($to)));
    $rid = $_POST['rid'];
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
    
   
   
    $param = array(":name" => $name, ":surname" => $surname,":username" => $username, ":email" => $email, ":mobile" => $mobile, ":role" => $role,":enabled" => $enabled, ":inputpage" => $inputpage,":manual" => $manual,":manual2" => $manual2,":searchpage" => $searchpage,":adminpanel" => $adminpanel,":from"=>$from,":to"=>$to,":password"=>$password,":rid"=>$rid);
$pm->run("UPDATE  user set name =:name,surname =:surname,username =:username,email =:email,mobile=:mobile,role=:role,enabled=:enabled,access_input=:inputpage,access_manual=:manual,access_manual2=:manual2,access_search=:searchpage,access_admin=:adminpanel,access_from=:from,access_to=:to,passphrase=:password where id=:rid", $param);
    header("location:list_user.php?type=update");
   
}
?>
