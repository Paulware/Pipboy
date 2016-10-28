<html>
<head> <Title>Delete lost pipboys</Title>
<?php
  include "common.inc";
  include "common.php";
?>
</head>
<body>
<?php
    $sql = "Delete From lostpipboys";
    $result = query ( $sql );
    echo ($sql);
?>
<script>
   window.location.href='index.php';
</script>
</body>
</html>