<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrace - EduVote</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Bricolage Grotesque', sans-serif; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation: fadeUp .5s ease both; }
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
<div class="fixed -top-32 -left-32 w-[500px] h-[500px] rounded-full bg-[#C9F050]/[0.05] blur-[140px] pointer-events-none z-0"></div>
<div class="fixed -bottom-32 -right-32 w-[400px] h-[400px] rounded-full bg-[#FF6B52]/[0.06] blur-[140px] pointer-events-none z-0"></div>

{{-- ─── NAV ─── --}}
<nav class="relative z-10 flex items-center justify-between px-6 lg:px-16 py-4 border-b border-white/[0.06]">
    <a href="{{ url('/') }}" class="flex items-center gap-2 font-display font-bold text-[1.15rem] text-[#F2F1EC] no-underline">
        <span class="w-2.5 h-2.5 rounded-full bg-[#C9F050]"></span>
        EduVote
    </a>
    <a href="{{ route('login') }}" class="text-sm text-[#5C5F7A] hover:text-[#F2F1EC] transition-colors no-underline">
        Už máš účet? <span class="text-[#C9F050]">Přihlásit se</span>
    </a>
</nav>

<main class="relative z-10 flex flex-1 items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        {{-- Header --}}
        <div class="text-center mb-10 fade-up">
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC] leading-tight mb-3">Vytvořit účet</h1>

            {{-- Přepínač (Tabs) --}}
            <div class="flex p-1 bg-[#1C1D2A] border border-[#2E3046] rounded-xl mt-6">
                <button onclick="switchTab('student')" id="tab-student" class="flex-1 py-2 text-sm font-medium rounded-lg transition-all bg-[#C9F050] text-[#0B0C14]">
                    Student / Pedagog
                </button>
                <button onclick="switchTab('school')" id="tab-school" class="flex-1 py-2 text-sm font-medium rounded-lg transition-all text-[#5C5F7A] hover:text-[#E8E7F0]">
                    Nová škola
                </button>
            </div>
        </div>

        {{-- FORMULÁŘ 1: STUDENT / PEDAGOG --}}
        <div id="form-student" class="fade-up-2 bg-[#1C1D2A]/60 backdrop-blur-sm border border-[#2E3046] rounded-2xl p-8">
            <form method="POST" action="{{ route('register.user') }}" class="flex flex-col gap-5">
                @csrf
                <h3 class="text-[#C9F050] font-display font-bold text-lg mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Připojit se ke škole
                </h3>

                {{-- Role --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-[#E8E7F0]">Jsem...</label>
                    <select name="role" class="input-field">
                        <option value="student">Student</option>
                        <option value="pedagog">Pedagog</option>
                    </select>
                </div>

                {{-- Kód školy --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-[#E8E7F0]">Unikátní kód školy</label>
                    <input type="text" name="student_code" required placeholder="Zadej kód od správce" class="input-field @error('student_code') error @enderror">
                    @error('student_code') <span class="text-xs text-[#FF6B52]">{{ $message }}</span> @enderror
                </div>

                <div class="border-t border-white/[0.06] my-1"></div>

                {{-- Osobní údaje --}}
                <div class="flex flex-col gap-4">
                    <input type="text" name="name" required placeholder="Celé jméno" class="input-field">
                    <input type="email" name="email" required placeholder="E-mail" class="input-field">
                    <input type="password" name="password" required placeholder="Heslo" class="input-field">
                    <input type="password" name="password_confirmation" required placeholder="Potvrzení hesla" class="input-field">
                </div>

                <button type="submit" class="mt-2 w-full py-3.5 rounded-full font-bold text-sm bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] transition-all glow-lime">
                    Zaregistrovat se
                </button>
            </form>
        </div>

        {{-- FORMULÁŘ 2: ŠKOLA (Skrytý v základu) --}}
        <div id="form-school" class="hidden fade-up-2 bg-[#1C1D2A]/60 backdrop-blur-sm border border-[#2E3046] rounded-2xl p-8">
            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
                @csrf
                <h3 class="text-[#C9F050] font-display font-bold text-lg mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v11a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10"/><path d="m22 7-10-5L2 7l10 5 10-5Z"/></svg>
                    Založit novou školu
                </h3>

                <input type="text" name="school_name" required placeholder="Název školy" class="input-field">
                <input type="text" name="school_address" required placeholder="Adresa školy" class="input-field">
                <input type="text" name="student_code" required placeholder="Vytvořit kód pro ostatní" class="input-field">

                <div class="border-t border-white/[0.06] my-1"></div>
                <p class="text-[11px] text-[#5C5F7A] uppercase tracking-wider font-bold">Údaje správce</p>

                <input type="text" name="name" required placeholder="Vaše jméno" class="input-field">
                <input type="email" name="email" required placeholder="Váš email" class="input-field">
                <input type="password" name="password" required placeholder="Heslo" class="input-field">

                <button type="submit" class="mt-2 w-full py-3.5 rounded-full font-bold text-sm bg-[#C9F050] text-[#0B0C14] hover:bg-[#d8ff60] transition-all glow-lime">
                    Vytvořit školu a spravovat
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    function switchTab(type) {
        const studentForm = document.getElementById('form-student');
        const schoolForm = document.getElementById('form-school');
        const studentTab = document.getElementById('tab-student');
        const schoolTab = document.getElementById('tab-school');

        if (type === 'student') {
            studentForm.classList.remove('hidden');
            schoolForm.classList.add('hidden');
            studentTab.classList.add('bg-[#C9F050]', 'text-[#0B0C14]');
            studentTab.classList.remove('text-[#5C5F7A]');
            schoolTab.classList.remove('bg-[#C9F050]', 'text-[#0B0C14]');
            schoolTab.classList.add('text-[#5C5F7A]');
        } else {
            schoolForm.classList.remove('hidden');
            studentForm.classList.add('hidden');
            schoolTab.classList.add('bg-[#C9F050]', 'text-[#0B0C14]');
            schoolTab.classList.remove('text-[#5C5F7A]');
            studentTab.classList.remove('bg-[#C9F050]', 'text-[#0B0C14]');
            studentTab.classList.add('text-[#5C5F7A]');
        }
    }
</script>

</body>
</html>
