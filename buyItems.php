<html>
<head> 
<?php
  include "common.inc";
  include "common.php";
  $OwnerId = getParam ("OwnerId" );
  $Owner = findOwner ( $OwnerId);
  $Name = $Owner ["Username"];
  $VisitorId = getParam ("VisitorId" );
  $Visitor = findOwner ( $VisitorId);
  $VisitorName = $Visitor["Username"];
  $Quantity = intval(getParam ("Quantity" ));
  $ItemId = getParam ( "ItemId" );
  $Cash = findItem ( "BottleCaps");
  $CashId = $Cash ["ID"];
  echo ("<Title>$Name => $VisitorName</Title>\n" ); 
?>
</head>
<body>

<?php
    $sql = "Select * From inventory Where OwnerId=$OwnerId and ItemId=$ItemId";
    echo ("$sql <BR>\n" );
    $result = query ( "Select * From inventory Where OwnerId=$OwnerId and ItemId=$ItemId" );
    $InStock = 0;
    if ($row = mysql_fetch_assoc ($result)) {
      $InStock = $row["Quantity"];
      $Price = $row["Price"];
      echo ( "Current number in Stock: $InStock, requested: $Quantity<br>\n" );
      $TotalPrice = $Quantity * $Price;
      echo ( "<h2>Total price = $Quantity @ $Price Bottle Caps each = $TotalPrice BottleCaps</h2><br>\n" );     
      $sql = ( "Select * From inventory where OwnerId=$VisitorId and ItemId=$CashId" );
      echo ("$sql<br>\n" );
      $result = query ( $sql );
      $CashOnHand = 0;
      if ($row = mysql_fetch_assoc ($result)) {
        $CashOnHand = $row["Quantity"];
        echo ("$VisitorName has $CashOnHand BottleCaps<br>\n" );
      }
    }
    echo ("Ready for this? $Quantity $Price $TotalPrice $CashOnHand<br>\n" );
    echo ("$VisitorName" );
    if ($CashOnHand < $TotalPrice) {
       echo ("<h2>$VisitorName does not have enough money to complete this purchase</h2><br>\n" );
       echo ("<h2>Needed: $TotalPrice BottleCaps, $VisitorName only has: $CashOnHand</h2><br>\n" );
    } else if ($Quantity > $InStock) {
       echo ( "<H2>Not enough inventory in stock, maximum quantity that can be purchased: $InStock</H2><br>\n" );
    } else {
       echo ("$InStock > $Quantity<br>\n" );
       // Update inventory or buyer and seller
       modifyInventory ( $OwnerId, $ItemId, 0, 0-$Quantity);           
       modifyInventory ( $VisitorId, $ItemId, 0, $Quantity );
       // Update Bottlecaps of buyer and seller
       modifyInventory ( $OwnerId, $CashId, 0, $TotalPrice);
       modifyInventory ( $VisitorId, $CashId, 0, 0-$TotalPrice);
    }
?>
<script>
   window.location.href = 'index.php';
</script>
</body>
</html>