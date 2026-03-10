<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->timestamp('scanned_at')->nullable();   // waktu scan QR
            $table->string('status')->default('present'); // present | late | absent
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'activity_id']); // 1 user 1x per activity
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
