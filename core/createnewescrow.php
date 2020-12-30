<?PHP
session_start();
include_once('../conf/escrowconfig.php');
$username = $_SESSION['nickname'];
$seller = $_POST['escrowdata_login'];
$price = $_POST['escrowdata_price'];
$desc = $_POST['escrowdata_desc'];

if($price < $price_min || $price > $price_max || !is_numeric($price))
    echo 'Wrong price range('.$price_min.'$ to '.$price_max.'$)';
//potential check if $seller exist in DB
$sql = "INSERT INTO escrows VALUES (NULL, '".$username."', '".$seller."', '".$price."', 0, 0, '".$desc."', 0)";
if($db->query($sql))
    header("Location: ../");
$db->close();
?>