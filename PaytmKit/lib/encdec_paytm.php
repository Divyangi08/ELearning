<?php

function encrypt_e($input, $ky) {
    $key = html_entity_decode($ky);
    $data = base64_encode($input . $key);
    return $data;
}

function decrypt_e($crypt, $ky) {
    $key = html_entity_decode($ky);
    $data = base64_decode($crypt);
    $data = str_replace($key, '', $data);
    return $data;
}

function generateSalt_e($length) {
    $random = "";
    srand((double) microtime() * 1000000);

    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";

    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, rand() % strlen($data), 1);
    }

    return $random;
}

function getChecksumFromArray($arrayList, $key) {
    ksort($arrayList);
    $str = getArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;

    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;

    return encrypt_e($hashString, $key);
}

function verifychecksum_e($arrayList, $key, $checksumvalue) {
    $arrayList = removeCheckSumParam($arrayList);
    ksort($arrayList);

    $str = getArray2Str($arrayList);
    $paytm_hash = decrypt_e($checksumvalue, $key);
    $salt = substr($paytm_hash, -4);

    $finalString = $str . "|" . $salt;
    $website_hash = hash("sha256", $finalString) . $salt;

    return $website_hash == $paytm_hash;
}

function getArray2Str($arrayList) {
    $paramStr = "";
    $flag = 1;

    foreach ($arrayList as $value) {
        if ($flag) {
            $paramStr .= $value;
            $flag = 0;
        } else {
            $paramStr .= "|" . $value;
        }
    }
    return $paramStr;
}

function removeCheckSumParam($arrayList) {
    if (isset($arrayList["CHECKSUMHASH"])) {
        unset($arrayList["CHECKSUMHASH"]);
    }
    return $arrayList;
}

# ✅ ADD THIS FUNCTION (IMPORTANT FIX)
function getTxnStatusNew($requestParamList) {

    $url = "https://securegw-stage.paytm.in/order/status"; // staging

    $postData = json_encode($requestParamList);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($postData)
    ));

    $response = curl_exec($ch);

    if ($response === false) {
        return ["ERROR" => curl_error($ch)];
    }

    curl_close($ch);

    return json_decode($response, true);
}

?>