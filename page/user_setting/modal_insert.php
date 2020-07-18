<!-- The Modal -->
<div class="modal fade" id="modal_insert">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Insert Data User</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form class="form">
               <div class="form-group row">
                  <label for="testLabel" class="col-sm  col-form-label col-form-label-sm">Nama</label>
                  <div class="col-sm-9">
                     <input class="form-control form-control-sm" id="txt_insert_nama" type="text" maxlength="25">
                  </div>
               </div>   
               <div class="form-group row">
                  <label for="testLabel" class="col-sm  col-form-label col-form-label-sm">E-mail</label>
                  <div class="col-sm-9">
                     <input class="form-control form-control-sm" id="txt_insert_email" type="email" maxlength="50">
                  </div>
               </div>
               <div class="form-group row">
                  <label for="testLabel" class="col-sm  col-form-label col-form-label-sm">Password</label>
                  <div class="col-sm-9">
                     <input class="form-control form-control-sm" id="txt_insert_password" type="password" maxlength="25">
                  </div>
               </div>
            </form>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
            <button id="submit_insert" type="button" class="btn btn-Success">Submit</button> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>