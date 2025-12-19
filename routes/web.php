<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\ProveedorAuth;
use App\Http\Controllers\SolicitudProveedorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\QuienessomosController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\BuscadorController;



//Pagina principal 
Route::get('/', function () {
    return view('welcome');
});



// Login común
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

//busqueda 

Route::get('/buscar', [BusquedaController::class, 'index'])
    ->name('buscar.productos');




// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Opciones 
//Formas de pago 
//Quienes somos 
//Soporte 
Route::get('/sabermas', [QuienesSomosController::class, 'quienesSomos'])
->name('quienes.somos');;

Route::view('/comopagar', 'opciones.Formas')->name('formas.pago');

Route::view('/ayuda', 'opciones.Soporte')->name('soporte');

//Tickets de soporte
Route::post('/tickets', [TicketController::class, 'store'])
    ->name('tickets.store');
Route::post('/tickets/responder/{id}', [TicketController::class, 'responder'])->name('tickets.responder');

Route::patch('/tickets/finalizar/{id}', [TicketController::class, 'finalizar'])->name('tickets.finalizar');

//mapa 
Route::get('/mapa', [MapaController::class, 'index'])->name('mapa.index');

// Mostrar producto individual
Route::get('/producto/{id}', [ProductoController::class, 'show'])->name('productos.show');

// Catálogo completo por sede
Route::get('/sede/{sede_id}/productos', [MapaController::class, 'catalogo'])->name('productos.catalogo');



Route::get('/categoria/{slug}', [CategoriaController::class, 'show'])
    ->name('categoria.show');

// Panel admin
//Los productos  que le llegan al admin 
//Ruta para eliminar los porductos que no cumplan las normas 
//Aceptar una solicitud 
// Rechazar una solicitud 
 // Lista de proveedores
 // Perfil de proveedor
 // Suspender proveedor
 // Historial
// Tickets de soporte 
//Solicitudes que envian al admin 
Route::middleware('admin')->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/productos', [AdminController::class, 'productos'])->name('admin.productos');
    Route::post('/admin/productos/eliminar/{id}', [AdminController::class, 'eliminarProducto'])
    ->name('admin.producto.eliminar');
    Route::post('/admin/solicitudes/aceptar/{id}', [SolicitudProveedorController::class, 'aceptar'])
    ->name('admin.solicitudes.aceptar');
    Route::post('/admin/solicitudes/rechazar/{id}', [SolicitudProveedorController::class, 'rechazar'])
    ->name('admin.solicitudes.rechazar');
    Route::get('/admin/proveedores', [AdminController::class, 'listaProveedores'])->name('admin.proveedores');
    Route::get('/admin/proveedor/{id}', [AdminController::class, 'verProveedor'])->name('admin.proveedor.ver');
    Route::post('/admin/proveedor/{id}/suspender', [AdminController::class, 'suspenderProveedor'])->name('admin.proveedor.suspender');
    Route::get('/admin/solicitudes/historial', 
    [SolicitudProveedorController::class, 'historial']
)->name('admin.solicitudes.historial');
    Route::delete('/admin/solicitudes/historial/eliminar', 
    [SolicitudProveedorController::class, 'eliminarHistorial'])->name('admin.solicitudes.historial.eliminar');
    Route::get('/admin/tickets', [AdminController::class, 'tickets'])->name('admin.tickets');
    Route::get('/admin/tickets/historial', [AdminController::class, 'historialTickets'])
    ->name('admin.tickets.historial');
    Route::delete('/admin/tickets/historial', [AdminController::class, 'eliminarHistorial'])
    ->name('admin.tickets.historial.eliminar');
    Route::get('/admin/solicitudes', [SolicitudProveedorController::class, 'index'])
    ->name('admin.solicitudes');

    Route::post('/admin/proveedor/{id}/reactivar', [AdminController::class, 'reactivarProveedor'])
    ->name('admin.proveedor.reactivar');

Route::delete('/admin/proveedor/{id}', [AdminController::class, 'eliminarProveedor'])
    ->name('admin.proveedor.eliminar');


});

//Solicitudes Publicas 

Route::post('/solicitud-proveedor', [SolicitudProveedorController::class, 'store'])
    ->name('solicitud.proveedor.store');


//Rutas de el buscador o filtro 

Route::get('/admin/solicitudes', [BuscadorController::class, 'solicitudes'])
    ->name('admin.solicitudes');

Route::get('/admin/solicitudes/historial', [BuscadorController::class, 'solicitudesHistorial'])
    ->name('admin.solicitudes.historial');

Route::get('/admin/proveedores', [BuscadorController::class, 'proveedores'])
    ->name('admin.proveedores');

Route::get('/admin/productos', [BuscadorController::class, 'productos'])
    ->name('admin.productos');

Route::get('/admin/tickets', [BuscadorController::class, 'tickets'])
    ->name('admin.tickets');

Route::get('/admin/tickets/historial', [BuscadorController::class, 'ticketsHistorial'])
    ->name('admin.tickets.historial');












// Rutas proveedor


Route::middleware(['proveedor'])->prefix('proveedor')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ProveedorController::class, 'dashboard'])
        ->name('proveedor.dashboard');

    // Actualizaciones del perfil del proveedor
    Route::post('/banner', [ProveedorController::class, 'actualizarBanner'])
        ->name('proveedor.banner');

    Route::post('/foto', [ProveedorController::class, 'actualizarFoto'])
        ->name('proveedor.foto');

    Route::post('/descripcion', [ProveedorController::class, 'actualizarDescripcion'])
        ->name('proveedor.descripcion');

    Route::post('/direccion', [ProveedorController::class, 'actualizarDireccion'])
        ->name('proveedor.direccion');

    Route::post('/celular', [ProveedorController::class, 'actualizarCelular'])
        ->name('proveedor.celular');
Route::get('/proveedor/{proveedor}', [ProveedorController::class, 'show'])
    ->whereNumber('proveedor')
    ->name('proveedor.perfil');
    // Productos
    Route::get('/productos', [ProductoController::class, 'index'])
        ->name('proveedor.productos.index');

    Route::get('/productos/crear', [ProductoController::class, 'create'])
        ->name('proveedor.productos.create');

    Route::post('/productos', [ProductoController::class, 'store'])
        ->name('proveedor.productos.store');

    Route::get('/productos/editar/{id}', [ProductoController::class, 'edit'])
        ->name('proveedor.productos.edit');

    Route::put('/productos/actualizar/{id}', [ProductoController::class, 'update'])
    ->name('proveedor.productos.update');

    Route::delete('/productos/eliminar/{id}', [ProductoController::class, 'destroy'])
        ->name('proveedor.productos.destroy');
});
