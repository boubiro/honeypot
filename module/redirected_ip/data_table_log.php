<?php
   /* Database connection start */
   require("../../config/db_connection.php");
   /* Database connection end */

   // storing  request (ie, get/post) global array to a variable  
   $sequence_id= $_POST["id"];

   // getting total number records without any search
	$sql = "SELECT sr_redirected_ip_log.ip_src, job_log, sig_name, sr_redirected_ip_log.timestamp FROM sr_redirected_ip_log";
	$sql .= " LEFT JOIN sr_event ON sr_redirected_ip_log.sid = sr_event.sid AND sr_redirected_ip_log.cid = sr_event.cid";
   $sql .= " WHERE sr_redirected_ip_log.sequence_id =$sequence_id";
   
   $hasil = $conn->query($sql);
   //$baris = $hasil->fetch_array();
   $totalData = $hasil->rowCount();
   //$totalData = $baris[0];
   $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

   $data = array();
   while( $row = $hasil->fetch()) {  // preparing an array
      $nestedData=array(); 
      $nestedData[] = $row["ip_src"];
      $nestedData[] = $row["job_log"];
      $nestedData[] = $row["sig_name"];
      $nestedData[] = $row["timestamp"];
      
      $data[] = $nestedData;
      
   }

   $json_data = array(
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

   echo json_encode($json_data);  // send data as json format

?>