
<? phpinfo(); ?>
<?php
$total_amount=86.85;
$item_name='';
$currency='Rs';
error_reporting(E_STRICT);
/**************************************************/
/*
Released by AwesomePHP.com, under the GPL License, a
copy of it should be attached to the zip file, or
you can view it on http://AwesomePHP.com/gpl.txt
*/
/**************************************************/

/*
This file will display
a form to make a buy now item
*/


/* Get Paypal Class */
require_once('paypal.class.php');

/***************************** BUY NOW EXAMPLE *****************************/
/* Start Class */
$buyNow = new Paypal;

/*
Do you want to test payments
before you actually make a real
payment? If So use the test mode:

*/
$buyNow->useSandBox(true);

/*
You will also need to create a sandbox account
https://developer.paypal.com/
and then create a test account to which you will
use when making the test payments
*/

/*
Add variables to Form 
PARAMTERS MUST ADHERE TO PAYPAL STANDARDS
View all paramters @ PaypalVariables.html
located in main folder of this class
*/

$buyNow->addVar('business','sijanz_1326947412_biz@gmail.com');	/* Payment Email */
$buyNow->addVar('cmd','_xclick');
$buyNow->addVar('amount',$total_amount);
$buyNow->addVar('item_name',$item_name);
$buyNow->addVar('item_number','');
$buyNow->addVar('quantity','1');
$buyNow->addVar('tax','0.00');
$buyNow->addVar('shipping','0.00');
$buyNow->addVar('currency_code','USD');
$buyNow->addVar('no_shipping','2');		/* Must provide shipping address */
$buyNow->addVar('rm','2');			/* Return method must be POST (2) for this class */
$buyNow->addVar('custom',$currency.",".md5($total_amount).",".$txtEmail);
/* Paypal IPN URL - MUST BE URL ENCODED */
$buyNow->addVar('notify_url','http://216.224.178.70/paypal_test/checkpayment.php');	
/*
Thank you Page (if any) - not included in this package*/

$buyNow->addVar('return','http://216.224.178.70/paypal_test/thankyou.php');


/*
Now add a button
*/
$buyNow->addButton(5);	/* Default buy now button */
/* or use custom buttons */
/*
$buyNow->addButton(6,'http://farm1.static.flickr.com/34/110260847_779dd141a6.jpg?v=0');
*/
/* Show final form */
$buyNow->showForm();

/*
To get the form in URL Form (when supported)
You use:
*/
echo '<a href="'.$buyNow->getLink().'"></a>';
?>
</div>
</td>
  </tr>
</table>
<!--</body>-->
