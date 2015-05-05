<html>
<body>

<?php

/**
 * STEP 3: check the transaction status (Using Get WebService)
 * ===========================================================
 */

/**
* SDK Setup
*/
require_once('purebilling-config-test.php');
use PureBilling\Bundle\SDKBundle\Store\V1 as Store;
use PureMachine\Bundle\SDKBundle\Service\WebServiceClient;

/**
* We ask the real transaction status to purebilling
*/
$get = new Store\Charge\Action\Get();
$get->setId($_POST["pb_billing_transaction"]);

$client = new WebServiceClient();
$response = $client->call('PureBilling/Charge/Get', $get);

//error management
if ($response->getStatus() != 'success') {
throw new \Exception("payment error:" . $response->getAnswer()->getMessage());
}

if ($response->getAnswer()->getStatus() == "paid") {
print "Transaction paid!! (check using webService)<br>";
} else {
print "Transaction refused : " . $response->getAnswer()->getMessage() . "(check using webService)<br>";
}

print "<br>";

/**
 * Check using POST values
 *
 */
$shaString =  $_REQUEST["pb_billing_transaction"] .":"
    .$_REQUEST["pb_billing_transaction_type"] .":"
    .$_REQUEST["pb_status"] .":"
    .PureBilling::getPrivateKey();

$validSha = hash("sha256", $shaString);

if ($validSha != $_REQUEST['pb_sha']) {
    //something wrong, probably a fraud ....
    throw new \Exception("SHA error");
}

if ($_REQUEST["pb_status"] == "paid") {
    print "Transaction paid!! (check using POST data)<br>";
} else {
    print "Transaction refused : " . $response->getAnswer()->getMessage() . "(check using POST data)<br>";
}

?>

<p>
    <a href="/">Back to home page</a>
</p>

</body>
</html>