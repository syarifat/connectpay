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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('id_pelanggan')->unique();
            $table->string('nama');
            $table->string('nik', 16);
            $table->string('nomor_wa');
            $table->text('alamat');
            $table->string('paket'); // Dropdown: 10Mbps, 20Mbps, dll
            $table->string('pppoe_profile');
            $table->string('foto_rumah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
