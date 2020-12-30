<?php
if(!isset($_SESSION['nickname']))
    header("Location: ../");


include_once('getmyescrows.php');

echo "<br/><br/>";

echo '
<form action="adds/pages/createnewescrow.php" method="post">
    <b>Create New Escrow:</b><br/>
    Seller login:<input type="text" id="escrowdata_login" name="escrowdata_login"><br/>
    Price(in USD) you pay:<input type="text" id="escrowdata_price" name="escrowdata_price"><br/>
    Description to seller(for ex. which product):<input type="text" rows="2" cols="25" id="escrowdata_desc" name="escrowdata_desc">
    <br/><input type="submit" value="Submit request">
</form>';
?>