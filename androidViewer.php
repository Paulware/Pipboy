<html>
<head> <Title>View Owner</Title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
  include "common.inc";
  include "common.php";
  $OwnerId = getParam ("OwnerId" );
  $Owner = findOwner ( $OwnerId);
  $Name =   $Owner ["Username"];
  $Health = $Owner ["Health"];
  $MAC = $Owner["MAC"];
  $Hits = $Owner["Hits"];
  $MACOwner = $Owner["MACOwner"];
  $Typename = $Owner["Typename"];
  $User = $_COOKIE["User"]; 
?>
</head>
<script>
  <?php
  echo ( "  var OwnerId  = $OwnerId;\n" );
  ?>
  function changePassword() {
     var newPassword = prompt ( "Enter new password" );
     var sql = "Update pipboys set Password='" + newPassword + "' Where ID=" + OwnerId;
     window.location.href = "query.php?sql=" + sql;   
  }
  
  function deleteMessage (ID) {
     var sql = "Delete From messages Where ID=" + ID;
     window.location.href = "query.php?sql=" + sql;
  }
  
  function sendMessage (ReceiverId) {
     var Message = prompt ( "Enter Message: " );
     Message = Message.replace(/'/g, "''");
     if (ReceiverId == 1000) { 
       window.location.href = "broadcastMessage.php?Message=" + Message + "&SenderId=" + OwnerId;
     } else {
       var sql = "Insert Into messages (OwnerId, SenderId, Message) values (" + ReceiverId + "," + OwnerId + ",'" + escape(Message) + "')";
       window.location.href = "query.php?sql=" + sql;
     }  
  }
  
  function changeMACOwner () {
     var MACAddress = prompt ( "Enter owners MAC address");
     var sql = "Update pipboys Set MACOwner='" + MACAddress + "' Where ID=" + OwnerId;
     alert (sql);
     window.location.href = 'query.php?sql=' + escape (sql);
  }
  
  function changePrice (ItemId, Price) {
     var newPrice = prompt ( "Enter New Price", Price );
     var sql = "Update inventory Set Price=" + newPrice + " Where ItemId=" + ItemId + " and OwnerId=" + OwnerId;  
     window.location.href = 'query.php?sql=' + escape (sql);     
  }
  
  function selectVisitor (Owner) {
     if (Owner != 0) {
       window.location.href = 'buyFromOwner.php?OwnerId=' + Owner + '&VisitorId=' + OwnerId;
     }  
  }
  
  function removeItem (ItemId) {
    var sql = "Delete from inventory Where OwnerId=" + OwnerId + " and ItemId='" + ItemId + "'";
    window.location.href = 'query.php?sql=' + escape(sql);
  }
    
  function forSale (checked,ItemId) {
     var sql = "Update inventory set ForSale=0 Where ItemId=" + ItemId;
     if (checked) {
        sql = "Update inventory set ForSale=1 Where ItemId=" + ItemId;
     } 
     window.location.href = 'query.php?sql=' + escape(sql);
  }  
  function archive (checked,ItemId) {
     /*
     var sql = "Update inventory set ForSale=0 Where ItemId=" + ItemId;
     if (checked) {
        sql = "Update inventory set ForSale=1 Where ItemId=" + ItemId;
     } 
     window.location.href = 'query.php?sql=' + escape(sql);
     */
  }  
</script>
<body>

<?php
  
    $result = query ( "Select * From inventory Where OwnerId=$OwnerId" );
    echo ("<h1>$Name</h1>\n");
    echo ("<h2><hr>\n" );
    echo ("<Table><th>Hits</th><th>Health</th></tr>\n" );
    echo ("<tr><td><center>$Hits</center></td><td><center>$Health</center></td></tr>\n" );
    echo ("</Table></h2><hr>\n" );
    
    $count = 0;
    while ($row = mysql_fetch_assoc ($result)) {		
       $ItemId = $row["ItemId"];
       $Item = findItemByID ($ItemId);
       $ItemName = $Item["Name"];
       $Quantity = $row["Quantity"];
       $Description = $Item["Description"];
       $ForSale = $row["ForSale"];
       $Price = $row["Price"];
       $Archived = 1;
       if ($count == 0) {    
         echo  ("<table border=\"1px solid\" width=\"90%\">\n" );
         echo  ("<tr bgcolor=\"lightgray\">\n" );
         echo  ("<th width=\"10%\" align=\"center\">Item</th>\n");
         print ("<th width=\"5%\" align=\"center\">Quantity</th>\n" );
         print ("<th width=\"65%\" align=\"middle\">Description</th>");
         print ("<th width=\"5%\" align=\"center\">For Sale</th>");
         print ("<th width=\"5%\" align=\"center\">Price</th>");
         print ("<th width=\"5%\">Delete</th>");
         print ("<th width=\"5%\" align=\"center\">In Vault</th>");
         print ("</tr>\n");
       }
       print ("<tr>");
       print ("<td align=\"center\">$ItemName</td>\n" );
       print ("<td align=\"center\">$Quantity</td>\n" );
       print ("<td align=\"center\">$Description</td>\n" );
       if ($ForSale == 1) {
         print ("<td align=\"center\"><input type=\"checkbox\" checked onchange=\"forSale(this.checked, $ItemId);\"></td>\n" );
       } else {
         print ("<td align=\"center\"><input type=\"checkbox\" onchange=\"forSale(this.checked, $ItemId);\"></td>\n" );
       }       
       print ("<td><input type=\"button\" value=\"$Price\" onclick=\"changePrice($ItemId,$Price);\"></td>\n" );
       print ("<td><input type=\"button\" value=\"Delete\" onclick=\"removeItem($ItemId);\"></td>\n" );
       if ($Archived == 1) {
         print ("<td align=\"center\"><input type=\"checkbox\" checked onchange=\"archive(this.checked, $ItemId);\"></td>\n" );
       } else {
         print ("<td align=\"center\"><input type=\"checkbox\" onchange=\"archive(this.checked, $ItemId);\"></td>\n" );
       }       
       
       print ("</tr>");       
       $count = $count + 1;
    }
    if ($count == 0) {
       echo ("<h1>Inventory Empty</h1>\n");
    } else {
       echo ("</Table>\n" );
    }
    echo ("<hr>\n" );
    echo ("Buy From <Select onchange=\"selectVisitor(this.value);\">\n" );
    echoOwnerOptions(); // Show Owners
    echo ("</Select>\n<BR>" ); 
    
    echo ("Send Message To <Select onchange=\"sendMessage(this.value);\">\n" );
    echoPlayers(); // Only send messages to real players 
    echo ("<option value=1000>EveryOne</option>\n" );
    echo ("</Select>\n<BR>" ); 
    
    if (($User == "admin") && (strtolower(substr($MAC,0,5)) != "store" ) ) {    
       echo ("<input type=\"button\" value=\"Revive\" onclick=\"window.location.href='revive.php?OwnerId='+OwnerId;\"><br>\n" );
    }
    
    $sql = "Select * From messages Where OwnerId=$OwnerId";
    $result = query ( $sql );
    $count = 0;
    while ($row = mysql_fetch_assoc ($result)) {
       $Message = $row["Message"];
       $SenderId = $row["SenderId"];
       $Sender = findOwner ($SenderId); 
       $SenderName = $Sender["Username"];
       $ID = $row["ID"];
       $count = $count + 1;
       if ($count == 1) {
          echo ("<hr>\n" );
          echo ("<h2>Messages: </h2><br>" );
          echo ("<table border=\"1px\">\n" );
       }
       echo ("<tr><td>$count</td><td>$SenderName</td><td>$Message</td>" );
       echo ("<td><input type=\"button\" value=\"delete\" onclick=\"deleteMessage($ID);\"></tr>\n" );
    }
    if ($count == 0) {
       echo ("No Messages<Table\n" );
    }   
    echo ("</Table><BR>\n" );
    if ($Typename == "Rifle") { 
      echo "MAC Address of rifles owner: <input value=\"$MACOwner\" name=\"MACOwner\" onchange=\"changeMACOwner();\">\n";
    } 
 ?>
<hr>
<input type="button" value="Leader Board" onclick="window.location.href='viewLeaders.php';">
<input type="button" value="Stores" onclick="window.location.href='viewStores.php';">
<hr>
<input type="button" value ="Change Password" onclick="changePassword();"><br>
<input type="button" value="Logout" onclick="window.location.href='logout.php';"> 
</body>
</html>