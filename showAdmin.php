<html>
<head> <Title>Show Administrators Page</Title>
<?php
  include "common.inc";
  include "common.php";

?>
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
</head>
<H1>Welcome Administrator</H1>
<Table>
<tr><th>Action</th><th>Description</th></tr>
<tr><td><input type="button" value="Start" onclick="window.location.href='captureTheFlags.php';"></td><td>Start a capture the flags game.</td></tr>
<tr><td><input type="button" value="Leader Board" onclick="window.location.href='viewLeaders.php';"></td><td>View the leader board</td></tr>
<tr><td><input type="button" value="Broadcast Address" onclick="window.location.href='broadcastAddress.php';"></td><td>UDP broadcast server address</td></tr>
</Table>
</body>
</html>