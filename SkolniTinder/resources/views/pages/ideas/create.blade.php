<x-layout>
    <x-slot:title>
        Nový nápad
    </x-slot:title>

    {{-- Zachování tvého vizuálního stylu (Noise + Glow) --}}
    <div class="fixed inset-0 pointer-events-none z-0 opacity-[0.04]"
         style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.75%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22300%22 height=%22300%22 filter=%22url(%23n)%22/%3E%3C/svg%3E')">
    </div>
    <div class="fixed top-0 right-0 w-[600px] h-[400px] rounded-full bg-[#C9F050]/[0.04] blur-[160px] pointer-events-none z-0"></div>

    <main class="relative z-10 max-w-[800px] mx-auto px-6 py-10">

        {{-- Tlačítko Zpět --}}
        <div class="mb-6 fade-up">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs text-[#5C5F7A] hover:text-[#C9F050] uppercase tracking-widest transition-colors font-bold">
                <i class="fa-solid fa-arrow-left"></i> Zpět na přehled
            </a>
        </div>

        {{-- Hlavička stránky --}}
        <div class="mb-10 fade-up">
            <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-2">Co máš na srdci?</p>
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC]">
                Vytvořit nový nápad pro <span class="text-[#C9F050]">{{ $school->name }}</span>
            </h1>
        </div>

        {{-- Formulářová karta --}}
        <div class="bg-[#1C1D2A]/60 backdrop-blur-md border border-[#2E3046] p-8 rounded-2xl shadow-2xl fade-up-2">
            <form action="{{ route('ideas.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Pole: Název nápadu --}}
                <div>
                    <label for="title" class="block text-xs text-[#5C5F7A] uppercase tracking-widest font-bold mb-2">
                        Název nápadu / Myšlenky
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           placeholder="Např. Gauče na chodby, Turnaj v ping-pongu..." autocomplete="off"
                           class="w-full bg-[#13141F]/80 border border-[#2E3046] rounded-xl px-4 py-3 text-[#F2F1EC] placeholder-[#5C5F7A] outline-none focus:border-[#C9F050]/50 focus:ring-1 focus:ring-[#C9F050]/30 transition-all">
                    @error('title')
                    <p class="mt-2 text-xs text-[#FF6B52] font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NOVÉ POLE: Výběr kategorie --}}
                <div>
                    <label class="block text-xs text-[#5C5F7A] uppercase tracking-widest font-bold mb-2">
                        Vyber kategorii nápadu
                    </label>
                    <input type="hidden" name="category" id="categoryInput" value="{{ old('category', 'Prostředí') }}">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        {{-- Karta: Prostředí --}}
                        <button type="button" onclick="selectCategory('Prostředí')" id="cat-Prostředí"
                                class="cat-card p-4 rounded-xl border text-left transition-all bg-[#13141F]/40 border-[#C9F050]/40 text-[#C9F050]">
                            <div class="font-bold text-sm mb-1">🌱 Prostředí</div>
                            <div class="text-[11px] text-[#5C5F7A] leading-tight">Chodby, učebny, odpočinkové zóny...</div>
                        </button>

                        {{-- Karta: Technika --}}
                        <button type="button" onclick="selectCategory('Technika')" id="cat-Technika"
                                class="cat-card p-4 rounded-xl border text-left transition-all bg-[#13141F]/40 border-[#2E3046] text-[#F2F1EC] hover:border-[#7eb6ff]/40">
                            <div class="font-bold text-sm mb-1">💻 Technika</div>
                            <div class="text-[11px] text-[#5C5F7A] leading-tight">Wi-Fi, počítače, nabíječky, software...</div>
                        </button>

                        {{-- Karta: Komunita --}}
                        <button type="button" onclick="selectCategory('Komunita')" id="cat-Komunita"
                                class="cat-card p-4 rounded-xl border text-left transition-all bg-[#13141F]/40 border-[#2E3046] text-[#F2F1EC] hover:border-[#FF6B52]/40">
                            <div class="font-bold text-sm mb-1">🤝 Komunita</div>
                            <div class="text-[11px] text-[#5C5F7A] leading-tight">Akce, turnaje, kroužky, doučování...</div>
                        </button>
                    </div>
                    @error('category')
                    <p class="mt-2 text-xs text-[#FF6B52] font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pole: Popis nápadu --}}
                <div>
                    <label for="description" class="block text-xs text-[#5C5F7A] uppercase tracking-widest font-bold mb-2">
                        Detailní popis
                    </label>
                    <textarea name="description" id="description" rows="6"
                              placeholder="Rozepiš svůj nápad podrobněji. Proč by to měla škola udělat? Co to přinese studentům?"
                              class="w-full bg-[#13141F]/80 border border-[#2E3046] rounded-xl px-4 py-3 text-[#F2F1EC] placeholder-[#5C5F7A] outline-none focus:border-[#C9F050]/50 focus:ring-1 focus:ring-[#C9F050]/30 transition-all resize-none">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-xs text-[#FF6B52] font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Informační banner v designu školy --}}
                <div class="p-4 rounded-xl bg-[#2E3046]/20 border border-[#2E3046] flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-[#7eb6ff] mt-0.5"></i>
                    <p class="text-xs text-[#5C5F7A] leading-relaxed">
                        Tvůj nápad bude zveřejněn v rámci školy <span class="text-[#F2F1EC] font-bold">{{ $school->name }}</span>. Ostatní studenti a učitelé budou moci pro tvůj nápad hlasovat systémem swipování (Tinder style).
                    </p>
                </div>

                {{-- Tlačítko pro odeslání --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-4 bg-[#C9F050] text-black font-display font-black text-xs uppercase tracking-widest rounded-xl hover:bg-[#b0d440] shadow-[0_20px_40px_rgba(201,240,80,0.1)] hover:shadow-[0_20px_40px_rgba(201,240,80,0.2)] active:scale-[0.99] transition-all flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                        Odeslat nápad ke schválení
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script>
        // Jednoduchý JS přepínač karet kategorií pro formulář
        function selectCategory(category) {
            // Resetujeme styl všech tlačítek
            document.querySelectorAll('.cat-card').forEach(btn => {
                btn.classList.remove('border-[#C9F050]/40', 'text-[#C9F050]', 'border-[#7eb6ff]/40', 'border-[#FF6B52]/40');
                btn.classList.add('border-[#2E3046]', 'text-[#F2F1EC]');
            });

            // Nastavíme skrytý input
            document.getElementById('categoryInput').value = category;

            // Oobarvíme aktivní kartu podle jejího zaměření
            const activeCard = document.getElementById('cat-' + category);
            activeCard.classList.remove('border-[#2E3046]', 'text-[#F2F1EC]');

            if (category === 'Prostředí') activeCard.classList.add('border-[#C9F050]/40', 'text-[#C9F050]');
            if (category === 'Technika') activeCard.classList.add('border-[#7eb6ff]/40', 'text-[#7eb6ff]');
            if (category === 'Komunita') activeCard.classList.add('border-[#FF6B52]/40', 'text-[#FF6B52]');
        }

        // Inicializace staré hodnoty (pokud se formulář vrátil s chybou validace)
        window.addEventListener('DOMContentLoaded', () => {
            selectCategory(document.getElementById('categoryInput').value);
        });
    </script>
</x-layout>
