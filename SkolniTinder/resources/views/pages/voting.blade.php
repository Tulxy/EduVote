<x-layout>
    <x-slot:title>Hlasování</x-slot:title>

    <style>
        .card-stack { position: relative; width: 380px; height: 520px; }
        .idea-card {
            position: absolute; inset: 0;
            background: #1C1D2A;
            border: 1px solid #2E3046;
            border-radius: 24px;
            padding: 2rem;
            cursor: grab;
            user-select: none;
            transition: box-shadow .2s;
            touch-action: none;
        }
        .idea-card:active { cursor: grabbing; }
        .idea-card.is-dragging { transition: none; }
        .idea-card.animate-out {
            transition: transform .45s cubic-bezier(.25,.46,.45,.94), opacity .45s ease;
        }

        /* Stamp overlays */
        .stamp {
            position: absolute; top: 2rem; padding: .4rem 1.2rem;
            border-radius: 8px; font-weight: 800; font-size: 1.5rem;
            letter-spacing: .08em; opacity: 0; pointer-events: none;
            border-width: 3px; border-style: solid; transform: rotate(-15deg);
            font-family: 'Bricolage Grotesque', sans-serif;
        }
        .stamp-yes { left: 2rem; color: #C9F050; border-color: #C9F050; transform: rotate(-15deg); }
        .stamp-no  { right: 2rem; color: #FF6B52; border-color: #FF6B52; transform: rotate(15deg); }

        /* Buttons */
        .action-btn {
            width: 64px; height: 64px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid; cursor: pointer; transition: all .2s;
            background: transparent;
        }
        .btn-no  { border-color: #FF6B52; color: #FF6B52; }
        .btn-no:hover  { background: #FF6B52; color: #0B0C14; transform: scale(1.1); }
        .btn-yes { border-color: #C9F050; color: #C9F050; }
        .btn-yes:hover { background: #C9F050; color: #0B0C14; transform: scale(1.1); }
        .btn-skip { width: 48px; height: 48px; border-color: #2E3046; color: #5C5F7A; }
        .btn-skip:hover { background: #2E3046; color: #F2F1EC; transform: scale(1.05); }

        @keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation: fadeUp .4s ease both; }



        /* Done state */
        #done-state { display: none; }
    </style>

    <div class="min-h-[calc(100vh-65px)] flex flex-col items-center justify-center px-4 py-10 relative z-10">

        {{-- Header --}}
        <div class="text-center mb-8 fade-up">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium text-[#C9F050] bg-[#C9F050]/10 border border-[#C9F050]/25 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Hlasování
            </span>
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC] mb-2">Co si myslíš?</h1>
            <p class="text-sm text-[#5C5F7A]">Posuň doleva = ne &nbsp;·&nbsp; Posuň doprava = jo</p>
        </div>


        {{-- Card Stack --}}
        <div class="card-stack fade-up" id="card-stack">
            @php
                // Pokud z controlleru nic nepřijde, pro jistotu dosadíme prázdné pole, aby web nespadl
                $allIdeas = $ideas ?? collect();
                $total = count($allIdeas);
            @endphp

            @forelse(array_reverse($allIdeas->all()) as $i => $idea)
                @php
                    // Bezpečně taháme data z Eloquent modelu Idea
                    $title = $idea->title;
                    $desc = $idea->description;
                    $author = $idea->user->name ?? 'Anonym';
                    $votes = $idea->votes_count ?? 0; // Předpokládá se count relací, případně sloupec v DB
                    $id = $idea->id;

                    // Dynamická kategorie (pokud ji v DB nemáš, uprav si podle potřeby)
                    $cat = $idea->category ?? 'Prostředí';
                    $catColor = match($cat) {
                        'Technika'   => ['bg-[#7eb6ff]/10','text-[#7eb6ff]'],
                        'Prostředí'  => ['bg-[#C9F050]/10','text-[#C9F050]'],
                        'Komunita'   => ['bg-[#FF6B52]/10','text-[#FF6B52]'],
                        default      => ['bg-white/5','text-[#5C5F7A]'],
                    };
                @endphp
                <div
                    class="idea-card"
                    data-id="{{ $id }}"
                    data-index="{{ $total - $i - 1 }}"
                    style="z-index: {{ $i + 1 }}; transform: scale({{ 1 - ($total - $i - 1) * 0.04 }}) translateY({{ ($total - $i - 1) * 12 }}px);"
                >
                    {{-- Stamps --}}
                    <div class="stamp stamp-yes" id="stamp-yes-{{ $id }}">JO ✓</div>
                    <div class="stamp stamp-no"  id="stamp-no-{{ $id }}">NE ✗</div>

                    {{-- Category tag --}}
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-4 {{ $catColor[0] }} {{ $catColor[1] }}">
                        {{ $cat }}
                    </span>

                    {{-- Title --}}
                    <h2 class="font-display font-extrabold text-2xl text-[#F2F1EC] leading-tight mb-3">{{ $title }}</h2>

                    {{-- Desc --}}
                    <p class="text-sm text-[#5C5F7A] leading-relaxed mb-6">{{ $desc }}</p>

                    {{-- Divider --}}
                    <div class="border-t border-[#2E3046] mb-4"></div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-[#C9F050]/20 border border-[#C9F050]/30 flex items-center justify-center text-xs font-bold text-[#C9F050]">
                                {{ strtoupper(substr($author, 0, 1)) }}
                            </div>
                            <span class="text-xs text-[#5C5F7A]">{{ $author }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-[#5C5F7A]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#FF6B52]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            {{ $votes }} hlasů
                        </div>
                    </div>

                    {{-- Swipe hint (only top card) --}}
                    @if($i === $total - 1)
                        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex items-center gap-1 text-[0.65rem] text-[#2E3046]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            táhni
                        </div>
                    @endif
                </div>
            @empty
                {{-- Pokud škola nemá žádné nápady, zobrazíme rovnou prázdný stav --}}
                <div class="text-center py-12">
                    <p class="text-sm text-[#5C5F7A]">Pro vaši školu zatím nebyly vytvořeny žádné nápady.</p>
                </div>
            @endforelse
        </div>

        {{-- Action buttons --}}
        <div class="flex items-center gap-6 mt-10 fade-up" id="action-btns">
            <button class="action-btn btn-no" onclick="voteNo()" title="Nesouhlasím">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <button class="action-btn btn-skip" onclick="skipCard()" title="Přeskočit">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
            <button class="action-btn btn-yes" onclick="voteYes()" title="Souhlasím">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </button>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-6 mt-4 text-xs text-[#5C5F7A] fade-up">
            <span class="flex items-center gap-1.5"><span class="text-[#FF6B52] font-bold">←</span> Nesouhlasím</span>
            <span class="flex items-center gap-1.5">Přeskočit <span class="text-[#5C5F7A] font-bold">→|</span></span>
            <span class="flex items-center gap-1.5">Souhlasím <span class="text-[#C9F050] font-bold">→</span></span>
        </div>

        {{-- Done state --}}
        <div id="done-state" class="text-center mt-6">
            <div class="w-16 h-16 rounded-2xl bg-[#C9F050]/10 border border-[#C9F050]/25 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#C9F050]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h2 class="font-display font-bold text-2xl text-[#F2F1EC] mb-2">Hotovo!</h2>
            <p class="text-sm text-[#5C5F7A] mb-6">Odhlasoval jsi všechny dostupné nápady.</p>
            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-bold text-sm bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] transition-all no-underline">
                Zpět na dashboard
            </a>
        </div>

    </div>

    <script>
        const CSRF = document.querySelector('meta[name=csrf-token]')?.content ?? '';
        let cards = Array.from(document.querySelectorAll('.idea-card'));
        let current = cards.length - 1; // top card index
        const total = cards.length;

        function getTopCard() { return cards[current]; }

        function updateProgress() {
            const done = total - current - 1;
            const pct  = Math.round(done / total * 100);
            document.getElementById('progress-fill').style.width  = pct + '%';
            document.getElementById('progress-label').textContent = (done + 1 > total ? total : done + 1) + ' / ' + total;
            document.getElementById('progress-pct').textContent   = pct + ' %';
        }

        function removeTopCard(direction) {
            const card = getTopCard();
            if (!card) return;
            card.classList.add('animate-out');
            const tx = direction === 'right' ? window.innerWidth : -window.innerWidth;
            card.style.transform = `translateX(${tx}px) rotate(${direction === 'right' ? 25 : -25}deg)`;
            card.style.opacity = '0';
            current--;
            updateProgress();
            // Reveal next card
            if (current >= 0) {
                cards[current].style.transition = 'transform .3s ease, box-shadow .2s';
                cards[current].style.transform  = 'scale(1) translateY(0)';
            } else {
                showDone();
            }
            setTimeout(() => card.remove(), 500);
        }

        function showDone() {
            document.getElementById('card-stack').style.display = 'none';
            document.getElementById('action-btns').style.display = 'none';
            document.getElementById('done-state').style.display  = 'block';
            document.getElementById('progress-fill').style.width = '100%';
            document.getElementById('progress-label').textContent = total + ' / ' + total;
            document.getElementById('progress-pct').textContent   = '100 %';
        }

        async function sendVote(id, vote) {
            try {
                await fetch(`/ideas/${id}/vote`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body: JSON.stringify({ vote })
                });
            } catch(e) {}
        }

        function voteYes() {
            const card = getTopCard(); if (!card) return;
            const stamp = card.querySelector('.stamp-yes');
            stamp.style.opacity = '1';
            setTimeout(() => {
                sendVote(card.dataset.id, 'yes');
                removeTopCard('right');
            }, 150);
        }

        function voteNo() {
            const card = getTopCard(); if (!card) return;
            const stamp = card.querySelector('.stamp-no');
            stamp.style.opacity = '1';
            setTimeout(() => {
                sendVote(card.dataset.id, 'no');
                removeTopCard('left');
            }, 150);
        }

        function skipCard() { removeTopCard('right'); }

        // ─── Drag / swipe ───
        let startX = 0, startY = 0, isDragging = false;

        function onStart(e) {
            const card = getTopCard(); if (!card) return;
            isDragging = true;
            startX = (e.touches ? e.touches[0].clientX : e.clientX);
            startY = (e.touches ? e.touches[0].clientY : e.clientY);
            card.classList.add('is-dragging');
        }

        function onMove(e) {
            if (!isDragging) return;
            const card = getTopCard(); if (!card) return;
            const x = (e.touches ? e.touches[0].clientX : e.clientX) - startX;
            const y = (e.touches ? e.touches[0].clientY : e.clientY) - startY;
            const rot = x * 0.08;
            card.style.transform = `translateX(${x}px) translateY(${y}px) rotate(${rot}deg)`;

            // Stamps
            const threshold = 60;
            card.querySelector('.stamp-yes').style.opacity = x > threshold  ? Math.min((x - threshold) / 80, 1) : 0;
            card.querySelector('.stamp-no').style.opacity  = x < -threshold ? Math.min((-x - threshold) / 80, 1) : 0;
        }

        function onEnd(e) {
            if (!isDragging) return;
            isDragging = false;
            const card = getTopCard(); if (!card) return;
            card.classList.remove('is-dragging');
            const x = (e.changedTouches ? e.changedTouches[0].clientX : e.clientX) - startX;

            if (x > 100)       { voteYes(); }
            else if (x < -100) { voteNo(); }
            else {
                // snap back
                card.style.transition = 'transform .35s cubic-bezier(.25,.46,.45,.94)';
                card.style.transform  = 'scale(1) translateY(0)';
                card.querySelector('.stamp-yes').style.opacity = 0;
                card.querySelector('.stamp-no').style.opacity  = 0;
            }
        }

        document.addEventListener('mousedown',  onStart);
        document.addEventListener('mousemove',  onMove);
        document.addEventListener('mouseup',    onEnd);
        document.addEventListener('touchstart', onStart, { passive: true });
        document.addEventListener('touchmove',  onMove,  { passive: true });
        document.addEventListener('touchend',   onEnd);

        // Keyboard shortcuts
        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowRight') voteYes();
            if (e.key === 'ArrowLeft')  voteNo();
            if (e.key === 'ArrowDown' || e.key === ' ') skipCard();
        });

        updateProgress();
    </script>

</x-layout>
