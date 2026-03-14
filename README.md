# 📦 KedaiApp - KeDai Computerworks

> **KedaiApp** adalah Progressive Web Application (PWA) yang dirancang untuk manajemen internal organisasi di **KeDai Computerworks**. Aplikasi ini berfokus pada keterlibatan anggota melalui berbagi berita dan pelacakan presensi yang efisien menggunakan kode QR.

---

## 🚀 Fitur Utama

-   **📱 Progressive Web App (PWA)**: Dapat diinstal di smartphone Anda dengan pengalaman seperti aplikasi native dan waktu muat yang cepat.
-   **🏢 Direktori Anggota**: Database terpusat untuk profil anggota, informasi kontak, dan peran.
-   **📅 Manajemen Kegiatan**: Penyelenggara dapat membuat acara, mengelola jadwal, dan melacak kehadiran.
-   **🎫 Sistem Presensi QR**: 
    -   Pembuatan token QR yang aman untuk anggota.
    -   Pemindaian presensi real-time untuk penyelenggara acara.
-   **📰 Berbagi Berita**: Platform berita internal untuk pembaruan dan pengumuman terbaru.
-   **💎 Pro Max Admin UI**: Dashboard desktop dengan kepadatan tinggi untuk administrator agar dapat mengelola segalanya dengan efisien.

---

## 🛠 Tech Stack

-   **Core**: [Laravel 12+](https://laravel.com)
-   **Backend**: PHP 8.2 / 8.3
-   **Frontend**: 
    -   [Tailwind CSS v4](https://tailwindcss.com) (Styling Modern Berperforma Tinggi)
    -   [Alpine.js](https://alpinejs.dev) (JavaScript Ringan)
    -   [Livewire](https://livewire.laravel.com) (UI Dinamis tetap di dalam PHP)
-   **Build Tool**: [Vite](https://vitejs.dev)
-   **Konektivitas**: 
    -   `html5-qrcode` untuk pemindaian kamera.
    -   `simplesoftwareio/simple-qrcode` untuk pembuatan QR yang aman.

---

## ⚙️ Persiapan Pengembangan

### 1. Persyaratan
-   PHP >= 8.2
-   Node.js & NPM
-   Composer
-   SQLite (Default) atau MySQL

### 2. Instalasi

```bash
# Clone repositori
git clone <repository-url>
cd KeDai-pwa

# Jalankan skrip pengaturan otomatis
composer run setup
```

### 3. Pengembangan Lokal

Jalankan server pengembangan, pendengar antrean, dan compiler Vite secara bersamaan:
```bash
composer run dev
```

### 4. Akses Admin
Kredensial admin default (jika sudah di-seed):
-   **Email**: `admin@kedai.com`
-   **Password**: `password`

---

## 🎨 Bahasa Desain

Aplikasi ini menggunakan standar **KeDai "Pro Max" UI**:
-   **Palet Biru yang Vibrant**: Terinspirasi oleh antarmuka digital modern.
-   **Layout Berbasis Kartu**: Untuk keterbacaan dan kepadatan informasi yang tinggi.
-   **Mikro-animasi Interaktif**: Meningkatkan pengalaman pengguna baik di desktop maupun mobile.

---

&copy; 2026 **KeDai Computerworks**. Dibuat dengan ❤️ dan Laravel.
