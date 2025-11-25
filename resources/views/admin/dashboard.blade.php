<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <link rel="stylesheet" href="{{ asset('css/base/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/Menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Estiloweb.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/Gestion.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header class="header">
    @include('components.header')
    </header>
    @include('components.lupa')
    

   <main class="admin-panel">
    <h2 style="text-align: center;">Administración</h2>

    <div class="tabs">
        <a href="{{ route('admin.solicitudes') }}" class="tab-button" style="text-decoration:none;">
            Solicitudes</a>
       <button class="tab-button" onclick="window.location='{{ route('admin.proveedores') }}'">
    Proveedores
</button>

     <button class="tab-button" onclick="window.location='{{ route('admin.productos') }}'">
    Productos
</button>

        <button class="tab-button" onclick="window.location='{{ route('admin.tickets') }}'">
    Soporte
</button>

    </div>

    <section id="dashboard" class="tab-content active">
        <!-- Aquí van estadísticas rápidas -->
       <div class="dashboard">
   <div class="card">
        <h4>Proveedores</h4>
        <p>{{ $totalActivos }}</p>
    </div>
<div class="card">
    <h4>Productos</h4>
    <p> {{ $totalProductos }}</p>
</div>

   <div class="card">
    <h4>Solicitudes Pendientes</h4>
    <p class="numero-solicitudes">
        {{ $solicitudesPendientes->count() }}
    </p>
</div>

  <div class="card">
    <h4>Soporte</h4>
    <p>{{ $totalTickets }}</p>
</div>
</div>
    </section>

    <section>
        
</section>

    <section id="proveedores" class="tab-content">
        <h3>Proveedores Registrados</h3>
        <div class="contenedor-cards" id="contenedorProveedores"></div>
    </section>

    <section id="clientes" class="tab-content">
        <h3>Clientes Registrados</h3>
        <!-- Aquí una tabla o lista de clientes -->
    </section>

    <section id="soporte" class="tab-content">
        <h3>Mensajes de Soporte</h3>
        <!-- Lista de mensajes enviados desde la sección de soporte -->
    </section>
</main>

    

    <script>
        
    function showTab(tabId) {
        const contents = document.querySelectorAll('.tab-content');
        const buttons = document.querySelectorAll('.tab-button');

        contents.forEach(c => c.classList.remove('active'));
        buttons.forEach(b => b.classList.remove('active'));

        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }


    proveedores.forEach(p => {
        const card = document.createElement("div");
        card.className = "card-proveedor";
        card.innerHTML = `
            <h3>${p.nombre}</h3>
            <p><strong>Contacto:</strong> ${p.contacto}</p>
            <p><strong>Email:</strong> ${p.email}</p>
            <p><strong>Teléfono:</strong> ${p.telefono}</p>
            <p><strong>Dirección:</strong> ${p.direccion}</p>
            <p><strong>Categoría:</strong> ${p.categoria}</p>
        `;
        contenedor.appendChild(card);
    });
</script>

    <script src="{{ asset('js/Generalidades.js') }}"></script>
    @include('components.botsoporte')
    <footer class="footer-container">
    @include('components.footer')
    </footer>
</body>
</html>
