<x-layout>
    <x-slot:title>Můj Profil</x-slot:title>

    <main class="relative z-10 max-w-[800px] mx-auto px-6 py-10">
        @if (session('status') === 'profile-updated')
            <div class="max-w-[800px] mx-auto px-6 mt-4 p-4 bg-lime-500/20 border border-lime-500 text-lime-500 rounded-xl">
                Změny byly úspěšně uloženy!
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-3">
            @csrf
            @method('PATCH')

            {{-- Změna jména --}}
            <div class="card px-6 py-2 border-[#2E3046]">
                <label class="block text-xs text-[#5C5F7A] uppercase tracking-widest mb-2 font-bold">Tvoje jméno</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                       class="w-full bg-[#0B0C14] border @error('name') border-red-500 @else border-[#2E3046] @enderror rounded-xl px-4 py-3 text-[#F2F1EC] focus:border-[#C9F050] outline-none transition-all">

                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="card px-6 py-2 border-[#2E3046]">
                <label class="block text-xs text-[#5C5F7A] uppercase tracking-widest mb-2 font-bold">Tvůj email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                       class="w-full bg-[#0B0C14] border @error('email') border-red-500 @else border-[#2E3046] @enderror rounded-xl px-4 py-3 text-[#F2F1EC] focus:border-[#C9F050] outline-none transition-all">

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Změna emailu --}}
            <div class="flex items-center gap-3">
                <div class="card px-6 py-2 border-[#2E3046] w-full">
                    <label class="block text-xs text-[#5C5F7A] uppercase tracking-widest mb-2 font-bold">Nové heslo</label>

                    <div class="relative">
                        <input id="password" type="password" name="password"
                               class="w-full bg-[#0B0C14] border @error('password') border-red-500 @else border-[#2E3046] @enderror rounded-xl px-4 py-3 pr-12 text-[#F2F1EC] focus:border-[#C9F050] outline-none transition-all">

                        <button type="button" onclick="togglePassword('password','eyeIcon1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#5C5F7A] hover:text-[#C9F050] transition">
                            <i id="eyeIcon1" class="fa-solid fa-eye"></i>
                        </button>
                    </div>

                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Potvrzení hesla --}}
                <div class="card px-6 py-2 border-[#2E3046] w-full">
                    <label class="block text-xs text-[#5C5F7A] uppercase tracking-widest mb-2 font-bold">Potvrzení hesla</label>

                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="w-full bg-[#0B0C14] border border-[#2E3046] rounded-xl px-4 py-3 pr-12 text-[#F2F1EC] focus:border-[#C9F050] outline-none transition-all">

                        <button type="button" onclick="togglePassword('password_confirmation','eyeIcon2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#5C5F7A] hover:text-[#C9F050] transition">
                            <i id="eyeIcon2" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>



            {{-- Výběr avatara --}}
            <div class="card p-6 border-[#2E3046]">
                <label class="block text-xs text-[#5C5F7A] uppercase tracking-widest mb-4 font-bold">Vyber si svého avatara</label>

                <div class="grid grid-cols-3 sm:grid-cols-5 gap-4">
                    {{-- Ujisti se, že $avatars existuje --}}
                    @isset($avatars)
                        @foreach($avatars as $avatar)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="avatar" value="{{ $avatar }}" class="peer hidden"
                                    {{ old('avatar', auth()->user()->avatar) == $avatar ? 'checked' : '' }}>

                                <img src="{{ asset('images/avatars/' . $avatar) }}"
                                     class="w-full aspect-square rounded-2xl border-2 border-transparent peer-checked:border-[#C9F050]  transition-all p-1">

                                <div class="absolute -top-2 -right-2 bg-[#C9F050] text-black rounded-full w-6 h-6 items-center justify-center hidden peer-checked:flex shadow-lg">
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                </div>
                            </label>
                        @endforeach
                    @else
                        <p class="text-[#5C5F7A] italic text-sm">Žádní avataři k dispozici.</p>
                    @endisset
                </div>
                @error('avatar')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-4 rounded-xl font-bold bg-[#C9F050] text-black hover:bg-[#d8ff60] transition-all glow-lime">
                Uložit změny
            </button>
        </form>
    </main>
</x-layout>
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
