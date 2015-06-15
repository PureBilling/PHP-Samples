<?php
date_default_timezone_set("UTC");
require_once('lib/PureBillingSDK/autoloader.php');

//You must here put your own private key
PureBilling::setPrivateKey('testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M');
PureBilling::setEndPoint('https://api.purebilling.com');
