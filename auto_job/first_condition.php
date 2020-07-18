<?php
   $script = 'sudo iptables -t nat -F';
   $output = shell_exec($script);
   echo $output;

   include "../config/db_connection.php";

   $sql_select = "SELECT * FROM sr_redirected_ip";

   foreach ($conn->query($sql_select) as $row)
   {
        $sequence_id = $row['sequence_id'];
        $ip_src = $row['ip_src'];
        $timestamp = $row['timestamp'];
        $permanent = $row['permanent'];

        $sql = "INSERT INTO sr_redirected_ip_log (sequence_id, job_log, sid, cid, ip_src, timestamp, permanent, adm_id) VALUES ($sequence_id, 'DELETE', '', '', '$ip_src', NOW(), $permanent, 1)";
        $conn->exec($sql);
      
        $sql = "DELETE FROM sr_redirected_ip WHERE ip_src='$ip_src'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
   }  
?>