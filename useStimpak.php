<html>
<head> <Title>Execute an sql query and return</Title>
<?php
  include "common.inc";
  include "common.php";
  $OwnerId = getParam ("OwnerId" );
  $Owner = findOwner ( $OwnerId);
  $Username = $Owner["Username"];
  $IpAddress = $Owner["IpAddress"];
     
  $sql = "Update pipboys set Health=5 Where ID=$OwnerId";    
  echo ("<br>$sql<br>\n" );
  $result = query ($sql);  
  
  $Stimpak = findItem ( "Stimpak");
  $ItemId = $Stimpak["ID"];
  
  modifyInventory ($OwnerId, $ItemId, 0, -1);

  $sql = "Update pipboys set Health=5 Where ID=$OwnerId";    
  echo ("<br>$sql<br>\n" );
  $result = query ($sql);  
  
  $sql = "Insert into systemlog (Message) Values ('$Username used a stimpak!')"; 
  query ($sql);
?>
</head>
<body>
  Database has been updated.
<script>
   window.location.href = document.referrer;
</script>
</body>
</html>