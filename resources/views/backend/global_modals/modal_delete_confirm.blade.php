 <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content text-center p-4">

             <!-- Animated Warning Icon -->
             <div class="mb-3">
                 <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce" width="50" height="50"
                     fill="#DC3545" viewBox="0 0 16 16">
                     <path
                         d="M8.982 1.566a1 1 0 0 0-1.964 0L.165 13.233A1 1 0 0 0 1 14.5h14a1 1 0 0 0 .835-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z" />
                 </svg>
             </div>

             <!-- Message -->
             <div class="modal-body mb-3">
                 Are you sure you want to <strong>delete</strong> this record? <br>
                 This action cannot be undone.
             </div>

             <!-- Footer Buttons -->
             <div class="modal-footer d-flex justify-content-center gap-2">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                 <form id="deleteForm" method="POST" action="#">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger">Delete</button>
                 </form>
             </div>
         </div>
     </div>
 </div>
