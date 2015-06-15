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
 * Cancel the authorization
 */
$cancelAuth = new Store\Charge\Action\CancelAuthorization();
$cancelAuth->setBillingTransaction($_REQUEST["pb_billing_transaction"]);
$cancelAuth->setMessage('Authorization cancellation test');

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/CancelAuthorization', $cancelAuth);
WebServiceException::raiseIfError($response);

$billingTransaction = $response->getAnswer();
print $billingTransaction->getDetailledStatus();
if ($billingTransaction->getDetailledStatus() == 'authorizedcancelled') {
    print "Transaction cancelled !!";
}

?>

<p>
    <a href="/">Back to home page</a><br>
</p>

</body>
</html>