<?php
include_once 'AppManager.php';
include 'timezone.inc.php';

$pm = AppManager::getPM();
session_start();
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {
    $_SESSION['logged'] = 0;
}

// filter incoming values
$user = (isset($_POST['user'])) ? trim($_POST['user']) : '';
$passwd = (isset($_POST['password'])) ? $_POST['password'] : '';
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'main.php';

if (isset($_POST['submit'])) {

    if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
        if (!empty($_POST['user']) && !empty($_POST['password'])) {
           
            $param = array(":username" => $user, ":passphrase" => $passwd);
            $query = "SELECT * FROM user WHERE username=:username AND passphrase=:passphrase AND enabled =1";
            $sql = "SELECT count(id) as c FROM user WHERE username=:username AND passphrase=:passphrase AND enabled =1";
            $count = $pm->getCount($sql,$param);
            $result = $pm->run($query,$param);
            $value = $result[0];

            if ($count > 0) {
                $_SESSION['userid'] = $value['id'];
                $_SESSION['username'] = $user;
                $_SESSION['userrole'] = $value['role'];
                $_SESSION['logged'] = 1;
                $_SESSION['access_manual'] = $value['access_manual'];
                $_SESSION['access_manual2'] = $value['access_manual2'];
                $_SESSION['access_admin'] = $value['access_admin'];
                $_SESSION['access_search'] = $value['access_search'];
                $_SESSION['access_input'] = $value['access_input'];
                $author = $_SESSION['username'];
$ip_address = get_client_ip();
$login = date("Y-m-d H:i:s", time());
$param = array(':username' => $author, ':ip_address' => $ip_address, ':login' => $login);
$sql = "INSERT INTO log_activity (username,ip_address,login) VALUES (:username,:ip_address,:login)";
$pm->run($sql, $param);
                echo "success";
            } else {
                // set these explicitly just to make sure
                $_SESSION['username'] = '';
                $_SESSION['logged'] = 0;
                echo "fail";
            }
        }
    } else {
        echo "success";
    }
}
?>
