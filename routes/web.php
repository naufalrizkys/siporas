<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\OrmasController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\TemplateController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

// ── Publik ───────────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/templates/download', [HomeController::class, 'downloadTemplates'])->name('templates.download');
Route::post('/templates/download-selected', [HomeController::class, 'downloadSelectedTemplates'])->name('templates.download.selected');
Route::get('/templates', [HomeController::class, 'templates'])->name('templates.index');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Direktori Ormas (publik)
Route::get('/ormas', [OrmasController::class, 'index'])->name('ormas.index');
Route::get('/ormas/{ormas}', [OrmasController::class, 'show'])->name('ormas.show');

// Kegiatan (publik)
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');

// ── Auth (login/logout/register/google) ──────────────────────────────────────

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auto-logout', [AuthController::class, 'logout'])->name('auto.logout')->middleware('auth');
Route::post('/beacon-logout', [AuthController::class, 'beaconLogout'])->name('beacon.logout')->withoutMiddleware([VerifyCsrfToken::class]);

// ── Route yang butuh login ────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // Cek Status Pengajuan (auth required)
    Route::get('/cek-status', [PengajuanController::class, 'cekStatusPage'])->name('cek.status');

    Route::post('/laporan/pendaftaran-baru', [PengajuanController::class, 'storeLaporanPendaftaranBaru'])->name('laporan.pendaftaran-baru.store');

    Route::get('/laporan/pendaftaran-baru', function () {
        return view('laporan.pendaftaran-baru');
    })->name('laporan.pendaftaran-baru');

    Route::get('/laporan/perubahan', function () {
        return view('laporan.perubahan');
    })->name('laporan.perubahan');

    Route::post('/laporan/perubahan', [PengajuanController::class, 'storePerubahan'])->name('laporan.perubahan.store');

    // Laporan Kegiatan Ormas
    Route::get('/laporan/kegiatan-ormas', function () {
        return view('laporan.kegiatan');
    })->name('laporan.kegiatan');

    Route::post('/laporan/kegiatan-ormas', [PengajuanController::class, 'storeKegiatan'])->name('laporan.kegiatan.store');

    // Pendaftaran online
    Route::get('/pendaftaran-online', function () {
        return view('pendaftaran.index');
    })->name('pendaftaran.online');
    Route::post('/pendaftaran-online', [PengajuanController::class, 'storePendaftaranBaru'])->name('pendaftaran.store');

    // Cek status — hanya user login
    Route::get('/layanan/cek', [PengajuanController::class, 'cekStatus'])->name('pengajuan.cek');
    Route::get('/layanan/{id}/status', [PengajuanController::class, 'status'])->name('pengajuan.status');
});

// ── Admin ─────────────────────────────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Ormas CRUD
    Route::get('/ormas', [AdminController::class, 'ormasList'])->name('ormas');
    Route::get('/ormas/tambah', [AdminController::class, 'ormasCreate'])->name('ormas.create');
    Route::post('/ormas', [AdminController::class, 'ormasStore'])->name('ormas.store');
    Route::get('/ormas/{ormas}/edit', [AdminController::class, 'ormasEdit'])->name('ormas.edit');
    Route::put('/ormas/{ormas}', [AdminController::class, 'ormasUpdate'])->name('ormas.update');
    Route::delete('/ormas/{ormas}', [AdminController::class, 'ormasDestroy'])->name('ormas.destroy');

    // Pengajuan
    Route::get('/pengajuan', [AdminController::class, 'pengajuanList'])->name('pengajuan');
    Route::get('/pengajuan/{pengajuan}', [AdminController::class, 'pengajuanShow'])->name('pengajuan.show');
    Route::put('/pengajuan/{pengajuan}', [AdminController::class, 'pengajuanUpdate'])->name('pengajuan.update');
    Route::get('/pengajuan/{pengajuan}/download', [AdminController::class, 'pengajuanDownload'])->name('pengajuan.download');

    // Laporan Kegiatan
    Route::get('/kegiatan', [AdminController::class, 'kegiatanList'])->name('kegiatan');
    Route::put('/kegiatan/{pengajuan}', [AdminController::class, 'kegiatanUpdate'])->name('kegiatan.update');

    // Slider
    Route::get('/slider', [AdminController::class, 'sliderIndex'])->name('slider');
    Route::post('/slider', [AdminController::class, 'sliderStore'])->name('slider.store');
    Route::post('/slider/{slider}', [AdminController::class, 'sliderUpdate'])->name('slider.update');
    Route::post('/slider/{slider}/toggle', [AdminController::class, 'sliderToggle'])->name('slider.toggle');
    Route::delete('/slider/{slider}', [AdminController::class, 'sliderDestroy'])->name('slider.destroy');

    // Running Text / Ticker Bar
    Route::get('/ticker', [AdminController::class, 'tickerIndex'])->name('ticker');
    Route::post('/ticker', [AdminController::class, 'tickerUpdate'])->name('ticker.update');

    // Template Dokumen
    Route::get('/template', [TemplateController::class, 'index'])->name('template');
    Route::post('/template', [TemplateController::class, 'store'])->name('template.store');
    Route::post('/template/{template}', [TemplateController::class, 'update'])->name('template.update');
    Route::post('/template/{template}/toggle', [TemplateController::class, 'toggleAktif'])->name('template.toggle');
    Route::delete('/template/{template}', [TemplateController::class, 'destroy'])->name('template.destroy');
});
