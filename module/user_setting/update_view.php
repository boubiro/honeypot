<?php
   session_start();
   include "../../config/db_connection.php";
   include "../../module/authentication.php";
	$id = $_POST['id'];	
	$sql = "SELECT * FROM sr_administrator WHERE adm_id = '" . $id . "'";

	if($hasil = $conn->query($sql)){
        if($hasil->rowCount() > 0){
            while($baris = $hasil->fetch()){
               $name = $baris['name'];
               $email = $baris['email'];
               $password = $baris['password'];
            }
        }
    }
?>

<form class="form">
   <input id="hidden_update_id" type="hidden" value="<?php print $id; ?>">
   <div class="form-group row">
      <label class="col-sm  col-form-label col-form-label-sm">Nama</label>
      <div class="col-sm-9">
         <input id="txt_update_nama" class="form-control form-control-sm" type="text" value="<?php print $name; ?>" maxlength="25">
      </div>
   </div>   
   <div class="form-group row">
      <label class="col-sm  col-form-label col-form-label-sm">E-mail</label>
      <div class="col-sm-9">
         <input id="txt_update_email" class="form-control form-control-sm" type="email" value="<?php print $email; ?>"  maxlength="50">
      </div>
   </div>
   <div class="form-group row">
      <label class="col-sm  col-form-label col-form-label-sm">Password</label>
      <div class="col-sm-9">
         <input id="txt_update_password" class="form-control form-control-sm" type="password" value="<?php print $password; ?>"  maxlength="25">
      </div>
   </div>
</form>