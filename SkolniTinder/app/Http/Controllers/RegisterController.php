<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 1. Zobrazení registračního formuláře
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 2. Zpracování registrace
    public function register(Request $request)
    {
        // Validace vstupů
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'], // 'confirmed' vyžaduje pole password_confirmation
        ]);

        // Vytvoření uživatele
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // VŽDY heslo hashujeme!
        ]);

        // Automatické přihlášení po registraci
        Auth::login($user);

        // Přesměrování na dashboard
        return redirect()->route('dashboard');
    }
}
