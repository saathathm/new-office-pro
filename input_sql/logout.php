<?php
// start or continue session
include 'auth.inc.php';

if (isset($_SESSION['logged']) || $_SESSION['logged'] == 1) {
    $author = $_SESSION['username'];
    $ip_address = get_client_ip();
    $logout = date("Y-m-d H:i:s", time());
    $sql = "SELECT id FROM log_activity where ip_address='$ip_address' ORDER BY id DESC
LIMIT 1";
    $result = $pm->run($sql);
    $id = $result[0]['id'];

    $sql = "UPDATE log_activity SET logout ='$logout' WHERE id ='$id' ";
    $pm->run($sql);
    $sql = "DELETE FROM history  WHERE `user` ='$author' ";
    $pm->run($sql);

    $_SESSION['logged'] = 0;
    session_destroy();
    $_SESSION = array();
}
header('Refresh: 0; URL=index.php');
exit();
?>