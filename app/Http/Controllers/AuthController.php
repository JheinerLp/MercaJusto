<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // 🔥 seguridad + rendimiento

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'provider') {
            return redirect()->route('proveedor.dashboard');
        }
    }

    return back()->with('error', 'Credenciales incorrectas');
}
    public function logout()
    {
       auth()->logout(); // cierra sesión correctamente
    return redirect('/');
    }
}

