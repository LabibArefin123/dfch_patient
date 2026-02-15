 <!-- Progress Modal -->
 <div class="modal fade" id="fileProcessModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content text-center p-4">

             <h5 id="processTitle" class="mb-4">Processing...</h5>

             <div class="position-relative d-inline-block">
                 <svg width="150" height="150">
                     <circle cx="75" cy="75" r="65" stroke="#e6e6e6" stroke-width="10" fill="none" />
                     <circle id="progressCircle" cx="75" cy="75" r="65" stroke="#28a745" stroke-width="10"
                         fill="none" stroke-dasharray="408" stroke-dashoffset="408" stroke-linecap="round"
                         transform="rotate(-90 75 75)" />
                 </svg>

                 <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                     style="top:0; left:0;">
                     <span id="progressPercent" style="font-size: 22px; font-weight: bold;">0%</span>
                 </div>
             </div>

             <p id="processText" class="mt-3 text-muted">Please wait...</p>

         </div>
     </div>
 </div>
