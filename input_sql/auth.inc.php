<?php 
ob_start();
set_time_limit(0);
include 'timezone.inc.php';
	// start or continue session
session_start();
	
	if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {	
		header('Refresh: 0; URL=index.php?redirect=' . $_SERVER['PHP_SELF']);
                exit();
	}

include_once 'AppManager.php';
$pm = AppManager::getPM();
 $_SESSION['userrole'];
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

function time_range_check($from, $to) {
   
        $now = date('H:i:s', time());
   

    $check = $now;
    // date('H:i:s', time());
    $midNight = false;
    $result = true;


    $check1 = date('12:00:00', time());

    if (($to < $check1) && ($from > $check1)) {
        $check = date('24:00:00', time());
//    check.setHours('24','00');
        $midNight = true;
    }

    if ($midNight) {
        if ($from <= $now && $now < $check) {

            $result = true;
        } else if ($now <= $to) {

            $result = true;
        } else {

            $result = false;
        }
    } else {
        if ($from <= $now && $now < $to) {

            $result = true;
        } else {

            $result = false;
        }
    }

    return $result;
}


if($_SESSION['userrole']=='user'){
     $client_ip = get_client_ip();
  // $client_ip ="101.2.182.16";
   $userid = $_SESSION['userid'];
  $count = $pm->getCount("SELECT count(id) as c from predefined_hours");
  $result = $pm->run("SELECT *  from user where id='$userid'");
  $count2 = $pm->getCount("SELECT count(id) as c  from predefined_ipaddress where ipaddress='$client_ip'");
  if($count2==0){
       header('Refresh: 0; URL=index.php?q=i');
                exit();
  }
if(!time_range_check($result[0]['access_from'],$result[0]['access_to'])){
    header('Refresh: 0; URL=index.php?q=h');
                exit();
}


}
        ?>