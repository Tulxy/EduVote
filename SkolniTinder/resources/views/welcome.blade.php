<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SchoolHelp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, .font-display { font-family: 'Bricolage Grotesque', sans-serif; }
        @keyframes float1 { 0%,100%{transform:translateY(0px) rotate(-1deg)} 50%{transform:translateY(-14px) rotate(0deg)} }
        @keyframes float2 { 0%,100%{transform:translateY(0px) rotate(1deg)} 50%{transform:translateY(-10px) rotate(.5deg)} }
        @keyframes float3 { 0%,100%{transform:translateY(0px) rotate(-.5deg)} 50%{transform:translateY(-12px) rotate(.5deg)} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pulse { 0%,100%{opacity:.3;transform:scale(1)} 50%{opacity:1;transform:scale(1.4)} }
        .float-1 { animation: float1 6s ease-in-out infinite; }
        .float-2 { animation: float2 7s ease-in-out infinite; }
        .float-3 { animation: float3 5.5s ease-in-out infinite; }
        .fade-up-1 { animation: fadeUp .5s ease both; }
        .fade-up-2 { animation: fadeUp .5s .1s ease both; }
        .fade-up-3 { animation: fadeUp .5s .2s ease both; }
        .fade-up-4 { animation: fadeUp .5s .3s ease both; }
        .fade-up-5 { animation: fadeUp .5s .4s ease both; }
        .pulse-dot { animation: pulse 3s ease-in-out infinite; }
        .pulse-dot-2 { animation: pulse 3s 1s ease-in-out infinite; }
        .accent-underline { position:relative; }
        .accent-underline::after { content:''; position:absolute; bottom:4px; left:0; width:100%; height:3px; background:#c9f050; border-radius:2px; opacity:.4; }
        .glow-lime { box-shadow: 0 8px 24px rgba(201,240,80,.25); }
    </style>
</head>
<body class="bg-[#0B0C14] text-[#E8E7F0] min-h-screen overflow-x-hidden">

{{-- Noise overlay --}}
<div class="fixed inset-0 pointer-events-none z-0 opacity-[0.04]"
     style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.75%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22300%22 height=%22300%22 filter=%22url(%23n)%22/%3E%3C/svg%3E')">
</div>

{{-- ─── NAV ─── --}}
<nav class="sticky top-0 z-50 flex items-center justify-between px-16 py-4 bg-[#0B0C14]/75 backdrop-blur-xl border-b border-white/[0.06]">
    <a href="{{route('register')}}" class="flex items-center gap-2 font-display font-bold text-[1.15rem] text-[#F2F1EC] no-underline">
        <span class="w-2.5 h-2.5 rounded-full bg-[#C9F050] flex-shrink-0"></span>
        SchoolHelp
    </a>

    <ul class="hidden md:flex items-center gap-8 list-none">
        <li><a href="#" class="text-[#5C5F7A] text-sm hover:text-[#F2F1EC] transition-colors no-underline">Všechny nápady</a></li>
        <li><a href="#" class="text-[#5C5F7A] text-sm hover:text-[#F2F1EC] transition-colors no-underline">Schválené</a></li>
        <li><a href="#" class="text-[#5C5F7A] text-sm hover:text-[#F2F1EC] transition-colors no-underline">Jak to funguje?</a></li>
    </ul>

    <div class="flex items-center gap-3">
        <a href="{{route('login')}}" class="inline-flex items-center px-5 py-2 rounded-full text-sm font-medium text-[#5C5F7A] border border-[#2E3046] hover:bg-[#1C1D2A] hover:text-[#F2F1EC] hover:border-[#5C5F7A] transition-all no-underline">
            Přihlásit se
        </a>
        <a href="{{route('register')}}" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-sm font-bold bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] hover:-translate-y-px glow-lime transition-all no-underline">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Začít
        </a>
    </div>
</nav>

{{-- ─── HERO ─── --}}
<header class="relative z-10 grid grid-cols-1 lg:grid-cols-2 items-center gap-16 px-6 lg:px-16 py-24 min-h-[calc(100vh-65px)] max-w-[1400px] mx-auto">

    {{-- Glow blobs --}}
    <div class="absolute -top-24 -left-24 w-[500px] h-[500px] rounded-full bg-[#C9F050]/[0.07] blur-[120px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-0 -right-0 w-[400px] h-[400px] rounded-full bg-[#FF6B52]/[0.08] blur-[120px] pointer-events-none -z-10"></div>

    {{-- LEFT --}}
    <div class="flex flex-col gap-8 fade-up-1">

            <span class="fade-up-1 inline-flex items-center gap-2 w-fit px-4 py-1.5 rounded-full text-xs font-medium text-[#C9F050] bg-[#C9F050]/10 border border-[#C9F050]/25">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Hlas pro lepší školu
            </span>

        <h1 class="fade-up-2 font-display font-extrabold text-[clamp(2.6rem,5vw,4rem)] leading-[1.1] text-[#F2F1EC]">
            Navrhni. <br>
            Hlasuj. <br>
            <span class="accent-underline text-[#C9F050]">Zlepšuj.</span>
        </h1>

        <p class="fade-up-3 text-[1.05rem] text-[#5C5F7A] leading-[1.75] max-w-[480px]">
            Platforma, kde žáci navrhují vylepšení školy a komunita rozhoduje, co se skutečně stane. Každý nápad se počítá.
        </p>

        <div class="fade-up-4 flex items-center gap-4 flex-wrap">
            <a href="#" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-base font-bold bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] hover:-translate-y-px glow-lime transition-all no-underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Přidat nápad
            </a>
            <a href="#" class="inline-flex items-center px-8 py-3.5 rounded-full text-base font-medium text-[#5C5F7A] border border-[#2E3046] hover:bg-[#1C1D2A] hover:text-[#F2F1EC] hover:border-[#5C5F7A] transition-all no-underline">
                Procházet nápady →
            </a>
        </div>

        <div class="fade-up-5 flex items-center gap-10 pt-2">
            <div class="flex flex-col gap-0.5">
                <span class="font-display font-bold text-2xl text-[#F2F1EC]">124</span>
                <span class="text-xs text-[#5C5F7A]">Návrhů celkem</span>
            </div>
            <div class="w-px h-10 bg-[#2E3046] self-center"></div>
            <div class="flex flex-col gap-0.5">
                <span class="font-display font-bold text-2xl text-[#F2F1EC]">38</span>
                <span class="text-xs text-[#5C5F7A]">Schváleno</span>
            </div>
            <div class="w-px h-10 bg-[#2E3046] self-center"></div>
            <div class="flex flex-col gap-0.5">
                <span class="font-display font-bold text-2xl text-[#F2F1EC]">1 200</span>
                <span class="text-xs text-[#5C5F7A]">Hlasů odevzdáno</span>
            </div>
        </div>
    </div>

    {{-- RIGHT – floating cards --}}
    <div class="relative h-[520px] hidden lg:block" aria-hidden="true">

        {{-- Pulse dots --}}
        <div class="absolute top-[165px] left-[220px] w-2 h-2 rounded-full bg-[#2E3046] border-2 border-[#5C5F7A] pulse-dot"></div>
        <div class="absolute top-[300px] right-[180px] w-2 h-2 rounded-full bg-[#2E3046] border-2 border-[#5C5F7A] pulse-dot-2"></div>

        {{-- Card 1 --}}
        <div class="float-1 absolute top-5 left-10 w-[260px] bg-[#1C1D2A] border border-[#2E3046] rounded-2xl p-4 hover:-translate-y-1 transition-transform cursor-default">
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium px-2.5 py-0.5 rounded-full mb-3 bg-[#C9F050]/10 text-[#C9F050]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Prostředí
                </span>
            <p class="font-display font-semibold text-[0.95rem] text-[#F2F1EC] leading-snug mb-1">Odpočinkové zóny na chodbách</p>
            <p class="text-xs text-[#5C5F7A] mb-3">od Jana K. · 3. 4. 2025</p>
            <div class="flex items-center justify-between">
                <button onclick="toggleVote(this)" class="vote-btn active inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs bg-[#C9F050]/15 border border-[#C9F050]/40 text-[#C9F050] transition-all">
                    <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    47
                </button>
                <span class="text-[0.7rem] font-medium px-2.5 py-0.5 rounded-full bg-[#C9F050]/15 text-[#C9F050]">Schváleno</span>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="float-2 absolute top-[160px] right-2.5 w-[260px] bg-[#1C1D2A] border border-[#C9F050]/20 rounded-2xl p-4 hover:-translate-y-1 transition-transform cursor-default">
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium px-2.5 py-0.5 rounded-full mb-3 bg-[#7eb6ff]/10 text-[#7eb6ff]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><polyline points="8 21 12 17 16 21"/></svg>
                    Technika
                </span>
            <p class="font-display font-semibold text-[0.95rem] text-[#F2F1EC] leading-snug mb-1">Rychlejší Wi-Fi v knihovně</p>
            <p class="text-xs text-[#5C5F7A] mb-3">od Tomáš M. · 28. 3. 2025</p>
            <div class="flex items-center justify-between">
                <button onclick="toggleVote(this)" class="vote-btn inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs bg-white/5 border border-[#2E3046] text-[#F2F1EC] hover:bg-[#C9F050]/10 hover:border-[#C9F050]/30 hover:text-[#C9F050] transition-all">
                    <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    31
                </button>
                <span class="text-[0.7rem] font-medium px-2.5 py-0.5 rounded-full bg-white/5 text-[#5C5F7A]">Čeká na schválení</span>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="float-3 absolute bottom-16 left-5 w-[260px] bg-[#1C1D2A] border border-[#2E3046] rounded-2xl p-4 hover:-translate-y-1 transition-transform cursor-default">
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-medium px-2.5 py-0.5 rounded-full mb-3 bg-[#FF6B52]/10 text-[#FF6B52]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Komunita
                </span>
            <p class="font-display font-semibold text-[0.95rem] text-[#F2F1EC] leading-snug mb-1">Školní komunitní zahrada</p>
            <p class="text-xs text-[#5C5F7A] mb-3">od Lucie V. · 10. 4. 2025</p>
            <div class="flex items-center justify-between">
                <button onclick="toggleVote(this)" class="vote-btn inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs bg-white/5 border border-[#2E3046] text-[#F2F1EC] hover:bg-[#C9F050]/10 hover:border-[#C9F050]/30 hover:text-[#C9F050] transition-all">
                    <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    19
                </button>
                <span class="text-[0.7rem] font-medium px-2.5 py-0.5 rounded-full bg-[#7eb6ff]/10 text-[#7eb6ff]">Nový</span>
            </div>
        </div>
    </div>
</header>

{{-- ─── FEATURE STRIP ─── --}}
<div class="border-t border-[#2E3046] max-w-[1400px] mx-auto px-6 lg:px-16 py-8 flex flex-col sm:flex-row items-start sm:items-center gap-6">
    <span class="text-xs text-[#5C5F7A] uppercase tracking-widest whitespace-nowrap flex-shrink-0">Jak to funguje</span>
    <div class="flex flex-wrap gap-8">
        <div class="flex items-center gap-3 text-sm text-[#5C5F7A]">
            <div class="w-8 h-8 bg-[#1C1D2A] border border-[#2E3046] rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#C9F050]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            Vyplníš formulář s nápadem
        </div>
        <div class="flex items-center gap-3 text-sm text-[#5C5F7A]">
            <div class="w-8 h-8 bg-[#1C1D2A] border border-[#2E3046] rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#C9F050]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            Spolužáci hlasují pro nápady
        </div>
        <div class="flex items-center gap-3 text-sm text-[#5C5F7A]">
            <div class="w-8 h-8 bg-[#1C1D2A] border border-[#2E3046] rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#C9F050]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            Administrátor návrh schválí
        </div>
        <div class="flex items-center gap-3 text-sm text-[#5C5F7A]">
            <div class="w-8 h-8 bg-[#1C1D2A] border border-[#2E3046] rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#C9F050]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            Škola se mění k lepšímu
        </div>
    </div>
</div>

<script>
    function toggleVote(btn) {
        const isActive = btn.classList.contains('active');
        const count = parseInt(btn.textContent.trim());
        if (isActive) {
            btn.classList.remove('active', 'bg-[#C9F050]/15', 'border-[#C9F050]/40', 'text-[#C9F050]');
            btn.classList.add('bg-white/5', 'border-[#2E3046]', 'text-[#F2F1EC]');
            btn.lastChild.textContent = ' ' + (count - 1);
        } else {
            btn.classList.add('active', 'bg-[#C9F050]/15', 'border-[#C9F050]/40', 'text-[#C9F050]');
            btn.classList.remove('bg-white/5', 'border-[#2E3046]', 'text-[#F2F1EC]');
            btn.lastChild.textContent = ' ' + (count + 1);
        }
    }
</script>

</body>
</html>
