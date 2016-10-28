<html>
<body>
Insert data for Pipboy<br>
<?php 
  include "common.inc";
  include "common.php";
  
  $sql = "Select * From pipboys";
  $result = query ($sql);
  
  while ($row = mysql_fetch_assoc ($result)) {		
     $Username = $row["Username"];
     $MAC = $row["MAC"];
     $Typename = $row["Typename"];
     $MACOwner = $row["MACOwner"];
     $Password = $row["Password"];
     $Team = $row["Team"];
          
     $sql = "   query (\"Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\\\"$Typename\\\", \\\"$MAC\\\", \\\"$MACOwner\\\", \\\"$Username\\\", \\\"$Password\\\", \\\"$Team\\\")\");"; 
     echo ("$sql<br>\n" );
  }     
  
  $sql = "Select * From items";
  $result = query ($sql);
  while ($row = mysql_fetch_assoc ($result)) {		
     $Name = $row["Name"];
     $Description = $row["Description"];          
     $sql = "   query (\"Insert into items (Name,Description) values (\\\"$Name\\\", \\\"$Description\\\")\");"; 
     echo ("$sql<br>\n" );
  }   
?>
</body>
</html>