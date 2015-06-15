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
 * First we create a customer
 */
$newCustomer = new Store\Customer\NewCustomer();
$newCustomer->setEmail("robert".uniqid()."@test757897.com");
$client = new WebServiceClient();
$response = $client->call('PureBilling/Customer/Create', $newCustomer);
WebServiceException::raiseIfError($response);
$customer = $response->getAnswer();

/**
 * We define the invoice
 */
$newInvoice = new Store\Invoice\NewInvoice();
$newInvoice->setCustomer($customer->getId());
$newInvoice->setCurrency('EUR');
$newInvoice->setDescription("super bike");

/**
 * Our invoice has two items to bill
 */
$item1 = new Store\Invoice\NewInvoiceItem();
$item1->setDescription('basic bike');
$item1->setAmount(199.00);
$newInvoice->addInvoiceItems($item1);

$item2 = new Store\Invoice\NewInvoiceItem();
$item2->setDescription('super option');
$item2->setAmount(59.99);
$newInvoice->addInvoiceItems($item2);

$response = $client->call('PureBilling/Invoice/Create', $newInvoice);
WebServiceException::raiseIfError($response);
$invoiceTransaction = $response->getAnswer();

print "$invoice has been created. id:" . $invoiceTransaction->getId() . "<br>";

?>


<p>
    <a href="/">Back to home page</a><br>
</p>

</body>
</html>