<html>
<head> <Title>Execute an sql query and return</Title>
<?php
  include "common.inc";
  include "common.php";
  $OwnerId = getParam ("OwnerId" );
  $Owner = findOwner ( $OwnerId);
  $Username = $Owner["Username"];
  $IpAddress = $Owner["IpAddress"];
  $Message = "start";
  $cmd = "python sendMessage.py $IpAddress \"$Message\"";
  echo ( "<h1>CMD:</h1><br>$cmd<BR>\n");
	 exec($cmd);	     
  $sql = "Update pipboys set Health=25 Where ID=$OwnerId";    
  echo ("<br>$sql<br>\n" );
  $result = query ($sql);  
  $sql = "Insert into systemlog (Message) Values ('$Username was revived!')"; 
  query ($sql);
?>
</head>
<body>
  Database has been updated.
<script>
  <?php
    echo ("  window.location.href = 'viewOwner.php?OwnerId=$OwnerId';" );
  ?>
</script>
</body>
</html>