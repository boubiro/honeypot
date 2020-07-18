<?php
  include "../config/db_connection.php";

  //Kirim notif flag alert 0 
  $sql_select = "SELECT * FROM sr_redirected_ip WHERE flag_alert = 0";
  foreach ($conn->query($sql_select) as $row)
  {
    $message = "Terjadi serangan dari " . $row['ip_src'] . " pada tanggal " . $row['timestamp'];
    $url = "https://api.telegram.org/bot1134714364:AAGubrGz9t9RP_Y7NUF0taViVT68w9nHhwE/sendMessage?chat_id=978129478&text=" . $message;
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_exec($ch); 
    curl_close($ch);
    
    $sql = "UPDATE sr_redirected_ip SET flag_alert=1 WHERE sequence_id=" . $row['sequence_id'];
    $stmt = $conn->prepare($sql);
    $stmt->execute();
  }
?>