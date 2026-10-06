<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TickerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_ticker_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.ticker'));

        $response->assertStatus(200);
        $response->assertSee('Kelola Running Text');
    }

    public function test_admin_can_update_running_text(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.ticker.update'), [
            'running_text' => 'PENGUMUMAN: PELAYANAN ORMAS ONLINE KESBANGPOL KABUPATEN GROBOGAN',
        ]);

        $response->assertRedirect(route('admin.ticker'));
        $this->assertEquals(
            'PENGUMUMAN: PELAYANAN ORMAS ONLINE KESBANGPOL KABUPATEN GROBOGAN',
            Setting::get('running_text')
        );

        $homeResponse = $this->get(route('home'));
        $homeResponse->assertSee('PENGUMUMAN: PELAYANAN ORMAS ONLINE KESBANGPOL KABUPATEN GROBOGAN');
    }
}
