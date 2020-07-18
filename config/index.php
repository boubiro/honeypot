<?php
   session_start();
   include "../config/db_connection.php";
   include "../module/authentication.php";
   if (session_check()) {
      header("Location: ../page/main_menu");
      exit();
   } else {
      header("Location: ../page/login");
      exit();
   }
?>
  