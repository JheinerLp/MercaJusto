<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if(!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Credenciales incorrectas');
    }

    // Iniciar sesión correctamente con Laravel
    auth()->login($user);

    // Redireccionar según rol
    if($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if($user->role === 'provider') {
        return redirect()->route('proveedor.dashboard');
    }

    return redirect('/login');
}
    public function logout()
    {
       auth()->logout(); // cierra sesión correctamente
    return redirect('/');
    }
}

