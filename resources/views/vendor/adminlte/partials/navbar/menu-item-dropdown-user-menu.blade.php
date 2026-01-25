@php
    $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout');
    // Default to your 'profile' route instead of logout
    $profile_url = View::getSection('profile_url') ?? 'user_profile';
@endphp

@if (config('adminlte.usermenu_profile_url', false))
    @php($profile_url = Auth::user()->adminlte_profile_url())
@endif

@if (config('adminlte.use_route_url', false))
    @php($profile_url = $profile_url ? route($profile_url) : '')
    @php($logout_url = $logout_url ? route($logout_url) : '')
@else
    @php($profile_url = $profile_url ? url($profile_url) : '')
    @php($logout_url = $logout_url ? url($logout_url) : '')
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if (config('adminlte.usermenu_image'))
            <img src="{{ Auth::user()->adminlte_image() }}" class="user-image img-circle elevation-2"
                alt="{{ Auth::user()->name }}">
        @endif
        <span @if (config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->name }}
        </span>
    </a>

    {{-- Simple dropdown list --}}
    <ul class="dropdown-menu dropdown-menu-right shadow-sm border-0">

        <li>
            <a href="{{ $profile_url ?? '#' }}" class="dropdown-item d-flex align-items-center gap-2">
                <i class="fa fa-user text-primary"></i>
                <span>Profile</span>
            </a>
        </li>

        <li>
            <a href="{{ route('settings.index') }}" class="dropdown-item d-flex align-items-center gap-2">
                <i class="fa fa-cog text-secondary"></i>
                <span>Settings</span>
            </a>
        </li>

        <li>
            <a href="#" class="dropdown-item d-flex align-items-center gap-2 text-danger"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-power-off"></i>
                <span>Logout</span>
            </a>
        </li>

        <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
            @if (config('adminlte.logout_method'))
                {{ method_field(config('adminlte.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
    </ul>

</li>
