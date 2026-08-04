{{-- ========================= LANYARD DESIGN 01 ========================= --}}
<div class="lanyard-card active mt-4">
    <div class="lanyard-title">
        Design 01
    </div>


    <div class="lanyard-body">


        {{-- White Section --}}
        <div class="lanyard-strip lanyard-white">

            <img src="{{ asset('uploads/images/icon.png') }}">

            <span>
                {{ config('app.name') }}
            </span>

        </div>

        {{-- Red Section --}}
        <div class="lanyard-strip lanyard-red mt-4">

            <img src="{{ asset('uploads/images/icon.png') }}">

            <span>
                {{ config('app.name') }}
            </span>

        </div>

        {{-- Black Section --}}
        <div class="lanyard-strip lanyard-black mt-4">

            <img src="{{ asset('uploads/images/icon.png') }}">

            <span>
                {{ config('app.name') }}
            </span>

        </div>


    </div>

</div>
