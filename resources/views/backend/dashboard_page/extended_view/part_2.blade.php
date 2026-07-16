 <div class="row mt-1">
     <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
         <x-adminlte-small-box title="{{ $totalRecommendedPatients }}" text="Total Recommended" theme="danger"
             icon="fas fa-user-md" />
     </div>
     <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
         <x-adminlte-small-box title="{{ $todayRecommendedPatients }}" text="Today's Recommended" theme="warning"
             icon="fas fa-stethoscope" />
     </div>
     <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
         <x-adminlte-small-box title="{{ $monthlyRecommendedPatients }}" text="Monthly Recommended" theme="success"
             icon="fas fa-chart-line" />
     </div>
 </div>
