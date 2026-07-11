 <div class="modal fade" id="photoModal">
     <div class="modal-dialog modal-md">
         <div class="modal-content p-4">

             <h5 class="mb-3 text-center">Upload Patient Photo</h5>

             <!-- Select File -->
             <input type="file" id="photoInput" class="form-control mb-3">

             <!-- Preview -->
             <div class="text-center mb-3">
                 <img id="previewImage" class="rounded shadow" style="max-width:180px; display:none;">
             </div>

             <!-- Progress -->
             <div class="text-center mb-3">
                 <div class="progress-circle" id="progressCircle">0%</div>
             </div>

             <!-- Info -->
             <div id="fileInfo" class="small text-muted text-center mb-3"></div>

             <!-- Buttons -->
             <div class="d-flex justify-content-between">
                 <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                 <button type="button" id="confirmUpload" class="btn btn-success btn-sm" disabled>
                     ✔ Use This Photo
                 </button>
             </div>

         </div>
     </div>
 </div>
