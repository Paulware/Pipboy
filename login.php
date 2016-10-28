<?php
  $User = '';
  $cookie_name = 'User';
  if(isset($_COOKIE[$cookie_name])) {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
	   $user = $_COOKIE[$cookie_name];
  }
  if ($User != "") 
  {
    setcookie ("User", "$User", time()+36000);
    header( 'Location: index.php' );
  }
?>

<html>
<head> 
<Title>Login Please</Title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
html {
  background: url("images/pipboyBackground.jpg") no-repeat center fixed;
  background-size: cover;
}
body {
  color: white;
}
</style>
<script>
  function login () {
    var Username = document.all.Username.value;
    var Password = document.all.Password.value;
    window.location.href = 'requestLogin.php?Username=' + Username + '&Password=' + Password;
  }

</script>

</head>

<body>

<table>
<tr><td>User Name</td><td><input name="Username"></td></tr>
<tr><td>Password</td><td><input type="Password" name="Password"></td></tr>
</table><hr>
<input type=button value="Login" onclick="login();"><br>
</body>
</html>