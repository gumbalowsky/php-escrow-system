<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require $path  . '/vendor/autoload.php';
require $path . '/config/siteconfig.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

// Get payment object by passing paymentId
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        $paypal_clientid,     // ClientID
        $paypal_secretid      // ClientSecret
    )
);
$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $apiContext);
$payerId = $_GET['PayerID'];

?>