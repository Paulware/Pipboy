<html>
<?php
  include "common.inc";
  include "common.php";
  
?>
<script>

</script>
<body>
<?php
   
  $sql = "Select * From pipboys";
  $result = query ($sql);

  while ($row = mysql_fetch_assoc ($result)) {		
     $Name = $row["Username"];
     $MAC = $row["MAC"];
     $ID = $row["ID"];
     $pos = strpos ( $MAC, ":"); 
     if ($pos !== false) { 
        $Message = "";  
        for ($i=0; $i<4; $i++) {
           $Item = getRandomItem();
           $ItemName = $Item ["Name"];
           if ($Message == "") {
              $Message = "$Name, your inventory has been updated, to win the game collect 1 $ItemName";
           } else {
              $Message = $Message . ", 1 $ItemName";
           }
        }           
        echo ( "$Message<br>\n" );     
        $sql = "Insert Into messages (OwnerId,SenderId,Message) values ($ID,$ID,'$Message')";
        $q = query ($sql);
        $sql = "delete from inventory Where (OwnerId=$ID)";
        $q = query ($sql);

        
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
     }     
  }
  
?>



   <!input type="button" value="Collect 4 Items" onclick="generateList();"> 
</body>
</html>
