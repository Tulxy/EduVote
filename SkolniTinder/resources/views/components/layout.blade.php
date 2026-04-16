<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ isset($title) ? $title . ' - EduVote' : 'EduVote' }}</title>

    @vite(['resources/css/app.css', 'resources/css/tags.css', 'resources/js/app.js', 'resources/js/tags.js', 'resources/js/clipboard.js', 'resources/js/profile-share.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #0B0C14; color: #F2F1EC; }
        h1, h2, .font-display { font-family: 'Bricolage Grotesque', sans-serif; }

        /* Animace */
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
        <li><a href="{{ url('/ideas') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Všechny nápady</a></li>
        <li><a href="{{ url('/ideas/create') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">Přidat nápad</a></li>
        @if(auth()->user()->is_admin ?? false)
            <li><a href="{{ url('/admin') }}" class="text-sm text-[#FF6B52] hover:text-[#ff8a75] transition-colors no-underline">Admin</a></li>
        @endif
    </ul>

    <div class="flex items-center gap-3">
        {{-- Avatar + jméno --}}
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-full bg-[#C9F050]/20 border border-[#C9F050]/30 flex items-center justify-center text-xs font-bold text-[#C9F050]">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <span class="hidden sm:block text-sm text-[#E8E7F0]">{{ auth()->user()->name ?? 'Uživatel' }}</span>
        </div>

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
</body>
</html>
