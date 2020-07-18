<?php
   /* Database connection start */
   require("../../config/db_connection.php");
   /* Database connection end */

   // storing  request (ie, get/post) global array to a variable  
   $first_date= $_POST["first_date"];
   $last_date = $_POST["last_date"];

   // getting total number records without any search
   $sql = "SELECT *, name FROM sr_redirected_ip_log, sr_administrator";
   $sql .= " WHERE sr_redirected_ip_log.adm_id = sr_administrator.adm_id";
   $sql .= " AND timestamp >= '" . $first_date . "' ";
   $sql .= " AND timestamp <= '" . $last_date . "' ";
   
   $hasil = $conn->query($sql);
   //$baris = $hasil->fetch_array();
   $totalData = $hasil->rowCount();
   //$totalData = $baris[0];
   $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

   $data = array();
   while( $row = $hasil->fetch()) {  // preparing an array
      $nestedData=array(); 
      $permanent_flag = $row["permanent"];
      if($permanent_flag == 1)
      {
      $permanent_flag = 'PERMANENT';
         }else
         {
      $permanent_flag = 'NON PERMANENT';
         }
         $nestedData[] = $row["sequence_id"];
         $nestedData[] = $row["job_log"];
         $nestedData[] = $row["sid"];
         $nestedData[] = $row["cid"];
         $nestedData[] = $row["ip_src"];	
         $nestedData[] = $row["timestamp"];
         $nestedData[] = $permanent_flag;	
         $nestedData[] = $row["name"];
      
      $data[] = $nestedData;
      
   }

   $json_data = array(
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

   echo json_encode($json_data);  // send data as json format

?>