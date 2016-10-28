<html>
<head> <Title>Execute an sql query and return</Title>
<?php
  include "common.inc";
  include "common.php";
  $sql = getParam ("sql" );
?>
</head>
<body>
<?php
    $result = query ( $sql );
    echo ($sql);
?>
<script>
   window.location.href = document.referrer;
</script>
</body>
</html>