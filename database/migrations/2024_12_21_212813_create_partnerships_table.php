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
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id(); // ID kerjasama
            $table->foreignId('organisation_id')->constrained('organisations')->onDelete('cascade'); // Relasi ke tabel organisations
            $table->string('partnership_type'); // Jenis kerjasama
            $table->string('title');
            $table->text('details'); // Detail kerjasama
            $table->string('document'); // Nama file lampiran kerjasama
            $table->date('start_date'); // Tanggal mulai kerjasama
            $table->date('end_date'); // Tanggal berakhir kerjasama
            $table->date('approval_date')->nullable(); // Tanggal disetujui (opsional, hanya diisi jika disetujui)
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending'); // Status persetujuan kerjasama
            $table->enum('is_active', ['Active', 'Inactive'])->default('Inactive'); // Status aktif kerjasama
            $table->text('notes')->nullable(); // Catatan tambahan (opsional, bisa untuk alasan penolakan atau keterangan lain)
            $table->timestamps(); // Tanggal dibuat dan diperbarui

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnerships');
    }
};
