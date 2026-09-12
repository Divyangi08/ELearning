<?php  

define('PAYTM_ENVIRONMENT', 'TEST'); // TEST or PROD

// 🔴 PUT YOUR REAL DETAILS HERE
define('PAYTM_MERCHANT_KEY', 'YOUR_MERCHANT_KEY_HERE');
define('PAYTM_MERCHANT_MID', 'YOUR_MID_HERE');
define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); // For TEST

// ✅ REQUIRED CONSTANTS (FIXED)
define('PAYTM_INDUSTRY_TYPE_ID', 'Retail');  
define('PAYTM_CHANNEL_ID', 'WEB');           

// URLs
$PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
$PAYTM_TXN_URL = 'https://securegw-stage.paytm.in/theia/processTransaction';

if (PAYTM_ENVIRONMENT == 'PROD') {
    $PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw.paytm.in/merchant-status/getTxnStatus';
    $PAYTM_TXN_URL = 'https://securegw.paytm.in/theia/processTransaction';
}

// DO NOT CHANGE BELOW
define('PAYTM_REFUND_URL', '');
define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

?>