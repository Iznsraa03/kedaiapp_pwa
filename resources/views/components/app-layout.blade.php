{{--
    app-layout: Root shell — delegates to templates/app-layout (Atomic Design).
    Komponen ini dipertahankan sebagai alias agar semua halaman tetap
    menggunakan <x-app-layout> tanpa perubahan.
--}}
<x-templates.app-layout>
    {{ $slot }}
</x-templates.app-layout>
