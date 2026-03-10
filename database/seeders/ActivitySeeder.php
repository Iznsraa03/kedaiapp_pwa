<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'uuid'        => (string) Str::uuid(),
                'title'       => 'Gathering Anggota 2025',
                'description' => 'Acara gathering tahunan seluruh anggota. Diisi dengan berbagai sesi sharing, games, dan penghargaan anggota terbaik.',
                'location'    => 'Aula Utama Gedung A',
                'starts_at'   => now()->addDays(8)->setTime(9, 0),
                'ends_at'     => now()->addDays(8)->setTime(12, 0),
                'status'      => 'upcoming',
                'emoji'       => '🎉',
            ],
            [
                'uuid'        => (string) Str::uuid(),
                'title'       => 'Pelatihan Barista Lanjutan',
                'description' => 'Pelatihan intensif teknik barista tingkat lanjut bersama trainer berpengalaman. Peserta wajib membawa peralatan pribadi.',
                'location'    => 'Ruang Training Lt. 2',
                'starts_at'   => now()->addDays(13)->setTime(13, 0),
                'ends_at'     => now()->addDays(13)->setTime(17, 0),
                'status'      => 'open',
                'emoji'       => '☕',
            ],
            [
                'uuid'        => (string) Str::uuid(),
                'title'       => 'Lomba Menu Kreasi',
                'description' => 'Kompetisi kreasi menu baru dengan bahan-bahan lokal. Pemenang mendapatkan hadiah menarik dan kesempatan menu masuk ke katalog resmi.',
                'location'    => 'Kedai Pusat',
                'starts_at'   => now()->addDays(21)->setTime(10, 0),
                'ends_at'     => now()->addDays(21)->setTime(15, 0),
                'status'      => 'open',
                'emoji'       => '🏆',
            ],
        ];

        foreach ($activities as $data) {
            Activity::create($data);
        }
    }
}
