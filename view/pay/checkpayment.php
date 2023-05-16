<?php



/**************************************************/
/*
Released by AwesomePHP.com, under the GPL License, a
copy of it should be attached to the zip file, or
you can view it on http://AwesomePHP.com/gpl.txt
*/
/**************************************************/

/*
This file will teach you show to use our class
to process payments from Paypal
*/

/* Get Paypal Class */
require_once('paypal.class.php');


$doCheck = new Paypal;

/* Record bad/unauthorized transactions */
$doCheck->setLogFile('logfile.txt');

/*
Do actual checking 
isPaid will be true if payment is good, otherwise
it will be false
*/
$doCheck->paypal_ipn($_POST);
$doCheck->send_response($_POST);


		
//if($doCheck->is_verified()){
	/* Now do your own game, process the payment, store it in file or database */
	/* To see sample implementation see our Membership V2.0 script found on our website */

	/*
	Here are some values returned. Entire paramters can be seen on
	PaypalVariables.html located in main folder 
	*/

	/*
	check the $payment_status is Completed
	check that $txn_id has not been previously processed
	check that $receiver_email is your Primary PayPal email
	check that $payment_amount/$payment_currency are correct
	process payment
	*/
	
	/*
	You can check the $payment_status and do your processing.
	A list of what $payment_status might contain is avaiable
	on PaymentStatus.html located in main folder
	*/
	
	
	$payment_status				=	$_POST['payment_status']; // => Completed
    $transaction_id				=	$_POST['txn_id']; // => 1NW94155T82556513
	$amount						=	$_POST['mc_gross'];	
	$currency					=	$_POST['mc_currency'];
	$payment_type				=	$_POST['payment_type'];
	$payment_date 				=	$_POST['payment_date'];
	$first_name 				=	$_POST['first_name'];
	$last_name 					=	$_POST['last_name'];
	$payer_email 				=	$_POST['payer_email'];
	$receiver_email 			=	$_POST['receiver_email'];
	$item_name 					=	$_POST['item_name'];
	$shipping 					=	$_POST['shipping'];
	$custom 					=	$_POST['custom'];
	$invoice  					=	$_POST['invoice'];
	
	/*$q="insert into users(user_id,user_name,pass,user_role)
	values('$payment_status','$transaction_id','$amount','$currency')";
	$r=mysql_query($q) or die(mysql_error());
	if(mysql_affected_rows($dbc)>0){*/
	
	$myFile = "testFile.txt";
	$fh = fopen($myFile, 'w') or die("can't open file");

	fwrite($fh, $payment_date);
	 
	fclose($fh);
		
		//header("Location:www.facebook.com");
		 
	//	}
	
	   
	
	


?>