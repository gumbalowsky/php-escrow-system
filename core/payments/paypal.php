<?php
$path = $_SERVER['DOCUMENT_ROOT'];

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
require $path  . '/vendor/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
$clientId = $paypal_clientid;
$clientSecret = $paypal_secretid;

$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
$request = new OrdersCreateRequest();
$request->prefer('return=representation');
$request->body = [
                     "intent" => "CAPTURE",
                     "purchase_units" => [[
                         "reference_id" => "test_ref_id1",
                         "amount" => [
                             "value" => $_Paymentprice,
                             "currency_code" => "USD"
                         ]
                     ]],
                     "application_context" => [
                          "cancel_url" => $url_returnapproved,
                          "return_url" => $url_returncancelled
                     ] 
                 ];

$response = $client->execute($request);
if($response->statusCode == 201) header("Location:".$response->result->links[1]->href);
?>