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
        Schema::create('event_documents', function (Blueprint $table) {
            $table->id(); // ID dokumentasi acara
            $table->foreignId('event_id')->constrained('events'); // Relasi ke tabel events
            $table->string('document_name'); // Nama dokumen acara
            $table->string('file'); // Nama file dokumentasi acara
            $table->text('description'); // Deskripsi dokumentasi acara
            $table->timestamps(); // Tanggal dibuat dan diperbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_documents');
    }
};
