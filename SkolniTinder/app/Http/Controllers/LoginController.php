<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm() {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Zkusíme najít uživatele podle e-mailu NEBO jména
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Pokus o přihlášení
        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Pokud se nepovede, vrátíme chybu k poli 'login'
        return back()->withErrors([
            'login' => 'Zadané údaje neodpovídají našim záznamům.',
        ])->onlyInput('login');
    }

    // Odhlášení
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
