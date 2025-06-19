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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique(); 
            $table->string('password');
            $table->integer('telepon')->nullable();
            $table->string('alamat')->nullable();
            $table->string('bidang')->nullable();
            $table->enum('role', ['Admin', 'Mitra'])->default('Mitra'); 
            $table->enum('status', ['Active', 'Inactive'])->default('Active'); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_picture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
