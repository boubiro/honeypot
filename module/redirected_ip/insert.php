<?php
	try{
		session_start();
		include "../../config/db_connection.php";
		include "../../module/authentication.php";

		$ip_address = $_POST['ip_address'];
		$permanent_trapped_time = $_POST['permanent_trapped_time'];
		$adm_id = $_SESSION['adm_id'];

		$sql = "INSERT INTO sr_redirected_ip VALUES" .
			"('" . '' . 
			"','" . $ip_address .
			"', NOW()" .
			", 0" .
			", 0" .
			"," . $permanent_trapped_time . ");";  
		$hasil = $conn->query($sql);

		$sql = "SELECT sequence_id, timestamp FROM sr_redirected_ip WHERE ip_src='$ip_address'";
      foreach ($conn->query($sql) as $row)
      {
			$sequence_id = $row["sequence_id"];
			$timestamp = $row["timestamp"];
      }

		$sql = "INSERT INTO sr_redirected_ip_log VALUES" .
			"('" . $sequence_id . 
			"','SET-INSERT" .
			"','" .
			"','" .
			"','" . $ip_address .
			"','" . $timestamp .
			"', " . $permanent_trapped_time .
			",'" . $adm_id . "');";  
			$hasil = $conn->query($sql);


		if ($hasil->rowCount() < 1){
			throw new Exception("Gagal menambahkan data obat. " . "Kesalahan " . $conn->getMessage());
		}else{
			print("Success");
		}
	}
	catch(Exception $ex) {
      // Untuk menentukan pesan kesalahan
   }
?>