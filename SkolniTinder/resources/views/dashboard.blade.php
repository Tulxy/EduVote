<x-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    {{-- Noise overlay --}}
    <div class="fixed inset-0 pointer-events-none z-0 opacity-[0.04]"
         style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.75%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22300%22 height=%22300%22 filter=%22url(%23n)%22/%3E%3C/svg%3E')">
    </div>

    {{-- Glow blob --}}
    <div class="fixed top-0 right-0 w-[600px] h-[400px] rounded-full bg-[#C9F050]/[0.04] blur-[160px] pointer-events-none z-0"></div>


    {{-- ─── MAIN ─── --}}
    <main class="relative z-10 max-w-[1300px] mx-auto px-6 lg:px-12 py-10">

        {{-- Page header --}}
        <div class="mb-10 fade-up">
            <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-2">Přehled</p>
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC]">
                Vítej zpět, <span class="text-[#C9F050]">{{ auth()->user()->name ?? 'Uživatel' }}</span> 👋
            </h1>
        </div>

        {{-- ─── STAT CARDS ─── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10 fade-up-2">

            <div class="card border rounded-2xl border-gray-700 mx-4 p-5">
                <p class="text-xs text-[#5C5F7A] mb-2">Celkem návrhů</p>
                <p class="font-display font-bold text-2xl text-[#F2F1EC]">{{ $stats['total'] ?? 0 }}</p>
                <p class="text-xs text-[#5C5F7A] mt-1">ve škole celkem</p>
            </div>

            <div class="card border rounded-2xl border-gray-700 mx-4 p-5">
                <p class="text-xs text-[#5C5F7A] mb-2">Schválené</p>
                <p class="font-display font-bold text-2xl text-[#C9F050]">{{ $stats['approved'] ?? 0 }}</p>
                <p class="text-xs text-[#5C5F7A] mt-1">realizováno</p>
            </div>

            <div class="card border rounded-2xl border-gray-700 mx-4 p-5">
                <p class="text-xs text-[#5C5F7A] mb-2">Hlasů celkem</p>
                <p class="font-display font-bold text-2xl text-[#F2F1EC]">{{ $stats['votes'] ?? 0 }}</p>
                <p class="text-xs text-[#5C5F7A] mt-1">od komunity</p>
            </div>

            <div class="card border rounded-2xl border-gray-700 mx-4 p-5">
                <p class="text-xs text-[#5C5F7A] mb-2">Tvoje návrhy</p>
                <p class="font-display font-bold text-2xl text-[#F2F1EC]">{{ $stats['mine'] ?? 0 }}</p>
                <p class="text-xs text-[#5C5F7A] mt-1">podáno tebou</p>
            </div>
        </div>

        {{-- ─── GRID: nápady + sidebar ─── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT: nápady --}}
            <div class="lg:col-span-2 flex flex-col gap-6 fade-up-3">

                {{-- Hlavička sekce --}}
                <div class="flex items-center justify-between">
                    <h2 class="font-display font-bold text-lg text-[#F2F1EC]">Historie hlasování</h2>
                    <a href="{{ route('pages.ideas.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] glow-lime transition-all no-underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Přidat nápad
                    </a>
                </div>

                {{-- Filter tabs --}}
                <div class="flex gap-2 flex-wrap">
                    @foreach([['all','Všechny'],['pending','Čeká'],['approved','Schválené'],['rejected','Zamítnuté']] as [$val,$label])
                        <button
                            onclick="filterIdeas('{{ $val }}')"
                            id="tab-{{ $val }}"
                            class="tab-btn px-4 py-1.5 rounded-full text-xs font-medium border transition-all
                                {{ $val === 'all' ? 'bg-[#C9F050]/15 border-[#C9F050]/40 text-[#C9F050]' : 'bg-transparent border-[#2E3046] text-[#5C5F7A] hover:text-[#F2F1EC]' }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Idea cards --}}
                {{-- Idea cards --}}
                <div id="ideas-list" class="flex flex-col gap-4">

                    @forelse($ideas ?? [] as $idea)
                        <div class="card p-5 idea-item" data-status="{{ $idea->status ?? 'pending' }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    {{-- Tag + status + TVOJE VOLBA --}}
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.7rem] font-medium
                            {{ ($idea->category ?? '') === 'Technika' ? 'bg-[#7eb6ff]/10 text-[#7eb6ff]' : '' }}
                            {{ ($idea->category ?? '') === 'Prostředí' ? 'bg-[#C9F050]/10 text-[#C9F050]' : '' }}
                            {{ ($idea->category ?? '') === 'Komunita' ? 'bg-[#FF6B52]/10 text-[#FF6B52]' : '' }}
                            {{ !in_array($idea->category ?? '', ['Technika','Prostředí','Komunita']) ? 'bg-white/5 text-[#5C5F7A]' : '' }}
                        ">
                            {{ $idea->category ?? 'Bez kategorie' }}
                        </span>

                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.7rem] font-medium
                            {{ ($idea->status ?? 'pending') === 'approved' ? 'bg-[#C9F050]/15 text-[#C9F050]' : '' }}
                            {{ ($idea->status ?? 'pending') === 'pending'  ? 'bg-white/5 text-[#5C5F7A]' : '' }}
                            {{ ($idea->status ?? 'pending') === 'rejected' ? 'bg-[#FF6B52]/10 text-[#FF6B52]' : '' }}
                        ">
                            {{ ($idea->status ?? 'pending') === 'approved' ? 'Schváleno' : (($idea->status ?? 'pending') === 'pending' ? 'Čeká na schválení' : 'Zamítnuto') }}
                        </span>

                                        {{-- Štítek vyjadřující, jak uživatel hlasoval --}}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.7rem] font-bold
                            {{ ($idea->user_choice ?? '') === 'yes' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }}">
                            Tvoje volba: {{ ($idea->user_choice ?? '') === 'yes' ? 'ANO 👍' : 'NE 👎' }}
                        </span>
                                    </div>

                                    <h3 class="font-display font-bold text-base text-[#F2F1EC] mb-1 leading-snug">{{ $idea->title }}</h3>
                                    <p class="text-sm text-[#5C5F7A] leading-relaxed line-clamp-2">{{ $idea->description }}</p>
                                    <p class="text-xs text-[#5C5F7A] mt-2">od {{ $idea->user->name ?? 'Anonym' }} · {{ $idea->created_at ? $idea->created_at->diffForHumans() : 'Neznámo kdy' }}</p>
                                </div>

                                {{-- Ovládání změny hlasu (Interaktivní tlačítka) --}}
                                <div class="flex flex-col sm:flex-row gap-2 items-center">
                                    {{-- Tlačítko pro ZMĚNU NA ANO --}}
                                    <button
                                        onclick="changeVote({{ $idea->id }}, 'yes')"
                                        class="p-2.5 rounded-xl border transition-all text-xs flex items-center justify-center gap-1
                            {{ ($idea->user_choice ?? '') === 'yes' ? 'bg-[#C9F050] text-black border-[#C9F050]' : 'border-[#2E3046] text-[#5C5F7A] hover:border-emerald-500/50 hover:text-emerald-400' }}"
                                        title="Změnit na ANO"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    </button>

                                    {{-- Tlačítko pro ZMĚNU NA NE --}}
                                    <button
                                        onclick="changeVote({{ $idea->id }}, 'no')"
                                        class="p-2.5 rounded-xl border transition-all text-xs flex items-center justify-center gap-1
                            {{ ($idea->user_choice ?? '') === 'no' ? 'bg-rose-500 text-white border-rose-500' : 'border-[#2E3046] text-[#5C5F7A] hover:border-rose-500/50 hover:text-rose-400' }}"
                                        title="Změnit na NE"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>

                                    <span class="text-[11px] text-[#5C5F7A] font-medium mt-1 sm:mt-0 px-1">{{ $idea->votes_count ?? 0 }}x celkem</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Tady zůstává tvůj stávající @empty blok --}}
                    @endforelse

                </div>

                <script>
                    // Nová asynchronní funkce, která odešle změnu hlasu (yes/no) do tvého Tinder backendu a pak refreshne stránku pro načtení nových štítků
                    async function changeVote(id, choice) {
                        try {
                            // Použijeme tvou stávající tinder routu pro uložení hlasu (uprav url podle potřeby, např. /ideas/vote nebo podobně)
                            await fetch(`/ideas/${id}/vote`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ choice: choice })
                            });
                            window.location.reload(); // Bleskový reload pro překreslení správných barev a textu
                        } catch(e) { console.warn('Hlasování selhalo', e); }
                    }
                </script>
                {{-- Skrytý prázdný stav pro JavaScriptové přepínání filtrů --}}
                <div id="empty-state" class="hidden text-center py-16 bg-[#1C1D2A]/20 border border-dashed border-[#2E3046] rounded-2xl">
                    <div class="w-14 h-14 rounded-2xl bg-[#1C1D2A] border border-[#2E3046] flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#5C5F7A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    </div>
                    <p class="text-sm text-[#5C5F7A]">Žádné odhlasované nápady v této kategorii</p>
                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="flex flex-col gap-6 fade-up-4">

                {{-- Quick action --}}
                <div class="card p-6 border-[#C9F050]/20">
                    <h3 class="font-display font-bold text-base text-[#F2F1EC] mb-1">Máš dobrý nápad?</h3>
                    <p class="text-xs text-[#5C5F7A] leading-relaxed mb-4">Navrhni vylepšení školy a nech ostatní hlasovat.</p>
                    <a href="{{ route('pages.ideas.create') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-bold text-sm bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] glow-lime transition-all no-underline text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Přidat nápad
                    </a>
                </div>

                {{-- Top hlasovaní --}}
                <div class="card p-6">
                    <h3 class="font-display font-bold text-base text-[#F2F1EC] mb-4">Top nápady týdne</h3>
                    <div class="flex flex-col gap-3">
                        @foreach([
                            ['Odpočinkové zóny na chodbách', 47],
                            ['Rychlejší Wi-Fi v knihovně', 31],
                            ['Školní komunitní zahrada', 19],
                            ['3D tiskárna do dílen', 12],
                        ] as $i => [$title, $votes])
                            <div class="flex items-center gap-3">
                                <span class="font-display font-bold text-xs w-5 text-center {{ $i === 0 ? 'text-[#C9F050]' : 'text-[#5C5F7A]' }}">{{ $i + 1 }}</span>
                                <p class="flex-1 text-sm text-[#E8E7F0] leading-snug">{{ $title }}</p>
                                <span class="text-xs text-[#5C5F7A] flex-shrink-0">{{ $votes }} ♥</span>
                            </div>
                            @if(!$loop->last)
                                <div class="border-t border-[#2E3046]"></div>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Stav školy --}}
                <div class="card p-6">
                    <h3 class="font-display font-bold text-base text-[#F2F1EC] mb-4">Stav návrhů</h3>
                    <div class="flex flex-col gap-3">
                        @foreach([
                            ['Schválené','approved', $stats['approved'] ?? 0, '#C9F050'],
                            ['Celkem návrhů','pending', $stats['total'] ?? 0, '#7eb6ff'],
                        ] as [$label,$key,$count,$color])
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-[#5C5F7A]">{{ $label }}</span>
                                    <span style="color:{{ $color }}">{{ $count }}</span>
                                </div>
                                <div class="h-1.5 bg-[#2E3046] rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" style="width:{{ ($stats['total'] ?? 0) > 0 ? round($count/($stats['total'] ?? 1)*100) : 0 }}%; background:{{ $color }}; opacity:.7;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        // ─── Filter tabs ───
        function filterIdeas(status) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-[#C9F050]/15','border-[#C9F050]/40','text-[#C9F050]');
                btn.classList.add('bg-transparent','border-[#2E3046]','text-[#5C5F7A]');
            });
            const active = document.getElementById('tab-' + status);
            if (active) {
                active.classList.add('bg-[#C9F050]/15','border-[#C9F050]/40','text-[#C9F050]');
                active.classList.remove('bg-transparent','border-[#2E3046]','text-[#5C5F7A]');
            }

            let visible = 0;
            const items = document.querySelectorAll('.idea-item');

            if (items.length > 0) {
                items.forEach(el => {
                    const show = status === 'all' || el.dataset.status === status;
                    el.style.display = show ? '' : 'none';
                    if (show) visible++;
                });
                document.getElementById('empty-state').classList.toggle('hidden', visible > 0);
            }
        }

        // ─── Vote (demo, bez backendu) ───
        function toggleVoteDemo(btn) {
            const voted = btn.dataset.voted === '1' || btn.classList.contains('vote-btn-active');
            const span  = btn.querySelector('.vote-count');
            const count = parseInt(span.textContent);
            if (voted) {
                btn.classList.remove('vote-btn-active');
                btn.classList.add('text-[#5C5F7A]');
                btn.dataset.voted = '0';
                span.textContent = count - 1;
            } else {
                btn.classList.add('vote-btn-active');
                btn.classList.remove('text-[#5C5F7A]');
                btn.dataset.voted = '1';
                span.textContent = count + 1;
            }
        }

        // ─── Vote (s backendem) ───
        async function toggleVote(btn, id) {
            toggleVoteDemo(btn);
            try {
                await fetch(`/ideas/${id}/vote`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '', 'Accept': 'application/json' }
                });
            } catch(e) { console.warn('Vote sync failed', e); }
        }
    </script>
</x-layout>
