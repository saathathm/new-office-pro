<?php
include 'header.php';
if($_SESSION['userrole']=='user'){
    if($_SESSION['access_admin'] != 1){
        header('Refresh: 0; URL=main.php?q=denied');
                exit();
    }
    }
include_once 'AppManager.php';
$pm = AppManager::getPM();
?>
<div class="container">
    <ul class="nav nav-pills">
        <li class=""><a href="list_user.php"
                        > List All User</a></li>
        <li class=""><a href="add_user.php"
                        > Add User</a></li>
        <li class=""><a href="log_activity.php"
                        > Log Activity</a></li>
        <li class=""><a href="status_list.php"
                        > Status List</a></li>
        
        <li class=""><a href="add_ip.php"
                        >Manage IP</a></li>
        <li class=""><a href="add_time.php"
                        >Manage Time</a></li>
    </ul>
</div>