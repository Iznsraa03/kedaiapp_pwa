<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'status',
        'emoji',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Activity $activity) {
            if (empty($activity->uuid)) {
                $activity->uuid = (string) Str::uuid();
            }
        });
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /** Badge warna berdasarkan status */
    public function badgeClass(): string
    {
        return match ($this->status) {
            'open'   => 'bg-green-50 text-green-600',
            'closed' => 'bg-gray-100 text-gray-400',
            default  => 'bg-[#EFF6FF] text-[#2563EB]', // upcoming
        };
    }

    public function badgeLabel(): string
    {
        return match ($this->status) {
            'open'   => 'Buka Pendaftaran',
            'closed' => 'Ditutup',
            default  => 'Akan Datang',
        };
    }

    public function stripeClass(): string
    {
        return match ($this->status) {
            'open'   => 'bg-green-500',
            'closed' => 'bg-gray-300',
            default  => 'bg-[#2563EB]',
        };
    }
}
