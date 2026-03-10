import './bootstrap';
import { registerSW } from 'virtual:pwa-register';
import { Html5Qrcode, Html5QrcodeSupportedFormats } from 'html5-qrcode';

// Register Service Worker
registerSW({ immediate: true });

// Daftarkan qrScannerOrg ke Alpine SEBELUM Alpine init
document.addEventListener('alpine:init', () => {
    Alpine.data('qrScannerOrg', (scanUrl, activityId) => ({
        scanning:   false,
        processing: false,
        lastResult: null,
        _scanner:   null,
        _started:   false,

        _getScanner() {
            if (!this._scanner) {
                this._scanner = new Html5Qrcode('qr-reader-admin', {
                    formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
                    verbose: false,
                });
            }
            return this._scanner;
        },

        async toggleScanner() {
            this.scanning ? await this.stopScanner() : await this.startScanner();
        },

        // Polyfill getUserMedia untuk browser lama
        _getUserMedia() {
            return navigator.mediaDevices?.getUserMedia
                || navigator.getUserMedia?.bind(navigator)
                || navigator.webkitGetUserMedia?.bind(navigator)
                || navigator.mozGetUserMedia?.bind(navigator)
                || null;
        },

        async startScanner() {
            this.lastResult = null;

            // 1. Tampilkan viewport dulu sebelum scanner.start()
            this.scanning = true;
            await this.$nextTick();
            await new Promise(r => setTimeout(r, 200));

            const scanner = this._getScanner();
            const gum     = this._getUserMedia();

            // 2. Cek support
            if (!gum) {
                this.scanning = false;
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', message: 'Browser kamu tidak mendukung kamera. Coba gunakan Chrome atau Firefox.' }
                }));
                return;
            }

            // 3. Strategi: coba 3 constraint dari yang paling spesifik ke paling generik
            const strategies = [
                { facingMode: { exact: 'environment' } }, // kamera belakang persis
                { facingMode: 'environment' },             // kamera belakang preferred
                { facingMode: 'user' },                    // kamera depan fallback
                true,                                      // kamera apapun yang ada
            ];

            const scanConfig = {
                fps: 10,
                qrbox: (w, h) => {
                    const s = Math.max(Math.min(w, h) * 0.70, 50);
                    return { width: Math.floor(s), height: Math.floor(s) };
                },
            };

            for (const constraint of strategies) {
                try {
                    // Test apakah constraint ini berhasil dapat stream
                    await new Promise((resolve, reject) => {
                        const videoConstraint = constraint === true
                            ? { video: true }
                            : { video: constraint };

                        const success = (stream) => {
                            stream.getTracks().forEach(t => t.stop());
                            resolve();
                        };
                        const fail = (err) => reject(err);

                        if (navigator.mediaDevices?.getUserMedia) {
                            navigator.mediaDevices.getUserMedia(videoConstraint).then(success).catch(fail);
                        } else {
                            gum(videoConstraint, success, fail);
                        }
                    });

                    // Constraint berhasil — start scanner dengan constraint ini
                    await scanner.start(
                        constraint === true
                            ? { facingMode: 'environment' }
                            : constraint,
                        scanConfig,
                        (decoded) => this.onScanSuccess(decoded),
                        () => {}
                    );

                    this._started = true;
                    return; // sukses, keluar dari loop

                } catch (err) {
                    console.warn('[QrScanner] Strategy failed:', constraint, err.name);

                    // Jika NotAllowed — tidak perlu coba strategi lain
                    if (err.name === 'NotAllowedError' || err.name === 'SecurityError') {
                        this.scanning = false;
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: { type: 'error', message: 'Izin kamera ditolak. Buka Pengaturan → Safari/Chrome → Kamera → Izinkan.' }
                        }));
                        return;
                    }

                    // Jika ini strategi terakhir dan masih gagal
                    if (constraint === true) {
                        this.scanning = false;
                        let msg = 'Tidak dapat membuka kamera.';
                        if (err.name === 'NotFoundError')    msg = 'Kamera tidak ditemukan di perangkat ini.';
                        if (err.name === 'NotReadableError') msg = 'Kamera sedang digunakan aplikasi lain. Tutup aplikasi lain lalu coba lagi.';
                        if (err.name === 'AbortError')       msg = 'Kamera dibatalkan. Coba lagi.';
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: { type: 'error', message: msg }
                        }));
                        return;
                    }
                    // Lanjut ke strategi berikutnya
                }
            }
        },

        async stopScanner() {
            if (this._scanner && this._started) {
                try { await this._scanner.stop(); } catch (_) {}
                this._started = false;
            }
            this.scanning = false;
        },

        async onScanSuccess(nra) {
            if (this.processing) return;
            this.processing = true;
            try { this._scanner.pause(true); } catch (_) {}

            try {
                const res  = await fetch(scanUrl, {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        'Accept':       'application/json',
                    },
                    body: JSON.stringify({ nra, activity_id: activityId }),
                });
                const data = await res.json();
                this.lastResult = data;

                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: data.success ? 'success' : 'error', message: data.message }
                }));

                if (data.success) {
                    window.dispatchEvent(new CustomEvent('attendee-added', { detail: data }));
                }
            } catch {
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', message: 'Terjadi kesalahan jaringan.' }
                }));
            } finally {
                this.processing = false;
                setTimeout(() => { try { this._scanner.resume(); } catch (_) {} }, 2000);
            }
        },

        destroy() { this.stopScanner(); },
    }));
});
