{{--
    Atom: Toast Notification
    Props: type (success|error|info), message
    Usage: <x-atoms.toast type="success" message="Berhasil!" />
    Or via Alpine event: window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: '...' } }))
--}}
<div
    x-data="toastManager()"
    x-on:toast.window="show($event.detail)"
    class="fixed top-4 left-1/2 -translate-x-1/2 z-[100] w-[calc(100%-2rem)] max-w-sm pointer-events-none"
    aria-live="polite"
>
    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-3 scale-95"
            class="pointer-events-auto mb-2"
        >
            <div
                :class="{
                    'bg-green-50 border-green-100': toast.type === 'success',
                    'bg-red-50 border-red-100':   toast.type === 'error',
                    'bg-blue-50 border-blue-100':  toast.type === 'info',
                }"
                class="flex items-center gap-3 border rounded-2xl px-4 py-3 shadow-lg"
            >
                {{-- Icon --}}
                <div
                    :class="{
                        'bg-green-100': toast.type === 'success',
                        'bg-red-100':   toast.type === 'error',
                        'bg-blue-100':  toast.type === 'info',
                    }"
                    class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                >
                    <template x-if="toast.type === 'success'">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'info'">
                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </template>
                </div>

                {{-- Message --}}
                <p
                    :class="{
                        'text-green-700': toast.type === 'success',
                        'text-red-600':   toast.type === 'error',
                        'text-blue-700':  toast.type === 'info',
                    }"
                    class="text-sm font-medium"
                    x-text="toast.message"
                ></p>
            </div>
        </div>
    </template>
</div>

<script>
    function toastManager() {
        return {
            toasts: [],
            show({ type = 'info', message = '' }) {
                const id = Date.now();
                this.toasts.push({ id, type, message, visible: true });
                setTimeout(() => {
                    const t = this.toasts.find(t => t.id === id);
                    if (t) t.visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                }, 3500);
            }
        }
    }
</script>
