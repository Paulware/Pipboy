<html>
<body>
Make Items Table required for the PipboyCreation project<br>
<?php 
  include "common.inc";
  include "common.php";

  
  echo ("Create Table items<br>\n" );
  $q = mysql_query ("Drop Table items");
  $sql = "CREATE TABLE items (ID INT AUTO_INCREMENT PRIMARY KEY, Name char(255), Description char(255), Cost INT)";
  $result = query ($sql);  
  
  $result = query ( "Select * From inventory" );
  $count = 0;
  while ($row = mysql_fetch_assoc ($result)) {		
     $Item = $row["Item"];
     $Quantity = $row["Quantity"];
     $Description = $row["Description"];
          
     if ($count == 0) {    
       echo  ("<table border=\"0px solid\" width=\"90%\">\n" );
       echo  ("<tr bgcolor=\"lightgray\">\n" );
       echo  ("<th width=\"10%\" align=\"center\">Item</th>\n");
       print ("<th width=\"15%\" align=\"center\">Quantity</th>\n" );
       print ("<th width=\"15%\" align=\"middle\">Description</th>");
       print ("<th width=\"15%\" align=\"middle\">Delete</th>");
       print ("</tr>\n");
     }
     print ("<tr>");
     print ("<td align=\"center\">$Item</td>\n" );
     print ("<td align=\"center\">$Quantity</td>\n" );
     print ("<td align=\"center\">$Descriptiont</td>\n" );
     print ("<td align=\"center\"><input type=\"button\" value=\"Delete\" onclick=\"deleteStoreItem('$Item');\"><td>\n" );
     print ("</tr>");
     
     $count = $count + 1;
     $sql = "INSERT INTO items (Name,Description,Cost) Values ('$Item','$Description',$count)";
     echo ("$sql<br>\n");
     $q = query ($sql);  
     echo ("Next item<br>\n" );
  }      
  
  $result = query ( "Select * From items" );
  $count = 0;
  while ($row = mysql_fetch_assoc ($result)) {		
     $Name = $row["Name"];
     $Description = $row["Description"];
     $Cost = $row["Cost"];
     if ($count == 0) {    
       echo  ("<table border=\"0px solid\" width=\"90%\">\n" );
       echo  ("<tr bgcolor=\"lightgray\">\n" );
       echo  ("<th width=\"10%\" align=\"center\">Name</th>\n");
       print ("<th width=\"15%\" align=\"middle\">Description</th>");
       print ("<th width=\"15%\" align=\"middle\">Cost</th>");
       print ("</tr>\n");
     }
     print ("<tr>");
     print ("<td align=\"center\">$Name</td>\n" );
     print ("<td align=\"center\">$Description</td>\n" );
     print ("<td align=\"center\">$Cost</td>\n" );
     print ("</tr>");
     
     $count = $count + 1;
  }      

  if ($count == 0) {
     echo ("<h1>Empty</h1>\n");    
  }
  
?>
</body>
</html>