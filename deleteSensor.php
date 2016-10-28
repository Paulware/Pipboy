<html>
<head> <Title>Delete sensor</Title>
<?php
  include "common.inc";
  include "common.php";
  $MAC = getParam ("MAC");
?>
</head>
<body>
<?php
    $sql = "Delete From sensors Where MAC = '$MAC'";
    $result = query ( $sql );
    echo ($sql);
    $sql = "Delete From lostsensors Where MAC = '$MAC'";
    $result = query ( $sql );
    echo ($sql);
?>
<script>
   window.location.href='index.php';
</script>
</body>
</html>