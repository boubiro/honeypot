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
      <title>Snort Redirector Setting</title>
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
            
            //Funtion update_redirector_setting
            function update_redirector_setting(){
               var permanent_trapped_time = document.getElementById('ddn_permanent_trapped_time').value;     
               var trapped_time = document.getElementById('txt_trapped_time').value;
               var honeypot_ip_address = document.getElementById('txt_honeypot_ip_address').value;
					$.ajax({
						url: "../../module/snort_redirector_setting/update.php",
						type: "post",
						data: {"permanent_trapped_time": permanent_trapped_time,
                        "trapped_time": trapped_time,
								"honeypot_ip_address": honeypot_ip_address},
						success: function(data){
							location.reload();
						}
					});
            }

            //Click Submit Update
            $(document).on('click','#btn_save',function(e){
               if (confirm("Yakin ingin menyimpan?")) {
                  update_redirector_setting();
               }
            });

            //Change
            $(document).on('change','#ddn_permanent_trapped_time',function(e){
               if ($( "#ddn_permanent_trapped_time option:selected" ).val() == 1) 
               {
                  $("#txt_trapped_time").prop( "disabled", true );
               }
               else
               {
                  $("#txt_trapped_time").prop( "disabled", false );
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
            <h3>Snort Redirector Setting</h3>
            <hr>
            <br>
            <?php
               include "../../config/db_connection.php";
               $sql = "SELECT * FROM sr_setting WHERE setting_id = 1";
               foreach ($conn->query($sql) as $row)
               {
                  $setting_1 = $row["setting_values"];
                  if ($setting_1 == 1)
                  {
                     $disabled_time = "disabled";
                     $option_1 = "selected";
                     $option_2 = "";
                  }
                  else
                  {
                     $disabled_time = "";
                     $option_1 = "";
                     $option_2 = "selected";
                  }
               }

               $sql = "SELECT * FROM sr_setting where setting_id = 2";
               foreach ($conn->query($sql) as $row)
               {
                  $setting_2 = $row["setting_values"];
               }

               $sql = "SELECT * FROM sr_setting where setting_id = 3";
               foreach ($conn->query($sql) as $row)
               {
                  $setting_3 = $row["setting_values"];
               }
            ?>

            <form class="form">
               <div class="form-group row">
                  <label class="col-sm  col-form-label col-form-label-sm">Permanent Trapped Time</label>
                  <div class="col-sm-9">
                  <select id="ddn_permanent_trapped_time">
                     <option value="1" <?php print $option_1;?>>Yes</option>
                     <option value="0" <?php print $option_2;?>>No</option>
                  </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3  col-form-label col-form-label-sm">Trapped time (minute)</label>
                  <div class="col-sm-3">
                     <input id="txt_trapped_time" class="form-control form-control-sm" type="text" maxlength="5" value="<?php print $setting_2 ?>" <?php print $disabled_time ?>>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3  col-form-label col-form-label-sm"></label>
                  <div class="col-sm-3">
                  <button type="button" class="btn btn-success" id="btn_save"><i class="fas fa-save"></i></i> Simpan</button> 
                  </div>
               </div>
            </form>
         </div>
      </span>
   </body>
</html>

