<html>
<head> <Title>Execute an sql query and return</Title>
<?php
  include "common.inc";
  include "common.php";
  $OwnerId = getParam ("OwnerId" );
  $Owner = findOwner ( $OwnerId);
  $Username = $Owner["Username"];
  $IpAddress = $Owner["IpAddress"];
  
  if ($IpAddress != "") { // Send message to weapon to reload
    $cmd = "python sendMessage.py $IpAddress \"reload\"";
    exec($cmd);	     
  }   
     
  $sql = "Update pipboys set Ammo=25 Where ID=$OwnerId";    
  echo ("<br>$sql<br>\n" );
  //$result = query ($sql);  
  
  $Reload = findItem ( "Reload");
  $ReloadId = $Reload ["ID"];  
  modifyInventory ($OwnerId, $ReloadId, 0, -1);

  $sql = "Insert into systemlog (Message) Values ('$Username reloaded')"; 
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