<?php

session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path.'/config/databaseconfig.php');
$path .= "/config/escrowconfig.php";
include_once($path);
$username = $_SESSION['nickname'];
$escrowId = $_POST['escrowdata_id'];

$sql = "UPDATE escrows SET status=4 WHERE id='".$escrowId."'";
if($db->query($sql))
    header("Location: ../");
$db->close();
?>