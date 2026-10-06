<?php

namespace Tests\Feature;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanPerubahanTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_laporan_perubahan(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('laporan.perubahan.store'), [
            'jenis_perubahan' => ['pengurus', 'alamat'],
            'ketua_baru' => 'Ahmad Fauzi',
            'sekretaris_baru' => 'Budi Santoso',
            'bendahara_baru' => 'Cici Paramida',
            'masa_bhakti_baru' => '2026-2029',
            'sk_pengurus_baru' => 'SK-123/2026',
            'alamat_lama' => 'Jl. Lama No. 12',
            'alamat_baru' => 'Jl. Baru No. 99, Purwodadi',
        ]);

        $this->assertDatabaseHas('pengajuan', [
            'jenis_layanan' => 'perubahan_data',
            'status' => 'menunggu',
        ]);

        $pengajuan = Pengajuan::first();
        $this->assertNotNull($pengajuan->data_perubahan);
        $this->assertEquals(['pengurus', 'alamat'], $pengajuan->data_perubahan['jenis']);
        $this->assertEquals('Ahmad Fauzi', $pengajuan->data_perubahan['detail']['pengurus']['ketua_baru']);
        $this->assertEquals('Jl. Baru No. 99, Purwodadi', $pengajuan->data_perubahan['detail']['alamat']['alamat_baru']);

        $response->assertRedirect(route('pengajuan.status', $pengajuan->id));
    }

    public function test_admin_can_view_laporan_perubahan_details(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $pengajuan = Pengajuan::create([
            'nama_pemohon' => 'Budi Raharjo',
            'nik' => '3315012345678901',
            'telepon' => '081234567890',
            'email' => 'budi@example.com',
            'jenis_layanan' => 'perubahan_data',
            'keterangan' => 'Pengajuan Perubahan Biodata Ormas: Perubahan Nama Organisasi',
            'data_perubahan' => [
                'jenis' => ['nama'],
                'detail' => [
                    'nama' => [
                        'nama_lama' => 'Ormas Pemuda Bersatu',
                        'nama_baru' => 'Ormas Pemuda Maju Grobogan',
                        'singkatan_lama' => 'OPB',
                        'singkatan_baru' => 'OPMG',
                    ],
                ],
            ],
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.pengajuan.show', $pengajuan));

        $response->assertStatus(200);
        $response->assertSee('Detail Perubahan Data Ormas');
        $response->assertSee('Perubahan Nama Organisasi');
        $response->assertSee('Ormas Pemuda Bersatu');
        $response->assertSee('Ormas Pemuda Maju Grobogan');
    }
}
