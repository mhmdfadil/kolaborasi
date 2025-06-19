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
        Schema::create('partnership_documents', function (Blueprint $table) {
            $table->id(); // ID dokumentasi kerjasama
            $table->foreignId('partnership_id')->constrained('partnerships'); // Relasi ke tabel partnerships
            $table->string('title'); // Judul dokumentasi
            $table->string('file'); // Nama file dokumentasi
            $table->string('mou');
            $table->string('moa');
            $table->date('date'); // Tanggal dokumentasi
            $table->text('description'); // Deskripsi dokumentasi
            $table->timestamps(); // Tanggal dibuat dan diperbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnership_documents');
    }
};
