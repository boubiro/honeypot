<?php
/* Database connection start */
session_start();
include "../../config/db_connection.php";
include "../authentication.php";
/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'adm_id',
   1 => 'name', 
	2 => 'email'
);

// getting total number records without any search
$sql = "SELECT * FROM sr_administrator WHERE status_active = 1";
$hasil = $conn->query($sql);
$totalData = $hasil->rowCount();
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT * ";
	$sql.=" FROM sr_administrator";
	$sql.=" WHERE status_active = 1";
	$sql.=" AND (adm_id LIKE '%".$requestData['search']['value']."%' "; // $requestData['search']['value'] contains search parameter
	$sql.=" OR name LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR email LIKE '%".$requestData['search']['value']."%')";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$hasil = $conn->query($sql); // again run query with limit
	$totalFiltered = $hasil->rowCount();// when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 
} else {	
	$sql = "SELECT * ";
	$sql.=" FROM sr_administrator";
	$sql.=" WHERE status_active = 1";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$hasil = $conn->query($sql);
}

$data = array();
while( $row = $hasil->fetch()) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["adm_id"];
   $nestedData[] = $row["name"];
	$nestedData[] = $row["email"];
   $nestedData[] = 	'<td><center>
								<button type="button" class="btn btn-warning py-0 px-2 btn_update_user" id="'.$row['adm_id'].'" data-toggle="modal" data-target="#modal_update"><i class="fas fa-edit"></i></button>
								<button type="button" class="btn btn-danger py-0 px-2 btn_delete_user" id="'.$row['adm_id'].'" value="'.$row['name'].'"><i class="fas fa-trash-alt"></i></button>
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
