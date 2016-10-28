<html>
<head> <Title>View Owner</Title>
<?php
  include "common.inc";
  include "common.php";
  $OwnerId = getParam ("OwnerId" );
  $Owner = findOwner ( $OwnerId);
  $Name =   $Owner ["Username"];
  $Health = $Owner ["Health"];
  $MAC = $Owner["MAC"];
  $Hits = $Owner["Hits"];
  //$Ammo = $Owner["Ammo"];
  $MACOwner = $Owner["MACOwner"];
  $Typename = $Owner["Typename"];
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
<script>
  setTimeout(function(){window.location.reload(1);}, 5000); // Refresh every five seconds
</script>
<body>
<?php
  // Show Hits and Health
  echo ("<H2>$Name Health:$Health Hits:$Hits</H2>\n");
  showFlagsTable();
  showStimpaks($OwnerId);
  showReloads($OwnerId);
  echo ("<input type=\"button\" value=\"inventory\" onclick=\"window.location.href='androidViewer.php?OwnerId=$OwnerId';\">\n" );
?>
<br>
</body>
</html>