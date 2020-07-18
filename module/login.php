<?php
   session_start();
   include "../config/db_connection.php";
   include "authentication.php";

   if (isset($_POST["username"]))
      $username = $_POST["username"];
   else
      $username = "";
      
   if (isset($_POST["password"]))
      $password = $_POST["password"];
   else
      $password = "";

   if (empty($username) or empty($password) or !password_valid($username, $password)) {
      header("Location: ../page/login");
      exit();
   }else{
      $_SESSION["username"] = $username;
      $_SESSION["password"] = $password;
      header("Location: ../page/main_menu");
      exit();
   }
?>