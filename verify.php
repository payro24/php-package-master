<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require __DIR__ . '/vendor/autoload.php';

use payro24\payro24;

function testVerifyPayment()
{
    $apiKey = 'YOUR API KEY';
    $endPoint = 'https://api.payro24.ir/v1.0/';
    $payro = new payro24($apiKey, $endPoint, true);

    if ($payro->receiveData()) {
        $receipt = $payro->inquiry($payro->getTrackId(), '123', 1000);
        echo json_encode($receipt);

    } else echo 'no data to validation';
}

testVerifyPayment();
