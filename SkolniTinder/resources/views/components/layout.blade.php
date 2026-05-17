<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - EduVote' : 'EduVote' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #0B0C14; color: #F2F1EC; }
        h1, h2, .font-display { font-family: 'Bricolage Grotesque', sans-serif; }

        /* Animace */
        @keyframes float1 { 0%,100%{transform:translateY(0px) rotate(-1deg)} 50%{transform:translateY(-14px) rotate(0deg)} }
        @keyframes float2 { 0%,100%{transform:translateY(0px) rotate(1deg)} 50%{transform:translateY(-10px) rotate(.5deg)} }
        @keyframes float3 { 0%,100%{transform:translateY(0px) rotate(-.5deg)} 50%{transform:translateY(-12px) rotate(.5deg)} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pulse { 0%,100%{opacity:.3;transform:scale(1)} 50%{opacity:1;transform:scale(1.4)} }
    </style>
</head>
<body class="antialiased">

{{-- ─── NAV ─── --}}
<nav class="sticky top-0 z-50 flex items-center justify-between px-6 lg:px-12 py-4 bg-[#0B0C14]/80 backdrop-blur-xl border-b border-white/[0.06]">
    <a href="{{ url('/') }}" class="flex items-center gap-2 font-display font-bold text-[1.1rem] text-[#F2F1EC] no-underline">
        <span class="w-2.5 h-2.5 rounded-full bg-[#C9F050]"></span>
        EduVote
    </a>

    <ul class="hidden md:flex items-center gap-6 list-none">
        <li>
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-1.5 text-sm text-[#F2F1EC] font-medium no-underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#C9F050]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
        </li>
        <li><a href="{{ url('/voting') }}" class="text-sm text-[#C9F050] hover:text-[#F2F1EC] transition-colors no-underline">Hlasování</a></li>
        <li><a href="{{ url('pages/ideas') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Všechny nápady</a></li>
        <li><a href="{{ route('pages.ideas.create') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Přidat nápad</a></li>
        <li><a href="{{ url('/user-ideas') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Moje nápady</a></li>
    </ul>

    <div class="flex items-center gap-4">
        <div class="flex items-center p-3  gap-2">
            {{-- V navigaci v layoutu --}}
            @auth
                @php $status = auth()->user()->accepted; @endphp

                @if(auth()->user()->role === 'admin')
                    {{-- ADMIN: Vidí klikatelné tlačítko pro správu --}}
                    <a href="{{ route('school.manage') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#C9F050]/10 border border-[#C9F050]/20 text-[#C9F050] text-xs font-bold uppercase hover:bg-[#C9F050] hover:text-black transition-all shadow-[0_0_15px_rgba(201,240,80,0.1)]">
                        <i class="fa-solid fa-shield"></i>
                        Správa školy
                    </a>
                @else
                    {{-- STUDENT: Vidí jen neklikatelný stav --}}
                    <div class="flex items-center gap-3 px-4 py-2 rounded-xl border border-[#2E3046] bg-[#1C1D2A]/50">
                        @if($status === 'accepted')
                            <i class="fa-solid fa-circle-check text-[#C9F050]"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#C9F050]">Student školy</span>
                        @elseif($status === 'wait')
                            <i class="fa-solid fa-circle-exclamation text-yellow-500"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-500">Čeká na schválení</span>
                        @else
                            <i class="fa-solid fa-circle-xmark text-[#FF6B52]"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#FF6B52]">Přístup zamítnut</span>
                        @endif
                    </div>
                @endif
            @endauth
        </div>
        {{-- Avatar + jméno --}}
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group no-underline">
            <div class="hidden lg:block text-right mr-1">
                <div class="text-[15px] font-bold text-[#F2F1EC] leading-none group-hover:text-[#C9F050] transition-colors">{{ auth()->user()->name }}</div>
                <div class="text-[13px] text-[#5C5F7A] uppercase tracking-tighter">Můj profil</div>
            </div>

            @if(auth()->user()->avatar)
                {{-- Pokud uživatel MÁ vybraného avatara --}}
                <img src="{{ asset('images/avatars/' . auth()->user()->avatar) }}"
                     class="w-11 h-11 rounded-xl border border-[#C9F050]/20 object-cover group-hover:border-[#C9F050] transition-all">
            @else
                {{-- Pokud uživatel NEMÁ avatara, ukážeme písmeno --}}
                <div class="w-11 h-11 rounded-xl bg-[#C9F050] flex items-center justify-center text-[#0B0C14] font-bold text-lg shadow-[0_0_15px_rgba(201,240,80,0.2)] group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-medium text-[#5C5F7A] border border-[#2E3046] hover:bg-[#1C1D2A] hover:text-[#F2F1EC] transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Odhlásit
            </button>
        </form>
    </div>
</nav>

<main class="w-full min-h-screen">
    {{ $slot }}
</main>

{{-- resources/views/components/footer.blade.php --}}
{{-- Použití: <x-footer /> --}}

<footer class="relative z-10 border-t border-white/[0.06] mt-auto">
    <div class="max-w-[1300px] mx-auto px-6 lg:px-12 py-12">

        {{-- Top row --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">

            {{-- Brand --}}
            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-2 font-display font-bold text-[1.15rem] text-[#F2F1EC] no-underline mb-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#C9F050]"></span>
                    SchoolHelp
                </a>
                <p class="text-sm text-[#5C5F7A] leading-relaxed max-w-[240px]">
                    Platforma, kde žáci navrhují vylepšení školy a komunita rozhoduje.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-4">Navigace</p>
                <ul class="flex flex-col gap-2.5 list-none">
                    <li><a href="{{ url('/') }}"         class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Domů</a></li>
                    <li><a href="{{ url('/voting') }}"   class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Hlasování</a></li>
                    <li><a href="{{ url('/dashboard') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Dashboard</a></li>
                    @guest
                        <li><a href="{{ route('login') }}"    class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Přihlásit se</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Registrace</a></li>
                    @endguest
                </ul>
            </div>

            {{-- CTA --}}
            <div>
                <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-4">Zapoj se</p>
                <p class="text-sm text-[#5C5F7A] leading-relaxed mb-4">
                    Máš nápad na vylepšení školy? Přidej ho a nech ostatní hlasovat.
                </p>
                <a href="{{ url('/voting') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-bold bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] transition-all no-underline" style="box-shadow: 0 8px 24px rgba(201,240,80,.2)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Přidat nápad
                </a>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t border-[#2E3046] mb-6"></div>

        {{-- Bottom row --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-[#5C5F7A]">
                &copy; {{ date('Y') }} SchoolHelp. Vytvořeno s
                <span class="text-[#FF6B52]">♥</span>
                pro lepší školy.
            </p>
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-[#C9F050] animate-pulse"></span>
                <span class="text-xs text-[#5C5F7A]">Systém běží</span>
            </div>
        </div>

    </div>
</footer>
</body>
</html>
