<html>
<head> <Title>View Items</Title>
<?php
  include "common.inc";
  include "common.php";
  
  $User = '';
  $cookie_name = 'User';
  if(isset($_COOKIE[$cookie_name])) {
	   $User = $_COOKIE[$cookie_name];
  }
  if ($User != "") { 
     echo ("User: $User<br>" );
  }   

?>
</head>
<script>
  function sendTo ( OwnerId, ItemId ) {
     if (OwnerId == 0) {
        alert ( 'No one selected' );
     } else {
        var Quantity = prompt ( 'Enter quantity' );
        window.location.href = 'addItem.php?ItemId=' + ItemId + '&Quantity=' + Quantity + '&OwnerId=' + OwnerId;
     }   
  }

  function modifyItem (ID, Name, Description) {
     Name = prompt ( 'Enter Name',Name );
     Description = prompt ( 'Enter Description',Description );
     var sql = "Update items Set Name='" + Name + "', " + 
               "Description='" + Description + "' Where ID=" + ID;         
     window.location.href = 'query.php?sql=' + sql;     
  }

  function deleteItem (ID) {
    var sql = "Delete from items Where ID=" + ID;
    window.location.href = 'query.php?sql=' + sql;
  }
  
  function addItem () {
     var Name = prompt ( 'Enter Name' );
     var Description = prompt ( 'Enter Description' );
     var sql = "Insert Into items (Name,Description) values ('" + Name +
               "', '" + Description + "')";         
     window.location.href = 'query.php?sql=' + sql;
  }
</script>
<body>

<?php
  if ($User != "admin") 
  {  
    echo "No admittance...sorry<br>";
  } 
  else { 
     echo  ("<table border=\"1px solid\" width=\"90%\">\n" );
     echo  ("<tr bgcolor=\"lightgray\">\n" );
     echo  ("<th width=\"20%\" align=\"center\">Name</th>\n");
     print ("<th width=\"55%\" align=\"middle\">Description</th>");
     print ("<th width=\"5%\" align=\"middle\">Delete</th>");  
     print ("<th width=\"5%\" align=\"middle\">Modify</th>"); 
     print ("<th width=\"5%\" align=\"middle\">Send To</th>"); 
     print ("</tr>\n");
     $result = query ( "Select * From items" );
     while ($row = mysql_fetch_assoc ($result)) {		
        $Name = $row["Name"];
        $Description = $row["Description"];
        $Cost = $row["Cost"];
        $ID = $row["ID"];
        print ("<tr>");
        print ("<td align=\"center\">$Name</td>\n" );
        print ("<td align=\"center\">$Description</td>\n" );
        print ("<td align=\"center\"><input type=\"button\" value=\"delete\" onclick=\"deleteItem($ID);\"></td>\n" );
        print ("<td align=\"center\"><input type=\"button\" value=\"modify\" onclick=\"modifyItem($ID,'$Name','$Description');\"></td>\n" );
        print ("<td align=\"center\">" );
        echo ("<Select onchange=\"sendTo(this.value, $ID);\">\n" );
        $q = query ( "Select * From pipboys" );
        echo ("<option value =\"0\">No one</option>\n" );
        while ($d = mysql_fetch_assoc ($q)) {		
           $OwnerId = $d["ID"];    
           $Username = $d["Username"];
           echo (" <option value=\"$OwnerId\">$Username</option>\n" );
        }       
        echo ("</Select>\n" ); 
        print ("</td>\n" );     
        print ("</tr>");
     }  
     echo ("<input type=\"button\" value=\"Add Item\" onclick=\"addItem();\">\n" ); 
  }   
?>
</body>
</html>