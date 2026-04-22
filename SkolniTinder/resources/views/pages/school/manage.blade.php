<x-layout>
    <x-slot:title>
        Správa školy
    </x-slot:title>

    {{-- Zachování tvého vizuálního stylu (Noise + Glow) --}}
    <div class="fixed inset-0 pointer-events-none z-0 opacity-[0.04]"
         style="background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.75%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22300%22 height=%22300%22 filter=%22url(%23n)%22/%3E%3C/svg%3E')">
    </div>
    <div class="fixed top-0 right-0 w-[600px] h-[400px] rounded-full bg-[#C9F050]/[0.04] blur-[160px] pointer-events-none z-0"></div>

    <main class="relative z-10 max-w-[1300px] mx-auto px-6 lg:px-12 py-10">

        {{-- Hlavička stránky --}}
        <div class="mb-10 fade-up">
            <p class="text-xs text-[#5C5F7A] uppercase tracking-widest mb-2">Administrace</p>
            <h1 class="font-display font-extrabold text-3xl text-[#F2F1EC]">
                Správa školy <span class="text-[#C9F050]">{{ $school->name }}</span>
            </h1>
        </div>

        {{-- Tabulka členů ve stejném stylu jako "Idea cards" --}}
        <div class="bg-[#1C1D2A]/60 backdrop-blur-md border border-[#2E3046] rounded-2xl overflow-hidden shadow-2xl fade-up-2">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="bg-[#2E3046]/30 text-[#5C5F7A] text-xs uppercase tracking-widest">
                    <th class="px-6 py-5 font-semibold">Uživatel</th>
                    <th class="px-6 py-5 font-semibold">Role</th>
                    <th class="px-6 py-5 font-semibold text-center">Status</th>
                    <th class="px-6 py-5 font-semibold text-right">Akce</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-[#2E3046]">
                @foreach($members as $member)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-[#F2F1EC] text-base">{{ $member->name }}</div>
                            <div class="text-xs text-[#5C5F7A]">{{ $member->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[0.7rem] font-medium
                                {{ $member->role === 'admin' ? 'bg-[#C9F050]/10 text-[#C9F050]' : 'bg-[#7eb6ff]/10 text-[#7eb6ff]' }}">
                                {{ strtoupper($member->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($member->accepted === 'accepted')
                                <span class="text-[#C9F050] text-sm font-bold">Schválen</span>
                            @elseif($member->accepted === 'wait')
                                <span class="text-yellow-500 text-sm">Čeká</span>
                            @else
                                <span class="text-[#FF6B52] text-sm">Zamítnut</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($member->id !== auth()->id())
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('user.update-status', $member->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="accepted">
                                        <button class="px-3 py-1.5 rounded-lg border border-[#2E3046] text-xs font-bold text-[#F2F1EC] hover:border-[#C9F050]/40 hover:text-[#C9F050] transition-all">Schválit</button>
                                    </form>
                                    <form action="{{ route('user.update-status', $member->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="canceled">
                                        <button class="px-3 py-1.5 rounded-lg border border-[#2E3046] text-xs font-bold text-[#F2F1EC] hover:border-[#FF6B52]/40 hover:text-[#FF6B52] transition-all">Zamítnout</button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
</x-layout>
