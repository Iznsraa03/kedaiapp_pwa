<x-app-layout>

    {{-- Toast global (Atom) --}}
    <x-atoms.toast />

    {{-- ===== HEADER ADMIN ===== --}}
    <div class="bg-[#1E3A8A] px-5 pt-12 pb-8 relative overflow-hidden rounded-b-[2rem]">
        <div class="absolute -top-6 -right-6 w-40 h-40 rounded-full border-[28px] border-white/10 pointer-events-none"></div>
        <div class="absolute top-12 -right-2 w-16 h-16 rounded-full border-[10px] border-white/10 pointer-events-none"></div>

        {{-- Back --}}
        <a href="{{ route('admin.activities.index') }}"
           class="relative z-10 inline-flex items-center gap-1.5 text-white/60 hover:text-white text-sm font-semibold mb-4 active:opacity-60 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kelola Kegiatan
        </a>

        {{-- Badge Admin --}}
        <div class="relative z-10 inline-flex items-center gap-1.5 bg-white/20 rounded-xl px-3 py-1.5 mb-3">
            <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-white text-xs font-bold tracking-wide">MODE ADMIN</span>
        </div>

        <div class="relative z-10 flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0">
                {{ $activity->emoji }}
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-white text-lg font-extrabold leading-snug">{{ $activity->title }}</h1>
                <p class="text-blue-200 text-xs mt-1">
                    {{ $activity->starts_at->translatedFormat('d F Y') }}
                    · {{ $activity->starts_at->format('H.i') }}–{{ $activity->ends_at->format('H.i') }} WIB
                </p>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="relative z-10 flex gap-4 mt-5">
            <div class="flex-1 bg-white/10 rounded-2xl px-4 py-3 text-center">
                <p class="text-white font-extrabold text-2xl" id="attendee-count">{{ $attendees->count() }}</p>
                <p class="text-blue-200 text-xs mt-0.5">Hadir</p>
            </div>
            <div class="flex-1 bg-white/10 rounded-2xl px-4 py-3 text-center">
                <p class="text-white font-extrabold text-2xl" id="late-count">{{ $attendees->where('status', 'late')->count() }}</p>
                <p class="text-blue-200 text-xs mt-0.5">Terlambat</p>
            </div>
            <div class="flex-1 bg-white/10 rounded-2xl px-4 py-3 text-center">
                <span class="inline-flex items-center px-2 py-1 rounded-xl text-[10px] font-bold
                    {{ $activity->status === 'open' ? 'bg-green-400/30 text-green-200' : 'bg-white/20 text-white/70' }}">
                    {{ $activity->badgeLabel() }}
                </span>
                <p class="text-blue-200 text-xs mt-1">Status</p>
            </div>
        </div>
    </div>

    {{-- ===== BODY ===== --}}
    <div class="px-5 py-5 space-y-5">

        {{-- ===== QR SCANNER ORGANISM ===== --}}
        <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 bg-[#EFF6FF] rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[#1E3A8A] font-bold text-sm">Scanner Presensi</p>
                    <p class="text-gray-400 text-xs">Scan QR Code anggota untuk mencatat kehadiran</p>
                </div>
            </div>

            <x-organisms.qr-scanner
                :activity-id="$activity->id"
                :scan-url="route('admin.activities.scan', $activity)"
            />
        </div>

        {{-- ===== DAFTAR PESERTA HADIR ===== --}}
        <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-[#EFF6FF] rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                    <p class="text-[#1E3A8A] font-bold text-sm">Peserta Hadir</p>
                </div>
                <span class="bg-[#EFF6FF] text-[#2563EB] text-xs font-bold px-3 py-1 rounded-xl" id="attendee-badge">
                    {{ $attendees->count() }} orang
                </span>
            </div>

            {{-- List Attendees --}}
            <div class="space-y-2" id="attendee-list"
                 x-data="attendeeList"
                 @attendee-added.window="addAttendee($event.detail.attendee)">

                @forelse($attendees as $att)
                <div class="attendee-item flex items-center gap-3 p-3 bg-gray-50 rounded-2xl">
                    <div class="w-9 h-9 bg-[#2563EB] rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-bold">{{ strtoupper(substr($att->user->name, 0, 2)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[#1E3A8A] font-semibold text-sm truncate">{{ $att->user->name }}</p>
                        <p class="text-gray-400 text-xs font-mono">{{ $att->user->nra }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="inline-block px-2 py-0.5 rounded-lg text-[10px] font-semibold
                            {{ $att->status === 'present' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }}">
                            {{ $att->status === 'present' ? 'Hadir' : 'Terlambat' }}
                        </span>
                        <p class="text-gray-300 text-[10px] mt-0.5">{{ $att->scanned_at->format('H:i') }}</p>
                    </div>
                </div>
                @empty
                <div id="empty-state" class="flex flex-col items-center gap-2 py-8 text-center">
                    <div class="w-14 h-14 bg-[#EFF6FF] rounded-3xl flex items-center justify-center text-2xl">👥</div>
                    <p class="text-gray-400 text-sm">Belum ada peserta yang hadir.</p>
                    <p class="text-gray-300 text-xs">Mulai scan untuk mencatat kehadiran.</p>
                </div>
                @endforelse

            </div>
        </div>

    </div>

    @push('scripts')
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('attendeeList', () => ({
                addAttendee(att) {
                    if (!att) return;

                    // Hapus empty state jika ada
                    const empty = document.getElementById('empty-state');
                    if (empty) empty.remove();

                    // Update counter Hadir
                    const hadirItems = document.querySelectorAll('.attendee-item').length + 1;
                    const badge    = document.getElementById('attendee-badge');
                    const countEl  = document.getElementById('attendee-count');
                    if (badge)   badge.textContent = hadirItems + ' orang';
                    if (countEl) countEl.textContent = hadirItems;

                    // Update counter Terlambat
                    const lateCountEl = document.getElementById('late-count');
                    if (lateCountEl && att.status === 'late') {
                        lateCountEl.textContent = parseInt(lateCountEl.textContent || '0') + 1;
                    }

                    // Buat elemen baru
                    const initials    = att.name.substring(0, 2).toUpperCase();
                    const statusClass = att.status === 'present'
                        ? 'bg-green-50 text-green-600'
                        : 'bg-yellow-50 text-yellow-600';
                    const statusLabel = att.status === 'present' ? 'Hadir' : 'Terlambat';

                    const el = document.createElement('div');
                    el.className = 'attendee-item flex items-center gap-3 p-3 bg-gray-50 rounded-2xl';
                    el.style.animation = 'fadeInUp 0.3s ease-out';
                    el.innerHTML = `
                        <div class="w-9 h-9 bg-[#2563EB] rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-xs font-bold">${initials}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[#1E3A8A] font-semibold text-sm truncate">${att.name}</p>
                            <p class="text-gray-400 text-xs font-mono">${att.nra}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block px-2 py-0.5 rounded-lg text-[10px] font-semibold ${statusClass}">${statusLabel}</span>
                            <p class="text-gray-300 text-[10px] mt-0.5">${att.scanned_at}</p>
                        </div>
                    `;

                    const list = document.getElementById('attendee-list');
                    list.prepend(el);
                }
            }));
        });
    </script>
    @endpush

</x-app-layout>
