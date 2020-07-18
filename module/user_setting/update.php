<?php
	try{
		session_start();
		include "../../config/db_connection.php";
		include "../../module/authentication.php";

		$id = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$sql = "UPDATE sr_administrator SET " .
			"name = '" . $name . "', " .
			"email = '" . $email . "', " .
			"password = '" . $password . "', " .
			"status_active = '1' " .
			"WHERE adm_id = '" . $id . "';";
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