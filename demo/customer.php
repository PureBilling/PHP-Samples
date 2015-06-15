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

$newCustomer = new Store\Customer\NewCustomer();
$newCustomer->setEmail("robert".uniqid()."@test757897.com");

//Set SignUp IP to improve fraud detection
$newCustomer->setIp('1.2.3.4');

//Attach your reference (optional)
$newCustomer->setExternalId('my-id-'. uniqid());

/**
 * create the customer
 */
$client = new WebServiceClient();
$response = $client->call('PureBilling/Customer/Create', $newCustomer);
WebServiceException::raiseIfError($response);

$customer = $response->getAnswer();

print "Customer created with id: " . $customer->getId() . "<br>";


/**
 * Update customer email
 */
$update = new Store\Customer\UpdateCustomer();
$update->setId($customer->getId());
$update->setEmail("updated-".uniqid()."@test757897.com");

$client = new WebServiceClient();
$response = $client->call('PureBilling/Customer/Update', $update);

/**
 * Check the webService answer
 */
if ($response->getStatus() != 'success') {
    $errorCode = $response->getAnswer()->getCode();
    $errorMessage = $response->getAnswer()->getMessage();
    throw new \Exception("ERROR $errorCode: $errorMessage");
}

$updatedCustomer = $response->getAnswer();
print "Customer updated to email: " . $updatedCustomer->getEmail() ."<br>"
?>


<p>
    <a href="/">Back to home page</a><br>
</p>

</body>
</html>