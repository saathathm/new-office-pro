
<?php require_once ("config.php"); ?>
<?php require_once("RequestReport.class.php"); ?>
<?php
//error_reporting(0);
session_start();
set_time_limit(0);

ini_set('memory_limit', '512M');



$object = new InventoryManage();
$inven_report=$object->requestInventoryReport();
sleep(30);
$array_txt = $object->getInventoryReport();
print_r($array_txt);
print_r($inven_report);

//echo 'total asins >> ' . $count . '<br/>';

?>