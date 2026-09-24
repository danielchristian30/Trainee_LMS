<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            //Relasi Ke Tabel users (intern)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Relasi ke template untuk history.
            $table->foreignId('certificate_template_id')->nullable()->constrained()->nullOnDelete();

            // Nomor Sertifikat
            $table->string('certificate_number')->unique();
            $table->timestamp('issued_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};