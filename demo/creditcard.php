<html>
<head></head>
<body>

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

/**
 * Call the webService
 */
$capture = new Store\Charge\Action\Capture();
$capture->setAmount(9.90);
$capture->setCurrency("EUR");

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/Capture', $capture);

/**
 * Check the webService answer
 */

if ($response->getStatus() != 'success') {
    throw new \Exception($response->getAnswer()->getMessage());
}

$chargeToken = $response->getAnswer()->getChargeToken();

/**
 * STEP 2: copy paste the javascript code
 * ======================================
 */
?>

<form method="POST" action="paid.php">
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