<html>
<head> <Title>Delete Pipboy</Title>
<?php
  include "common.inc";
  include "common.php";
  $MAC = getParam ("MAC");
  $pipboy = findPipboy($MAC);
  $pipboyId = $pipboy["ID"];
?>
</head>
<body>
<?php
    $sql = "Delete From inventory Where OwnerId = $pipboyId";
    $result = query ($sql);
    echo ("$sql<br>\n" );
    $sql = "Delete From pipboys Where MAC = '$MAC'";
    $result = query ( $sql );
    echo ("$sql<br>\n");
    $sql = "Delete From lostpipboys Where MAC = '$MAC'";
    $result = query ( $sql );
    echo ("$sql<br>\n");
?>
<script>
   window.location.href='index.php';
</script>
</body>
</html>