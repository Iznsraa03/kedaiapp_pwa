<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display — {{ $activity->title }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(40px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes pulseRing {
            0%   { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(2); opacity: 0; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        .slide-in-up { animation: slideInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .fade-in     { animation: fadeIn 0.5s ease both; }
        .pulse-dot::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 9999px;
            background: #4ade80;
            opacity: 0.5;
            animation: pulseRing 1.5s ease-out infinite;
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-dark {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
    </style>
</head>
<body class="bg-primary min-h-screen overflow-hidden font-sans select-none p-16">

    {{-- Background blobs --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-[500px] h-[500px] bg-[#1E3A8A]/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-blue-400/10 rounded-full blur-3xl"></div>
    </div>

    @php
        $lastScan = $activity->attendances()->with('user')->latest('scanned_at')->first();
    @endphp

    <div class="relative z-10 flex flex-col h-screen pr-12 pl-12 py-8 gap-3">

        {{-- ===== HEADER ===== --}}
        <div class="flex items-center justify-between fade-in">

            {{-- Logo & Brand --}}
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center">
                    <img src="/logo/KDCW.png" alt="KeDai" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <p class="text-white font-extrabold text-base leading-tight">KeDai Computerworks</p>
                    <p class="text-blue-200 text-xs">Management System</p>
                </div>
            </div>

            {{-- Live Badge + Clock --}}
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 glass px-4 py-2 rounded-2xl">
                    <div class="relative w-2.5 h-2.5 flex-shrink-0">
                        <div class="pulse-dot"></div>
                        <div class="w-2.5 h-2.5 bg-green-400 rounded-full relative z-10"></div>
                    </div>
                    <span class="text-green-300 text-sm font-bold tracking-wide">LIVE Presensi</span>
                </div>
                <div class="text-right">
                    <p id="clock" class="text-white font-mono text-3xl font-extrabold tracking-wider"></p>
                    <p id="date" class="text-blue-200 text-xs mt-0.5"></p>
                </div>
            </div>
        </div>

        {{-- ===== WELCOME TITLE ===== --}}
        <div class="text-center fade-in pb-12">
            <p class="text-blue-200 text-sm font-bold tracking-[0.3em] uppercase mb-2">Selamat Datang di</p>
            <h1 class="text-white font-extrabold text-4xl xl:text-5xl leading-tight drop-shadow-sm">
                {{ $activity->emoji ? $activity->emoji . ' ' : '' }}{{ $activity->title }}
            </h1>
            @if($activity->location)
            <p class="text-blue-200 text-base mt-2 flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $activity->location }}
            </p>
            @endif
        </div>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex flex-12 gap-3 min-h-6 mt-10">

            {{-- LEFT: Last Scan Big Display --}}
            <div class="flex-1 glass rounded-3xl flex flex-col items-center justify-center p-10">
                <div id="scan-result" class="flex flex-col items-center gap-6 w-full slide-in-up">

                    <!-- {{-- Avatar --}}
                    <div class="w-40 h-40 rounded-full bg-white/20 border-4 border-white/40 flex items-center justify-center shadow-2xl">
                        <span id="scan-initials" class="text-white font-black text-7xl drop-shadow">
                            {{ $lastScan ? strtoupper(substr($lastScan->user->name, 0, 2)) : '?' }}
                        </span>
                    </div> -->

                    {{-- Name & NRA --}}
                    <div class="text-center">
                        <h2 id="scan-name" class="text-white font-black text-9xl xl:text-9xl drop-shadow">
                            {{ $lastScan ? $lastScan->user->name : '—' }}
                        </h2>
                        <p id="scan-nra" class="text-blue-200 font-mono text-2xl tracking-widest mt-3">
                            {{ $lastScan ? $lastScan->user->nra : '' }}
                        </p>
                    </div>

                    {{-- Status badge --}}
                    <div id="scan-status-badge"
                        @if($lastScan)
                            class="px-8 py-3 rounded-2xl text-base font-bold {{ $lastScan->status === 'present' ? 'bg-green-400/20 text-green-300' : 'bg-yellow-400/20 text-yellow-300 ' }}"
                        @else
                            class="px-8 py-3 rounded-2xl text-base font-bold"
                        @endif
                    >
                        @if($lastScan)
                            {{ $lastScan->status === 'present' ? 'Hadir' : 'Terlambat' }}
                        @endif
                    </div>

                    {{-- Time --}}
                    <p id="scan-time" class="text-white/60 text-sm font-mono">
                        {{ $lastScan ? 'Scan pada ' . $lastScan->scanned_at->format('H:i:s') : '' }}
                    </p>
                </div>
            </div>

            {{-- Divider --}}
            <div class="w-px bg-white/15 self-stretch"></div>

            {{-- RIGHT: Attendee List --}}
            <div class="w-80 xl:w-96 flex flex-col gap-4 min-h-0">

                {{-- Stats --}}
                    <div class="glass rounded-2xl px-4 py-3 text-center">
                        <p id="attendee-count" class="text-white font-extrabold text-3xl">{{ $activity->attendances()->count() }}</p>
                        <p class="text-blue-200 text-xs mt-0.5">Hadir</p>
                    </div>

                {{-- List header --}}
                <div class="flex items-center justify-between px-1">
                    <p class="text-white font-bold text-sm">Peserta Terbaru</p>
                    <span id="total-count" class="bg-white/10 text-blue-100 text-xs font-bold px-3 py-1 rounded-xl">
                        {{ $activity->attendances()->count() }} orang
                    </span>
                </div>

                {{-- List --}}
                <div id="attendee-list" class="flex flex-col gap-2 overflow-y-auto flex-1 pr-1 scrollbar-hide">
                    @forelse($activity->attendances()->with('user')->latest('scanned_at')->take(10)->get() as $att)
                    <div class="attendee-card glass-dark flex items-center gap-3 rounded-2xl px-4 py-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                            <span class="text-white text-sm font-bold">{{ strtoupper(substr($att->user->name, 0, 2)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-semibold text-sm truncate">{{ $att->user->name }}</p>
                            <p class="text-blue-200 font-mono text-xs">{{ $att->user->nra }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-[10px] font-semibold px-2 py-1 rounded-lg {{ $att->status === 'present' ? 'bg-green-400/20 text-green-300' : 'bg-yellow-400/20 text-yellow-300' }}">
                                {{ $att->status === 'present' ? 'Hadir' : 'Terlambat' }}
                            </span>
                            <p class="text-blue-300/50 text-[10px] mt-0.5 font-mono">{{ $att->scanned_at->format('H:i:s') }}</p>
                        </div>
                    </div>
                    @empty
                    <div id="empty-state" class="flex flex-col items-center gap-2 py-10 text-center">
                        <div class="w-14 h-14 bg-white/10 rounded-3xl flex items-center justify-center text-2xl">👥</div>
                        <p class="text-blue-200/50 text-sm">Belum ada peserta hadir.</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>

        <!-- {{-- ===== FOOTER ===== --}}
        <div class="flex items-center justify-center">
            <p class="text-blue-300/40 text-xs tracking-widest uppercase">
                {{ $activity->starts_at->translatedFormat('d F Y') }}
                @if($activity->ends_at)
                &mdash; {{ $activity->starts_at->format('H:i') }}–{{ $activity->ends_at->format('H:i') }} WIB
                @endif
            </p>
        </div> -->

    </div>

    <script>
        // === Clock ===
        function updateClock() {
            const now  = new Date();
            const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const date = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('clock').textContent = time;
            document.getElementById('date').textContent  = date;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // === Polling ===
        let lastTimestamp = {{ $lastScan ? $lastScan->scanned_at->timestamp : 0 }};

        function poll() {
            fetch('{{ route('admin.activities.stream', $activity) }}')
                .then(r => r.json())
                .then(data => {
                    // Update counters
                    document.getElementById('attendee-count').textContent = data.total;
                    document.getElementById('late-count').textContent     = data.late;
                    document.getElementById('total-count').textContent    = data.total + ' orang';

                    // Tampilkan jika ada scan baru
                    if (data.attendee && data.timestamp && data.timestamp > lastTimestamp) {
                        lastTimestamp = data.timestamp;
                        showLastScan(data.attendee);
                        prependAttendee(data.attendee);
                    }
                })
                .catch(() => {});
        }

        // Poll setiap 2 detik
        setInterval(poll, 2000);

        function showLastScan(att) {
            const result = document.getElementById('scan-result');

            // Reset animasi
            result.classList.remove('slide-in-up');
            void result.offsetWidth;
            result.classList.add('slide-in-up');

            document.getElementById('scan-initials').textContent = att.name.substring(0, 2).toUpperCase();
            document.getElementById('scan-name').textContent     = att.name;
            document.getElementById('scan-nra').textContent      = att.nra;
            document.getElementById('scan-time').textContent     = 'Scan pada ' + att.scanned_at;

            const badge = document.getElementById('scan-status-badge');
            if (att.status === 'present') {
                badge.textContent = '✅ Hadir';
                badge.className   = 'px-8 py-3 rounded-2xl text-base font-bold bg-green-400/20 text-green-300 border border-green-400/30';
            } else {
                badge.textContent = '⚠️ Terlambat';
                badge.className   = 'px-8 py-3 rounded-2xl text-base font-bold bg-yellow-400/20 text-yellow-300 border border-yellow-400/30';
            }
        }

        function prependAttendee(att) {
            const list  = document.getElementById('attendee-list');
            const empty = document.getElementById('empty-state');
            if (empty) empty.remove();

            const statusClass = att.status === 'present' ? 'bg-green-400/20 text-green-300' : 'bg-yellow-400/20 text-yellow-300';
            const statusLabel = att.status === 'present' ? 'Hadir' : 'Terlambat';
            const initials    = att.name.substring(0, 2).toUpperCase();

            const card = document.createElement('div');
            card.className = 'attendee-card glass-dark slide-in-up flex items-center gap-3 rounded-2xl px-4 py-3';
            card.innerHTML = `
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <span class="text-white text-sm font-bold">${initials}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-semibold text-sm truncate">${att.name}</p>
                    <p class="text-blue-200 font-mono text-xs">${att.nra}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <span class="text-[10px] font-semibold px-2 py-1 rounded-lg ${statusClass}">${statusLabel}</span>
                    <p class="text-blue-300/50 text-[10px] mt-0.5 font-mono">${att.scanned_at}</p>
                </div>
            `;

            list.prepend(card);

            // Batasi 10 item
            const cards = list.querySelectorAll('.attendee-card');
            if (cards.length > 10) cards[cards.length - 1].remove();
        }
    </script>

</body>
</html>
