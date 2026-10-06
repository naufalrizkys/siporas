<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemohon');
            $table->string('nik');
            $table->string('telepon');
            $table->string('email');
            $table->enum('jenis_layanan', [
                'pendaftaran_ormas',
                'perpanjangan_skt',
                'perubahan_data',
                'pencabutan_skt',
                'surat_keterangan',
            ]);
            $table->foreignId('ormas_id')->nullable()->constrained('ormas')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->string('dokumen')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
