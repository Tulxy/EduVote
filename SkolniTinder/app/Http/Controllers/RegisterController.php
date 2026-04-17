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
