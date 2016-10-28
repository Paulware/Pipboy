<html>
<head>
<title>Change Password</title>
<Script>
   function submitPassword() {
       password1 = document.all.password1.value;
       password2 = document.all.password2.value;
       if (password1 == password2) {
          window.location.href='updatePassword.php?Password=' + password1;
       } else {
          alert ( 'The passwords do not match!' );
       }
       
   }
</Script>
</head>
<body>
<?php
include "common.inc";
include "common.php";

$user = '';
if(isset($_COOKIE["user"])) {  
  $user = $_COOKIE["user"]; 
  $sql = "Select * from Users where Username='$user'";
  $result = query ( $sql);
  if ($row = mysql_fetch_assoc ($result)) {
    $Password = $row['Password'];
    echo ( "<Table>\n");
    echo ( "<tr><td>Old Password</td><td>$Password</td></tr>\n" );
    echo ( "<tr><td>New Password</td><td><input type=\"password\" name=\"password1\"></td></tr>\n");
    echo ( "<tr><td>Confirm Password</td><td><input type=\"password\" name=\"password2\"></td></tr>\n");
    echo ( "</Table>\n");
    echo ( "<input type=\"button\" onClick=\"submitPassword();\" value=\"Submit\"><br>\n" );
  }
} else {
  echo ("User not specified");
}
?>
</body>
</html>