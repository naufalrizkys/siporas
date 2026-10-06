<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ormas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ormas');
            $table->string('singkatan')->nullable();
            $table->string('nomor_skt')->nullable(); // Surat Keterangan Terdaftar
            $table->date('tanggal_berdiri')->nullable();
            $table->string('bidang_kegiatan');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('alamat_sekretariat');
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kota');
            $table->string('provinsi');
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif', 'menunggu'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ormas');
    }
};
