<?php
   session_start();
   include "../../config/db_connection.php";
   include "../../module/authentication.php";
   $sequence_id = $_POST['sequence_id'];	
   
	$sql = "SELECT * FROM sr_redirected_ip WHERE sequence_id = '" . $sequence_id . "'";
	if($hasil = $conn->query($sql)){
        if($hasil->rowCount() > 0){
            while($baris = $hasil->fetch()){
                $ip_src = $baris['ip_src'];
                $permanent = $baris['permanent'];
                if ($permanent == 1)
               {
                  $option_1 = "selected";
                  $option_2 = "";
               }
               else
               {
                  $option_1 = "";
                  $option_2 = "selected";
               }
            }
        }
    }
?>

<form class="form">
   <input id="hidden_update_id" type="hidden" value="<?php print $sequence_id; ?>">
   <div class="form-group row">
      <label for="testLabel" class="col-sm  col-form-label col-form-label-sm">IP Peretas</label>
      <div class="col-sm-6">
         <input class="form-control form-control-sm" id="txt_ip_src" type="text" value="<?php print $ip_src; ?>" disabled>
      </div>
   </div>
   <div class="form-group row">
      <label for="testLabel" class="col-sm  col-form-label col-form-label-sm">Permanent Trapped Time</label>
      <div class="col-sm-6">
         <select id="ddn_update_permanent_trapped_time">
            <option value="1" <?php print $option_1;?>>Yes</option>
            <option value="0" <?php print $option_2;?>>No</option>
         </select>
      </div>
   </div>
</form>