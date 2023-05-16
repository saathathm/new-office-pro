<?php

class InventoryManage {

    private $request_id = "";
    private $serviceUrl = "https://mws.amazonservices.com"; 
    private $donerequests = array();

    public function __constructor() {
        
    }

    public function getInventoryReport() {

        $config = array(
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );

        //$this->requestid = $this->requestInventoryReport();
        //echo "Request ID $requestid<br/>";

        $service = new MarketplaceWebService_Client(
                AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, $config, APPLICATION_NAME, APPLICATION_VERSION);


        $request = new MarketplaceWebService_Model_GetReportRequestListRequest();
        $request->setMerchant(MERCHANT_ID);
        //$request->setRequestedToDate(new DateTime('+1 day', new DateTimeZone('UTC')));
        //$request->setRequestedFromDate(new DateTime('-20 days', new DateTimeZone('UTC')));
        
        echo "--------".  $this->request_id."-----------<br/>";
        $idlist = new MarketplaceWebService_Model_IdList();
        //$idlist->setId($this->request_id);
        
        //$request->setReportRequestIdList($idlist);

        $reporttypelist = new MarketplaceWebService_Model_TypeList();
        $reporttypelist->setType('_GET_MERCHANT_LISTINGS_DATA_');
        $request->setReportTypeList($reporttypelist);
        
        $this->invokeGetReportRequestList($service, $request);
		
		//print_r($this->donerequests);

//        while (count($this->donerequests) <= 0) {
//            echo "Waiting for report....<br/>";
//            sleep(30);
//            flush();
//            $this->invokeGetReportRequestList($service, $request);
//            flush();
//            
//        }
        
        //print_r($this->donerequests);

        $request = new MarketplaceWebService_Model_GetReportListRequest();
        $request->setMerchant(MERCHANT_ID);
        $request->setAvailableToDate(new DateTime('+1 day', new DateTimeZone('UTC')));
        $request->setAvailableFromDate(new DateTime('-1 day', new DateTimeZone('UTC')));
        $request->setReportTypeList($reporttype);
        $request->setAcknowledged(false);
        $reportId = $this->invokeGetReportID($service, $request);

        if (!empty($reportId)) {

            $request = new MarketplaceWebService_Model_GetReportRequest();
            $request->setMerchant(MERCHANT_ID);
            $request->setReport(@fopen('php://memory', 'rw+'));
            $request->setReportId($reportId);

            $report = $this->invokeGetReport($service, $request);
            return $report;
        }

        return array();
    }

    public function requestInventoryReport() {
        $config = array(
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );
        $service = new MarketplaceWebService_Client(
                AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, $config, APPLICATION_NAME, APPLICATION_VERSION);

        $request = new MarketplaceWebService_Model_RequestReportRequest();
        $request->setMarketplace(MARKETPLACE_ID);
        $request->setMerchant(MERCHANT_ID);
        $request->setStartDate(new DateTime('-2 days', new DateTimeZone('UTC')));
        $request->setEndDate(new DateTime('now', new DateTimeZone('UTC')));
        $request->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
        $this->request_id = $this->invokeRequestReport($service, $request);
        
        echo "New request id is ".$this->request_id."<br/>";
    }

    public function invokeRequestReport(MarketplaceWebService_Interface $service, $request) {
        try {
            $response = $service->requestReport($request);

            if ($response->isSetRequestReportResult()) {


                $requestReportResult = $response->getRequestReportResult();
                if ($requestReportResult->isSetReportRequestInfo()) {

                    $reportRequestInfo = $requestReportResult->getReportRequestInfo();

                    if ($reportRequestInfo->isSetReportRequestId()) {

                        return $reportRequestInfo->getReportRequestId();
                    }
                }
            }

            return "";

            // echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
        } catch (MarketplaceWebService_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
    }

    public function invokeGetReportRequestList(MarketplaceWebService_Interface $service, $request) {
        $this->donerequests = array();
        $response = $service->getReportRequestList($request);
		        
        if ($response->isSetGetReportRequestListResult()) {

            $getReportRequestListResult = $response->getGetReportRequestListResult();

            $reportRequestInfoList = $getReportRequestListResult->getReportRequestInfoList();
            foreach ($reportRequestInfoList as $reportRequestInfo) {

                if ($reportRequestInfo->isSetReportRequestId()) {

					//print_r($reportRequestInfo);
					
                    $function_id = $reportRequestInfo->getReportRequestId();

                    if ($reportRequestInfo->isSetReportProcessingStatus()) {
					
                        $status = $reportRequestInfo->getReportProcessingStatus();
                        echo $reportRequestInfo->getReportRequestId() . ">>" . $reportRequestInfo->getReportType() . ">>" . $status . "<br/>";

                        echo $reportRequestInfo->getReportRequestId()."==".$this->request_id."<br/>";
                        //if ($reportRequestInfo->getReportType() == '_GET_MERCHANT_LISTINGS_DATA_' && $status == "_DONE_" && $reportRequestInfo->getReportRequestId()==$this->request_id) {
                        if ($reportRequestInfo->getReportType() == '_GET_MERCHANT_LISTINGS_DATA_' && $status == "_DONE_" ) {

                            $this->donerequests[] = $reportRequestInfo->getReportRequestId();
                            
                            break;
                        }
                    }
                }
            }
        }
    }

    public function invokeGetReportID(MarketplaceWebService_Interface $service, $request) {
        try {

            $response = $service->getReportList($request);

            if ($response->isSetGetReportListResult()) {

                $getReportListResult = $response->getGetReportListResult();

                $reportInfoList = $getReportListResult->getReportInfoList();

                foreach ($reportInfoList as $reportInfo) {
                    //print_r($reportInfo);
                    if ($reportInfo->isSetReportId()) {
                        if (in_array($reportInfo->getReportRequestId(), $this->donerequests)) {
                            echo 'current request id is >> ' . $reportInfo->getReportRequestId() . '<br/>';
                            return $reportInfo->getReportId();
                        }
                    }
                }
            }
            return "";

            //echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
        } catch (MarketplaceWebService_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }

        return "";
    }

    public function invokeGetReport(MarketplaceWebService_Interface $service, $request) {
        try {
            $response = $service->getReport($request);
            
            //echo "getting report ";
            //echo "<br/>";
            $fp = $request->getReport();
            stream_set_timeout($fp,1200); 
            $report = stream_get_contents($fp);
            
            //echo "data is ".$report;

            file_put_contents("report.txt", $report);
            
            
        } catch (MarketplaceWebService_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
    }

}

?>
