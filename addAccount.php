
<html>
<head> <Title>Create An Account</Title>

<script>
  function login (value) {
    var user = document.all.user.value;
    var password = document.all.password1.value;
    if (password != document.all.password2.value) {
        alert ( 'The passwords do not match');
    } else {
        window.location.href = 'createAccount.php?user=' + user + '&password=' + password;        
    }
  }
</script>

</head>

<body>
<table>
<tr><td>User Name</td><td><input name="user"></td></tr>
<tr><td>Password</td><td><input type=password name="password1"></td></tr>
<tr><td>Confirm Password</td><td><input type=password name="password2"></td></tr>
</table><hr>
<input type=button value="Create Account" onclick="login();"><br>
<input type=button value="cancel" onclick="window.location.href='index.php';"><br>
</body>
</html>