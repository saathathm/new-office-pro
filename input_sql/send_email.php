<?php
include_once 'AppManager.php';
include_once 'maildata.inc.php';
$pm = AppManager::getPM();

if (isset($_POST['send_mail'])) {
    $id = $_POST['user_id'];

    $result = $pm->run("SELECT * FROM user WHERE id=" . $id);
    $value = $result[0];
    $to = $value['email'];
//$subject = "Username and Password";
    $email_message .= "Username : " . $value['username'] . " AND  Password  :  " . $value['passphrase'];
//$header = "From:abc@somedomain.com \r\n";
    $retval = mail($to, $email_subject, $email_message, $header);
    if ($retval == true) {
        header("location:list_user.php?type=sent_mail");
    } else {
        header("location:list_user.php?type=notsent_mail");
    }
}
?>
