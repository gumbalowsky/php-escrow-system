<?php
$__DEBUG__ = true;

$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = '';
$db_database = 'escrow';
$db = new mysqli($db_host,$db_user,$db_pass,$db_database);
if($db->connect_error)
{
    echo "Couldn't connect to MySQL database.";
    exit();
}
$price_min = 0.00;
$price_max = 1000.00;
?>