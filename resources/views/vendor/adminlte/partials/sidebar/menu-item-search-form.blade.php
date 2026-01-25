<li>
    <form class="form-inline my-2" action="{{ $item['href'] }}" method="{{ $item['method'] }}" data-search="true">
        {{ csrf_field() }}
        <div class="input-group">
            <input class="form-control form-control-sidebar" type="search"
                @isset($item['id']) id="{{ $item['id'] }}" @endisset
                name="{{ $item['input_name'] ?? 'term' }}" placeholder="{{ $item['text'] }}"
                aria-label="{{ $item['text'] }}">

            <div class="input-group-append">
                <button class="btn btn-sidebar" type="submit">
                    <i class="fas fa-fw fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</li>
