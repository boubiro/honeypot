<?php
   session_start();
   include "../../config/db_connection.php";
   include "../../module/authentication.php";

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

   if($permanet_trapped_flag == 1)
   {
      $note = "CATATAN: saat ini semua IP yg diarahkan ke honeypot <b>akan permanen berada disana</b>.";
   }
   else
   {
      $note = "CATATAN: IP yg berada pada tabel dibawah akan di remove dalam waktu <b>$trapped_time menit dari timestamp</b>.";
   }

   if (!session_check()) {
      header("Location: ../../page/login");
      exit();
   }
   include "modal_insert.php";
   include "modal_select.php";
   include "modal_update.php";
?>

<!DOCTYPE html>
<html lang="en">
   <head><title>Redirected IP</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="../../assets/fontawesome/css/all.css">
      <link rel="stylesheet" href="../../assets/datatables/datatables.min.css"/>
      <link rel="stylesheet" href="../../assets/gijgo/css/gijgo.min.css"/>
   
      <script src="../../assets/jquery/jquery.min.js"></script>
      <script src="../../assets/popper/popper.min.js"></script>
      <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="../../assets/datatables/datatables.min.js"></script>
      <script src="../../assets/gijgo/js/gijgo.min.js"></script>

      <!-- Embedded CSS -->
      <style>
      span#fullpage {
         min-width: 1366px;
         display: inline-block;
      }
      </style>

      <!-- Embedded Javascript -->
      <script>
         $(document).ready(function() {
            //clear_form();
            
            //Data Table Employee
            var DataTableRedirectedIP = $('#tabel_redirected_ip').DataTable({
               "iDisplayLength": 50,
               "serverSide": true,
               "ajax":{
                  url :"../../module/redirected_ip/data_table.php", // json datasource
                  type: "post",  // method  , by default get
                  error: function(){  // error handling
                        $(".lookup-error").html("");
                        $("#lookup").append('<tbody class="ip-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#lookup_processing").css("display","none");
                  }
               }
            });
            setInterval( function () {
               DataTableRedirectedIP.ajax.reload();
            }, 5000 );

            //Data Table Employee
            DataTableRedirectedIPLog = $('#tabel_redirected_ip_log').DataTable();
            
            //Action btn_select_redirected_ip
            $(document).on('click','.btn_select_redirected_ip',function(e){
               DataTableRedirectedIPLog.destroy(); 
               var id = $(this).attr("sequence_id");
               DataTableRedirectedIPLog = $('#tabel_redirected_ip_log').DataTable({
               "paging":false,
               "ordering":false,
               "info":false,
               "searching":false,
               "ajax":{
                  url :"../../module/redirected_ip/data_table_log.php", // json datasource
                  type: "post",  // method  , by default get
                  data: {"id": id},
                  error: function(){  // error handling
                        $(".lookup-error").html("");
                        $("#lookup").append('<tbody class="ip-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#lookup_processing").css("display","none");
                  }
               }
               });
               setInterval( function () {
                  DataTableRedirectedIP.ajax.reload();
               }, 5000 );
            });

            //Action btn_update_redirected_ip
            $(document).on('click','.btn_update_redirected_ip',function(e){
               var sequence_id = $(this).attr("sequence_id");
               $.ajax({
                  url: "../../module/redirected_ip/update_view.php",
                  type: "post",
                  data: {"sequence_id": sequence_id},
                  success: function(data){
                     $("#modal_update_view").html(data);
                  }
               });
            });

            //Action btn_delete_employee
            $(document).on('click','.btn_delete_redirected_ip',function(e){
               var ip_src = $(this).attr("value");
               var sequence_id = $(this).attr("sequence_id");
               if (confirm("Delete Redirected IP " + ip_src + "?")) {
                  delete_redirected_ip(sequence_id);
               }
            });

            //Funtion save_medicine
            function save_redirected_ip(){               
               var ip_address = document.getElementById('txt_ip_address').value;
               var permanent_trapped_time = document.getElementById('ddn_permanent_trapped_time').value;
					$.ajax({
						url: "../../module/redirected_ip/insert.php",
						type: "post",
						data: {"ip_address": ip_address,
								"permanent_trapped_time": permanent_trapped_time},
						success: function(data){
							location.reload();
						}
					});
            }

            //Funtion update_redirected_ip
            function update_redirected_ip(){
               var sequence_id = document.getElementById('hidden_update_id').value;              
               var permanent_trapped_time = document.getElementById('ddn_update_permanent_trapped_time').value;
					$.ajax({
						url: "../../module/redirected_ip/update.php",
						type: "post",
						data: {"sequence_id": sequence_id,
                        "permanent_trapped_time": permanent_trapped_time},
						success: function(data){
							location.reload();
						}
					});
            }

            //Funtion delete_medicine
            function delete_redirected_ip(sequence_id){    
					$.ajax({
						url: "../../module/redirected_ip/delete.php",
						type: "post",
						data: {"sequence_id": sequence_id},
						success: function(data){
							location.reload();
						}
					});
            }

            //Function Clear Form
            // function clear_form(){
            //    document.getElementById('txt_insert_nama').value = "";
            //    document.getElementById('txt_insert_harga').value = "";
            //    document.getElementById('txt_insert_stok').value = "";
            //    document.getElementById('dtp_insert_tanggal_lahir').value = "";
            //    document.getElementById('txt_insert_no_identitas').value = "";
            //    document.getElementById('txt_insert_no_sip').value = "";
            //    document.getElementById('txt_insert_email').value = "";
            //    document.getElementById('txt_insert_password').value = "";
            // }

            //Click Submit Button
            $(document).on('click','#submit_insert',function(e){
               if (confirm("Save?")) {
                  save_redirected_ip();
               }
            });
            //Click Submit Button
            $(document).on('click','#submit_update',function(e){
               if (confirm("Update Redirected IP?")) {
                  update_redirected_ip();
               }
            });
         }); 
      </script>
   </head>
   <body>
      <span id="fullpage">
         <?php include "../../template/navbar.php"; ?>
         <br>
         <div class="container shadow-lg p-4 bg-white">
            <h3>Redirected IP</h3>
            <hr>
            <p>
               <?php print $note; ?>
               <br>
               Untuk merubah pengaturan, silahkan mengarah ke setting > snort redirector setting.
            </p>
            <button type="buton" class="btn btn-success" id="btn_insert_redirected_ip" data-toggle="modal" data-target="#modal_insert"><i class="fas fa-plus"></i> Tambah</button>
            <br>
            <br>
            <table class="table table-sm table-striped table-bordered DT_master_bahan" id="tabel_redirected_ip">
               <thead>
                  <tr>
                     <th>Sequence ID</th>
                     <th>IP Peretas</th>
                     <th>Timestamp</th>
                     <th>Removed on</th>
                     <th>Option</th>
                  </tr>
               </thead>
               <tfoot>
               </tfoot>
            </table>
         </div>
      </span>
   </body>
</html>

