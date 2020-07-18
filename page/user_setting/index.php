<?php
   session_start();
   include "../../config/db_connection.php";
   include "../../module/authentication.php";
   if (!session_check()) {
      header("Location: ../../page/login");
      exit();
   }
   include "modal_insert.php";
   include "modal_update.php";   
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Viva Medika</title>
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
            clear_form();
            
            //Data Table Employee
            var DataTableUser = $('#tabel_user').DataTable({
               "iDisplayLength": 50,
               "processing": true,
               "serverSide": true,
               "ajax":{
                  url :"../../module/user_setting/data_table.php", // json datasource
                  type: "post",  // method  , by default get
                  error: function(){  // error handling
                        $(".lookup-error").html("");
                        $("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#lookup_processing").css("display","none");
                  }
               }
            });

            //Action btn_update_employee
            $(document).on('click','.btn_update_user',function(e){
               var id = $(this).attr("id");
               $.ajax({
                  url: "../../module/user_setting/update_view.php",
                  type: "post",
                  data: {"id": id},
                  success: function(data){
                     $("#modal_update_view").html(data);
                  }
               });
            });

            //Action btn_delete_employee
            $(document).on('click','.btn_delete_user',function(e){
               var nama = $(this).attr("value");
               var id = $(this).attr("id");
               if (confirm("Delete access of " + nama + "?")) {
                  delete_employee(id);
               }
            });

            //Funtion save_employee
            function save_employee(){               
               var name = document.getElementById('txt_insert_nama').value;
               var email = document.getElementById('txt_insert_email').value;
               var password = document.getElementById('txt_insert_password').value;
					$.ajax({
						url: "../../module/user_setting/insert.php",
						type: "post",
						data: {"name": name,
                        "email": email,
								"password": password},
						success: function(data){
							location.reload();
						}
					});
            }
            
            //Funtion update_employee
            function update_employee(){
               var id = document.getElementById('hidden_update_id').value;     
               var name = document.getElementById('txt_update_nama').value;
               var email = document.getElementById('txt_update_email').value;
               var password = document.getElementById('txt_update_password').value;
					$.ajax({
						url: "../../module/user_setting/update.php",
						type: "post",
						data: {"id": id,
								"name": name,
                        "email": email,
								"password": password},
						success: function(data){
							location.reload();
						}
					});
            }

            //Funtion delete_employee
            function delete_employee(id){
               var id = id;     
					$.ajax({
						url: "../../module/user_setting/delete.php",
						type: "post",
						data: {"id": id},
						success: function(data){
							location.reload();
						}
					});
            }

            //Function Clear Form
            function clear_form(){
               document.getElementById('txt_insert_nama').value = "";
               document.getElementById('txt_insert_email').value = "";
               document.getElementById('txt_insert_password').value = "";
            }

            //Click Submit Button
            $(document).on('click','#submit_insert',function(e){
               if (confirm("Save Employee?")) {
                  save_employee();
               }
            });
            //Click Submit Button
            $(document).on('click','#submit_update',function(e){
               if (confirm("Update Employee?")) {
                  update_employee();
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
            <h3>Data User</h3>
            <hr>
            <button type="buton" class="btn btn-success" id="insert_user" data-toggle="modal" data-target="#modal_insert"><i class="fas fa-plus"></i> Tambah</button>
            <br>
            <br>
            <table class="table table-sm table-striped table-bordered DT_master_bahan" id="tabel_user">
               <thead>
                  <tr>
                     <th>Adm ID</th>
                     <th>Name</th>
                     <th>E-mail</th>
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

