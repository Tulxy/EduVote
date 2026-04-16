<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Přihlášení - SchoolHelp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Bricolage Grotesque', sans-serif; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .fade-up   { animation: fadeUp .5s ease both; }
        .fade-up-2 { animation: fadeUp .5s .08s ease both; }
        .fade-up-3 { animation: fadeUp .5s .16s ease both; }
        .glow-lime { box-shadow: 0 8px 24px rgba(201,240,80,.2); }
        .input-field {
            width: 100%;
            background: #1C1D2A;
            border: 1px solid #2E3046;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            color: #E8E7F0;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .input-field::placeholder { color: #5C5F7A; }
        .input-field:focus {
            border-color: #C9F050;
            box-shadow: 0 0 0 3px rgba(201,240,80,.1);
        }
        .input-field.error { border-color: #FF6B52; }
        .input-field.error:focus { box-shadow: 0 0 0 3px rgba(255,107,82,.1); }
    </style>
</head>
<body class="bg-[#0B0C14] text-[#E8E7F0] min-h-screen overflow-x-hidden flex flex-col">

{{-- Noise overlay --}}
<div class="fixed inset-0 pointer-events-none z-0 opacity-[0.04]"
     style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.75%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22300%22 height=%22300%22 filter=%22url(%23n)%22/%3E%3C/svg%3E')">
</div>

{{-- Glow blobs --}}
<div class="fixed -top-32 -right-32 w-[500px] h-[500px] rounded-full bg-[#C9F050]/[0.05] blur-[140px] pointer-events-none z-0"></div>
<div class="fixed -bottom-32 -left-32 w-[400px] h-[400px] rounded-full bg-[#FF6B52]/[0.06] blur-[140px] pointer-events-none z-0"></div>

{{-- ─── NAV ─── --}}
<nav class="relative z-10 flex items-center justify-between px-6 lg:px-16 py-4 border-b border-white/[0.06]">
    <a href="{{ url('/') }}" class="flex items-center gap-2 font-display font-bold text-[1.15rem] text-[#F2F1EC] no-underline">
        <span class="w-2.5 h-2.5 rounded-full bg-[#C9F050]"></span>
        SchoolHelp
    </a>
    <a href="{{ route('register') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">
        Nemáš účet? <span class="text-[#C9F050]">Zaregistrovat se</span>
    </a>
</nav>

{{-- ─── MAIN ─── --}}
<main class="relative z-10 flex flex-1 items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-10 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium text-[#C9F050] bg-[#C9F050]/10 border border-[#C9F050]/25 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Vítej zpět
            </div>
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC] leading-tight mb-3">Přihlásit se</h1>
            <p class="text-sm text-[#5C5F7A]">Přihlas se a hlasuj za nápady své školy</p>
        </div>

        {{-- Session error (např. špatné heslo) --}}
        @if (session('status'))
            <div class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl bg-[#C9F050]/10 border border-[#C9F050]/25 text-sm text-[#C9F050]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('status') }}
            </div>
        @endif

        @error('email')
        @if ($message === 'These credentials do not match our records.' || str_contains($message, 'nepodaří'))
            <div class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl bg-[#FF6B52]/10 border border-[#FF6B52]/25 text-sm text-[#FF6B52]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Nesprávný e-mail nebo heslo.
            </div>
        @endif
        @enderror

        {{-- Card --}}
        <div class="fade-up-2 bg-[#1C1D2A]/60 backdrop-blur-sm border border-[#2E3046] rounded-2xl p-8">

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                @csrf

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-[#E8E7F0]">E-mail</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="jan@skola.cz"
                        class="input-field @error('email') error @enderror"
                    >
                    @error('email')
                    <span class="flex items-center gap-1.5 text-xs text-[#FF6B52]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </span>
                    @enderror
                </div>

                {{-- Heslo --}}
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-[#E8E7F0]">Heslo</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-[#5C5F7A] hover:text-[#C9F050] transition-colors no-underline">
                                Zapomněl jsi heslo?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            placeholder="Tvoje heslo"
                            class="input-field pr-11 @error('password') error @enderror"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#5C5F7A] hover:text-[#E8E7F0] transition-colors">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                    <span class="flex items-center gap-1.5 text-xs text-[#FF6B52]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </span>
                    @enderror
                </div>

                {{-- Remember me --}}
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="remember" id="remember" class="sr-only peer">
                        <div class="w-10 h-5 bg-[#2E3046] border border-[#2E3046] rounded-full peer-checked:bg-[#C9F050]/20 peer-checked:border-[#C9F050]/40 transition-all"></div>
                        <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-[#5C5F7A] rounded-full peer-checked:translate-x-5 peer-checked:bg-[#C9F050] transition-all"></div>
                    </div>
                    <span class="text-sm text-[#5C5F7A] group-hover:text-[#E8E7F0] transition-colors select-none">Zapamatovat si mě</span>
                </label>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="mt-2 w-full py-3.5 rounded-full font-bold text-sm bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] hover:-translate-y-px glow-lime transition-all"
                >
                    Vstoupit
                </button>

            </form>
        </div>

        {{-- Footer --}}
        <p class="fade-up-3 text-center text-xs text-[#5C5F7A] mt-6">
            Nemáš ještě účet?
            <a href="{{ route('register') }}" class="text-[#C9F050] hover:underline">Zaregistruj se zdarma</a>
        </p>

    </div>
</main>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.outerHTML = isHidden
            ? `<svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
            : `<svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
    }

    // Toggle checkbox visually
    document.getElementById('remember').addEventListener('change', function() {
        const dot = this.nextElementSibling.nextElementSibling;
    });
</script>

</body>
</html>
