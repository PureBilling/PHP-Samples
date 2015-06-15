<html>
<head></head>
<body>

<?php

/**
 * SDK Setup
 */
require_once('purebilling-config-test.php');
use PureBilling\Bundle\SDKBundle\Store\V1 as Store;
use PureMachine\Bundle\SDKBundle\Service\WebServiceClient;
use PureMachine\Bundle\SDKBundle\Exception\WebServiceException;

$refund = new Store\Charge\Action\Refund();
$refund->setBillingTransaction($_REQUEST["pb_billing_transaction"]);
$refund->setShortDescription('refund test');

/**
 * refund the transaction
 */
$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/Refund', $refund);
WebServiceException::raiseIfError($response);

$billingTransaction = $response->getAnswer();

if ($billingTransaction->getStatus() == 'paid') {
    print "Transaction refunded !!";
}

?>


<p>
    <a href="/">Back to home page</a><br>
</p>

</body>
</html>