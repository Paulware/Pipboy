<?php
  include "common.inc";
  include "common.php";
 
  $OwnerId  = getParam ("OwnerId" );  
  $ItemId   = getParam ("ItemId"  );
  $Quantity = getParam ("Quantity");
  $Offset   = getParam ("Offset"  );
  modifyInventory ( $OwnerId, $ItemId, $Quantity, $Offset );
?>
<html>
<head> <Title>Modify Inventory</Title>
</head>
<body>
<script>
   window.location.href = document.referrer;
</script>
</body>
</html>