<html>
<head> <Title>View Messages</Title>
<?php
  include "common.inc";
  include "common.php";
?>
</head>
<script>
  function deleteMessage (ID) {
     var sql = "Delete from messages where ID=" + ID;
     window.location.href = 'query.php?sql=' + escape (sql);
  }
  
  function deleteAllMessages() {
     var sql = "Delete from messages";
     window.location.href = 'query.php?sql=' + escape (sql);
  }
</script>
<body>

<?php
  echo  ("<table border=\"1px solid\" width=\"90%\">\n" );
  echo  ("<tr bgcolor=\"lightgray\">\n" );
  echo  ("<th width=\"5%\"   align=\"center\">ID</th>\n");
  echo  ("<th width=\"5%\"   align=\"center\">TimeStamp</th>\n");
  echo  ("<th width=\"5%\"   align=\"center\">Sender</th>\n");
  print ("<th width=\"5%\"   align=\"middle\">Receiver</th>");
  print ("<th width=\"50%\"  align=\"middle\">Message</th>");  
  print ("<th width=\"5%\"   align=\"middle\">Delete</th>");
  print ("</tr>\n");
  $result = query ( "Select * From messages" );
  while ($row = mysql_fetch_assoc ($result)) {		
     $Timestamp = $row["Timestamp"];
     $SenderId = $row["SenderId"];
     $Sender = findOwner ($SenderId);
     $SenderName = $Sender["Username"];
     $ID = $row["ID"];
     $OwnerId = $row["OwnerId"];
     $Owner = findOwner ( $OwnerId );
     $OwnerName = $Owner["Username"];
     $Message = $row["Message"];
     print ("<tr>");
     print ("<td align=\"center\">$ID</td>\n" );
     print ("<td align=\"center\">$Timestamp</td>\n" );
     print ("<td align=\"center\">$SenderName</td>\n" );
     print ("<td align=\"center\">$OwnerName</td>\n" );
     print ("<td align=\"center\">$Message</td>\n" );
     
     print ("<td align=\"center\"><input type=\"button\" value=\"delete\" onclick=\"deleteMessage($ID);\"></td>\n" );
     print ("</tr>");
  }   
?>
<input type="button" value="Delete all messages" onclick="deleteAllMessages();"> 

</body>
</html>