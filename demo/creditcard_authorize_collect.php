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

/**
 * Collect the authorization
 */
$collect = new Store\Charge\Action\Collect();
$collect->setBillingTransaction($_REQUEST["pb_billing_transaction"]);
$collect->setAmount(9.90);

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/Collect', $collect);
WebServiceException::raiseIfError($response);

$billingTransaction = $response->getAnswer();

if ($billingTransaction->getStatus() == 'paid') {
    print "Transaction paid !!";
}

?>

<p>
    <a href="/">Back to home page</a><br>
</p>

</body>
</html>