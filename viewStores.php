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
  showStores();
?>
</body>
</html>