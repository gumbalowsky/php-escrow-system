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

?>