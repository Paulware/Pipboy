<?php
  include "common.inc";
  include "common.php";
?>

<html>
<head> <Title>Send Message</Title>
</head>
<body>
<?php
  $Message = getParam ("Message");
  echo ("Message: $Message");
  $sql = "Select * From pipboys";
  $result = query ($sql);
  $SenderId = getParam ("SenderId" );

  while ($row = mysql_fetch_assoc ($result)) {		
     $ID = $row["ID"];
     $MAC = $row["MAC"];
     $pos = strpos ( $MAC, ":"); 
     if ($pos !== false) { 
        $sql = "Insert Into messages (OwnerId, SenderId, Message) values ($ID,$SenderId,'$Message')";
        $q = query ($sql);
     }      
  }   
?>
<script>
   window.location.href = document.referrer;
</script>
<br>
</Body>
</html>