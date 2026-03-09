@if($productos->count())
    <div class="grid-productos resultados-busqueda">
        @foreach($productos as $p)
            <x-card-producto :p="$p" :mostrarPerfil="true" />
        @endforeach
    </div>
@else
    <p class="sin-resultados">❌ No se encontraron resultados</p>
@endif



