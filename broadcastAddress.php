<?php
  include "common.inc";
  include "common.php";
?>

<html>
<head> <Title>Broadcast server address</Title>
</head>
<body>
UDP Broadcasting server address<br>
<?php
    $cmd = "python sendMessage.py $IpAddress \"$Message\"";
    exec($cmd);	
?>
<input type="button" value="back" onclick="window.location.href = document.referrer;"><br>
<br>
</Body>
</html>