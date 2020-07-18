<?php
  include "../config/db_connection.php";
  
  $sql_select = "SELECT * FROM sr_redirected_ip WHERE iptables_add = '0'";
  foreach ($conn->query($sql_select) as $row)
  {
    $sequence_id = $row['sequence_id'];
    $ip_src = $row['ip_src'];
    $permanent = $row['permanent'];
    
    $script = 'sudo iptables -t nat -A PREROUTING -s ' . $ip_src . ' -p tcp --dport 80 -j REDIRECT --to-port 8060';
    $script1 = 'sudo iptables -t nat -A PREROUTING -s ' . $ip_src . ' -p udp --dport 80 -j REDIRECT --to-port 8060';
    $output = shell_exec($script);
    $output1 = shell_exec($script1);
    echo $output;
    echo $output1;

    $sql = "INSERT INTO sr_redirected_ip_log (sequence_id, job_log, sid, cid, ip_src, timestamp, permanent, adm_id) VALUES ($sequence_id, 'INSERT', '', '', '$ip_src', NOW(), $permanent, 1)";
    $conn->exec($sql);

    $sql = "UPDATE sr_redirected_ip SET iptables_add = 1 WHERE ip_src='$ip_src'";
	  $stmt = $conn->prepare($sql);
	  $stmt->execute();
  }
?>
