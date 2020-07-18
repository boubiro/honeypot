<!-- The Modal -->
<div class="modal fade" id="modal_insert">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Insert Redirected IP</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
         <form class="form">
            <div class="form-group row">
               <label for="testLabel" class="col-sm  col-form-label col-form-label-sm">Ip Peretas</label>
               <div class="col-sm-7">
                  <input class="form-control form-control-sm" id="txt_ip_address" type="text" maxlength="15">
               </div>
            </div>
            <div class="form-group row">
                  <label class="col-sm  col-form-label col-form-label-sm">Permanent Trapped Time</label>
                  <div class="col-sm-7">
                  <select id="ddn_permanent_trapped_time">
                     <option value="1">Yes</option>
                     <option value="0">No</option>
                  </select>
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