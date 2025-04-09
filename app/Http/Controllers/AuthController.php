<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Dentro de tu método login (o el que maneje la autenticación manual):
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();
        
        // Guardar el rol en la sesión para fácil acceso
        session(['user_role' => $user->rol]);
        
        if ($user->rol === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($user->rol === 'vendedor') {
            return redirect()->route('sales.create');
        }

        // Por si hay un rol desconocido
        Auth::logout();
        return redirect('/login')->withErrors([
            'rol' => 'Rol no autorizado.',
        ]);
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden.',
    ]);
}

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
