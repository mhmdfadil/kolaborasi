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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // ID acara
            $table->foreignId('partnership_id')->constrained('partnerships'); // Relasi ke tabel partnerships
            $table->string('event_name'); // Nama acara
            $table->text('event_details'); // Detail acara
            $table->date('start_date'); // Tanggal mulai acara
            $table->date('end_date'); // Tanggal selesai acara
            $table->enum('status', ['Ongoing', 'Completed', 'Cancelled'])->default('Ongoing'); // Status acara
            $table->timestamps(); // Tanggal dibuat dan diperbarui
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
