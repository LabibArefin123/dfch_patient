 <div class="row">
     <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
         <x-adminlte-small-box title="{{ $totalPatients }}" text="Total Patients" theme="info" icon="fas fa-users" />
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
         <x-adminlte-small-box title="{{ $todayPatients }}" text="Registered Today" theme="light"
             icon="fas fa-calendar-day" />
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
         <x-adminlte-small-box title="{{ $weeklyPatients }}" text="This Week" theme="primary"
             icon="fas fa-calendar-week" />
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
         <x-adminlte-small-box title="{{ $monthlyPatients }}" text="This Month" theme="secondary"
             icon="fas fa-calendar-alt" />
     </div>
 </div>
