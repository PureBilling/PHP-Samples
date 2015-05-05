<html><body>
<?php

require_once('purebilling-config-test.php');
use PureBilling\Bundle\SDKBundle\Store\V1 as Store;
use PureMachine\Bundle\SDKBundle\Service\WebServiceClient;
$client = new WebServiceClient();

//call the test webService
$response = $client->call('PureBilling/Test/SDKTest');

if ($response->getStatus() == 'success') {
print "configuration ok !";
} else {
print "webService call error: " . $response->getAnswer()->getMessage();
}

?>

<p>
    <a href="/">Back to home page</a>
</p>

</body></html>