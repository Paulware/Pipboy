<html>
<?php
  include "common.inc";
  include "common.php";
  
?>
<script>

</script>
<body>
<?php   
  $BottleCaps = findItem ("BottleCaps");
  $BottleCapsId = $BottleCaps["ID"];
  $Dragonball = findItem ("DragonBall");
  $DragonballId = $Dragonball["ID"];

  $sql = "Delete from messages";
  $q = query ($sql);        
  $sql = "Update pipboys Set Hits=0";
  $q = query ($sql);        
  $sql = "Update pipboys Set Health=25";
  $q = query ($sql);        
  $sql = "Select * From pipboys";
  $result = query ($sql);
  $count = 0;
  while ($row = mysql_fetch_assoc ($result)) {		
     $Name = $row["Username"];
     $MAC = $row["MAC"];
     $ID = $row["ID"];
     $pos = strpos ( $MAC, ":"); 
     if ($pos !== false) { 
        $IpAddress = $row["IpAddress"];
        $Message = "start";
        $cmd = "python sendMessage.py $IpAddress \"$Message\"";
        echo ( "<h1>CMD:</h1><br>$cmd<BR>\n");
	       exec($cmd);	     
        $sql = "delete from inventory Where (OwnerId=$ID)";
        $q = query ($sql);
        if ($count < 7 ) {
           $sql = "Insert into inventory (OwnerId, ItemId,Quantity) values ( $ID, $DragonballId,1)"; 
           $q = query ($sql);           
           $Message = $Message . " You have 1 dragonball";
        }
        $count = $count + 1;
        
        // Insert 4 items in the players inventory        
        for ($i=0; $i<4; $i++) {
           $Item = getRandomItem();
           $ItemId = $Item["ID"];
           $sql = "Insert into inventory (OwnerId, ItemId, Quantity) values ($ID, $ItemId, 1)"; 
           $q = query ($sql);
        }  
               
        $BottleCaps = findItem ("BottleCaps");
        $BottleCapsId = $BottleCaps["ID"];
        $sql = "Insert into inventory (OwnerId, ItemId,Quantity) values ($ID,$BottleCapsId,500)";
        $q = query ($sql);        
        $Message = "$Name, your inventory has been updated, to win the game collect all 7 dragonballs";  
        echo ( "$Message<br>\n" );     
        $sql = "Insert Into messages (OwnerId,SenderId,Message) values ($ID,$ID,'$Message')";
        $q = query ($sql);
     }     
  }
  
?>

</body>
</html>
