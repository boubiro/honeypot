<!-- The Modal -->
<div class="modal fade" id="modal_event_log">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Log Event</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>

         <!-- Modal body -->
         <div class="modal-body">
            <table id="tbl_event_log" class="table table-sm table-striped table-bordered" width="100%">
               <thead>
                  <tr>            
                     <th>Sequence Id</th>
                     <th>Signature Name</th>
                     <th>Timestamp</th>
                     <th>Ip Peretas</th>
                     <th>Port Peretas</th>
                     <th>IP yg Diretas</th>
                     <th>Port yg Diretas</th>                  
                  </tr>
               </thead>
               <tfoot>
               </tfoot>
            </table>
         </div>

         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>