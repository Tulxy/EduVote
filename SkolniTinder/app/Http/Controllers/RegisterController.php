<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function registerUser(Request $request) {
        $request->validate([
            'student_code' => ['required', 'string'],
            'role' => ['required', 'in:student,teacher'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // 1. Najdeme školu podle kódu
        $school = School::where('student_code', $request->student_code)->first();

        // 2. Pokud škola neexistuje, vrátíme chybu
        if (!$school) {
            return back()->withErrors(['student_code' => 'Tento kód školy neexistuje.'])->withInput();
        }

        // 3. Vytvoříme uživatele a přiřadíme mu ID školy
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'school_id' => $school->id, // Tady se to propojí!
            'role' => $request->role,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }
    public function showRegistrationForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            // Škola
            'school_name' => ['required', 'string', 'max:255'],
            'school_address' => ['required', 'string', 'max:255'],
            'student_code' => ['required', 'string', 'unique:schools'],
            // Správce
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = DB::transaction(function () use ($request) {
            // 1. Vytvoření školy
            $school = School::create([
                'name' => $request->school_name,
                'address' => $request->school_address,
                'student_code' => $request->student_code,
            ]);

            // 2. Vytvoření uživatele (správce) přiřazeného k této škole
            return User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'school_id' => $school->id,
                'role' => 'admin',
            ]);
        });

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
