<?php
	try{
		session_start();
		include "../../config/db_connection.php";
		include "../../module/authentication.php";

		$id = $_POST['id'];

		$sql = "UPDATE sr_administrator SET " .
			"status_active = '0' " .
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