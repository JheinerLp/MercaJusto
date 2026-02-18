@if($productos->count())
    <div class="grid-productos">
        @foreach($productos as $p)
            <x-card-producto :p="$p" :mostrarPerfil="true" />
        @endforeach
    </div>
@else
    <p style="margin-top:20px">❌ No se encontraron resultados</p>
@endif
