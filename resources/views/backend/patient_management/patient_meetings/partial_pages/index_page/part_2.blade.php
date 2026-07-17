 <div class="card card-outline card-primary shadow-sm mb-4">
     <div class="card-header">
         <h3 class="card-title">
             <i class="fas fa-filter mr-1"></i>
             Schedule Filters
         </h3>
     </div>

     <div class="card-body">
         <form method="GET" action="{{ route('patient_meetings.index') }}">
             <div class="row">
                 {{-- Search --}}
                 <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                     <label>
                         <i class="fas fa-search mr-1"></i>
                         Search
                     </label>

                     <div class="input-group">
                         <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                             placeholder="Patient, code, specialist, title...">
                         <div class="input-group-append">
                             <button class="btn btn-primary">
                                 <i class="fas fa-search"></i>
                             </button>
                         </div>
                     </div>
                 </div>

                 {{-- Date --}}
                 <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">
                     <label>
                         <i class="fas fa-calendar-day mr-1"></i>
                         Date
                     </label>
                     <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                 </div>


                 {{-- Status --}}
                 <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">
                     <label>
                         <i class="fas fa-tasks mr-1"></i>
                         Status
                     </label>

                     <select name="status" class="form-control">
                         <option value="">All Status</option>
                         <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled
                         </option>
                         <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                         </option>
                         <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                         </option>
                         <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                         </option>
                         <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                     </select>
                 </div>

                 {{-- Meeting Type --}}
                 <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">
                     <label>
                         <i class="fas fa-stethoscope mr-1"></i>
                         Meeting Type
                     </label>

                     <select name="meeting_type" class="form-control">
                         <option value="">
                             All Types
                         </option>
                         <option value="consultation" {{ request('meeting_type') == 'consultation' ? 'selected' : '' }}>
                             Consultation
                         </option>
                         <option value="follow_up" {{ request('meeting_type') == 'follow_up' ? 'selected' : '' }}>
                             Follow Up
                         </option>
                         <option value="report_review"
                             {{ request('meeting_type') == 'report_review' ? 'selected' : '' }}>
                             Report Review
                         </option>

                         <option value="emergency" {{ request('meeting_type') == 'emergency' ? 'selected' : '' }}>
                             Emergency
                         </option>
                         <option value="other" {{ request('meeting_type') == 'other' ? 'selected' : '' }}>
                             Other
                         </option>
                     </select>
                 </div>

                 {{-- Buttons --}}
                 <div class="col-lg-2 d-flex align-items-end mb-3 mb-lg-0">
                     <button type="submit" class="btn btn-primary mr-2">
                         <i class="fas fa-filter mr-1"></i>
                         Filter
                     </button>

                     <a href="{{ route('patient_meetings.index') }}" class="btn btn-outline-secondary">
                         <i class="fas fa-sync-alt"></i>
                     </a>
                 </div>
             </div>
         </form>
     </div>
 </div>
