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

print "<h1>check using webService</h1>";
if ($response->getAnswer()->getStatus() == "paid") {
    print "Transaction paid!!<br>";
}
elseif ($response->getAnswer()->getStatus() == "running") {
    print "Transaction is running<br>";
} else {
print "Transaction refused : " . $response->getAnswer()->getMessage() . "<br>";
}

print "<br>";
print "<b>transaction type:</b> " . $response->getAnswer()->getBillingTransactionType() . "<br>";
print "<b>detailled status:</b> " . $response->getAnswer()->getDetailledStatus() . "<br>";
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

print "<h1>check using POST data</h1>";
if ($_REQUEST["pb_status"] == "paid") {
    print "Transaction paid!!<br>";
} elseif ($_REQUEST["pb_status"] == "running") {
    print "Transaction is running<br>";
} else {
    print "<b>Transaction refused:</b> " . $response->getAnswer()->getMessage() . "(check using POST data)<br>";
}

print "<br>";
print "<b>transaction type:</b> " . $_REQUEST["pb_billing_transaction_type"] . "<br>";

?>

<p>
    <?php
    if ($response->getAnswer()->getDetailledStatus() == "authorized") {
        print '<a href="creditcard_authorize_collect.php?pb_billing_transaction='
              .$_REQUEST["pb_billing_transaction"].'">Collect transaction</a><br>';
        print '<a href="creditcard_authorize_cancel.php?pb_billing_transaction='
              .$_REQUEST["pb_billing_transaction"].'">Cancel transaction</a><br>';
    } elseif ($response->getAnswer()->getDetailledStatus() == "collected") {
        print '<a href="creditcard_refund.php?pb_billing_transaction='
            .$_REQUEST["pb_billing_transaction"].'">refund transaction</a><br>';
    }
    ?>
    <a href="/">Back to home page</a><br>
</p>

</body>
</html>