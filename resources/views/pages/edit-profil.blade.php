<x-app-layout>

    {{-- Cropper.js CSS --}}
    @push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    @endpush

    {{-- Header --}}
    <div class="px-5 pt-12 pb-6 bg-[#1E3A8A] hd-wobbly-lg mt-2 mx-2">
        <div class="flex items-center gap-3">
            <a href="{{ route('profil') }}"
               class="w-9 h-9 bg-white/20 hd-wobbly-md flex items-center justify-center active:scale-90 transition-transform duration-150 border border-transparent">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-white text-base font-bold leading-none">Edit Profil</h1>
                <p class="text-blue-200 text-xs mt-0.5">Perbarui data pribadi kamu</p>
            </div>
        </div>
    </div>

    <div class="px-5 py-5">

        {{-- Success Message --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-600 text-sm font-medium px-4 py-3 rounded-2xl mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="space-y-4" id="profile-form">
            @csrf
            @method('PUT')

            {{-- Input file tersembunyi untuk hasil crop (base64 → dikonversi di server) --}}
            <input type="hidden" name="avatar_cropped" id="avatar-cropped-input">

            {{-- Foto Profil --}}
            <div class="flex flex-col items-center gap-3 py-2">
                <div class="relative">
                    <div class="w-24 h-24 bg-blue-50 hd-wobbly-md flex items-center justify-center overflow-hidden border border-hd-ink/10" id="avatar-preview-wrapper">
                        @if($user->avatar)
                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div id="avatar-placeholder" class="flex flex-col items-center gap-1">
                                <svg class="w-7 h-7 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                                <span class="text-blue-300 text-[10px] font-medium">Foto</span>
                            </div>
                            <img id="avatar-preview" src="" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <label for="avatar-input"
                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-[#2563EB] hd-wobbly-md flex items-center justify-center cursor-pointer shadow-md active:scale-90 transition-transform border border-hd-ink/10">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                        </svg>
                    </label>
                </div>
                <input id="avatar-input" type="file" accept="image/*" class="hidden">
                <p class="text-gray-400 text-xs">Ketuk ikon kamera untuk ganti foto (maks. 2MB)</p>
                @error('avatar_cropped')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama --}}
            <div class="bg-white hd-card px-4 py-3 border-none">
                <label class="text-[#1E3A8A] text-xs font-bold uppercase tracking-wide mb-1.5 block">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full text-sm text-gray-700 font-bold placeholder-gray-300 border-0 outline-none focus:ring-0 p-0 bg-transparent"
                    required
                >
                @error('name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email (read only) --}}
            <div class="bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-gray-400 text-xs font-bold uppercase tracking-wide mb-1.5 block">Email</label>
                <input
                    type="email"
                    value="{{ $user->email }}"
                    class="w-full text-sm text-gray-400 font-medium border-0 outline-none focus:ring-0 p-0 bg-transparent cursor-not-allowed"
                    disabled
                >
                <p class="text-gray-300 text-[10px] mt-1">Email tidak dapat diubah</p>
            </div>

            {{-- NRA (read only) --}}
            <div class="bg-gray-50 border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-gray-400 text-xs font-bold uppercase tracking-wide mb-1.5 block">NRA</label>
                <input
                    type="text"
                    value="{{ $user->nra }}"
                    class="w-full text-sm text-gray-400 font-medium border-0 outline-none focus:ring-0 p-0 bg-transparent cursor-not-allowed"
                    disabled
                >
                <p class="text-gray-300 text-[10px] mt-1">NRA tidak dapat diubah</p>
            </div>

            {{-- No. HP --}}
            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-[#1E3A8A] text-xs font-bold uppercase tracking-wide mb-1.5 block">No. HP / WhatsApp</label>
                <input
                    type="tel"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    placeholder="Contoh: 08123456789"
                    class="w-full text-sm text-gray-700 font-medium placeholder-gray-300 border-0 outline-none focus:ring-0 p-0 bg-transparent"
                >
                @error('phone')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="bg-white border border-gray-100 rounded-2xl px-4 py-3 shadow-sm">
                <label class="text-[#1E3A8A] text-xs font-bold uppercase tracking-wide mb-1.5 block">Alamat</label>
                <textarea
                    name="address"
                    rows="3"
                    placeholder="Masukkan alamat lengkap kamu"
                    class="w-full text-sm text-gray-700 font-medium placeholder-gray-300 border-0 outline-none focus:ring-0 p-0 bg-transparent resize-none"
                >{{ old('address', $user->address) }}</textarea>
                @error('address')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <x-atoms.button
                type="submit"
                variant="primary"
                size="lg"
                :handdrawn="true"
                class="w-full mt-2"
            >
                Simpan Perubahan
            </x-atoms.button>

        </form>

    </div>

    @push('modals')
    {{-- ===== MODAL CROP ===== --}}
    <div id="crop-modal" class="fixed inset-0 z-[9999] hidden items-end justify-center">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="crop-backdrop"></div>

        {{-- Sheet --}}
        <div class="relative w-full max-w-md bg-white rounded-t-3xl shadow-2xl flex flex-col" style="height: 92vh;">

            {{-- Handle --}}
            <div class="w-10 h-1 bg-gray-200 rounded-full mx-auto mt-4 mb-3 flex-shrink-0"></div>

            {{-- Header --}}
            <div class="flex items-center justify-between px-5 pb-3 flex-shrink-0">
                <div>
                    <p class="text-[#1E3A8A] font-extrabold text-base">Atur Foto Profil</p>
                    <p class="text-gray-400 text-xs mt-0.5">Geser & cubit untuk mengatur posisi</p>
                </div>
                <button id="crop-cancel" class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center active:scale-90 transition-transform">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Cropper Area --}}
            <div class="flex-1 overflow-hidden mx-5 rounded-2xl bg-gray-900" style="min-height: 0;">
                <img id="crop-image" src="" alt="Crop" style="max-width:100%; display:block;">
            </div>

            {{-- Controls --}}
            <div class="flex items-center justify-center gap-4 px-5 py-3 flex-shrink-0">

                {{-- Rotate Left --}}
                <button type="button" id="btn-rotate-left"
                    class="w-11 h-11 bg-[#EFF6FF] rounded-xl flex items-center justify-center active:scale-90 transition-transform">
                    <svg class="w-5 h-5 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>
                    </svg>
                </button>

                {{-- Rotate Right --}}
                <button type="button" id="btn-rotate-right"
                    class="w-11 h-11 bg-[#EFF6FF] rounded-xl flex items-center justify-center active:scale-90 transition-transform">
                    <svg class="w-5 h-5 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3"/>
                    </svg>
                </button>

                {{-- Flip Horizontal --}}
                <button type="button" id="btn-flip-h"
                    class="w-11 h-11 bg-[#EFF6FF] rounded-xl flex items-center justify-center active:scale-90 transition-transform">
                    <svg class="w-5 h-5 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                </button>

                {{-- Reset --}}
                <button type="button" id="btn-reset"
                    class="w-11 h-11 bg-[#EFF6FF] rounded-xl flex items-center justify-center active:scale-90 transition-transform">
                    <svg class="w-5 h-5 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                </button>

            </div>

            {{-- Apply Button --}}
            <div class="px-5 pb-6 flex-shrink-0">
                <button type="button" id="btn-crop-apply"
                    class="w-full bg-[#2563EB] text-white font-bold text-sm py-4 rounded-2xl shadow-lg shadow-blue-200 active:scale-[0.98] transition-transform duration-150">
                    Gunakan Foto Ini
                </button>
            </div>

        </div>
    </div>
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
        let cropper = null;

        const avatarInput     = document.getElementById('avatar-input');
        const cropModal       = document.getElementById('crop-modal');
        const cropImage       = document.getElementById('crop-image');
        const cropCancel      = document.getElementById('crop-cancel');
        const cropBackdrop    = document.getElementById('crop-backdrop');
        const btnApply        = document.getElementById('btn-crop-apply');
        const btnRotateLeft   = document.getElementById('btn-rotate-left');
        const btnRotateRight  = document.getElementById('btn-rotate-right');
        const btnFlipH        = document.getElementById('btn-flip-h');
        const btnReset        = document.getElementById('btn-reset');
        const avatarPreview   = document.getElementById('avatar-preview');
        const avatarPlaceholder = document.getElementById('avatar-placeholder');
        const croppedInput    = document.getElementById('avatar-cropped-input');

        // Buka file picker
        avatarInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi ukuran (maks 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran foto maksimal 2MB.');
                avatarInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (ev) {
                cropImage.src = ev.target.result;
                openCropModal();
            };
            reader.readAsDataURL(file);

            // Reset input agar bisa pilih file yang sama lagi
            avatarInput.value = '';
        });

        const bottomNav = document.querySelector('nav.fixed.bottom-0');

        function openCropModal() {
            cropModal.classList.remove('hidden');
            cropModal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Sembunyikan bottom nav agar tidak menutupi modal
            if (bottomNav) bottomNav.style.display = 'none';

            // Destroy cropper lama jika ada
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            // Init Cropper.js
            setTimeout(() => {
                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.85,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    background: false,
                });
            }, 100);
        }

        function closeCropModal() {
            cropModal.classList.add('hidden');
            cropModal.classList.remove('flex');
            document.body.style.overflow = '';

            // Tampilkan kembali bottom nav
            if (bottomNav) bottomNav.style.display = '';

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        // Tutup modal
        cropCancel.addEventListener('click', closeCropModal);
        cropBackdrop.addEventListener('click', closeCropModal);

        // Kontrol cropper
        btnRotateLeft.addEventListener('click',  () => cropper?.rotate(-90));
        btnRotateRight.addEventListener('click', () => cropper?.rotate(90));
        btnReset.addEventListener('click',       () => cropper?.reset());
        btnFlipH.addEventListener('click', () => {
            if (!cropper) return;
            const data = cropper.getData();
            cropper.scaleX(data.scaleX === -1 ? 1 : -1);
        });

        // Terapkan hasil crop
        btnApply.addEventListener('click', function () {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            const base64 = canvas.toDataURL('image/jpeg', 0.85);

            // Simpan ke hidden input
            croppedInput.value = base64;

            // Tampilkan preview
            avatarPreview.src = base64;
            avatarPreview.classList.remove('hidden');
            if (avatarPlaceholder) avatarPlaceholder.classList.add('hidden');

            closeCropModal();
        });
    </script>
    @endpush

</x-app-layout>
