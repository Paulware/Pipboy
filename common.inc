<?php
  $connection = mysql_connect('localhost', 'root', 'pi') or die ( 'Could not connect');
  $DB = 'Paulware';
  if (!mysql_select_db ($DB, $connection)) 
  {
    echo ("Could not select: $DB <BR>");
  }
  
?>