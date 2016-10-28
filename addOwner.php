
<html>
<head>
<Title>Add Pipboy</Title>
<body>
<p><center style="font-size:200%">Pipboy Automation Center</center></p>
<hr><center> 

<script>
  function addPipboy (MAC, Username, Typename) {
    window.location.href = 'addPipboyMac.php?MAC=' + MAC + '&Username=' + Username + '&Typename=' + Typename;
  }

</script>

</head>

<body>
<table>
<tr><td>MAC Address</td><td><input name="macAddress"></td></tr>
<tr><td>Username</td><td><input name="Username"></td></tr>
<tr><td>Typename</td><td><select name="Typename"><option value="Player">Player</option><option value="Rifle">Rifle</option><option value="Flag">Flag</option><option value="Tank">Tank</option><option value="NPC">Non-Player Character</option><option value="PickAndDrop">Pick and Drop</option></select></td></tr>
</table>
<br>
<input type="button" value="Cancel" onclick="window.location.href='index.php';">
<input type=button value="Add" onclick="javascript:addPipboy(document.all.macAddress.value, document.all.Username.value, document.all.Typename.value);">
<hr>
<b>Contact/help:</b> <u><i>paulware@hotmail.com</i></u>
</body>
</html>