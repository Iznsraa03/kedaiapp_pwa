# 🧊 KeDai Computerworks PWA
[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![PWA Ready](https://img.shields.io/badge/PWA-Ready-000000?style=for-the-badge&logo=pwa)](https://web.dev/pwa/)

**KeDai Computerworks Management System** adalah aplikasi Progressive Web App (PWA) yang dirancang khusus untuk manajemen kegiatan dan presensi anggota dengan pendekatan *mobile-first native feel*.

---

## ✨ Fitur Unggulan

- **📱 Mobile-First PWA:** Pengalaman aplikasi native langsung dari browser. Mendukung instalasi layar utama (Add to Home Screen) dengan panduan khusus iOS.
- **🛡️ Secure QR Attendance:** Sistem presensi anti-curang menggunakan hash HMAC-SHA256 yang unik per user, per kegiatan, dan memiliki masa berlaku (TTL) 5 menit.
- **🎨 Atomic Design System:** Arsitektur frontend yang terstruktur mulai dari *Atoms* hingga *Pages* untuk konsistensi UI maksimal.
- **📸 Activity Management:** Admin dapat mengelola kegiatan lengkap dengan upload thumbnail, lokasi, dan penjadwalan.
- **🎭 Dual Interface:** Dashboard modern untuk anggota dan Mode Admin khusus untuk pemindaian presensi di lokasi.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Tailwind CSS 4, Alpine.js, Blade Components
- **Database:** MySQL / SQLite
- **Security:** HMAC-SHA256 Tokenization
- **PWA Tooling:** Vite PWA Plugin

---

## 🚀 Panduan Instalasi

### 1. Kloning Repositori
```bash
git clone https://github.com/username/kedaiapp_pwa.git
cd kedaiapp_pwa
```

### 2. Instalasi Dependensi
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database & Storage
```bash
php artisan migrate --seed
php artisan storage:link
```

### 5. Menjalankan Aplikasi
```bash
npm run dev
# Buka terminal baru
php artisan serve
```

---

## 📂 Struktur Proyek (Atomic Design)

Aplikasi ini menggunakan struktur komponen hirarkis di `resources/views/components/`:

- **Atoms:** Komponen terkecil (Button, Badge, Input).
- **Molecules:** Gabungan atoms (Form Field, Card Header).
- **Organisms:** Bagian fungsional utuh (Bottom Nav, QR Scanner).
- **Templates:** Layout kerangka halaman (App Layout Shell).
- **Pages:** Implementasi data riil dalam halaman (`resources/views/pages/`).

---

## 🔒 Skema Keamanan QR

QR Code yang dihasilkan bersifat dinamis dengan logika:
1. Menggabungkan `UserID + ActivityID + Timestamp`.
2. Di-hash menggunakan `HMAC-SHA256` dengan kunci unik aplikasi.
3. Divalidasi oleh scanner admin untuk memastikan integritas data dan waktu (berlaku 5 menit).

---

## 🎨 Palet Warna & Identitas

| Nama | Hex Code | Penggunaan |
| :--- | :--- | :--- |
| **Primary Blue** | `#2563EB` | Tombol Utama, Ikon Aktif, Header |
| **Navy Blue** | `#1E3A8A` | Teks Utama, Branding, QR Header |
| **Soft Blue** | `#EFF6FF` | Background Section, Input Field |
| **White** | `#FFFFFF` | Background Utama |

---

## 📝 Lisensi

Proyek ini dibangun untuk internal **KeDai Computerworks** dan dilisensikan di bawah [MIT License](LICENSE).

---
<p align="center">
  Dibuat dengan ❤️ oleh <b>KeDai Computerworks Team</b>
</p>
