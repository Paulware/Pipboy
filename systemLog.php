<html>
<head>
<title>System Log</title>
</head>
<body>
<p><center style="font-size:200%">System Log</center></p>
<hr>
<?php
      include "common.inc";
      include "common.php";
      
      $result = query ( "Select * From systemlog" );
      $count = 0;
      
      while ($row = mysql_fetch_assoc ($result)) {		
      
         $Message   = $row["Message"];
         $Timestamp = $row ["Timestamp"];
         
         if ($count == 0) {
            echo  ("<table border=\"2px solid\" width=\"90%\">\n" );
            echo  ("<tr bgcolor=\"lightgray\">");
            echo  ("<th width=\"25%\" align=\"center\">Time</th>");
            echo  ("<th width=\"75%\">Message</th>");
            echo  ("</tr>\n" );
         }  
         $Message   = $row["Message"];
         $Timestamp = $row["Timestamp"];      
         print ("<tr>");
         print ("<td align=\"center\">$Timestamp</td><td>$Message</td>" );
         print ("</tr>");
         $count = $count + 1;
      }
   
   if ($count > 0) {
     print ("</table>\n" );
   }  
   
?>
<hr>
<input type="button" value="home" onclick="window.location.href='index.php';"><br>

</body>
</html>
