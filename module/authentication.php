<?php
   function password_valid($username, $password) {
      global $conn;
      $sql = "SELECT * FROM sr_administrator WHERE email='$username' AND status_active = '1'";
      foreach ($conn->query($sql) as $row)
      {
         global $username_valid, $password_valid;
         $adm_id = $row["adm_id"];
         $username_valid = $row['email'];
         $password_valid = $row['password'];
         $name = $row["name"];
      }
      $conn = null;
   
      if (!isset($username_valid) or !isset($password_valid))
         return FALSE;
      else if(($username != $username_valid) or ($password != $password_valid))
         return FALSE;
      else     
      {
         $_SESSION["adm_id"] = $adm_id;
         $_SESSION["name"] = $name;
         return TRUE;
      }
   }
   function session_check() {      
      if ((!isset($_SESSION["username"])) or (!isset($_SESSION["password"])))
         return FALSE;
      else {    
         if (password_valid($_SESSION["username"], $_SESSION["password"])) 
            return TRUE;
         else   
            return FALSE;
      }     
   }
?>