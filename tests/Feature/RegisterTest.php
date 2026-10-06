<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_register_page(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun & Registrasi Ormas', false);
        $response->assertSee('Nama Lengkap Pengurus');
    }

    public function test_user_can_register_new_account(): void
    {
        $response = $this->post(route('register.post'), [
            'name' => 'Pengurus Baru',
            'email' => 'pengurusbaru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Pengurus Baru',
            'email' => 'pengurusbaru@example.com',
            'role' => 'user',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('laporan.keberadaan'));
    }

    public function test_register_validation_fails_if_email_exists(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post(route('register.post'), [
            'name' => 'User Duplikat',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_register_with_ormas_data_and_pinpoint_coordinates(): void
    {
        $response = $this->post(route('register.post'), [
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_ormas' => 'Ormas Pemuda Maju Grobogan',
            'singkatan' => 'OPMG',
            'bidang_kegiatan' => 'Sosial',
            'alamat_sekretariat' => 'Jl. Pemuda No. 123, Purwodadi',
            'latitude' => -7.0867,
            'longitude' => 110.9167,
            'kelurahan' => 'Purwodadi',
            'kecamatan' => 'Purwodadi',
            'kota' => 'Kabupaten Grobogan',
            'provinsi' => 'Jawa Tengah',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@example.com',
        ]);

        $this->assertDatabaseHas('ormas', [
            'nama_ormas' => 'Ormas Pemuda Maju Grobogan',
            'singkatan' => 'OPMG',
            'bidang_kegiatan' => 'Sosial',
            'alamat_sekretariat' => 'Jl. Pemuda No. 123, Purwodadi',
            'latitude' => -7.0867,
            'longitude' => 110.9167,
            'status' => 'menunggu',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('laporan.keberadaan'));
    }
}
