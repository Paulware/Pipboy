<html>
<head> 
<?php
  include "common.inc";
  include "common.php";
  $OwnerId      = getParam ("OwnerId" );
  $Owner        = findOwner ( $OwnerId);
  $Name         = $Owner ["Username"];
  $Health       = findItem ( "Health");
  $HealthId     = $Health["ID"];
  $VisitorId    = getParam ("VisitorId" );
  $Visitor      = findOwner ($VisitorId );
  $VisitorName   = $Visitor["Username"];
  $BottleCaps   = findItem ( "BottleCaps" );
  $BottleCapsId = $BottleCaps["ID"];
  $VisitorMoney = findInventory ( $VisitorId, $BottleCapsId );
  $CashOnHand   = $VisitorMoney["Quantity"];
  echo ("<Title>Buy From $Name</Title>\n" ); 
?>
</head>
<script>
  <?php
  echo ( "  var OwnerId   = $OwnerId;\n" );
  echo ( "  var HealthId  = $HealthId;\n" );
  echo ( "  var VisitorId = $VisitorId;\n" );
  
  ?>  
  function purchaseItem (ItemId) {
    var Quantity = prompt ( "How many?",1 );
    window.location.href = 'buyItems.php?ItemId=' + ItemId + '&OwnerId=' + OwnerId + '&VisitorId=' + VisitorId + '&Quantity=' + Quantity;
  }
    
</script>
<body>

<?php
    echo ( "<input type=\"button\" value=\"$VisitorName\" onclick=\"window.location.href='viewOwner.php?OwnerId=$VisitorId';\"> has $CashOnHand BottleCaps<br>\n" );
    $result = query ( "Select * From inventory Where OwnerId=$OwnerId" );
    echo ("<h1>$Name</h1><hr>\n");      
    $count = 0;
    while ($row = mysql_fetch_assoc ($result)) {		
       $ItemId = $row["ItemId"];
       $Item = findItemByID ($ItemId);
       $ItemName = $Item["Name"];
       $Quantity = $row["Quantity"];
       $Description = $Item["Description"];
       $ForSale = $row["ForSale"];
       $Price = $row["Price"];
       if ($Quantity > 0) { 
          if ($count == 0) {    
            echo  ("<table border=\"0px solid\" width=\"90%\">\n" );
            echo  ("<tr bgcolor=\"lightgray\">\n" );
            echo  ("<th width=\"10%\" align=\"center\">Item</th>\n");
            print ("<th width=\"5%\"  align=\"center\">Quantity</th>\n" );
            print ("<th width=\"35%\" align=\"middle\">Description</th>");
            print ("<th width=\"5%\"  align=\"middle\">Price</th>");
            print ("<th width=\"25%\" align=\"middle\">Purchase</th>");
            print ("</tr>\n");
          }
          print ("<tr>");
          print ("<td align=\"center\">$ItemName</td>\n" );
          print ("<td align=\"center\">$Quantity</td>\n" );
          print ("<td align=\"center\">$Description</td>\n" );
          print ("<td align=\"center\">$Price</td>\n" );
    
          if ($ForSale == 1) { 
            print ("<td align=\"center\"><input type=\"button\" value=\"Purchase\" onclick=\"purchaseItem($ItemId);\"><td>\n" );
          } else {
            print ("<td align=\"center\">Sorry....Not for sale<td>\n" );
          }        
          print ("</tr>");       
          $count = $count + 1;
       }   
    }
    if ($count == 0) {
       echo ("<h1>Empty</h1>\n");
    }
    $result = query ( "Select * From pipboys" );
    $count = 0;
    echo ("Visit <Select name=\"selectVisitor\" onchange=\"selectVisitor(this.value);\">\n" );
    while ($row = mysql_fetch_assoc ($result)) {		
       $OwnerId = $row["ID"];    
       $Username = $row["Username"];
       echo (" <option value=\"$OwnerId\">$Username</option>\n" );
    }       
    echo ("</Select>\n" ); 
?>
</body>
</html>