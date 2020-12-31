<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require $path  . '/vendor/autoload.php';
require $path . '/config/siteconfig.php';
include $path . '/config/databaseconfig.php';
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient {
  public static function client()
  {
    return new PayPalHttpClient(self::environment());
  }

  public static function environment()
  {
    $paypal_clientid = "Ab5-y_mOHBtRP8-Ym_jtL1vLoAx9jUf5_LK3_BVO-WmQTc7JszJ-yrRKhpyUuTNijoqUtS6VOpJ07ONB";
    $paypal_secretid = "EMhM9QvFY18_m9I7pKsYLQ92pTfLjzfhvZrmjW54awAs0nkhbRgP7YM0c4Ohd_Lis7cYbM552VmXheKC";
    $clientId = $paypal_clientid;
    $clientSecret = $paypal_secretid;
    return new SandboxEnvironment($clientId, $clientSecret);
  }
}
$orderId = $_GET['token'];
$escrowId = $_GET['id'];
$request = new OrdersCaptureRequest($orderId);
$client = PayPalClient::client();
$response = $client->execute($request);
if($response->statusCode='201' AND $response->result->status='COMPLETED')
{
  $sql = "SELECT * FROM payments WHERE paymentid='".$orderId."'";
  $sql = $db->query($sql);
  if($sql->num_rows > 0)
  {
    while($row = $sql->fetch_assoc()) 
    if($escrowId == $row['escrowid'])
    {
      $sql = "UPDATE escrows SET paid=1, status=1 WHERE id='".$escrowId."'";
      if($db->query($sql)) header("Location:".$website_url);
      else echo 'Something went wrong. Please contact our staff with your escrow id.';
    }
    else
    {
      $sql = "DELETE FROM payments WHERE paymentid='".$orderId."'";
      $db->query($sql);
      echo "Payment has been cancelled.";
    }
  }
  else
  {
    $sql = "DELETE FROM payments WHERE paymentid='".$orderId."'";
    $db->query($sql);
    echo "Payment has been cancelled.";
  }
  
}

?>