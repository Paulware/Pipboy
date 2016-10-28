<?php

   function chooseCommand ($winCmd, $linuxCmd) { // necessary?
       $cmd = $linuxCmd;
       return $cmd;
   }
   
   function showStores() {
      // Show the stores
      print ("<hr>\n");
      $result = query ( "Select * From pipboys" );
      $count = 0;
      while ($row = mysql_fetch_assoc ($result)) {		
         $MAC = $row["MAC"];
         $OwnerId = $row["ID"];
         $Username = $row["Username"];      
            
         if (strtolower(substr($MAC,0,5)) == "store" ) { 
            if ($count == 0) {
               echo  ("<H1>Stores<br></h1>\n");      
               echo  ("<table border=\"0px solid\" width=\"90%\">\n" );
               echo  ("<tr bgcolor=\"lightgray\">\n" );
               print ("<th width=\"15%\" align=\"center\">Typename</th>\n");
               print ("<th width=\"15%\" align=\"center\">Name</th>\n");
               print ("<th width=\"15%\" align=\"center\">MAC</th><th width=\"15%\" align=\"middle\">IP Address</th>");
               print ("<th width=\"10%\" align=\"center\">Message</th><th width=\"15%\" align=\"center\">Timestamp</th>");
               print ("<th width=\"10%\">Location</th><th width=\"10%\">Delete</th>");
               print ("<th width=\"10%\">Test Message</th><th>Test Message</th><th>View</th>\n" );
               print ("</tr>\n");
            }  
            $Id = $row["ID"];
            $Typename = $row["Typename"];
            $Username = $row["Username"];
            $Message = $row["Message"];
            $IpAddress = $row["IpAddress"];
            $Location = "[Latitude,Longitude]"; // $row["Nickname"];
            $Timestamp = $row["Timestamp"];      
            print ("<tr>");
            print ("<td align=\"center\">$Typename</td>\n" );
            print ("<td align=\"center\">$Username</td>\n" );
            print ("<td align=\"center\">$MAC</td><td align=\"center\">$IpAddress</td><td align=\"center\">$Message</td>");
            print ("<td align=\"center\">$Timestamp</td><td align=\"center\">$Location</td>" );
            print ("<td align=\"center\"><input type=\"button\" value=\"Delete\" onclick=\"deletePipboy('$MAC');\"></td>");
            print ("<td align=\"center\"><input type=\"button\" value=\"Msg to Server\" onclick=\"sendMessageToServer('$MAC');\"></td>");
            print ("<td align=\"center\"><input type=\"button\" value=\"Msg to Store\" onclick=\"sendMessageToPipboy('$MAC');\"></td>");
            print ("<td align=\"center\"><input type=\"button\" value=\"View Store\" onclick=\"window.location.href='viewOwner.php?OwnerId=$OwnerId';\"></td>");
            print ("</tr>");
            $count = $count + 1;
         }
      }
      if ($count > 0) {
        print ("</table>\n" );
      }      
   }
  
   function captureTheFlags() {
     $count = 0;
     $sql = "Select * From pipboys";
     $result = query ($sql);
     // Clear all flags first 
     while ($row = mysql_fetch_assoc ($result)) {		
        $Name = $row["Username"];
        $MAC = $row["MAC"];
        $ID = $row["ID"];
        $pos = strpos ( $MAC, ":"); 
        $Typename = $row["Typename"];
        if ($Typename == "Flag") { 
           $IpAddress = $row["IpAddress"];
           $Message = "start";
           if ($IpAddress != "") { 
             $cmd = "python sendMessage.py $IpAddress \"$Message\"";
             exec($cmd);	     
           }  
        }   
     }        
     
     $Stimpaks = findItem ("Stimpak");
     $StimpakId = $Stimpaks["ID"];
     $BottleCaps = findItem ("BottleCaps");
     $BottleCapsId = $BottleCaps["ID"];
     $Dragonball = findItem ("DragonBall");
     $DragonballId = $Dragonball["ID"];

     $sql = "Delete from messages";
     $q = query ($sql);        
     $sql = "Update pipboys Set Ammo=25";
     $q = query ($sql);        
     $sql = "Update pipboys Set Hits=0";
     $q = query ($sql);        
     $sql = "Update pipboys Set Health=5";
     $q = query ($sql);     
     
     $sql = "Select * From pipboys";
     $result = query ($sql);
     $count = 0;
     while ($row = mysql_fetch_assoc ($result)) {		
        $Name = $row["Username"];
        $MAC = $row["MAC"];
        $ID = $row["ID"];
        $pos = strpos ( $MAC, ":"); 
        $Team = $row ["Team"];
        if (($pos !== false) && ( $Team != "") && ($Team != "None")){ 
           $IpAddress = $row["IpAddress"];
           $Message = "start";
           if ($IpAddress != "") {
             $cmd = "python sendMessage.py $IpAddress \"$Message\"";
             echo ( "<h1>Start $Name [$Team]</h1><br>$cmd<BR>\n");
             exec($cmd);	     
           
             $sql = "Insert into inventory (OwnerId, ItemId, Quantity) values ($ID, $StimpakId, 4)"; 
             $q = query ($sql);
           
             $Reload = findItem ( "Reload");
             $ReloadId = $Reload["ID"];
             $sql = "Insert into inventory (OwnerId, ItemId, Quantity) values ($ID, $ReloadId, 5)"; 
             $q = query ($sql);
              
             // Add 10 bottlecaps for playing the game
             $BottleCaps = findItem ("BottleCaps");
             $BottleCapsId = $BottleCaps["ID"];
             echo ("ID: $ID, Team: [$Team]<br>\n" );
             modifyInventory ($ID, $BottleCapsId, 0, 10);                      
           }  
        }          
     }
     
     // Set Flag colors = None
     print ("Set flag colors = None<br>\n" );
     $sql = "Select * From pipboys Where Typename='Flag'";
     $result = query ($sql);
     while ($row = mysql_fetch_assoc ($result)) {		
        $ID = $row["ID"]; // Primary key
        $sql = "Update pipboys set Team='None' Where ID=$ID";
        $q = query($sql);
     } 
     
     
     $sql = "Delete From systemlog";
     query ($sql);
     $sql = "Insert into systemlog (Message) Values ('Capture the flags started.' )";
     query ($sql);  
     print ("<hr>Done<br>\n" );     
   }
   
   function killDevices ($MAC) {
      // kill all devices owned by this player
      $sql = "Select * From pipboys where MACOwner='$MAC'";
      $results = query ($sql);
      while ($row = mysql_fetch_assoc ($results)) {
         $ID = $row["ID"];
         $IpAddress = $row["IpAddress"];       
         $Message = "died";
         $cmd = "python sendMessage.py $IpAddress \"$Message\"";
         echo ( "<h1>CMD:</h1><br>$cmd<BR>\n");
         exec($cmd);	
         $sql = "Update pipboys set Health=0 Where ID=$ID";         
         $results = query ($sql);
      }    
   }
   
   function findShooter ( $shooter ) {
      echo "Match $shooter MAC address in the database<br>";
      $result = query ( "Select * From pipboys" );
      while ($row = mysql_fetch_assoc ($result))   {		 
         $mac = $row["MAC"];
         list($mac1, $mac2, $mac3, $mac4, $mac5, $mac6) = explode(":", $mac);
         $last3 = substr ( $mac5, 1,1).$mac6;
         if ($last3 == $shooter) {
            echo "Found shooter! $mac<br>\n";
            break;
         }
      } 
      return $row;      
   }
   
   function incrementHits ($shooter, $numHits) {
      $Hits = $shooter["Hits"] + $numHits;
      $shooterId = $shooter["ID"];
      $sql = "Update pipboys set Hits = $Hits Where ID=$shooterId";
      $result = query ($sql);      
   }
   
   function selectTeam ($team) {  
      if ($team == "Red") {
         echo "<option value=\"Red\" selected>Red</option>\n";
      } else {
         echo "<option value=\"Red\">Red</option>\n";          
      }
      if ($team == "Blue") {
         echo "<option value=\"Blue\" selected>Blue</option>\n";
      } else {
         echo "<option value=\"Blue\">Blue</option>\n";          
      }
      if ($team == "Green") {
         echo "<option value=\"Green\" selected>Green</option>\n";
      } else {
         echo "<option value=\"Green\">Green</option>\n";          
      }
      if (($team != "Blue") && ($team != "Red") && ($team != "Green")) {
         echo "<option value=\"\" selected>None</option>\n";
      } else {
         echo "<option value=\"\">None</option>\n";          
      }
      echo ("</Select>\n");
   }   

   // $Quantity creates a static count
   // $Offset makes a relative count (like adding) 
   function modifyInventory ($OwnerId, $ItemId, $Quantity, $Offset) {
      if ($Offset == 0) { 
         echo ( "Quantity is $Quantity<br>\n" );
         $sql = "Select * From inventory where OwnerId=$OwnerId and ItemId=$ItemId";
         $result = query ($sql);
         if ($row = mysql_fetch_assoc($result)) {
            $sql = "Update inventory set Quantity=$Quantity Where ItemId=$ItemId and OwnerId=$OwnerId";         
         } else {
            $sql = "Insert into inventory (ItemId, OwnerId, Quantity) values ($ItemId, $OwnerId, $Quantity)";
         }
      } else {
         $sql = "Select * From inventory where OwnerId=$OwnerId and ItemId=$ItemId";
         echo ("sql: $sql<br>");
         $result = query ($sql);
         if ($row = mysql_fetch_assoc($result)) {
            $InStock = $row["Quantity"];
            $NewTotal = $InStock + $Offset;
            if ($NewTotal >= 0) { 
              $sql = "Update inventory set Quantity=$NewTotal Where ItemId=$ItemId and OwnerId=$OwnerId";        
            } else {
              echo ("ERR cannot have less than 0 of an item " );             
            }            
         } else {
            $sql = "Insert into inventory (ItemId, OwnerId, Quantity) values ($ItemId, $OwnerId, $Offset)";
         }       
      }
      echo ("$sql<br>\n" );   
      $q = query ($sql);           
   }
   
   function query ( $sql ) {
     $q = mysql_query ($sql) or die ("Could not execute: $sql");
     return $q;  
   }   
   
   function MACtoIp($mac) {
     $pipboy = findPipboy($mac);
     $IpAddress = $pipboy['IpAddress'];
     return $IpAddress;     
   }
   
   function findOwner ($OwnerId) {
     $sql = "Select * From pipboys Where ID=$OwnerId";
     $result = query ( $sql);
     $value = mysql_fetch_assoc($result);
     return $value;
   }     
   
   function findPipboy($mac) {
     $sql = "Select * From pipboys Where MAC='$mac'";
     $result = query ( $sql);
     $value = mysql_fetch_assoc($result);
     return $value;
   }
   
   function findUsername ($Username) {
     $sql = "Select * From pipboys Where Username='$Username'";
     $result = query ($sql);
     $value = mysql_fetch_assoc($result);
     return $value;
   }
 
   function findItemByID($ID) {
     $sql = "Select * From items Where ID=$ID";
     $result = query ( $sql);
     $value = mysql_fetch_assoc($result);
     return $value;
   }
   
   function findItem($Name) {
     $sql = "Select * From items Where Name='$Name'";
     $result = query ( $sql);
     $value = mysql_fetch_assoc($result);
     return $value;
   }   
 
   function findInventory ($OwnerId, $ItemId) {
     $sql = "Select * From inventory Where OwnerId=$OwnerId And ItemId=$ItemId";     
     $result = query ( $sql);
     $value = mysql_fetch_assoc($result);
     return $value;
   }
   
   function updateInventoryItem ($PipboyId, $Item, $Quantity) {
     $sql = "Update inventory Set Quantity=$Quantity Where PipboyId=$PipboyId And Item='$Item'";    
     echo ("$sql<BR>\n" );
     $q = mysql_query ($sql) or die ("Could not execute: $sql");
   }
   
   function getRandomItem() {
      $sql = "Select ID from items order by ID DESC";
      $result = query ($sql);
      $row = mysql_fetch_assoc($result);
      $maxID = $row["ID"];
      while (true) {
         $ID = rand (0,$maxID);
         $sql = "Select * From items where ID=$ID";
         $result = query ($sql);
         if ($row = mysql_fetch_assoc($result) ) {
            break;
         }
      }
      return $row;
   }
   
   // Only show real players (not non-player characters)
   function echoPlayers() {
      $result = query ( "Select * From pipboys" );    
      echo ("<option value=0>No One</option>\n" );
      while ($row = mysql_fetch_assoc ($result)) {		
         $Owner = $row["ID"];    
         $Username = $row["Username"];
         $MAC = $row["MAC"];
         $pos = strpos ( $MAC, ":"); 
         if ($pos !== false) {          
            echo (" <option value=\"$Owner\">$Username</option>\n" );
         }      
      }       
   }    
   
   function echoOwnerOptions () {   
      $result = query ( "Select * From pipboys" );    
      echo ("<option value=0>No One</option>\n" );
      while ($row = mysql_fetch_assoc ($result)) {		
         $Owner = $row["ID"];    
         $Username = $row["Username"];
         echo (" <option value=\"$Owner\">$Username</option>\n" );
      }       
   }
   
   function getParam ($name) {
      $value = $_GET["$name"];
      if ($value == "")
        $value = $_REQUEST["$name"];
       return $value;      
   }
   
   function showFlagsTable() {
      $result = query ( "Select * From pipboys where Typename = 'Flag'");
      echo ("<table border = \"1px solid\">\n" );
      // echo ("<tr><th>Flag</th><th>Color</th></tr>\n" );
      $lastTeam = "";
      $winner = 1;
      echo ("<tr>");
      while ($row = mysql_fetch_assoc($result)) {
         $Team = $row ["Team"];
         $Username = $row["Username"];
         if ($Team == "None") { 
           echo ("<td>$Username</td>" );
         } else {
           echo ("<td bgColor=\"$Team\">$Username</td>" );
         }  
         if ($Team == "None") {
           $winner = 0;
         } else if ($lastTeam == "") {
           $lastTeam = $Team;
         } else if ($lastTeam != $Team) { 
           $winner = 0;
         } 
         $lastTeam = $Team;
      }
      echo ("</tr></table><p>\n" );        
   }
   
   function showStimpaks($OwnerId) {
      $Stimpak = findItem ( "Stimpak");
      $StimpakId = $Stimpak ["ID"];
      $Stimpaks = findInventory ( $OwnerId, $StimpakId);
      $Quantity = $Stimpaks["Quantity"];
      if ($Quantity > 0) {
         echo ("<table border = \"1px solid\">\n" );
         echo ("<tr>" );
      
         for ($i=0; $i<$Quantity; $i++) {
            echo ("<td><input type=\"button\" value=\"Stimpak\" onclick=\"window.location.href='useStimpak.php?OwnerId=$OwnerId';\"></td>" );
         }

         echo ("</tr></table><p>\n" );        
      }   
   }
   
   function showReloads($OwnerId) {
      $Reload = findItem ( "Reload");
      $ReloadId = $Reload ["ID"];
      $Reloads = findInventory ( $OwnerId, $ReloadId);
      $Quantity = $Reloads["Quantity"];
      if ($Quantity > 0) {
         echo ("<table border = \"1px solid\">\n" );
         echo ("<tr>" );
      
         for ($i=0; $i<$Quantity; $i++) {
            echo ("<td><input type=\"button\" value=\"Reload\" onclick=\"window.location.href='useReload.php?OwnerId=$OwnerId';\"></td>" );
         }
         echo ("</tr></table><p>\n" );        
      }   
   }
   
   
   // Get lines ready for display
   function unescapeCharacters ($line) {
     $line = str_replace ('&#060;','<',$line);
     $line = str_replace ('&#062;','>',$line);
     $line = str_replace ('&#146;','\'',$line);
     $line = str_replace ('&#147;','"',$line);
	    $line = str_replace ('\r\n','<BR>',$line);
     //$line = str_replace ('&','$2$1$', $line);	 
	    $line = str_replace ('&#092;','\\',$line);
	    return $line;
   }
   
   function escapeCharacters ( $line ) {
     $line = str_replace ('<','&#060;',$line);
     $line = str_replace ('>','&#062;',$line);
     $line = str_replace ('\'','&#146;',$line);
     $line = str_replace ('"','&#147;',$line);
	    $line = str_replace ('\\','&#092;',$line);
     //$line = str_replace ('\r\n', '<BR>', $line );
     // Do not escape <BR>, <LI>, <UL>, or <OL> or others
     $line = str_replace ('&#060;BR&#062;','<BR>',$line );
     $line = str_replace ('&#060;LI&#062;','<LI>',$line );
     $line = str_replace ('&#060;UL&#062;','<UL>',$line );
     $line = str_replace ('&#060;OL&#062;','<OL>',$line );
     $line = str_replace ('&#060;/LI&#062;','</LI>',$line );
     $line = str_replace ('&#060;/UL&#062;','</UL>',$line );
     $line = str_replace ('&#060;/OL&#062;','</OL>',$line );
     $line = str_replace ('&#060;br&#062;','<br>',$line );
     $line = str_replace ('&#060;li&#062;','<li>',$line );
     $line = str_replace ('&#060;ul&#062;','<ul>',$line );
     $line = str_replace ('&#060;ol&#062;','<ol>',$line );
     $line = str_replace ('&#060;/li&#062;','</li>',$line );
     $line = str_replace ('&#060;/ul&#062;','</ul>',$line );
     $line = str_replace ('&#060;/ol&#062;','</ol>',$line );
     $line = str_replace ('&#060;b&#062;','<b>',$line );
     $line = str_replace ('&#060;/b&#062;','</b>',$line );
     $line = str_replace ('&#060;B&#062;','<B>',$line );
     $line = str_replace ('&#060;/B&#062;','</B>',$line );
	    $line = str_replace ('&#092;','\\',$line );

     return $line;
   }

?>