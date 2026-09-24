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
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('background_path');

            // Posisi Teks Nama
            $table->decimal('name_x', 5, 2)->default(50.00);
            $table->decimal('name_y', 5, 2)->default(50.00);
            $table->integer('name_font_size')->default(32);
            $table->string('name_color', 7)->default('#000000');

            // Posisi Teks Course / LMS
            $table->decimal('course_x', 5, 2)->nullable();
            $table->decimal('course_y', 5, 2)->nullable();
            $table->integer('course_font_size')->default(24);
            $table->string('course_color', 7)->default('#000000');

            // Posisi teks tanggal
            $table->decimal('date_x', 5, 2)->nullable();
            $table->decimal('date_y', 5, 2)->nullable();
            $table->integer('date_font_size')->default(18);
            $table->string('date_color', 7)->default('#000000');

            // Posisi Teks Nomor Sertifikat
            $table->decimal('cert_number_x', 5, 2)->nullable();
            $table->decimal('cert_number_y', 5, 2)->nullable();
            $table->integer('cert_number_font_size')->default(16);
            $table->string('cert_number_color', 7)->default('#000000');

            // Posisi QR Code
            $table->decimal('qr_x', 5, 2)->nullable();
            $table->decimal('qr_y', 5, 2)->nullable();
            $table->integer('qr_size')->default(100); //ukuran dalam pixel

            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
