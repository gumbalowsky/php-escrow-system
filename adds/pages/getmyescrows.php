<?php
include_once('adds/conf/escrowconfig.php');
$username = $_SESSION['nickname'];
$sql = "SELECT * FROM escrows WHERE buyer='".$username."'";
$sql = $db->query($sql);

if($sql->num_rows > 0)
{
    echo "<br/><b>Your escrows as buyer:</b><br/>";
    while($row = $sql->fetch_assoc())
    {
        echo "Escrow no.".$row['id'].": <b>Seller:</b>".$row['seller']." <b>Price:</b>".$row['price']."$ <b>Paid:</b>";
        if($row['paid'] == 0) echo "NO";
        else echo "YES";
        echo "<br/>";
    }
}
$sql = "SELECT * FROM escrows WHERE seller='".$username."' AND status='1'";
$sql = $db->query($sql);
if($sql->num_rows > 0)
{
    echo "<br/><b>Your escrows as seller:</b></br>";
    while($row = $sql->fetch_assoc())
    {
        echo "Escrow no.".$row['id']." Description:".$row['description']."<br/>Price ".$row['buyer']." wish to pay: ".$row['price']."<br/>
        Paid: ".$row['paid_price']."$ out of ".$row['price']."$<br/>";
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