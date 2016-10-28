<html>
<head>
<title>Pipboy Creation</title>
<meta charset="utf-8" />'
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
html {
  background: url("images/pipboyBackground.jpg") no-repeat fixed;
  background-size: cover;
}
body {
  color: white;
}
</style>
<Script>
<?php
   include "common.inc";
   include "common.php";
   $User = $_COOKIE["User"];   
?>
  function setTime () {
    var NewTime = prompt ( "Enter New Time: HH:MM");
    window.location.href = 'setTime.php?NewTime=' + NewTime;
  }
  function sendMessageToServer(MAC) {
     var Message = prompt ( 'Enter message');
     window.location.href = 'updatePipboy.php?MAC=' + MAC + '&Message=' + escape(Message);
  }
  function sendMessageToPipboy(MAC) {
     var Message = prompt ( 'Enter message');
     window.location.href = 'sendMessage.php?MAC=' + MAC + '&Message=' + escape(Message);
  }
  function deletePipboy(MAC) {
     window.location.href = 'deletePipboy.php?MAC=' + MAC;
  }
  function resetPipboy(OwnerId) {
     window.location.href = 'resetPipboy.php?OwnerId=' + OwnerId;
  }
  function selectTeam (ID, Team) {
    var sql = "Update pipboys Set Team='" + Team + "' Where ID=" + ID;
    window.location.href='query.php?sql=' + escape(sql); 
  }
</Script>
</head>
<body>
<p><center style="font-size:200%">PipBoy Control Center</center></p>
<hr>
<?php
   if ($User == "") {
      echo ("<script>window.location.href='login.php';</script>\n" );  
   } else {
      echo ("You are logged in as: $User<br>\n" );
   }
   if ($User != 'admin') { // Normal player
      $Userdata = findUsername ($User);
      $ID = $Userdata ["ID"];
      $result = query ( "Select * From pipboys where ID=$ID" );
      
      if ($row = mysql_fetch_assoc ($result)) {		
         $MAC = $row["MAC"];
         
         echo  ("<table border=\"0px solid\" width=\"90%\">\n" );
         echo  ("<tr bgcolor=\"lightgray\">");
         echo  ("<th width=\"10%\" align=\"center\">Typename</th>");
         echo  ("<th width=\"10%\" align=\"center\">Username</th>");
         print ("<th width=\"15%\" align=\"center\">MAC</th><th width=\"15%\" align=\"middle\">IP Address</th>");
         print ("<th width=\"10%\" align=\"center\">Message</th><th width=\"15%\" align=\"center\">Timestamp</th>");
         print ("<th width=\"10%\">Location</th><th width=\"10%\">Delete</th>");
         print ("<th width=\"10%\">Test Message</th><th>Test Message</th><th>Reset</th></tr>\n");
         
         $OwnerId = $row["ID"];
         $Typename = $row["Typename"];
         $Username = $row["Username"];
         $Message = $row["Message"];
         $IpAddress = $row["IpAddress"];
         $Location = "[Latitude,Longitude]"; // $row["Nickname"];
         $Timestamp = $row["Timestamp"];      
         print ("<tr>");
         print ("<td align=\"center\">$Typename</td>");
         print ("<td align=\"center\"><input type=\"button\" value=\"$Username\" onclick=\"window.location.href='viewOwner.php?OwnerId=$OwnerId'\"></td><td align=\"center\">$MAC</td><td align=\"center\">$IpAddress</td><td align=\"center\">$Message</td>");
         print ("<td align=\"center\">$Timestamp</td><td align=\"center\">$Location</td>" );
         print ("<td align=\"center\"><input type=\"button\" value=\"Delete\" onclick=\"deletePipboy('$MAC');\"></td>");
         print ("<td align=\"center\"><input type=\"button\" value=\"Msg to Server\" onclick=\"sendMessageToServer('$MAC');\"></td>");
         print ("<td align=\"center\"><input type=\"button\" value=\"Msg to Pipboy\" onclick=\"sendMessageToPipboy('$MAC');\"></td>");
         print ("<td align=\"center\"><input type=\"button\" value=\"Reset Pipboy\" onclick=\"resetPipboy('$OwnerId');\"></td>");
         print ("</tr>");
         print ("</table>\n" );
      }
      
   } else { // User == admin
   
      echo ("<H1>Players</H1><Hr>\n" );   
      $count = 0;
      $result = query ( "Select * From pipboys" );
      while ($row = mysql_fetch_assoc ($result)) {		
         $Typename = $row["Typename"];
         $Team = $row["Team"];
         //echo ("Got a Team [$Team]<br>\n" );
         
         if (($Typename == "Player") && ($Team != ''))  {         
            if ($count == 0) {
               echo  ("<table border=\"1px solid\" width=\"90%\">\n" );
               echo  ("<tr bgcolor=\"lightgray\">");
               echo  ("<th width=\"10%\" align=\"center\">Username</th>");
               print ("<th width=\"15%\" align=\"center\">MAC</th><th width=\"15%\" align=\"middle\">IP Address</th>");
               print ("<th width=\"10%\" align=\"center\">Message</th>");
               print ("<th width=\"10%\">Team</th></tr>\n");
               print ("<tr><td align=\"center\"><input type=\"button\" value=\"admin\" onclick=\"window.location.href='showAdmin.php'\"></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>\n" );
            }  
            $MAC = $row["MAC"];
            $OwnerId = $row["ID"];
            $Username = $row["Username"];
            $Message = $row["Message"];
            $IpAddress = $row["IpAddress"];
            $Location = "[Latitude,Longitude]"; // $row["Nickname"];
            $Timestamp = $row["Timestamp"];   
            $Team = $row["Team"];            
            print ("<tr>");
            print ("<td align=\"center\"><input type=\"button\" value=\"$Username\" onclick=\"window.location.href='viewOwner.php?OwnerId=$OwnerId'\"></td><td align=\"center\">$MAC</td><td align=\"center\">$IpAddress</td><td align=\"center\">$Message</td>");
            print ("<td align=\"center\" bgcolor=\"$Team\">" );
            print ("<Select onchange=\"selectTeam($OwnerId, this.value);\">\n" );      
            selectTeam ($Team);
            print ("</td>" );
            print ("</tr>");
            $count = $count + 1;
         }
      }
      if ($count > 0) {
        print ("</table>\n" );
      } else {
        print ("<H2>No Players found</h2><hr>\n" );
      }       
   
   
      print ("<hr>\n" );
      $count = 0;
      $result = query ( "Select * From lostpipboys" );
      while ($row = mysql_fetch_assoc ($result)) {
         $MAC = $row['MAC'];      
         if ($MAC != '') {
            $sql = "Select * From pipboys Where MAC='$MAC'";
            $q = query ("$sql");
            if (!mysql_fetch_assoc ($q)) {
               if ($count==0) {
                 echo ("<H1>Pipboys detected but not yet assigned:<br></h1>\n");      
                 echo ( "<Table border=\"0\" width=\"30%\">\n");
                 echo ( "<tr><th>MAC</th></tr>\n");
               }
               echo ( "<tr><td>$MAC</td></tr>\n");
               $count = $count + 1;         
            }   
         }   
      }
      if ($count == 1) {
         echo ( "</Table>\n");
         echo ( "<p>\n");
         echo ("<H1>Pipboys assigned to users:<br></h1>\n");      
      }
                
      $count = 0;
      $result = query ( "Select * From pipboys" );
      while ($row = mysql_fetch_assoc ($result)) {		
         $MAC = $row["MAC"];
         // echo ("Got a MAC: $MAC<br>\n" );
         
         if (strtolower(substr($MAC,0,5)) != "store" ) {         
            if ($count == 0) {
               echo  ("<table border=\"0px solid\" width=\"90%\">\n" );
               echo  ("<tr bgcolor=\"lightgray\">");
               echo  ("<th width=\"10%\" align=\"center\">Typename</th>");
               echo  ("<th width=\"10%\" align=\"center\">Username</th>");
               print ("<th width=\"15%\" align=\"center\">MAC</th><th width=\"15%\" align=\"middle\">IP Address</th>");
               print ("<th width=\"10%\" align=\"center\">Message</th><th width=\"15%\" align=\"center\">Timestamp</th>");
               print ("<th width=\"10%\">Team</th><th width=\"10%\">Delete</th>");
               print ("<th width=\"10%\">Test Message</th><th>Test Message</th><th>Reset</th></tr>\n");
            }  
            $OwnerId = $row["ID"];
            $Typename = $row["Typename"];
            $Username = $row["Username"];
            $Message = $row["Message"];
            $IpAddress = $row["IpAddress"];
            $Location = "[Latitude,Longitude]"; // $row["Nickname"];
            $Timestamp = $row["Timestamp"];   
            $Team = $row["Team"];            
            print ("<tr>");
            print ("<td align=\"center\">$Typename</td>");
            print ("<td align=\"center\"><input type=\"button\" value=\"$Username\" onclick=\"window.location.href='viewOwner.php?OwnerId=$OwnerId'\"></td><td align=\"center\">$MAC</td><td align=\"center\">$IpAddress</td><td align=\"center\">$Message</td>");
            print ("<td align=\"center\">$Timestamp</td>\n" );
            print ("<td align=\"center\" bgColor=\"$Team\">" );
            print ("<Select onchange=\"selectTeam($OwnerId, this.value);\">\n" );      
            selectTeam ($Team);
            print ("</td>" );
            print ("<td align=\"center\"><input type=\"button\" value=\"Delete\" onclick=\"deletePipboy('$MAC');\"></td>");
            print ("<td align=\"center\"><input type=\"button\" value=\"Msg to Server\" onclick=\"sendMessageToServer('$MAC');\"></td>");
            print ("<td align=\"center\"><input type=\"button\" value=\"Msg to Pipboy\" onclick=\"sendMessageToPipboy('$MAC');\"></td>");
            print ("<td align=\"center\"><input type=\"button\" value=\"Reset Pipboy\" onclick=\"resetPipboy('$OwnerId');\"></td>");
            print ("</tr>");
            $count = $count + 1;
         }
      }
      if ($count > 0) {
        print ("</table>\n" );
      } 
      showStores();      
           
      print ("<p>");
      print ("<input type=\"button\" value=\"Add Owner\" onclick=\"window.location.href='addOwner.php';\"><br>\n");
   }   
?>
<hr>
<h2>Games</h2>
<input type="button" value="Collect 4 Items" onclick="window.location.href='collect4.php';"><br>       
<input type="button" value="Dragonball z" onclick="window.location.href='dragonballZ.php';"><br>      
<input type="button" value="Capture the Flags" onclick="window.location.href='captureTheFlags.php';"><br>      
<hr>
<input type="button" value="Delete Lost Sensors" onclick="window.location.href='deleteLostPipboys.php';"><br>
<input type="button" value="Logout" onclick="window.location.href='logout.php';"><br>
<input type="button" value="Set Server Time" onclick="setTime();"><br>
<input type="button" value="Leader Board" onclick="window.location.href='viewLeaders.php';"><br>
<hr>
<input type="button" value="Documentation" onclick="window.location.href='docs/docs.html';"><br>
<input type="button" value="Start tank" onclick="window.location.href='runTankjs.php';"><br>
<input type="button" value="Stop tank" onclick="window.location.href='stopTankjs.php';"><br>
Contact/help: paulware@hotmail.com
</body>
</html>
