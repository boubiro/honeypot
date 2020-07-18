<?php
   $servername = "111.92.169.31";
   $username = "snort";
   $password = "snort26";
   $dbname = "snortcoba";

   try 
   {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOException $e)
   {
      echo "Connection failed: " . $e->getMessage();
   }
?>
