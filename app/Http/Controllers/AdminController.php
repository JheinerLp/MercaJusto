<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\SolicitudProveedor;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class AdminController extends Controller
{
    public function dashboard()
{
    
    $solicitudesPendientes = SolicitudProveedor::pendientes()->get();

    
    $totalActivos = Proveedor::where('suspendido', false)->count();

   
    $totalProductos = Producto::count();

  
    $totalTickets = Ticket::where('estado', '!=', 'finalizado')->count();

    
    return view('admin.dashboard', compact('solicitudesPendientes', 'totalActivos', 'totalProductos', 'totalTickets'));
}

public function productos()
{
    // Obtener todos los productos con su categoría y proveedor
    $productos = Producto::with(['categoria', 'proveedor.user'])->get();

    // Contar la cantidad de productos
    $totalProductos = $productos->count();

    return view('admin.productos', compact('productos', 'totalProductos'));
}


    // Lista de proveedores
    public function listaProveedores() {
        $proveedores = Proveedor::all();
        return view('admin.proveedores.lista', compact('proveedores'));
    }

    // Ver perfil del proveedor
    public function verProveedor($id) {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedor.perfil', compact('proveedor'));
    }

    // Suspender proveedor
    public function suspenderProveedor($id) {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->suspendido = true; // Asumiendo que tienes un campo 'suspendido' en la tabla
        $proveedor->save();

        return redirect()->route('admin.proveedores')->with('success', 'Proveedor suspendido correctamente.');
    }

    public function reactivarProveedor($id)
{
    $proveedor = Proveedor::findOrFail($id);
    $proveedor->suspendido = false;
    $proveedor->save();

    return redirect()->route('admin.proveedores')
        ->with('success', 'Proveedor reactivado correctamente.');
}

public function eliminarProveedor($id)
{
    $proveedor = Proveedor::findOrFail($id);

    // Opcional: eliminar productos asociados
    $proveedor->productos()->delete();

    // Opcional: eliminar usuario asociado
    if ($proveedor->user) {
        $proveedor->user->delete();
    }

    $proveedor->delete();

    return redirect()->route('admin.proveedores')
        ->with('success', 'Proveedor eliminado correctamente.');
}


    public function eliminarProducto(Request $request, $id)
{
    $producto = Producto::findOrFail($id);
    $proveedor = $producto->proveedor;

    // Obtener el motivo desde el formulario
    $motivo = $request->input('motivo');

    // Eliminar producto
    $producto->delete();

    // Enviar notificación por correo al proveedor
    if($proveedor) {
        \Mail::to($proveedor->correo)->send(new \App\Mail\ProductoEliminado($proveedor, $producto, $motivo));
    }

    return redirect()->back()->with('success', 'Producto eliminado y proveedor notificado.');
}


public function tickets()
{
    // Obtener todos los tickets con relación a usuario y proveedor
    $tickets = Ticket::with(['proveedor', 'user'])->where('estado', '!=', 'finalizado')->get();

    return view('admin.tickets', compact('tickets'));
}

public function historialTickets()
{
    $tickets = Ticket::with(['proveedor', 'user'])
        ->where('estado', 'finalizado')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('admin.tickets_historial', compact('tickets'));
}

public function eliminarHistorial()
{
    Ticket::where('estado', 'finalizado')->delete();

    return redirect()->route('admin.tickets.historial')
        ->with('success', 'Historial de tickets eliminado correctamente.');
}

public function actualizarCarrusel(Request $request)
{
    $request->validate([
        'imagen1' => 'nullable|image|max:5120',
        'imagen2' => 'nullable|image|max:5120',
        'imagen3' => 'nullable|image|max:5120',
        'imagen4' => 'nullable|image|max:5120',
    ]);

    $nombresImagenes = [
        1 => 'Carrusel.jpg',
        2 => 'Carrusel2.jpeg',
        3 => 'Carrusel3.jpeg',
        4 => 'Carrusel4.jpeg'
    ];

    $rutaImagenes = public_path('Images');

    // Crear el directorio si no existe
    if (!File::exists($rutaImagenes)) {
        File::makeDirectory($rutaImagenes, 0755, true, true);
    }

    // Verificar que el directorio sea escribible
    if (!is_writable($rutaImagenes)) {
        // Intentar cambiar permisos en Windows
        @chmod($rutaImagenes, 0755);
        
        if (!is_writable($rutaImagenes)) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Error: No se tienen permisos para escribir en el directorio de imágenes. Verifica los permisos de la carpeta public/Images');
        }
    }

    $imagenesActualizadas = 0;

    for ($i = 1; $i <= 4; $i++) {
        $campo = 'imagen' . $i;
        
        if ($request->hasFile($campo)) {
            $archivo = $request->file($campo);
            
            // Validar que el archivo es válido
            if (!$archivo->isValid()) {
                continue;
            }
            
            $nombreArchivo = $nombresImagenes[$i];
            $rutaCompleta = $rutaImagenes . DIRECTORY_SEPARATOR . $nombreArchivo;

            // Eliminar imagen anterior si existe
            if (File::exists($rutaCompleta)) {
                try {
                    File::delete($rutaCompleta);
                } catch (\Exception $e) {
                    // Continuar aunque falle el borrado
                }
            }

            // Guardar nueva imagen usando File::put para mejor compatibilidad
            try {
                // Obtener el contenido de la imagen
                $contenido = File::get($archivo->getPathname());
                
                // Guardar el archivo
                File::put($rutaCompleta, $contenido);
                
                // Asegurar permisos correctos
                @chmod($rutaCompleta, 0644);
                
                $imagenesActualizadas++;
            } catch (\Exception $e) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Error al guardar la imagen ' . $i . ': ' . $e->getMessage());
            }
        }
    }

    if ($imagenesActualizadas > 0) {
    return redirect()->route('admin.dashboard')
        ->with('success', $imagenesActualizadas . ' imagen(es) del carrusel actualizada(s) correctamente.');
    } else {
        return redirect()->route('admin.dashboard')
            ->with('error', 'No se seleccionaron imágenes para actualizar.');
    }
}

public function actualizarCredenciales(Request $request)
{
    $user = Auth::user();

    // Validaciones
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|confirmed',
        'email_confirmation' => 'required|string|email',
    ];

    // Validar email único (excepto el del usuario actual)
    $rules['email'] = 'required|string|email|max:255|confirmed|unique:users,email,' . $user->id;

    // Si se proporciona contraseña, validarla
    if ($request->filled('password')) {
        $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
    }

    $request->validate($rules, [
        'name.required' => 'El nombre es obligatorio',
        'email.required' => 'El correo electrónico es obligatorio',
        'email.email' => 'El correo electrónico no es válido',
        'email.unique' => 'Este correo electrónico ya está en uso',
        'email.confirmed' => 'Los correos electrónicos no coinciden',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        'password.confirmed' => 'Las contraseñas no coinciden',
    ]);

    try {
        // Actualizar nombre
        $user->name = $request->name;

        // Actualizar email
        $user->email = $request->email;

        // Actualizar contraseña solo si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Credenciales actualizadas correctamente.');

    } catch (\Exception $e) {
        return redirect()->route('admin.dashboard')
            ->with('error', 'Error al actualizar las credenciales: ' . $e->getMessage());
    }
}


}
