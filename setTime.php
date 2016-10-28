<?php
  include "common.inc";
  include "common.php";
?>

<html>
<head> <Title>Set Time on the Pi</Title>
</head>
<body>
<?php
  $NewTime = getParam ("NewTime");
  echo ("NewTime: $NewTime<br>");
  $cmd = "python broadcastCommand.py \"sudo date +%T -s '$NewTime'\"";
  echo ( "<h1>CMD:</h1><br>$cmd<BR>\n");
	 exec($cmd);	 
?>
<br>
<input type="button" value="back" onclick="window.history.back();">
</Body>
</html>