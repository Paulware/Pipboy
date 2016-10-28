<html>
<head> <Title>Leader Board</Title>
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
<?php
  include "common.inc";
  include "common.php";
?>
</head>
<script>
  setTimeout(function(){window.location.reload(1);}, 5000); // Refresh every five seconds
</script>
<body>

<?php
    showFlagsTable();
    
    if ($winner == 1) {
      echo ("<H1>$Team team wins!</H1><br>\n" );
    }
    
    $result = query ( "Select * From pipboys order by Hits DESC" );
    $count = 0;
    while ($row = mysql_fetch_assoc ($result)) {		
       $Username = $row["Username"];
       $Hits = $row["Hits"];
       $MAC = $row["MAC"];
       $Health = $row["Health"];
       $Typename = $row["Typename"];
       $Team = $row["Team"];
       $ID = $row["ID"];
       
       if ((strtolower(substr($MAC,0,5)) != "store" ) && ($Typename != "Flag") && ($Team != "")){         
         
          if ($count == 0) {    
            echo  ("<table border=\"1px solid\" width=\"90%\">\n" );
            echo  ("<tr bgcolor=\"lightgray\">\n" );
            echo  ("<th width=\"10%\" align=\"center\">Name</th>\n");
            print ("<th width=\"5%\" align=\"center\">Hits</th>\n" );
            print ("<th width=\"5%\" align=\"center\">Health</th>\n" );
            print ("</tr>\n");
          }
          print ("<tr>");
          print ("<td align=\"center\"><input type=\"button\" value=\"$Username\" onclick=\"window.location.href='viewOwner.php?OwnerId=$ID'\"></td>\n" );
          print ("<td align=\"center\" bgColor=\"$Team\">$Hits</td>\n" );
          print ("<td align=\"center\">$Health</td>\n" );
          print ("</tr>");       
          $count = $count + 1;
       }   
    }
    echo ("</Table>\n" );
?>
<hr>
<input type="button" value="Home" onclick="window.location.href='index.php';"> 
</body>
</html>