<?php
	try{
		session_start();
		include "../../config/db_connection.php";
		include "../../module/authentication.php";

		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "INSERT INTO sr_administrator VALUES" .
				"('" . '' . 
				 "','" . $name . 
				 "','" . $email . 
				 "','" . $password .
				 "','1');";  
		$hasil = $conn->query($sql);
		if ($hasil->rowCount() < 1){
			throw new Exception("Gagal menambahkan data PO Supplier. " . "Kesalahan " . $conn->getMessage());
		}else{
			print("Success");
		}
	}
	catch(Exception $ex) {
      // Untuk menentukan pesan kesalahan
   }
?>