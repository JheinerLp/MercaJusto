<?php

namespace App\Http\Controllers;

use App\Mail\ProductoEliminado;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\SolicitudProveedor;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {

        $solicitudesPendientes = SolicitudProveedor::pendientes()
            ->paginate(10);

        $totalActivos = Proveedor::where('suspendido', false)->count();

        $totalProductos = Producto::count();

        $totalTickets = Ticket::where('estado', '!=', 'finalizado')->count();

        return view('admin.dashboard', compact('solicitudesPendientes', 'totalActivos', 'totalProductos', 'totalTickets'));
    }

    public function productos(Request $request)
    {
        $query = Producto::with(['categoria', 'proveedor.user']);

        if ($request->filled('search')) {
            $query->where('nombre', 'like', "%{$request->search}%");
        }

        $productos = $query
            ->paginate(10)
            ->withQueryString();

        $totalProductos = Producto::count();

        return view('admin.productos', compact('productos', 'totalProductos'));
    }

    // Lista de proveedores
    public function listaProveedores(Request $request)
    {
        $query = Proveedor::with(['categoria', 'user']);

        // 🔍 búsqueda opcional
        if ($request->filled('search')) {
            $query->where('empresa', 'like', "%{$request->search}%")
                ->orWhere('correo_dueño', 'like', "%{$request->search}%");
        }

        $proveedores = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.proveedores.lista', compact('proveedores'));
    }

    // Ver perfil del proveedor
    public function verProveedor($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view('proveedor.perfil', compact('proveedor'));
    }

    // Suspender proveedor
    public function suspenderProveedor($id)
    {

        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->suspendido = true;
            $proveedor->save();

            return back()->with('success', 'Proveedor suspendido correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al suspender proveedor');
        }

    }

    public function reactivarProveedor($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->suspendido = false;
            $proveedor->save();

            return back()->with('success', 'Proveedor reactivado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al reactivar proveedor');
        }
    }

    public function eliminarProveedor($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $proveedor = Proveedor::findOrFail($id);

                $proveedor->productos()->delete();

                if ($proveedor->user) {
                    $proveedor->user->delete();
                }

                $proveedor->delete();
            });

            return back()->with('success', 'Proveedor eliminado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar proveedor');
        }
    }

    public function eliminarProducto(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $proveedor = $producto->proveedor;

            // Obtener el motivo desde el formulario
            $motivo = $request->input('motivo');

            // Eliminar producto
            $producto->delete();

            // Enviar notificación por correo al proveedor
            if ($proveedor) {
                \Mail::to($proveedor->correo)->send(new ProductoEliminado($proveedor, $producto, $motivo));
            }

            return redirect()->back()->with('success', 'Producto eliminado y proveedor notificado.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar producto');
        }
    }

    public function tickets(Request $request)
    {
        $query = Ticket::with(['proveedor', 'user'])
            ->where('estado', '!=', 'finalizado');

        $tickets = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.tickets', compact('tickets'));
    }

    public function historialTickets(Request $request)
    {
        $tickets = Ticket::with(['proveedor', 'user'])
            ->where('estado', 'finalizado')
            ->orderBy('updated_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.tickets_historial', compact('tickets'));
    }

    public function eliminarHistorial()
    {
        try {
            Ticket::where('estado', 'finalizado')->delete();

            return redirect()->route('admin.tickets.historial')
                ->with('success', 'Historial de tickets eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar historial');
        }
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
            4 => 'Carrusel4.jpeg',
        ];

        $rutaImagenes = public_path('Images');

        // Crear el directorio si no existe
        if (! File::exists($rutaImagenes)) {
            File::makeDirectory($rutaImagenes, 0755, true, true);
        }

        // Verificar que el directorio sea escribible
        if (! is_writable($rutaImagenes)) {
            // Intentar cambiar permisos en Windows
            @chmod($rutaImagenes, 0755);

            if (! is_writable($rutaImagenes)) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Error: No se tienen permisos para escribir en el directorio de imágenes. Verifica los permisos de la carpeta public/Images');
            }
        }

        $imagenesActualizadas = 0;

        for ($i = 1; $i <= 4; $i++) {
            $campo = 'imagen'.$i;

            if ($request->hasFile($campo)) {
                $archivo = $request->file($campo);

                // Validar que el archivo es válido
                if (! $archivo->isValid()) {
                    continue;
                }

                $nombreArchivo = $nombresImagenes[$i];
                $rutaCompleta = $rutaImagenes.DIRECTORY_SEPARATOR.$nombreArchivo;

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
                        ->with('error', 'Error al guardar la imagen '.$i.': '.$e->getMessage());
                }
            }
        }

        if ($imagenesActualizadas > 0) {
            return redirect()->route('admin.dashboard')
                ->with('success', $imagenesActualizadas.' imagen(es) del carrusel actualizada(s) correctamente.');
        } else {
            return redirect()->route('admin.dashboard')
                ->with('error', 'No se seleccionaron imágenes para actualizar.');
        }
    }

    public function enviarCodigo(Request $request)
    {
        $user = Auth::user();

        $codigo = rand(100000, 999999); // 6 dígitos

        $user->otp_code = $codigo;
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        Mail::raw("Tu código de verificación es: $codigo", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Código de verificación');
        });

        return response()->json(['success' => true]);
    }

    public function actualizarCredenciales(Request $request)
    {
        $user = Auth::user();

        // 🔐 VALIDACIONES
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|confirmed|unique:users,email,'.$user->id,
            'email_confirmation' => 'required|string|email',
            'otp_code' => 'required|numeric',
        ];

        // Si hay contraseña
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $request->validate($rules, [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo es obligatorio',
            'email.email' => 'Correo inválido',
            'email.unique' => 'Este correo ya está en uso',
            'email.confirmed' => 'Los correos no coinciden',
            'password.min' => 'Mínimo 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'otp_code.required' => 'El código es obligatorio',
        ]);

        try {

            // 🔑 VALIDAR OTP
            if (
                ! $user->otp_code ||
                $request->otp_code != $user->otp_code ||
                now()->gt($user->otp_expires_at)
            ) {
                return back()->with('error', 'Código inválido o expirado');
            }

            // 🧹 LIMPIAR OTP
            $user->otp_code = null;
            $user->otp_expires_at = null;

            // ✏️ ACTUALIZAR DATOS
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Credenciales actualizadas correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }
}
