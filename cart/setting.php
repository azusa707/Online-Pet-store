<?php
 // Secret Key provided by eSewa
$secretKey = '8gBm/:&EnhH.1/q';

// Function to generate UUID v4
function uuidv4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// Function to calculate HMAC signature
function calculateSignature($total_amount, $transaction_uuid, $product_code, $secret) {
    $data = "total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";
    return base64_encode(hash_hmac('sha256', $data, $secret, true));
}
//code for V1
// $epay_url = "https://uat.esewa.com.np/epay/main";
// $pid = "MiriStore99";
// $successurl = "success.php";
// $failedurl = "failed.php";
// $merchant_code = "epay_payment"; 
// $fraudcheck_url = "https://uat.esewa.com.np/epay/transrec";

// $actualamount = $totalPrice;

?>