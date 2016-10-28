<html>
<script>
  function deleteInventory (ID) {
     var sql = "Delete From inventory Where ID=" + ID;
     window.location.href = 'query.php?sql=' + escape (sql);
  }
  
</script>
<body>
Modify Inventory Table<br>
<?php 
  include "common.inc";
  include "common.php";

  //$sql = "ALTER TABLE inventory add column ForSale BOOL";
  //$result = query ($sql);  
  //echo ("inventory Modified<br>\n" );
  
  $result = query ( "Select * From inventory" );
  $count = 0;
  while ($row = mysql_fetch_assoc ($result)) {		
     $ID = $row["ID"];     
     $Quantity = $row["Quantity"];
     $ItemId = $row["ItemId"];
     
     $ItemInfo = findItemByID ($ItemId);
     $Description = $ItemInfo["Description"];
     $Item = $ItemInfo["Name"];
     $OwnerId = $row ["OwnerId"];
     $ForSale = $row ["ForSale"];
     $Price = $row ["Price"];
         
     if ($count == 0) {    
       echo  ("<table border=\"0px solid\" width=\"90%\">\n" );
       echo  ("<tr bgcolor=\"lightgray\">\n" );
       echo  ("<th width=\"10%\" align=\"center\">Item</th>\n");
       print ("<th width=\"5%\" align=\"center\">Quantity</th>\n" );
       print ("<th width=\"35%\" align=\"middle\">Description</th>");
       print ("<th width=\"15%\" align=\"middle\">ItemId</th>");
       print ("<th width=\"5%\" align=\"middle\">Owner</th>");
       print ("<th width=\"5%\" align=\"middle\">Price</th>");
       print ("<th width=\"5%\" align=\"middle\">Delete</th>");
       print ("</tr>\n");
     }
     
     $Owner = findOwner ( $OwnerId );
     $Name = $Owner["Username"];
     
     print ("<tr>");
     print ("<td align=\"center\">$Item</td>\n" );
     print ("<td align=\"center\">$Quantity</td>\n" );
     print ("<td align=\"center\">$Description</td>\n" );
     print ("<td align=\"center\">$ItemId</td>\n" );
     print ("<td align=\"center\"><input type=\"button\" value=\"$Name\"");
     print ("  onclick=\"window.location.href='viewOwner.php?OwnerId=$OwnerId';\"</td>\n" );     
     print ("<td align=\"center\">$Price</td>\n" );
     print ("<td align=\"center\"><input type=\"button\" value=\"Delete\"");
     print ("  onclick=\"deleteInventory($ID);\"</td>\n" );
     print ("</tr>");
     
     $count = $count + 1;
  }       
?>
</body>
</html>