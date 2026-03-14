<x-app-layout>

    {{-- Header --}}
    <div class="px-5 pt-12 pb-6 relative overflow-hidden bg-[#1E3A8A] hd-wobbly-lg mt-2 mx-2">
        <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full border-[24px] border-white/10 pointer-events-none"></div>
        <div class="absolute top-10 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none"></div>

        <div class="relative z-10">
            <h1 class="text-white text-xl font-extrabold">Direktori Anggota</h1>
            <p class="text-blue-200 text-sm mt-1">{{ $members->count() }} anggota terdaftar</p>
        </div>

        {{-- Search Bar --}}
        <div class="relative z-10 mt-4">
            <input
                type="text"
                id="search-input"
                placeholder="Cari nama atau NRA…"
                oninput="filterMembers(this.value)"
                class="w-full bg-white/20 backdrop-blur-sm text-white placeholder:text-blue-200 text-sm font-bold px-4 py-3 pl-10 hd-wobbly-md border border-white/20 focus:outline-none focus:bg-white/30 transition-all duration-200"
            >
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    {{-- Member List --}}
    <div class="px-5 py-4 space-y-3" id="member-list">

        @forelse($members as $member)
        <div
            class="member-card bg-white hd-card p-4 flex items-center gap-3 border-none"
            data-name="{{ strtolower($member->name) }}"
            data-nra="{{ strtolower($member->nra) }}"
        >
            {{-- Avatar --}}
            @if($member->avatar)
                <img src="{{ $member->avatar_url }}"
                     alt="{{ $member->name }}"
                     class="w-12 h-12 hd-wobbly-md object-cover flex-shrink-0 border border-hd-ink/10">
            @else
                <div class="w-12 h-12 bg-blue-50 hd-wobbly-md flex items-center justify-center flex-shrink-0 border border-hd-ink/10">
                    <span class="text-[#2563EB] font-extrabold text-base">
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    </span>
                </div>
            @endif

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <p class="text-[#1E3A8A] font-bold text-sm truncate">{{ $member->name }}</p>
                <p class="text-[#2563EB] font-mono text-xs mt-0.5">{{ $member->nra }}</p>
                <p class="text-gray-400 text-xs mt-0.5 truncate">{{ $member->address ?? '-' }}</p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2 flex-shrink-0">

                {{-- WhatsApp --}}
                @if($member->phone)
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $member->phone);
                    if (str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $waNumber }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-10 h-10 bg-green-50 hd-wobbly-md flex items-center justify-center active:scale-90 transition-transform duration-150 border border-hd-ink/5"
                   title="WhatsApp {{ $member->name }}">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
                @else
                <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center" title="Nomor tidak tersedia">
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                @endif

                {{-- Email --}}
                <a href="mailto:{{ $member->email }}"
                   class="w-10 h-10 bg-blue-50 hd-wobbly-md flex items-center justify-center active:scale-90 transition-transform duration-150 border border-hd-ink/5"
                   title="Email {{ $member->name }}">
                    <svg class="w-5 h-5 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </a>

            </div>
        </div>
        @empty
        <div class="flex flex-col items-center gap-3 py-16 text-center">
            <div class="w-16 h-16 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-3xl">👥</div>
            <p class="text-[#1E3A8A] font-semibold text-sm">Belum ada anggota</p>
            <p class="text-gray-400 text-xs">Anggota yang mendaftar akan tampil di sini.</p>
        </div>
        @endforelse

        {{-- Empty search state --}}
        <div id="empty-search" class="hidden flex-col items-center gap-3 py-16 text-center">
            <div class="w-16 h-16 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-3xl">🔍</div>
            <p class="text-[#1E3A8A] font-semibold text-sm">Anggota tidak ditemukan</p>
            <p class="text-gray-400 text-xs">Coba kata kunci lain.</p>
        </div>

    </div>

    @push('scripts')
    <script>
        function filterMembers(query) {
            const q = query.toLowerCase().trim();
            const cards = document.querySelectorAll('.member-card');
            let visible = 0;

            cards.forEach(card => {
                const name = card.dataset.name ?? '';
                const nra  = card.dataset.nra ?? '';
                const match = name.includes(q) || nra.includes(q);
                card.style.display = match ? 'flex' : 'none';
                if (match) visible++;
            });

            const emptySearch = document.getElementById('empty-search');
            emptySearch.style.display = visible === 0 ? 'flex' : 'none';
        }
    </script>
    @endpush

</x-app-layout>
