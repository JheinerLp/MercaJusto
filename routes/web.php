<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\ProveedorAuth;
use App\Http\Controllers\SolicitudProveedorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;


//Pagina principal 
Route::get('/', function () {
    return view('welcome');
});



// Login común
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');






// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Opciones 
//Formas de pago 
//Quienes somos 
//Soporte 
Route::view('/sabermas', 'opciones.QuienesSomos')->name('quienes.somos');

Route::view('/mapa', 'opciones.Mapa')->name('mapa');

Route::view('/comopagar', 'opciones.Formas')->name('formas.pago');

Route::view('/ayuda', 'opciones.Soporte')->name('soporte');









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
    Route::get('/admin/solicitudes/historial', [SolicitudProveedorController::class, 'historial'])->name('solicitudes.historial');
    Route::get('/admin/tickets', [AdminController::class, 'tickets'])->name('admin.tickets');
    Route::get('/admin/solicitudes', [SolicitudProveedorController::class, 'index'])
    ->name('admin.solicitudes');

});

//Solicitudes Publicas 

Route::post('/solicitud-proveedor', [SolicitudProveedorController::class, 'store'])
    ->name('solicitud.proveedor.store');















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
