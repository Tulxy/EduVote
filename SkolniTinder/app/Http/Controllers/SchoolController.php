<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Idea;
use App\Models\School;

class SchoolController extends Controller
{
    public function manage()
    {
        $schoolId = auth()->user()->school_id;

        if (!$schoolId) {
            abort(403, 'Nejste přiřazen k žádné škole.');
        }

        $school = School::findOrFail($schoolId);

        $pendingIdeas = Idea::where('school_id', $school->id)
            ->where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        $members = User::where('school_id', $school->id)->get();

        $stats = [
            'total'    => $members->count(),
            'admins'   => $members->where('role', 'admin')->count(),
            'teachers' => $members->where('role', 'teacher')->count(),
            'students' => $members->where('role', 'student')->count(),
            'waiting'  => $members->where('accepted', 'wait')->count(),
        ];

        return view('pages.school.manage', compact('school', 'members', 'stats', 'pendingIdeas'));
    }

    // NOVÁ METODA: Schvalování/Zamítání uživatelů (členů školy)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,canceled'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'accepted' => $request->status
        ]);

        return back()->with('success', 'Stav uživatele byl úspěšně změněn.');
    }

    // Metoda pro změnu stavu nápadu adminem
    public function updateIdeaStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $idea = Idea::findOrFail($id);
        $idea->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Stav nápadu byl úspěšně změněn.');
    }

    // Úprava kódu školy přes ID (bezpečnější pro tvou současnou routu)
    public function updateCode(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'student_code' => 'required|string|min:4|max:10|unique:schools,student_code,' . $school->id,
        ]);

        $school->update([
            'student_code' => strtoupper($request->student_code)
        ]);

        return back()->with('success', 'Kód školy byl změněn!');
    }
}
