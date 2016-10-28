<html>
<head> <Title>Add items to an Owner</Title>
<?php
  include "common.inc";
  include "common.php";
  $OwnerId  = getParam ("OwnerId" );
  $ItemId   = getParam ("ItemId" );
  $Quantity = getParam ("Quantity" );  
?>
</head>
<body>
<?php
    $sql = "Select * from inventory Where OwnerId=$OwnerId and ItemId=$ItemId";
    $result = query ( $sql );
    $CurrentQuantity = 0;
    if ($row = mysql_fetch_assoc ($result)) {
      $CurrentQuantity = $row["Quantity"];
      $CurrentQuantity = $CurrentQuantity + intval ($Quantity);
      $sql = "Update inventory Set Quantity = $CurrentQuantity Where OwnerId=$OwnerId and ItemId=$ItemId";
    } else {
      $sql = "Insert into inventory (OwnerId, ItemId, Quantity) values ($OwnerId, $ItemId, $Quantity)";
    }
    echo ($sql);
    $result = query ( $sql );
    echo ("<br>");
?>
</Table>
<script>
   window.location.href = document.referrer;
</script>
<hr>
</body>
</html>