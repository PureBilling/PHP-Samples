<html>
<head>
    <script src="https://pbjs-pvf.purebilling.com/V1/stable/pb.min.js"></script>
    <script type="text/javascript">
        PUREBILLING_PUBLIC_KEY = 'testpublickey_DEMOPUBLICKEY95me92597fd28tGD4r5';
    </script></head>
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

$capture = new Store\Charge\Action\Capture();
$capture->setAmount(9.90);
$capture->setCurrency("EUR");

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/Capture', $capture);

/**
 * Check the webService answer
 */
if ($response->getStatus() != 'success') {
    $errorCode = $response->getAnswer()->getCode();
    $errorMessage = $response->getAnswer()->getMessage();
    throw \Exception("ERROR $code: $message");
}

$chargeToken = $response->getAnswer()->getChargeToken();

/**
 * STEP 2: copy paste the embedded form code
 * ==========================================
 */
?>

<form role="form" id="paymentform" method="POST" action="paid.php">
    Card Number:
    <input type="text" class="pb-cardnumber" name="card-number">

    Expiration Date:
    <input type="text" class="pb-cardexpirationmonth" name="expiry-month">
    <input type="text" class="pb-cardexpirationyear" name="expiry-year">

    Card CVV:
    <input type="text" class="pb-cardcvv" name="cvv">

    <button class="btn btn-success"
            onclick="PB.charge('<?echo $chargeToken;?>');return false;">
        Pay Now
    </button>

    <div class="pb-form-error"></div>
</form>

</body>
</html>