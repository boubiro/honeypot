<?php
   session_start();
   include "../../config/db_connection.php";
   include "../../module/authentication.php";
   if (!session_check()) {
      header("Location: ../../page/login");
      exit();
   }             
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Bootstrap Example</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="../../assets/fontawesome/css/all.css">
   <link rel="stylesheet" href="../../assets/datatables/datatables.min.css"/>

   <script src="../../assets/jquery/jquery.min.js"></script>
   <script src="../../assets/popper/popper.min.js"></script>
   <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="../../assets/datatables/datatables.min.js"></script>
</head>
<body>

<?php include "../../template/navbar.php"; ?>
<br>

<div class="container-fluid">
<br>
<br>
<center><img src="../../image/logo.png"></center>
<br>
<center><h1>Universitas Budi Luhur</h1></center>
</div>

</body>
</html>

