<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function manage()
    {
        $school = auth()->user()->school;
        $members = $school->users; // nebo tvůj query

        // Statistiky
        $stats = [
            'total' => $members->count(),
            'admins' => $members->where('role', 'admin')->count(),
            'teachers' => $members->where('role', 'teacher')->count(),
            'students' => $members->where('role', 'student')->count(),
            'waiting' => $members->where('accepted', 'wait')->count(),
        ];

        return view('pages.school.manage', compact('school', 'members', 'stats'));
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
