<x-layout>
    <x-slot:title>
        Správa školy
    </x-slot:title>

    {{-- Zachování tvého vizuálního stylu (Noise + Glow) --}}
    <div class="fixed inset-0 pointer-events-none z-0 opacity-[0.04]"
         style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.75%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22300%22 height=%22300%22 filter=%22url(%23n)%22/%3E%3C/svg%3E')">
    </div>
    <div class="fixed top-0 right-0 w-[600px] h-[400px] rounded-full bg-[#C9F050]/[0.04] blur-[160px] pointer-events-none z-0"></div>

    <main class="relative z-10 max-w-[1300px] mx-auto px-6 lg:px-12 py-10">

        {{-- Hlavička stránky --}}
        <div class="mb-10 fade-up">
            <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-2">Administrace</p>
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC]">
                Správa školy <span class="text-[#C9F050]">{{ $school->name }}</span>
            </h1>
        </div>

        {{-- Statistiky školy --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 fade-up-2">

            {{-- 1. KARTA: Složení týmu --}}
            <div class="bg-[#1C1D2A]/60 backdrop-blur-md border border-[#2E3046] p-6 rounded-2xl relative overflow-hidden">
                <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-4 font-bold">Struktura školy</p>
                <div class="flex items-end justify-between mb-4">
                    <h3 class="text-4xl font-display font-black text-[#F2F1EC]">{{ $stats['total'] }}</h3>
                    <span class="text-xs text-[#5C5F7A] mb-1">Celkem členů</span>
                </div>
                <div class="space-y-2 border-t border-[#2E3046] pt-4">
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5C5F7A]">Administrátoři:</span>
                        <span class="text-[#7eb6ff] font-bold">{{ $stats['admins'] }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5C5F7A]">Pedagogové:</span>
                        <span class="text-[#C9F050] font-bold">{{ $stats['teachers'] }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-[#5C5F7A]">Pedagogové:</span>
                        <span class="text-[#F2F1EC] font-bold">{{ $stats['students'] }}</span>
                    </div>
                </div>
            </div>

            {{-- 2. KARTA: Čekající fronta --}}
            <div class="bg-[#1C1D2A]/60 backdrop-blur-md border border-[#2E3046] p-6 rounded-2xl flex flex-col justify-between group">
                <div>
                    <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-1 font-bold">Nové žádosti</p>
                    <h3 class="text-5xl font-display font-black {{ $stats['waiting'] > 0 ? 'text-yellow-500' : 'text-[#F2F1EC]' }}">
                        {{ $stats['waiting'] }}
                    </h3>
                </div>
                <div class="mt-4 p-3 rounded-xl {{ $stats['waiting'] > 0 ? 'bg-yellow-500/10 border border-yellow-500/20' : 'bg-[#2E3046]/20 border border-[#2E3046]' }}">
                    <p class="text-[10px] {{ $stats['waiting'] > 0 ? 'text-yellow-500' : 'text-[#5C5F7A]' }} leading-relaxed">
                        @if($stats['waiting'] > 0)
                            <i class="fa-solid fa-circle-exclamation mr-1 animate-pulse"></i> Máte nevyřízené žádosti o vstup do školy.
                        @else
                            Všechny žádosti byly vyřízeny.
                        @endif
                    </p>
                </div>
            </div>

            {{-- 3. KARTA: Kód školy s kopírováním (VRÁCEN PŮVODNÍ SCRIPT) --}}
            <div class="bg-[#C9F050] p-6 rounded-2xl flex flex-col justify-between shadow-[0_20px_50px_rgba(201,240,80,0.15)] relative overflow-hidden h-full min-h-[200px]">
                <div class="absolute -right-4 -bottom-4 text-black/5 text-8xl rotate-12 uppercase font-black pointer-events-none">Code</div>

                {{-- 1. VIEW MODE (Zobrazení kódu) --}}
                <div id="codeViewMode" class="relative z-10 flex flex-col justify-between h-full">
                    <div>
                        <div class="flex justify-between items-start mb-1">
                            <p class="text-[10px] text-black/60 uppercase tracking-[0.2em] font-bold">Unikátní kód školy</p>
                            <div class="flex gap-3">
                                <button onclick="showEditForm()" class="text-black/40 hover:text-black transition-colors">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="toggleCode()" id="lockBtn" class="text-black/40 hover:text-black transition-colors">
                                    <i id="lockIcon" class="fa-solid fa-lock text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <h3 id="schoolCode" class="text-4xl mx-auto font-display font-black text-black tracking-widest transition-all duration-300 blur-sm select-none">
                        {{ $school->student_code }}
                    </h3>
                    <button onclick="copySchoolCode()" class="mt-6 w-full py-3 bg-black text-[#C9F050] rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-black/80 active:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
                        <i class="fa-regular fa-copy group-hover:rotate-12 transition-transform"></i>
                        <span id="copyText">Kopírovat kód</span>
                    </button>
                </div>

                {{-- 2. EDIT MODE (Formulář) --}}
                <div id="codeEditMode" class="relative z-10 hidden h-full flex flex-col justify-between">
                    <form action="{{ route('school.update-code', $school->id) }}" method="POST" class="h-full flex flex-col justify-between">
                        @csrf
                        @method('PATCH')
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <p class="text-[10px] text-black/60 uppercase tracking-[0.2em] font-bold">Nový kód školy</p>
                                <button type="button" onclick="hideEditForm()" class="text-black/40 hover:text-black transition-colors">
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <input type="text" name="student_code" id="studentCode" value="{{ $school->student_code }}" autocomplete="off"
                               class="w-full text-center bg-black border-b-2 border-[#C9F050]/20 rounded-xl focus:border-black outline-none text-2xl font-display font-black text-[#C9F050] tracking-widest uppercase py-1 px-2 transition-all">

                        <button type="submit" class="mt-4 w-full py-3 bg-black text-[#C9F050] rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-black/80 transition-all">
                            Uložit nový kód
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- TABULKA ČLENŮ --}}
        <div class="bg-[#1C1D2A]/60 backdrop-blur-md border border-[#2E3046] rounded-2xl overflow-hidden shadow-2xl fade-up-2 mb-12">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-[#2E3046]/30 text-[#5C5F7A] text-xs uppercase tracking-widest">
                    <th class="px-6 py-5 font-semibold">Uživatel</th>
                    <th class="px-6 py-5 font-semibold">Role</th>
                    <th class="px-6 py-5 font-semibold text-center">Status</th>
                    <th class="px-6 py-5 font-semibold text-right">Akce</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-[#2E3046]">
                @foreach($members as $member)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-[#F2F1EC] text-base">{{ $member->name }}</div>
                            <div class="text-xs text-[#5C5F7A]">{{ $member->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.7rem] font-medium
                                {{ $member->role === 'admin' ? 'bg-[#C9F050]/10 text-[#C9F050]' : 'bg-[#7eb6ff]/10 text-[#7eb6ff]' }}">
                                {{ strtoupper($member->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($member->accepted === 'accepted')
                                <span class="text-[#C9F050] text-sm font-bold">Schválen</span>
                            @elseif($member->accepted === 'wait')
                                <span class="text-yellow-500 text-sm">Čeká</span>
                            @else
                                <span class="text-[#FF6B52] text-sm">Zamítnut</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($member->id !== auth()->id())
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('user.update-status', $member->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="accepted">
                                        <button class="px-3 py-1.5 rounded-lg border border-[#2E3046] text-xs font-bold text-[#F2F1EC] hover:border-[#C9F050]/40 hover:text-[#C9F050] transition-all">Schválit</button>
                                    </form>
                                    <form action="{{ route('user.update-status', $member->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="canceled">
                                        <button class="px-3 py-1.5 rounded-lg border border-[#2E3046] text-xs font-bold text-[#F2F1EC] hover:border-[#FF6B52]/40 hover:text-[#FF6B52] transition-all">Zamítnout</button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- SCHVALOVÁNÍ NÁPADŮ (IDEAS) --}}
        <div class="fade-up-3">
            <h2 class="font-display font-bold text-lg text-[#F2F1EC] mb-4">Nápady čekající na schválení do Tinderu</h2>
            <div class="bg-[#1C1D2A]/60 backdrop-blur-md border border-[#2E3046] rounded-2xl overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-[#2E3046]/30 text-[#5C5F7A] text-xs uppercase tracking-widest">
                        <th class="px-6 py-5 font-semibold">Nápad / Navrhovatel</th>
                        <th class="px-6 py-5 font-semibold">Kategorie</th>
                        <th class="px-6 py-5 font-semibold">Popis návrhu</th>
                        <th class="px-6 py-5 font-semibold text-right">Rozhodnutí</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2E3046]">
                    @forelse($pendingIdeas ?? [] as $idea)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-[#F2F1EC] text-base">{{ $idea->title }}</div>
                                <div class="text-xs text-[#5C5F7A]">od {{ $idea->user->name ?? 'Anonymní student' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.7rem] font-medium
                                    {{ $idea->category === 'Technika' ? 'bg-[#7eb6ff]/10 text-[#7eb6ff]' : '' }}
                                    {{ $idea->category === 'Prostředí' ? 'bg-[#C9F050]/10 text-[#C9F050]' : '' }}
                                    {{ $idea->category === 'Komunita' ? 'bg-[#FF6B52]/10 text-[#FF6B52]' : '' }}
                                ">
                                    {{ $idea->category ?? 'Bez kategorie' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-[#E8E7F0] truncate" title="{{ $idea->description }}">{{ $idea->description }}</p>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('ideas.update-status', $idea->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="px-3 py-1.5 rounded-lg font-bold text-xs bg-[#C9F050] text-black hover:bg-[#d8ff60] transition-all">
                                            Pustit do hlasování
                                        </button>
                                    </form>
                                    <form action="{{ route('ideas.update-status', $idea->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="px-3 py-1.5 rounded-lg border border-[#2E3046] text-xs font-bold text-[#FF6B52] hover:bg-[#FF6B52]/10 transition-all">
                                            Zamítnout
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-[#5C5F7A]">
                                <i class="fa-solid fa-check-double text-[#C9F050] text-xl mb-2 block"></i>
                                Žádné nové nápady nečekají ve frontě. Vše je schváleno!
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- TVŮJ PŮVODNÍ SCRIPT PRO KÓD ŠKOLY --}}
    <script>
        function showEditForm() {
            document.getElementById('codeViewMode').classList.add('hidden');
            document.getElementById('codeEditMode').classList.remove('hidden');
            document.getElementById('studentCode').value = '{{ $school->student_code }}';
        }

        function hideEditForm() {
            document.getElementById('codeEditMode').classList.add('hidden');
            document.getElementById('codeViewMode').classList.remove('hidden');
        }

        function toggleCode() {
            const code = document.getElementById('schoolCode');
            const icon = document.getElementById('lockIcon');
            const isLocked = code.classList.contains('blur-sm');

            if (isLocked) {
                code.classList.remove('blur-sm', 'select-none');
                icon.classList.replace('fa-lock', 'fa-lock-open');
                icon.parentElement.classList.add('text-black');
            } else {
                code.classList.add('blur-sm', 'select-none');
                icon.classList.replace('fa-lock-open', 'fa-lock');
                icon.parentElement.classList.remove('text-black');
            }
        }

        function copySchoolCode() {
            const codeElement = document.getElementById('schoolCode');
            const btnText = document.getElementById('copyText');
            const wasLocked = codeElement.classList.contains('blur-sm');

            if (wasLocked) {
                toggleCode();
            }

            const codeValue = codeElement.innerText.trim();

            navigator.clipboard.writeText(codeValue).then(() => {
                const originalText = btnText.innerText;
                btnText.innerText = 'Zkopírováno!';

                setTimeout(() => {
                    btnText.innerText = originalText;
                    if (!codeElement.classList.contains('blur-sm')) {
                        toggleCode();
                    }
                }, 2000);
            }).catch(err => {
                console.error('Chyba při kopírování: ', err);
            });
        }
    </script>
</x-layout>
