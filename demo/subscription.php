<html>
<head></head>
<body>
<h1>To make a subscription, you need a valid paymentMethod. Please create a new one.</h1>
<?php

/**
 * STEP 1: Create the charge token
 * ===============================
 */

/**
 * SDK Setup
 */
require_once('purebilling-config-test.php');
use PureBilling\Bundle\SDKBundle\Store\V1 as Store;
use PureMachine\Bundle\SDKBundle\Service\WebServiceClient;
use PureMachine\Bundle\SDKBundle\Exception\WebServiceException;

/**
 * Call the webService
 */
$authorize = new Store\Charge\Action\Authorize();
$authorize->setAmount(9.90);
$authorize->setCurrency("EUR");

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/Authorize', $authorize);
WebServiceException::raiseIfError($response);

$chargeToken = $response->getAnswer()->getChargeToken();

/**
 * STEP 2: copy paste the javascript code
 * ======================================
 */
?>

<form method="POST" action="subscription_step2.php">
    <script src="https://pbjs.purebilling.com/V1/stable/pb.min.js" class="pb-checkout"
            pb_public_key="testpublickey_DEMOPUBLICKEY95me92597fd28tGD4r5"
            pb_company_name="PureBilling"
            pb_amount="99.90"
            pb_chargetoken="<?php echo $chargeToken;?>"
            pb_order_summary="super bike">
    </script>
</form>

</body>
</html>