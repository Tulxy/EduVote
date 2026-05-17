<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Models\Vote;

class IdeaController extends Controller
{
    // Zobrazení formuláře pro nový nápad
    public function create()
    {
        $school = auth()->user()->school;

        if (!$school) {
            return redirect()->back()->with('error', 'Nejprve musíte být přiřazeni ke škole.');
        }

        return view('pages.ideas.create', compact('school'));
    }

    // Uložení nápadu do databáze
    // Uložení nápadu do databáze
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'category' => 'required|string|in:Prostředí,Technika,Komunita', // Zvalidujeme vybranou kartu
            'description' => 'required|string|min:10|max:2000',
        ], [
            'title.required' => 'Název nápadu je povinný.',
            'title.max' => 'Název může mít maximálně 100 znaků.',
            'category.required' => 'Výběr kategorie je povinný.',
            'category.in' => 'Zvolená kategorie není platná.',
            'description.required' => 'Popis nápadu je povinný.',
            'description.min' => 'Popis musí mít alespoň 10 znaků.',
        ]);

        Idea::create([
            'user_id' => auth()->id(),
            'school_id' => auth()->user()->school_id,
            'title' => $validated['title'],
            'category' => $validated['category'], // Uložíme zvalidovanou kategorii
            'description' => $validated['description'],
            'status' => 'pending', // Nové nápady padají přímo administrátorovi do schvalovací fronty
        ]);

        return redirect()->route('dashboard')->with('success', 'Tvůj nápad byl úspěšně odeslán ke schválení!');
    }
    public function voting()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        // Vytáhneme pouze SCHVÁLENÉ nápady, u kterých ještě uživatel nehlasoval
        $ideas = Idea::where('school_id', $schoolId)
            ->where('status', 'approved') // PŘIDÁNO: Pouze schválené administrátorem
            ->whereDoesntHave('votes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with('user')
            ->get();

        return view('pages.voting', compact('ideas'));
    }
    public function userIdeas()
    {
        $user = auth()->user();

        // Vytáhneme nápady, pro které přihlášený uživatel už hlasoval
        $votedIdeas = $user->votedIdeas()
            ->where('school_id', $user->school_id)
            ->with('user') // načteme autory nápadů
            ->get();

        return view('pages.ideas.user-ideas', compact('votedIdeas'));
    }
    public function vote(Request $request, Idea $idea)
    {
        // 1. Zvalidujeme data, která přišla z JavaScriptu ('yes' nebo 'no')
        $validated = $request->validate([
            'vote' => 'required|in:yes,no'
        ]);

        // 2. Uložíme hlas do databáze (případně aktualizujeme, pokud by už existoval)
        Vote::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'idea_id' => $idea->id,
            ],
            [
                'choice' => $validated['vote']
            ]
        );

        // 3. Odpovíme JavaScriptu, že je vše v pořádku
        return response()->json(['success' => true]);
    }
    // ... (začátek třídy a ostatní metody store, voting atd.)

    public function dashboard()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        // Načteme nápady, pro které uživatel HLASOVAL, včetně hodnoty z pivot tabulky 'choice'
        $ideas = $user->votedIdeas()
            ->where('school_id', $schoolId)
            ->with('user')
            ->withCount('votes')
            ->get()
            ->map(function($idea) {
                // Vytáhneme hodnotu 'choice' (yes/no) z pivot tabulky votes
                $idea->user_choice = $idea->pivot->choice;
                return $idea;
            });

        $stats = [
            'total'    => Idea::where('school_id', $schoolId)->count(),
            // Pokud už máš v DB sloupec status přes migraci, změň 0 na: Idea::where('school_id', $schoolId)->where('status', 'approved')->count()
            'approved' => Idea::where('school_id', $schoolId)->where('status', 'approved')->count(),
            'votes'    => Vote::whereHas('idea', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            })->count(),
            'mine'     => Idea::where('user_id', $user->id)->count(),
        ];

        return view('dashboard', compact('ideas', 'stats'));
    }
}
