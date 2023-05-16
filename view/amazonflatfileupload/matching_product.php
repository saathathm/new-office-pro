<?php
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//curl_exec($ch);
        //curl_close($ch);
set_time_limit(0);
include("config.php");
include('GetMatchingProductForIdSample.php');
  $asin ="LTH1BLK-IP4-4S-ABST-10002";
  $pxml = get_product($asin);
	print_r($pxml);
	

   // echo $item = $pxml->GetMatchingProductForIdResult->attributes()->status;
 //$items = $pxml->GetMatchingProductForIdResult->attributes()->status;

   echo $item = $pxml->GetMatchingProductForIdResult->attributes()->Id;

    echo $brand = $items->AttributeSets->ItemAttributes->Brand;
   
	


?>
