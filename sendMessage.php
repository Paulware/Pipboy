<?php
  include "common.inc";
  include "common.php";
?>

<html>
<head> <Title>Send Message</Title>
</head>
<body>
<?php
  $MAC = getParam ("MAC");
  echo ("MAC: $MAC<br>");
  $Message = getParam ("Message");
  echo ("Message: $Message");
  $IpAddress = MACtoIp ($MAC);
  $cmd = "python sendMessage.py $IpAddress \"$Message\"";
  echo ( "<h1>CMD:</h1><br>$cmd<BR>\n");
	 exec($cmd);	   
?>
<script>
  window.location.href = 'index.php';
</script>
<br>
</Body>
</html>