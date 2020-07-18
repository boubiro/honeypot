<?php
   /* Database connection start */
   require("../../config/db_connection.php");
   /* Database connection end */

   // storing  request (ie, get/post) global array to a variable  
   $first_date= $_POST["first_date"];
   $last_date = $_POST["last_date"];

   // getting total number records without any search
   $sql = "SELECT sequence_id, sig_name, sr_event.timestamp, sr_event.ip_src, layer4_sport, ip_dst, layer4_dport FROM sr_event";
   $sql .= " LEFT JOIN sr_redirected_ip_log ON sr_redirected_ip_log.sid = sr_event.sid  AND sr_redirected_ip_log.cid = sr_event.cid";
   $sql .= " WHERE sr_event.timestamp >= '" . $first_date . "' ";
   $sql .= " AND sr_event.timestamp <= '" . $last_date . "' ";
   $hasil = $conn->query($sql);
   //$baris = $hasil->fetch_array();
   $totalData = $hasil->rowCount();
   //$totalData = $baris[0];
   $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

   $data = array();
   while( $row = $hasil->fetch()) {  // preparing an array
      $nestedData=array(); 
      $nestedData[] = $row["sequence_id"];
      $nestedData[] = $row["sig_name"];
      $nestedData[] = $row["timestamp"];
      $nestedData[] = $row["ip_src"];
      $nestedData[] = $row["layer4_sport"];	
      $nestedData[] = $row["ip_dst"];
      $nestedData[] = $row["layer4_dport"];	
      
      $data[] = $nestedData;
      
   }

   $json_data = array(
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

   echo json_encode($json_data);  // send data as json format

?>