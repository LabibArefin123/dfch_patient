 <div class="col-md-3 d-flex justify-content-end">
     <div class="text-center">
         <div class="patient-photo-box mb-2">

             <img src="{{ $patient->patient_photo && file_exists(public_path($patient->patient_photo))
                 ? asset($patient->patient_photo)
                 : asset('uploads/images/default.jpg') }}"
                 alt="Patient Photo" class="patient-photo-img zoomable" data-action="zoom">

         </div>

         <small class="text-muted">Patient Photo</small>

     </div>
     <!-- Image Zoom Modal -->
     <div id="imageZoomModal" class="zoom-modal">
         <span class="zoom-close">&times;</span>
         <img class="zoom-modal-content" id="zoomedImage">
     </div>

 </div>
