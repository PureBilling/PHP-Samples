<<html>
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
 * We check the billingTransaction
 */
$get = new Store\Charge\Action\Get();
$get->setId($_POST["pb_billing_transaction"]);

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/Get', $get);
WebServiceException::raiseIfError($response);
$billingTransaction = $response->getAnswer();

if ($billingTransaction->getStatus() != "running" && $billingTransaction->getDetailledStatus() !='authorize') {
    throw new \Exception("Transaction not authorized");
}

/**
 * Cancel the authorization
 */
$cancelAuth = new Store\Charge\Action\CancelAuthorization();
$cancelAuth->setBillingTransaction($billingTransaction->getId());
$cancelAuth->setMessage('Authorization cancellation test');

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/CancelAuthorization', $cancelAuth);
WebServiceException::raiseIfError($response);
$billingTransaction = $response->getAnswer();

if ($billingTransaction->getDetailledStatus() != 'authorizedcancelled') {
    throw new \Exception("Can't cancel transaction");
}

$paymentMethod = $billingTransaction->getPaymentMethod();

?>

<p>
    <a href="/">Back to home page</a><br>
</p>

</body>
</html>