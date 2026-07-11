 <div class="row">
     <div class="col-md-3 mb-2">
         <div class="form-control bg-light">
             Personal:
             <span class="header-link text-primary font-weight-bold" data-phone="{{ $patient->phone_1 }}">
                 {{ $patient->phone_1 }}
             </span>
         </div>
     </div>

     <div class="col-md-3 mb-2">
         <div class="form-control bg-light">
             Alt:
             <span class="header-link text-primary font-weight-bold" data-phone="{{ $patient->phone_2 }}">
                 {{ $patient->phone_2 ?? 'N/A' }}
             </span>
         </div>
     </div>

     <div class="col-md-3 mb-2">
         <div class="form-control bg-light">
             Father:
             <span class="header-link text-primary font-weight-bold" data-phone="{{ $patient->phone_f_1 }}">
                 {{ $patient->phone_f_1 ?? 'N/A' }}
             </span>
         </div>
     </div>

     <div class="col-md-3 mb-2">
         <div class="form-control bg-light">
             Mother:
             <span class="header-link text-primary font-weight-bold" data-phone="{{ $patient->phone_m_1 }}">
                 {{ $patient->phone_m_1 ?? 'N/A' }}
             </span>
         </div>
     </div>
 </div>
