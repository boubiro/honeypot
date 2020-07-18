<?php
  include "../config/db_connection.php";

  //Delete semua yg berstatus SET-DELETE
  $sql_select = "SELECT * FROM sr_redirected_ip WHERE iptables_delete = 1";
  foreach ($conn->query($sql_select) as $row)
  {
    $sequence_id = $row['sequence_id'];
    $ip_src = $row['ip_src'];
    $permanent = $row['permanent'];

    $script = 'sudo iptables -t nat -A PREROUTING -s ' . $ip_src . ' -p tcp --dport 80 -j REDIRECT --to-port 8060';
    $script1 = 'sudo iptables -t nat -A PREROUTING -s ' . $ip_src . ' -p udp --dport 80 -j REDIRECT --to-port 8060';
    $output1 = shell_exec($script1);
    $output = shell_exec($script);
    echo $output;
    echo $output1;

    $sql = "INSERT INTO sr_redirected_ip_log (sequence_id, job_log, sid, cid, ip_src, timestamp, permanent, adm_id) VALUES ($sequence_id, 'DELETE', '', '', '$ip_src', NOW(), $permanent, 1)";
    $conn->exec($sql);
    
    $sql = "DELETE FROM sr_redirected_ip WHERE ip_src='$ip_src'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
  }

  //Delete yg melewati batas trapped time
  $sql_select = "SELECT setting_values FROM sr_setting WHERE setting_id = 1";
  foreach ($conn->query($sql_select) as $row)
  {
    $permanent_trapped = $row['setting_values'];
    if ($permanent_trapped == 0)
    {
      $sql_select = "SELECT setting_values FROM sr_setting WHERE setting_id = 2";
      foreach ($conn->query($sql_select) as $row)
      {
        $trapped_time = $row['setting_values'];
        $sql_select = "SELECT * FROM sr_redirected_ip WHERE permanent = 0 AND timestamp < (NOW() - INTERVAL $trapped_time MINUTE)";
        foreach ($conn->query($sql_select) as $row)
        {
          $sequence_id = $row['sequence_id'];
          $ip_src = $row['ip_src'];
          $timestamp = $row['timestamp'];
          $permanent = $row['permanent'];

          $script = 'sudo iptables -t nat -A PREROUTING -s ' . $ip_src . ' -p tcp --dport 80 -j REDIRECT --to-port 8060';
          $script1 = 'sudo iptables -t nat -A PREROUTING -s ' . $ip_src . ' -p udp --dport 80 -j REDIRECT --to-port 8060';
          $output = shell_exec($script);
          $output1 = shell_exec($script1);
          echo $output;
          echo $output1;

          $sql = "INSERT INTO sr_redirected_ip_log (sequence_id, job_log, sid, cid, ip_src, timestamp, permanent, adm_id) VALUES ($sequence_id, 'DELETE', '', '', '$ip_src', NOW(), $permanent, 1)";
          $conn->exec($sql);
          
          $sql = "DELETE FROM sr_redirected_ip WHERE ip_src='$ip_src'";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
        }
      }
    }
  }
?>
