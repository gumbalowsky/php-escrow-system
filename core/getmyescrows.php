<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path.'/config/databaseconfig.php');
$path .= "/config/escrowconfig.php";
include_once($path);
$username = $_SESSION['nickname'];
$sql = "SELECT * FROM escrows WHERE buyer='".$username."'";
$sql = $db->query($sql);

if($sql->num_rows > 0)
{
    echo "<br/><b>Your escrows as buyer:</b><br/>";
    while($row = $sql->fetch_assoc())
    {
        if($row['status']=='4') continue;
        echo "Escrow no.".$row['id'].": <b>Seller:</b>".$row['seller']." <b>Price:</b>".$row['price']."$ <b>Payment:</b>";
        if($row['paid'] == 0) 
        {
            echo '<form action="/core/payments/paypal.php" method="post">
            <input type="hidden" value="'.$row['id'].'" name="paypaldata_id">
            <input type="submit" value="Pay with PayPal"></form><br/>';
        }
        else echo "Received<br/>";
        echo "Status:";
        if($row['status']=='1') echo "Awaiting for escrow seller to accept your offer.";
        else if($row['status']=='2') echo "Escrow seller accepted your offer.";
        else if($row['status']=='3') echo 'Completed. <form action="/core/escrowcomplete.php" method="post">
        <input type="hidden" value="'.$row['id'].'" name="escrowdata_id">
        <input type="submit" value="Close Escrow"></form><br/>';
    }
}
$sql = "SELECT * FROM escrows WHERE seller='".$username."' AND status='1'";
$sql = $db->query($sql);
if($sql->num_rows > 0)
{
    echo "<br/><b>Your escrows as seller:</b></br>";
    while($row = $sql->fetch_assoc())
    {
        echo "Escrow no.".$row['id']." Description:".$row['description']."<br/>Price ".$row['buyer']." wish to pay: ".$row['price']."<br/>";
        echo '<form action="adds/pages/accept_escrow.php" method="post">
            <input type="hidden" value="'.$row['id'].'" name="escrowdata_id">
            <input type="submit" value="Accept">
        </form>';
    }
}
else
{
    echo "<br/><b>You haven't received any escrow payments yet.</b>";
}
?>