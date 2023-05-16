<?php

class InventoryManage {

    private $request_id = "";
    private $serviceUrl = "https://mws.amazonservices.com"; 
    private $donerequests = array();

    public function __constructor() {
        
    }
    
    public function downloadReport($reportId){
        
        $config = array(
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );

        $service = new MarketplaceWebService_Client(
                AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, $config, APPLICATION_NAME, APPLICATION_VERSION);


        
        $request = new MarketplaceWebService_Model_GetReportRequest();

        $request->setMerchant(MERCHANT_ID);
        $request->setReport(@fopen('php://temp', 'rw+'));
        $request->setReportId($reportId);

        $report = $this->invokeGetReport($service, $request);
    }
    
    public function checkReportReady($requestid){
 
        $this->request_id=$requestid;
        
        $config = array(
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );

        $service = new MarketplaceWebService_Client(
                AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, $config, APPLICATION_NAME, APPLICATION_VERSION);


        $request = new MarketplaceWebService_Model_GetReportRequestListRequest();
        $request->setMerchant(MERCHANT_ID);

        $idlist = new MarketplaceWebService_Model_IdList();
        $idlist->setId($this->request_id);
        
        $request->setReportRequestIdList($idlist);
        
        $this->invokeGetReportRequestList($service, $request);

        return count($this->donerequests) > 0;
                    
    }

    public function getReportId($requestid){
 
        $this->request_id=$requestid;
        $config = array(
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );

        $service = new MarketplaceWebService_Client(
                AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, $config, APPLICATION_NAME, APPLICATION_VERSION);


        
        $request = new MarketplaceWebService_Model_GetReportListRequest();
        $request->setMerchant(MERCHANT_ID);
        
        $idlist = new MarketplaceWebService_Model_IdList();
        $idlist->setId($this->request_id);
        
        $request->setReportRequestIdList($idlist);
        $reportId = $this->invokeGetReportID($service, $request);
        
        return $reportId;
                    
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
        $request->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
        $this->request_id = $this->invokeRequestReport($service, $request);
        
        echo "New request id is ".$this->request_id."<br/>";
        
        return $this->request_id;
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
                        //echo $reportRequestInfo->getReportRequestId()."==".$this->request_id."<br/>";
                        if ($reportRequestInfo->getReportRequestId()==$this->request_id && $status == "_DONE_" ) {
                        //if ($reportRequestInfo->getReportType() == '_GET_MERCHANT_LISTINGS_DATA_' && $status == "_DONE_" ) {

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
                        if ($reportInfo->getReportRequestId()==$this->request_id) {
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
