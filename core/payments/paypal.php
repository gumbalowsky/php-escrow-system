<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require $path  . '/vendor/autoload.php';
require $path . '/config/siteconfig.php';

//Sql data
$_ESCROWid = $_POST['paypaldata_id'];
if($_ESCROWid == null OR $_ESCROWid == 0) exit(); // return error
$_Paymentprice = 0.0;
include $path . '/config/databaseconfig.php';

$sql = "SELECT price FROM escrows WHERE id='".$_ESCROWid."'";
$sql = $db->query($sql);
if($sql->num_rows > 0)
    while($row = $sql->fetch_assoc()) $_Paymentprice = $row['price'];
else exit(); // return error



//PayPal configs
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        $paypal_clientid,
        $paypal_secretid
    )
);
$payer = new \PayPal\Api\Payer();
$payer->setPaymentMethod('paypal');

$amount = new \PayPal\Api\Amount();
$amount->setTotal($_Paymentprice);
$amount->setCurrency('USD');

$transaction = new \PayPal\Api\Transaction();
$transaction->setAmount($amount);

$redirectUrls = new \PayPal\Api\RedirectUrls();
$redirectUrls->setReturnUrl($url_returnapproved)
    ->setCancelUrl($url_returncancelled);

$payment = new \PayPal\Api\Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions(array($transaction))
    ->setRedirectUrls($redirectUrls);




//PAYPAL CALL
try {
    $payment->create($apiContext);
    header("Location:".$payment->getApprovalLink());
}
catch (\PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getData();
}

?>