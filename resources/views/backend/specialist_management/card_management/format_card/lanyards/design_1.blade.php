<div class="lanyard-card active">
    <div class="lanyard-title">
        Design 01
    </div>
    <div class="lanyard-body">
        @for ($i = 0; $i < 2; $i++)
            <div class="lanyard-strip">
                <img src="{{ asset('uploads/images/icon.png') }}" alt="Logo">
                <span>{{ config('app.name') }}</span>
            </div>
        @endfor
    </div>
</div>
