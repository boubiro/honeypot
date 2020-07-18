<?php
	try{
		session_start();
		include "../../config/db_connection.php";
		include "../../module/authentication.php";

		$permanent_trapped_time = $_POST['permanent_trapped_time'];
		$trapped_time = $_POST['trapped_time'];
		$honeypot_ip_address = $_POST['honeypot_ip_address'];

		$sql = "UPDATE sr_setting SET " .
			"setting_values = '" . $permanent_trapped_time . "' " .
			"WHERE setting_id = 1;";
		$hasil = $conn->query($sql);

		$sql = "UPDATE sr_setting SET " .
			"setting_values = '" . $trapped_time . "' " .
			"WHERE setting_id = 2;";
		$hasil = $conn->query($sql);

		$sql = "SELECT * FROM sr_setting WHERE setting_id = 3";
      foreach ($conn->query($sql) as $row)
      {
			$old_ip_address = $row["setting_values"];
			if ($old_ip_address != $honeypot_ip_address)
			{
				$sql = "UPDATE sr_setting SET " .
				"setting_values = '~" . $honeypot_ip_address . "' " .
				"WHERE setting_id = 3;";
				$hasil = $conn->query($sql);
			}
      }

	}
	catch(Exception $ex) {
      // Untuk menentukan pesan kesalahan
   }
?>