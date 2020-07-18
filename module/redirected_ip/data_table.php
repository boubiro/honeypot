<?php
/* Database connection start */
session_start();
include "../../config/db_connection.php";
include "../authentication.php";
/* Database connection end */

$sql = "SELECT setting_values FROM sr_setting WHERE setting_id = 1";
foreach ($conn->query($sql) as $row)
{
	$permanet_trapped_flag = $row['setting_values'];
}

$sql = "SELECT setting_values FROM sr_setting WHERE setting_id = 2";
foreach ($conn->query($sql) as $row)
{
	$trapped_time = $row['setting_values'];
}

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'sequence_id',
	1 => 'ip_src',
	2 => 'timestamp',
	3 => 'removed_on'
);

// getting total number records without any search
$sql = "SELECT sequence_id, ip_src, timestamp, IF(permanent=1,'PERMANENT', timestamp + INTERVAL ($trapped_time) MINUTE) as removed_on FROM sr_redirected_ip";
$hasil = $conn->query($sql);
$totalData = $hasil->rowCount();
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT sequence_id, ip_src, timestamp, IF(permanent=1,'PERMANENT', timestamp + INTERVAL ($trapped_time) MINUTE) as removed_on ";
	$sql.=" FROM sr_redirected_ip";
	$sql.=" HAVING sequence_id LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR ip_src LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR timestamp LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR removed_on LIKE '%".$requestData['search']['value']."%' "; // $requestData['search']['value'] contains search parameter
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$hasil = $conn->query($sql); // again run query with limit
	$totalFiltered = $hasil->rowCount();// when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 
} else {	
	$sql = "SELECT sequence_id, ip_src, timestamp, IF(permanent=1,'PERMANENT', timestamp + INTERVAL ($trapped_time) MINUTE) as removed_on ";
	$sql.=" FROM sr_redirected_ip";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$hasil = $conn->query($sql);
}

$data = array();
while( $row = $hasil->fetch()) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["sequence_id"];
	$nestedData[] = $row["ip_src"];
	$nestedData[] = $row["timestamp"];
	if($permanet_trapped_flag == 1)
	{
		$nestedData[] = 'PERMANENT';
	}
	else
	{
		$nestedData[] = $row["removed_on"];
	}
	$nestedData[] = 	'<td><center>
								<button type="button" class="btn btn-primary py-0 px-2 btn_select_redirected_ip" sequence_id="'.$row['sequence_id'].'" data-toggle="modal" data-target="#modal_select"><i class="fas fa-search"></i></button>
								<button type="button" class="btn btn-warning py-0 px-2 btn_update_redirected_ip" sequence_id="'.$row['sequence_id'].'" data-toggle="modal" data-target="#modal_update"><i class="fas fa-edit"></i></button>
								<button type="button" class="btn btn-danger py-0 px-2 btn_delete_redirected_ip" sequence_id="'.$row['sequence_id'].'" value="'.$row['ip_src'].'"><i class="fas fa-trash-alt"></i></button>
				   		</center></td>';		
	
	$data[] = $nestedData;
    
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
