<?php

namespace Tests\Feature;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminStatusVerifikasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_pengajuan_and_status_is_reflected_in_cek_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $pengajuan = Pengajuan::create([
            'nama_pemohon' => 'Siti Aminah',
            'nik' => '3315025505950002',
            'telepon' => '085712345678',
            'email' => 'siti@example.com',
            'jenis_layanan' => 'pendaftaran_ormas',
            'keterangan' => 'Permohonan Pendaftaran Ormas Baru',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.pengajuan.update', $pengajuan), [
            'status' => 'disetujui',
            'catatan_admin' => 'Dokumen lengkap dan telah diverifikasi oleh Kesbangpol.',
        ]);

        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status' => 'disetujui',
            'catatan_admin' => 'Dokumen lengkap dan telah diverifikasi oleh Kesbangpol.',
        ]);

        // Cek halaman status
        $cekResponse = $this->actingAs($admin)->get(route('pengajuan.cek', ['nomor' => $pengajuan->id]));
        $cekResponse->assertStatus(200);
        $cekResponse->assertSee('Disetujui');
        $cekResponse->assertSee('Dokumen lengkap dan telah diverifikasi oleh Kesbangpol.');
    }

    public function test_admin_can_reject_pengajuan_with_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $pengajuan = Pengajuan::create([
            'nama_pemohon' => 'Budi Santoso',
            'nik' => '3315025505950003',
            'telepon' => '085712345679',
            'email' => 'budi@example.com',
            'jenis_layanan' => 'perubahan_data',
            'keterangan' => 'Pengajuan Perubahan Pengurus',
            'status' => 'menunggu',
        ]);

        $this->actingAs($admin)->put(route('admin.pengajuan.update', $pengajuan), [
            'status' => 'ditolak',
            'catatan_admin' => 'Berkas SK Pengurus belum melampirkan Tanda Tangan Notaris.',
        ]);

        $this->assertDatabaseHas('pengajuan', [
            'id' => $pengajuan->id,
            'status' => 'ditolak',
            'catatan_admin' => 'Berkas SK Pengurus belum melampirkan Tanda Tangan Notaris.',
        ]);

        $cekResponse = $this->actingAs($admin)->get(route('pengajuan.cek', ['nomor' => $pengajuan->id]));
        $cekResponse->assertStatus(200);
        $cekResponse->assertSee('Ditolak');
        $cekResponse->assertSee('Berkas SK Pengurus belum melampirkan Tanda Tangan Notaris.');
    }
}
