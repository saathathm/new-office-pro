<?php require_once(dirname(__FILE__) . "/config.php"); ?>
<?php require_once(dirname(__FILE__) . "/RequestReport.class2.php"); ?>
<?php
set_time_limit(0);

$object = new InventoryManage();

//$request_id=$object->requestInventoryReport();
//
//echo "Request id is ".$request_id."<br/>";


$request_id="10154599072";

if($object->checkReportReady($request_id)){
    echo "Report is ready<br/>";
    $reportid = $object->getReportId($request_id);
    echo "Report id is ".$reportid."<br/>";
    $object->downloadReport($reportid);
    
}else{
    echo "Report not ready<br/>";
}

?>