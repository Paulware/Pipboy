<html>
<head> <Title>Reset Pipboy</Title>
<?php
  include "common.inc";
  include "common.php";
  $OwnerId = getParam ("OwnerId" );
  $Health = findItem ( "Health");
  $HealthId = $Health["ID"];
  $BottleCaps = findItem ("BottleCaps" );
  $BottleCapsId = $BottleCaps["ID"];
  
?>
</head>
<body>
<?php
    $sql = "Delete From inventory Where OwnerId = $OwnerId";
    $result = query ( $sql );
    echo ($sql);
    echo ("<br>");
    $sql = "Insert into inventory (ItemId,Quantity,OwnerId) Values ($HealthId, 100, $OwnerId)";
    $result = query ( $sql);
    echo ($sql);
    $sql = "Insert into inventory (ItemId,Quantity,OwnerId) Values ($BottleCapsId, 100, $OwnerId)";
    $result = query ( $sql);
    echo ($sql);
?>
</Table>
<script>
   window.location.href='index.php';
</script>
<hr>
</body>
</html>