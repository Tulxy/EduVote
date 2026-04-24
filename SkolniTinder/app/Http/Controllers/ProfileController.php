<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $path = public_path('images/avatars');

        // Najde všechny soubory s příponou .jpg, .png nebo .jpeg
        // glob() vrátí celé cesty, tak použijeme array_map a basename, abychom dostali jen názvy souborů
        $avatars = array_map('basename', glob("$path/*.{jpg,jpeg,png,webp}", GLOB_BRACE));
        return view('pages.profile.edit', compact('avatars'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string', // Změněno na nullable
            'email'=>'required|string|email|max:255',
            'password'=>'nullable|string|min:6|confirmed',
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'avatar' => $request->avatar ?: null, // Pokud je prázdno, uložíme NULL
            'email'=>$request->email,
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Profil aktualizován!');
    }
}
