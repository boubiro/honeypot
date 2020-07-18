<?php
	try{
		session_start();
		include "../../config/db_connection.php";
		include "../../module/authentication.php";

		$sequence_id = $_POST['sequence_id'];
		$adm_id = $_SESSION['adm_id'];
		
		$sql_select = "SELECT * FROM sr_redirected_ip WHERE sequence_id = $sequence_id";
		foreach ($conn->query($sql_select) as $row)
		{
			$ip_src = $row['ip_src'];
			$permanent = $row['permanent'];
		}

		$sql = "INSERT INTO sr_redirected_ip_log (sequence_id, job_log, sid, cid, ip_src, timestamp, permanent, adm_id) VALUES ($sequence_id, 'SET-DELETE', '', '', '$ip_src', NOW(), $permanent, $adm_id)";
		$hasil = $conn->query($sql);

		$sql = "UPDATE sr_redirected_ip SET " .
			" timestamp = NOW()" .
			", iptables_delete = 1" .
			" WHERE sequence_id = " . $sequence_id . ";";
		$hasil = $conn->query($sql);
		
	}
	catch(Exception $ex) {
      // Untuk menentukan pesan kesalahan
	}
?>