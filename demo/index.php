<?php

function display_setup()
{
    print '<div style="background-color: #E96D63;">';
    print "<h2>Missing dependencies</h2>";
    print "To install depedencies, please do:";
    print "<br><br>";
    print "<b>docker-compose run --rm pbdemo bash -c pb_load_deps.sh</b>";
    print "</div>\n";
}
?>

<html>
<body>

<h1>PureBilling Demo Page</h1>


<?php
if (!file_exists('lib/PureBillingSDK/vendor/puremachine/sdk/src/PureMachine/Bundle/SDKBundle/Store/ExceptionStore.php')) {
    display_setup();
}
?>

Test links:

<ul style="list-style-type:square">
    <li><a href="test_your_setup.php"/>test your setup sample</a></li>
    <li><a href="creditcard.php"/>creditcard Pop-in test</a></li>
    <li><a href="creditcard_authorize.php"/>creditcard Pop-in test (authorization)</a></li>
    <li><a href="creditcard_embedded.php"/>creditcard embedded test</a></li>
    <li><a href="iban.php"/>SEPA Direct Debit (IBAN) Pop-in</a></li>
    <li><a href="iban_embedded.php"/>SEPA Direct Debit (IBAN) Embedded</a></li>
    <li><a href="customer.php"/>Customer example</a></li>
    <li><a href="invoice.php"/>Invoice example</a></li>
    <li><a href="subscription.php"/>Subscription example</a></li>
</ul>

</body>
</html>