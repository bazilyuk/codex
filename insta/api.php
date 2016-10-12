<?php
function generate_sig($endpoint, $params, $secret) {
    $sig = $endpoint;
    ksort($params);
    foreach ($params as $key => $val) {
        $sig .= "|$key=$val";
    }
    return hash_hmac('sha256', $sig, $secret, false);
}

$endpoint = '/media/657988443280050001_25025320';
$params = array(
    'access_token' => '3268428633.0e86eb9.8979574eda4d4596b6b04601c4a368b9',
    'count' => 10,
);
$secret = 'e6ee0c27bea1440da6f27c6a14d41f02';

$sig = generate_sig($endpoint, $params, $secret);
echo $sig;

?>