# Get the SDK
cd /var/www/html
git clone https://github.com/PureBilling/PureBillingSDK.git lib/PureBillingSDK

# Load SDK deps
cd lib/PureBillingSDK
git fetch origin
git checkout master
git reset --hard origin/master
php composer.phar install
