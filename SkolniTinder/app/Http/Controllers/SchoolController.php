<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function manage()
    {
        // Získáme školu aktuálně přihlášeného uživatele (admina)
        $school = Auth::user()->school;

        // Vytáhneme všechny uživatele, kteří patří do této školy
        $members = User::where('school_id', $school->id)
            ->orderBy('role', 'asc') // Admini nahoře
            ->get();

        return view('pages.school.manage', compact('school', 'members'));
    }
    public function updateStatus(Request $request, User $user)
    {
        // Musíš mít nahoře: use Illuminate\Http\Request;

        if (auth()->user()->role !== 'admin' || auth()->user()->school_id !== $user->school_id) {
            abort(403);
        }

        // Tady se prostě vezme status z formuláře (accepted nebo canceled) a uloží se
        $user->update([
            'accepted' => $request->status
        ]);

        return back()->with('success', 'Status aktualizován');
    }
}
