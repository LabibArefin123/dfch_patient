<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item dropdown">

    {{-- Menu toggler --}}
    <a class="nav-link dropdown-toggle {{ $item['class'] }}" href="" data-toggle="dropdown" {!! $item['data-compiled'] ?? '' !!}>

        {{-- Icon (optional) --}}
        @isset($item['icon'])
            <i class="{{ $item['icon'] }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
        @endisset

        {{-- Text --}}
        {{ $item['text'] }}

        {{-- Label (optional) --}}
        @isset($item['label'])
            @php
                $display = $item['label'] > 99 ? '99+' : $item['label'];
            @endphp
            <span class="position-absolute bottom-0 right-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="font-size: 0.65rem; min-width: 20px;">
                {{ $display }}
            </span>
        @endisset

    </a>

    {{-- Menu items --}}
    <ul class="dropdown-menu border-0 shadow">
        @each('adminlte::partials.navbar.dropdown-item', $item['submenu'], 'item')
    </ul>

</li>
