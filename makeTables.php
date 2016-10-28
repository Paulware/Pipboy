<html>
<body>
Make Tables required for the PipboyCreation project<br>
<?php 
  include "common.inc";
  include "common.php";
  
  $q = mysql_query ("Drop Table pipboys");
  echo ("Create Table pipboys<br>\n");
  $sql = "CREATE TABLE pipboys (ID INT AUTO_INCREMENT PRIMARY KEY, Health INT Default 0, Ammo INT Default 25, Hits INT Default 0, IpAddress char(255), Team char(255), MAC char(255), MACOwner char(255), Username char(255), Password char(255), Typename char(255), Timestamp TIMESTAMP, Message char(255))";
  $result = mysql_query ($sql) or die ("Could not execute: $sql");
  
  $q = mysql_query ("Drop Table inventory");
  echo ("Create Table inventory<br>\n");
  $sql = "CREATE TABLE inventory (ID INT AUTO_INCREMENT PRIMARY KEY, ItemId INT, OwnerId INT, Quantity INT, ForSale BOOL DEFAULT 0, Price INT DEFAULT 100)";  
  $result = mysql_query ($sql) or die ("Could not execute: $sql");  
  
  echo ("Create Table lostpipboys<br>\n");
  $q = mysql_query ("Drop Table lostpipboys");
  $sql = "CREATE TABLE lostpipboys (ID INT AUTO_INCREMENT PRIMARY KEY, MAC char(255))";  
  $result = query ($sql);  
  
  echo ("Create Table items<br>\n" );
  $q = mysql_query ("Drop Table items");
  $sql = "CREATE TABLE items (ID INT AUTO_INCREMENT PRIMARY KEY, Name char(255), Description char(255))";
  $result = query ($sql);  
  
  echo ("Create Table Messages<br>\n" );
  $q = mysql_query ("Drop Table messages" );
  $sql = "CREATE TABLE messages (ID INT AUTO_INCREMENT PRIMARY KEY, OwnerId INT, SenderId INT, Message char(255), Timestamp TIMESTAMP)";
  $result = query ($sql);
  
  echo ("Create Table systemlog<br>\n" );
  $q = mysql_query ("Drop Table systemlog" );
  $sql = "CREATE TABLE systemlog (ID INT AUTO_INCREMENT PRIMARY KEY, Timestamp TIMESTAMP, Message char(255))";
  $result = query ($sql);
  

  // Add data to tables 
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"\", \"Store1\", \"\", \"First Store\", \"First Store\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"\", \"Store2\", \"\", \"Bank\", \"Bank\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"\", \"Store3\", \"\", \"Hospital\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"\", \"Store4\", \"\", \"Squidward dab\", \"Squidward dab\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"\", \"Store5\", \"\", \"Secret store (You dont see this)\", \"Secret store (You dont see this)\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"\", \"store7\", \"\", \"Store\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"\", \"store8\", \"\", \"nuke store\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"18:fe:34:e5:f0:d2\", \"\", \"Ashton\", \"\", \"Red\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Tank\", \"5c:cf:7f:14:2d:fc\", \"\", \"Tiger Tank\", \"\", \"Blue\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"NPC\", \"5c:cf:7f:1b:50:10\", \"\", \"Thomas\", \"\", \"Blue\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"5c:cf:7f:15:ac:4a\", \"\", \"Ian\", \"\", \"Red\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Flag\", \"5c:cf:7f:89:1f:80\", \"\", \"Flag2\", \"\", \"None\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Flag\", \"18:fe:34:e0:64:a5\", \"\", \"Flag3\", \"\", \"None\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Flag\", \"18:fe:34:e0:65:e8\", \"\", \"Flag4\", \"\", \"None\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Player\", \"5c:cf:7f:00:31:9b\", \"\", \"Conner\", \"\", \"Red\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"5c:cf:7f:c2:ba:39\", \"5c:cf:7f:00:31:9b\", \"Conner Rifle\", \"\", \"Red\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"18:fe:34:d3:33:4c\", \"5c:cf:7f:1b:50:10\", \"Thomas Rifle\", \"\", \"Blue\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Flag\", \"5c:cf:7f:14:32:4c\", \"\", \"Flag1\", \"\", \"None\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Player\", \"5c:cf:7f:80:5b:97\", \"\", \"Derek Helmet\", \"\", \"Red\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"18:fe:34:dc:fc:5b\", \"\", \"Derek Rifle\", \"\", \"Red\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Player\", \"5c:cf:7f:86:61:3d\", \"\", \"Alec Helmet\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"5c:cf:7f:14:30:70\", \"\", \"Alec Rifle\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Player\", \"5c:cf:7f:80:65:a7\", \"\", \"helmet2\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Player\", \"5c:cf:7f:86:61:df\", \"\", \"JacksHelmet\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"18:fe:34:dc:fc:88\", \"5c:cf:7f:86:61:df\", \"JacksRifle\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Player\", \"5c:cf:7f:80:5c:71\", \"\", \"Owens Helmet\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Rifle\", \"5c:cf:7f:14:2b:2c\", \"5c:cf:7f:80:5c:71\", \"OwensRifle\", \"\", \"\")");
query ("Insert into pipboys (Typename,MAC,MACOwner,Username,Password,Team) values (\"Player\", \"5c:cf:7f:1b:4d:28\", \"\", \"Abhushan\", \"\", \"Red\")");
query ("Insert into items (Name,Description) values (\"Shotgun\", \"\")");
query ("Insert into items (Name,Description) values (\"Sniper Rifle\", \"\")");
query ("Insert into items (Name,Description) values (\"AK-47\", \"\")");
query ("Insert into items (Name,Description) values (\"Revolver\", \"\")");
query ("Insert into items (Name,Description) values (\"Stimpak\", \"\")");
query ("Insert into items (Name,Description) values (\"Double Barrel Shotgun\", \"\")");
query ("Insert into items (Name,Description) values (\"Pipe Pistol\", \"\")");
query ("Insert into items (Name,Description) values (\"Pipe Machine Pistol\", \"\")");
query ("Insert into items (Name,Description) values (\"Tommy Gun\", \"\")");
query ("Insert into items (Name,Description) values (\"M4\", \"\")");
query ("Insert into items (Name,Description) values (\"Military Knife\", \"\")");
query ("Insert into items (Name,Description) values (\"Olympia\", \"\")");
query ("Insert into items (Name,Description) values (\"Hardened Sniper Rifle\", \"Very powerful sniper rifle\")");
query ("Insert into items (Name,Description) values (\"Ballista\", \"Call of Duty Black Ops 2 Sniper Rifle Good For Quick Scoping\")");
query ("Insert into items (Name,Description) values (\"Alien Pistol\", \"A specila pistol that you have to be in the right place at the right time and eihter kill an alien or just get it from him.\")");
query ("Insert into items (Name,Description) values (\"Rad Away\", \"A medicine that takes all of your less health away( instead it could maybe take away 5% of damage\")");
query ("Insert into items (Name,Description) values (\"Pipe Revolver Rifle\", \"made of pipes instead of being a hand held weapon its a rifle revolver\")");
query ("Insert into items (Name,Description) values (\"BottleCaps\", \"Money used in the game to buy items\")");
query ("Insert into items (Name,Description) values (\"Bandages\", \"Heales player to over 1000!!!\")");
query ("Insert into items (Name,Description) values (\"T-shirt of awesomenes\", \"This T-shirt will give you magical power when fighting other people or monsters.\")");
query ("Insert into items (Name,Description) values (\"Tin can\", \"Does nothing but looks cool.\")");
query ("Insert into items (Name,Description) values (\"nuke\", \"win item\")");
query ("Insert into items (Name,Description) values (\"KAMEHAMEHA\", \"It does tings Made by Ashton and Abhushaun All Rights Reserved\")");
query ("Insert into items (Name,Description) values (\"DragonBall\", \"KRILIN SUCKS!!!!!!!!!!!!!!!!!!!\")");
query ("Insert into items (Name,Description) values (\"PowerArmor\", \"Protects the user when they get shot\")");
query ("Insert into items (Name,Description) values (\"Reload\", \"25 Ammo\")");
echo ("Tables created.");
?>
</body>
</html>