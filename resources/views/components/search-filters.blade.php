<head>
    <link rel="stylesheet" href="{{ asset('css/components/search-filters.css') }}">
</head>
<form method="GET" action="{{ $action }}" class="search-box">
    <div class="search-wrapper">

        {{-- Input de búsqueda --}}
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="{{ $placeholder ?? 'Buscar...' }}"
            class="search-input"
        >

        {{-- Filtros dinámicos --}}
        @if(!empty($filters))
            @foreach($filters as $name => $options)
                <select name="{{ $name }}" class="search-select">
                    <option value="">— {{ ucfirst($name) }} —</option>
                    @foreach($options as $value => $label)
                        <option value="{{ $value }}"
                            {{ request($name) == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            @endforeach
        @endif

        {{-- Botones --}}
        <button type="submit" class="btn-search">
            <i class="fas fa-search"></i>
        </button>

        @if(request()->hasAny(['q', ...array_keys($filters ?? [])]))
            <a href="{{ $action }}" class="btn-clear">
                <i class="fas fa-times"></i>
            </a>
        @endif

    </div>
</form>