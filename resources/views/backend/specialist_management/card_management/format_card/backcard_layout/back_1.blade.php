 <div class="doctor-card-holder">
     <div class="doctor-card-back">
         <div class="back-top-bg"></div>
         <div class="back-hospital-logo">
             @if ($specialistCard->show_logo)
                 <img src="{{ asset('uploads/images/logo.png') }}" alt="Hospital Logo">
             @endif
         </div>
         <div class="back-content">
             @if ($specialistCard->show_about)
                 <h4>
                     About Hospital
                 </h4>
                 <p>

                     {{ $specialistCard->about_text ??
                         'Providing advanced colorectal care with modern medical facilities and experienced specialists.' }}
                 </p>
             @endif
             <div class="back-divider"></div>
             @if ($specialistCard->show_contact)
                 <h4>
                     Contact Us:
                 </h4>
                 <div class="contact-details">
                     <p>
                         <i class="fas fa-phone"></i>
                         {{ $specialistCard->specialist->phone ?? '+880 1XXXXXXXXX' }}
                     </p>
                     <p>
                         <i class="fas fa-envelope"></i>
                         {{ $specialistCard->specialist->email ?? 'info@hospital.com' }}
                     </p>
                     <p>
                         <i class="fas fa-map-marker-alt"></i>
                         {{ $specialistCard->address ?? 'Hospital Address Here' }}
                     </p>
                 </div>
             @endif
         </div>
         <div class="back-bottom-wave"></div>
     </div>
 </div>
