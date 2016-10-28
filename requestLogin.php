<?php
  include "common.inc";
  include "common.php"; 
    
  $Username = getParam ("Username");
  $Password = getParam("Password");
?>

<html>
<head> <Title>Checking Login</Title>
</head>
<body>
<?php

  if ( ($Username == 'admin') && ($Password == 'admin1') ) {
     echo ( " You are admin!<br>\n<script>window.location.href='index.php';</script>\n" );
     setcookie("User", "admin", time() + 3600000);
  } else { 
  
     $User = findUsername ( $Username );
     if ($User) { 
        $password = $User["Password"]; 
     } else { 
        echo ( "This user does not exist: $Username<br>\n" );
     }      
     
     if ($Password == $password) {
        echo ( "You are now logged in as $Username " );
        setcookie ( "User", "$Username", time() + 3600000);
        echo ("<Script>window.location.href = 'index.php';</Script>" );
     } else { 
        echo ("Incorrect Username or password" );
     }
     /*  
     if ($row) {
       $pword = $row['Password'];
       if ($pword == $password) {
          echo ("$user now logged in, set the cookie");
          setcookie ("user", "$user", time()+36000);
          echo ("<Script>window.location.href = 'index.php';</Script>\n");       
       } else {
          echo ("<h1>Bad password please go back and try again.</h1><hr>");
       }    
     } else { 
       echo ( "<h1>Sorry that user does not exist</h1><br>\n");  
     }
     */
   }
?>
<input type=button value="back" onclick="window.location.href='index.php';">
</body>

</html>