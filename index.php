<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require __DIR__ . '/vendor/autoload.php';

use payro24\payro24;

function testPayment()
{
    $apiKey = 'YOUR API KEY';
    $endPoint = 'https://api.payro24.ir/v1.0/';
    $callback = 'http://' . 'YOUR CALLBACK URI' . '/verify.php';

    $payro = new payro24($apiKey, $endPoint, true);
    $order = $payro->payment($callback, '123', 1000, 'name', 'mail@domain.com', 'mobile', 'desc');
    if ($order) {
        $payro->gotoPaymentPath();
        echo 'redirect to payro24';
    }

}

testPayment();
