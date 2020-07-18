<?php
   session_start();
   include "../../config/db_connection.php";
   include "../../module/authentication.php";
   if (!session_check()) {
      header("Location: ../../page/login");
      exit();
   }
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Log Redirected IP</title>
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
            clear_all();

            function clear_all(){
               DataTableRedirectedIPLog = $('#tbl_redirected_ip_log').DataTable();
            }

            //Date Time Picker Tanggal Lahir
            $('#dtp_tanggal_awal').datepicker({
               uiLibrary: 'bootstrap4',
               format: 'yyyy-mm-dd'
            });

            //Date Time Picker Tanggal Lahir
            $('#dtp_tanggal_akhir').datepicker({
               uiLibrary: 'bootstrap4',
               format: 'yyyy-mm-dd'
            });

            $('#btn_proses').click( function () {
               DataTableRedirectedIPLog.destroy(); 
               first_date = document.getElementById('dtp_tanggal_awal').value;
               last_date = document.getElementById('dtp_tanggal_akhir').value;
               //Data Table Laporan Pendapatan
               DataTableRedirectedIPLog = $('#tbl_redirected_ip_log').DataTable({
                  "paging":   false,
                  "ordering": false,
                  "info":     false,
                  "searching":     false,
                  dom: 'Bfrtip',
                  buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                  ],
                  "ajax":{
                     url :"../../module/redirected_ip_log/data_table.php", // json datasource
                     type: "post",  // method  , by default get
                     data: {"first_date": first_date,
								   "last_date": last_date},
                     error: function(){  // error handling
                           $(".lookup-error").html("");
                           $("#lookup").append('<tbody class="treatment-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                           $("#lookup_processing").css("display","none");
                     }
                  }
               });
            });

         }); 
      </script>
   </head>
   <body>
      <span id="fullpage">
         <?php 
            include "../../template/navbar.php"; 
            include "modal_redirected_ip_log.php";
         ?>
         <br>
         <div class="container shadow-lg p-4 bg-white">
            <h3>Log Redirected IP</h3>
            <hr>
            <div class="form-group row">
               <label for="testLabel" class="col-sm-2  col-form-label col-form-label-sm">Tanggal Awal</label>
               <div class="col-sm-3">
                  <input class="form-control form-control-sm" id="dtp_tanggal_awal" type="text" value="2000-01-01" readonly>
               </div>
            </div>
            <div class="form-group row">
               <label for="testLabel" class="col-sm-2  col-form-label col-form-label-sm">Tanggal Akhir</label>
               <div class="col-sm-3">
                  <input class="form-control form-control-sm" id="dtp_tanggal_akhir" type="text" value="<?php print date("Y-m-d", time() + 86400); ?>" readonly>
               </div>
            </div>
            <div class="form-group row">
               <label for="testLabel" class="col-sm-2  col-form-label col-form-label-sm"></label>
               <div class="col-sm-3">
                  <button type="button" class="btn btn-sm btn-success" id="btn_proses"  data-toggle="modal" data-target="#modal_redirected_ip_log">Proses</button>
               </div>
            </div>
         </div>
      </span>
   </body>
</html>

