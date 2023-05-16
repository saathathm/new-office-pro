<?php 
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 */
/******************************************************************************* 

 *  Marketplace Web Service PHP5 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 * 
 */

/**
 * Submit Feed  Sample
 */

//include_once ('config.inc.php'); 


function amazon_send_file($localFile, $type='get_all') {
   
        /*if (empty($localFile)) return 'Error No File!';
        if (!file_exists($localFile)) return 'File does not exist!';*/

        /************************************************************************
        * Uncomment to configure the client instance. Configuration settings
        * are:
        *
        * - MWS endpoint URL
        * - Proxy host and port.
        * - MaxErrorRetry.
        ***********************************************************************/
        // IMPORTANT: Uncomment the approiate line for the country you wish to
        // sell in:
        // United States:
        $serviceUrl = "https://mws.amazonservices.com";
        // United Kingdom
        //$serviceUrl = "https://mws-eu.amazonservices.com";
        // Germany
        //$serviceUrl = "https://mws.amazonservices.de";
        // France
        //$serviceUrl = "https://mws.amazonservices.fr";
        // Japan
        //$serviceUrl = "https://mws.amazonservices.jp";
        
        $config = array (
          'ServiceURL' => $serviceUrl,
          'ProxyHost' => null,
          'ProxyPort' => 21,
          'MaxErrorRetry' => 3,
        );
        
        /************************************************************************
         * Instantiate Implementation of MarketplaceWebService
         * 
         * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
         * are defined in the .config.inc.php located in the same 
         * directory as this sample
         ***********************************************************************/
         $service = new MarketplaceWebService_Client(
             AWS_ACCESS_KEY_ID, 
             AWS_SECRET_ACCESS_KEY, 
             $config,
             APPLICATION_NAME,
             APPLICATION_VERSION);
         
        /************************************************************************
         * Uncomment to try out Mock Service that simulates MarketplaceWebService
         * responses without calling MarketplaceWebService service.
         *
         * Responses are loaded from local XML files. You can tweak XML files to
         * experiment with various outputs during development
         *
         * XML files available under MarketplaceWebService/Mock tree
         *
         ***********************************************************************/
         // $service = new MarketplaceWebService_Mock();
        
        /************************************************************************
         * Setup request parameters and uncomment invoke to try out 
         * sample for Submit Feed Action
         ***********************************************************************/
         // @TODO: set request. Action can be passed as MarketplaceWebService_Model_SubmitFeedRequest
         // object or array of parameters
        
        // Note that PHP memory streams have a default limit of 2M before switching to disk. While you
        // can set the limit higher to accomidate your feed in memory, it's recommended that you store
        // your feed on disk and use traditional file streams to submit your feeds. For conciseness, this
        // examples uses a memory stream.
        
      
		
		//print_r ($feed);
             
         // MWS request objects can be constructed two ways: either passing an array containing the 
         // required request parameters into the request constructor, or by individually setting the request
         // parameters via setter methods.
         // Uncomment one of the methods below.
         
        /********* Begin Comment Block *********/
        //$feedHandle = @fopen('php://memory', 'rw+');
        //fwrite($feedHandle, $feed);
        //rewind($feedHandle);
        
        // TEST FILE:
        // $localFile = '/home/ahcorp/s/import_feeds/amazon_update_11-16.csv';
        
/*

Product Feed	_POST_PRODUCT_DATA_	XML
Relationships Feed	_POST_PRODUCT_RELATIONSHIP_DATA_	XML
Single Format Item Feed	_POST_ITEM_DATA_	XML
Shipping Override Feed	_POST_PRODUCT_OVERRIDES_DATA_	XML
Product Images Feed	_POST_PRODUCT_IMAGE_DATA_	XML
Pricing Feed	_POST_PRODUCT_PRICING_DATA_	XML
Inventory Feed	_POST_INVENTORY_AVAILABILITY_DATA_	XML
Order Acknowledgement Feed	_POST_ORDER_ACKNOWLEDGEMENT_DATA_	XML
Order Fulfillment Feed	_POST_ORDER_FULFILLMENT_DATA_	XML
FBA Shipment Injection Fulfillment Feed	_POST_FULFILLMENT_ORDER_REQUEST_DATA_	XML
FBA Shipment Injection Cancellation Feed	_POST_FULFILLMENT_ORDER_CANCELLATION_REQUEST_DATA_	XML
Order Adjustment Feed	_POST_PAYMENT_ADJUSTMENT_DATA_	XML
Flat File Listings Feed	_POST_FLAT_FILE_LISTINGS_DATA_	Tab delimited
Flat File Order Acknowledgement Feed	_POST_FLAT_FILE_ORDER_ACKNOWLEDGEMENT_DATA_	Tab delimited
Flat File Order Fulfillment Feed	_POST_FLAT_FILE_FULFILLMENT_DATA_	Tab delimited
Flat File Order Adjustment Feed	_POST_FLAT_FILE_PAYMENT_ADJUSTMENT_DATA_	Tab delimited
Flat File Inventory Loader Feed	_POST_FLAT_FILE_INVLOADER_DATA_	Tab delimited
Flat File Music Loader File	_POST_FLAT_FILE_CONVERGENCE_LISTINGS_DATA_	Tab delimited
Flat File Book Loader File	_POST_FLAT_FILE_BOOKLOADER_DATA_	Tab delimited
Flat File Price and Quantity Update File	_POST_FLAT_FILE_PRICEANDQUANTITYONLY_UPDATE_DATA_	Tab delimited
UIEE Inventory File	_POST_UIEE_BOOKLOADER_DATA_	Universal Information Exchange Environment (UIEE)

*/

       // _POST_FLAT_FILE_INVLOADER_DATA_
        //readfile($localFile);
		
        $feedHandle = fopen ($localFile, "r");
        fwrite($feedHandle, $feed);
        rewind($feedHandle);
        
        if ($type == 'quantity') {
            $feedStringType = '_POST_FLAT_FILE_PRICEANDQUANTITYONLY_UPDATE_DATA_';
            $parameters = array (
              'Marketplace' => MARKETPLACE_ID,
              'Merchant' => MERCHANT_ID,
              'FeedType' => $feedStringType, 
              'FeedContent' => $feedHandle,
              'PurgeAndReplace' => false,
              'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
            );
            echo "\n\n ---> QUANTITY UPLOAD";
            print_r ($parameters);
        }
        if ($type == 'modify_all') { 
            $feedStringType = '_POST_FLAT_FILE_LISTINGS_DATA_';
            $parameters = array (
              'Marketplace' => MARKETPLACE_ID,
              'Merchant' => MERCHANT_ID,
              'FeedType' => $feedStringType, 
              'FeedContent' => $feedHandle,
              'PurgeAndReplace' => TRUE,
              'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
            );

            print_r ($parameters);
        }
		// Naaz
		if ($type == 'get_all') { 
            $feedStringType = '_POST_FLAT_FILE_INVLOADER_DATA_';
            $parameters = array (
              'Marketplace' => MARKETPLACE_ID,
              'Merchant' => MERCHANT_ID,
              'FeedType' => $feedStringType, 
              'FeedContent' => $feedHandle,
              'PurgeAndReplace' => FALSE,
              'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
            );
        }
		
		
        if ($type == 'update_all') { 
            $feedStringType = '_POST_FLAT_FILE_LISTINGS_DATA_';
            $parameters = array (
              'Marketplace' => MARKETPLACE_ID,
              'Merchant' => MERCHANT_ID,
              'FeedType' => $feedStringType, 
              'FeedContent' => $feedHandle,
              'PurgeAndReplace' => FALSE,
              'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
            );
        }

		if ($type == 'add_to_inventory') { 
            $feedStringType = '_POST_FLAT_FILE_LISTINGS_DATA_';
            $parameters = array (
              'Marketplace' => MARKETPLACE_ID,
              'Merchant' => MERCHANT_ID,
              'FeedType' => $feedStringType, 
              'FeedContent' => $feedHandle,
              'PurgeAndReplace' => FALSE,
              'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
            );
			
        }
		

        
        rewind($feedHandle);
        
        $request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);
       
        $submitionId=invokeSubmitFeed($service, $request);
        
        @fclose($feedHandle);
		
		return $submitionId;

}
                                        
/**
  * Submit Feed Action Sample
  * Uploads a file for processing together with the necessary
  * metadata to process the file, such as which type of feed it is.
  * PurgeAndReplace if true means that your existing e.g. inventory is
  * wiped out and replace with the contents of this feed - use with
  * caution (the default is false).
  *   
  * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
  * @param mixed $request MarketplaceWebService_Model_SubmitFeed or array of parameters
  */
  function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) 
  {
      try {
		      
              $response = $service->submitFeed($request);
              
                echo ("Service Response\n");
                echo ("=============================================================================\n");

                echo("        SubmitFeedResponse\n");
                if ($response->isSetSubmitFeedResult()) { 
                    echo("            SubmitFeedResult\n");
                    $submitFeedResult = $response->getSubmitFeedResult();
                    if ($submitFeedResult->isSetFeedSubmissionInfo()) { 
                        echo("                FeedSubmissionInfo\n");
                        $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                        if ($feedSubmissionInfo->isSetFeedSubmissionId()) 
                        {
                            echo("                    FeedSubmissionId\n");
                            echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");
                        }
                        if ($feedSubmissionInfo->isSetFeedType()) 
                        {
                            echo("                    FeedType\n");
                            echo("                        " . $feedSubmissionInfo->getFeedType() . "\n");
                        }
                        if ($feedSubmissionInfo->isSetSubmittedDate()) 
                        {
                            echo("                    SubmittedDate\n");
                            echo("                        " . $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
                        }
                        if ($feedSubmissionInfo->isSetFeedProcessingStatus()) 
                        {
                            echo("                    FeedProcessingStatus\n");
                            echo("                        " . $feedSubmissionInfo->getFeedProcessingStatus() . "\n");
                        }
                        if ($feedSubmissionInfo->isSetStartedProcessingDate()) 
                        {
                            echo("                    StartedProcessingDate\n");
                            echo("                        " . $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
                        }
                        if ($feedSubmissionInfo->isSetCompletedProcessingDate()) 
                        {
                            echo("                    CompletedProcessingDate\n");
                            echo("                        " . $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT) . "\n");
                        }
						return $feedSubmissionInfo->getFeedSubmissionId();
                    } 
                } 
                if ($response->isSetResponseMetadata()) { 
                    echo("            ResponseMetadata\n");
                    $responseMetadata = $response->getResponseMetadata();
                    if ($responseMetadata->isSetRequestId()) 
                    {
                        echo("                RequestId\n");
                        echo("                    " . $responseMetadata->getRequestId() . "\n");
                    }
                } 

     } catch (MarketplaceWebService_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
     }
	 return "";
 }
                                                                
