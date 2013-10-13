<?php
 $_USER  = "root";
 $_PSSWD = "";
 $_DB    = "uv_experiencias";
 $_HOST  = "localhost";

try
{
  $DB = new PDO("mysql:host=". $_HOST . ";dbname=" . $_DB , $_USER, $_PSSWD);       
} catch (PDOException $e) { 
  print "¡Error!: " . $e->getMessage() . "<br/>";
  die();
}


