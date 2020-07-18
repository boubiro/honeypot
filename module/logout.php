<?php
   session_start();
   require_once("authentication.php");
   include "../config/db_connection.php";

   session_unset();
   session_destroy();
   header("Location: ../page/login");
   exit();
?>