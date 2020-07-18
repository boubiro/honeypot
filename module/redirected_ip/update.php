<?php
	try{
		session_start();
		include "../../config/db_connection.php";
		include "../../module/authentication.php";

		$sequence_id = $_POST['sequence_id'];
		$permanent_trapped_time = $_POST['permanent_trapped_time'];
		$adm_id = $_SESSION['adm_id'];

		$sql = "UPDATE sr_redirected_ip SET " .
			" permanent = " . $permanent_trapped_time .
			" WHERE sequence_id = " . $sequence_id . ";";
		$hasil = $conn->query($sql);
		
		$sql = "SELECT ip_src FROM sr_redirected_ip WHERE sequence_id=$sequence_id";
      foreach ($conn->query($sql) as $row)
      {
			$ip_address = $row["ip_src"];
      }

		$sql = "INSERT INTO sr_redirected_ip_log VALUES" .
			"(" . $sequence_id . 
			",'UPDATE" .
			"','" .
			"','" .
			"','" . $ip_address .
			"', NOW()" .
			", " . $permanent_trapped_time .
			"," . $adm_id . ");";  
			print $sql;
		$hasil = $conn->query($sql);

	}
	catch(Exception $ex) {
      // Untuk menentukan pesan kesalahan
   }
?>