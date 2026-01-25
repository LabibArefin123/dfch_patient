@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav
    class="main-header navbar 
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }} 
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Left side navbar --}}
    <ul class="navbar-nav">
        {{-- Sidebar toggle (hamburger) --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Left menu items from config --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Additional custom left content (optional) --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Right side navbar --}}
    <ul class="navbar-nav ml-auto">
        {{-- Additional custom right content (optional) --}}
        @yield('content_top_nav_right')

        {{-- Right menu items from config --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu / Logout --}}
        @auth
            @if (config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endauth

        {{-- Right sidebar toggler --}}
        @if ($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
