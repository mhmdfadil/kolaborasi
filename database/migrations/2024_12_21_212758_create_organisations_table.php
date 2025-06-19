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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id(); // ID organisasi
            $table->string('name'); // Nama organisasi
            $table->string('email')->unique(); // Email organisasi (unik)
            $table->text('address'); // Alamat organisasi
            $table->text('description')->nullable(); // Deskripsi organisasi (opsional)
            $table->string('phone_number')->nullable(); // Nomor telepon organisasi (opsional)
            $table->string('website')->nullable(); // Website organisasi (opsional)
            $table->enum('type', ['Company', 'NGO', 'University', 'Other'])->default('Other'); // Jenis organisasi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users (mitra)
            $table->boolean('is_verified')->default(false); // Status verifikasi organisasi
            $table->timestamps(); // Tanggal dibuat dan diperbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
