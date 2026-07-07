 <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content border-0 shadow">
             <div class="modal-header bg-danger text-white">
                 <h5 class="modal-title">
                     <i class="fas fa-x-ray mr-2"></i>
                     X-Ray Preview
                 </h5>

                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                 </button>
             </div>

             <div class="modal-body text-center bg-light">

                 <img id="modalPreviewImage" src="" class="img-fluid rounded shadow"
                     style="max-height:75vh;object-fit:contain;">

             </div>

             <div class="modal-footer">
                 <a id="downloadImage" href="" target="_blank" class="btn btn-danger">
                     <i class="fas fa-download"></i>
                     Open Original
                 </a>

                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                     <i class="fas fa-times"></i>
                     Close
                 </button>
             </div>
         </div>
     </div>
 </div>
