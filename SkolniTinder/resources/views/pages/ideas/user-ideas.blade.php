<x-layout>
    <x-slot:title>Moje hlasování</x-slot:title>

    <main class="max-w-[1000px] mx-auto px-6 py-10 relative z-10">
        <div class="mb-10">
            <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-2">Historie</p>
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC]">
                Nápady, o kterých jsi <span class="text-[#C9F050]">rozhodoval</span>
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($votedIdeas as $idea)
                <div class="bg-[#1C1D2A]/60 backdrop-blur-md border border-[#2E3046] p-6 rounded-2xl relative overflow-hidden">

                    {{-- Malý štítek s tvým rozhodnutím v rohu --}}
                    <div class="absolute top-4 right-4">
                        @if($idea->pivot->choice === 'yes')
                            <span class="px-2.5 py-1 rounded-md text-xs font-black bg-[#C9F050]/10 text-[#C9F050] border border-[#C9F050]/20">DAl JSEM JO ✓</span>
                        @else
                            <span class="px-2.5 py-1 rounded-md text-xs font-black bg-[#FF6B52]/10 text-[#FF6B52] border border-[#FF6B52]/20">DAL JSEM NE ✗</span>
                        @endif
                    </div>

                    {{-- Název a popis nápadu --}}
                    <h3 class="font-display font-bold text-xl text-[#F2F1EC] pr-24 mb-3 leading-tight">
                        {{ $idea->title }}
                    </h3>
                    <p class="text-sm text-[#5C5F7A] leading-relaxed mb-4">
                        {{ $idea->description }}
                    </p>

                    <div class="border-t border-[#2E3046] pt-4 flex items-center justify-between text-xs text-[#5C5F7A]">
                        <span>Autor: <strong class="text-[#F2F1EC]">{{ $idea->user->name ?? 'Anonym' }}</strong></span>
                        <span>Odhlasováno: {{ $idea->pivot->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-[#1C1D2A]/20 border border-dashed border-[#2E3046] rounded-2xl">
                    <p class="text-sm text-[#5C5F7A]">Zatím jsi nehlasoval pro žádný nápad ze své školy.</p>
                    <a href="{{ route('voting') }}" class="mt-4 inline-flex text-xs uppercase tracking-widest font-bold text-[#C9F050] hover:underline">
                        Jít swipovat teď →
                    </a>
                </div>
            @endforelse
        </div>
    </main>
</x-layout>
