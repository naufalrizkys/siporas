<?php

namespace App\Http\Controllers;

use App\Mail\PengajuanStatusMail;
use App\Models\Kegiatan;
use App\Models\Ormas;
use App\Models\Pengajuan;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_ormas' => Ormas::count(),
            'ormas_aktif' => Ormas::where('status', 'aktif')->count(),
            'total_pengajuan' => Pengajuan::count(),
            'pengajuan_proses' => Pengajuan::where('status', 'diproses')->count(),
            'pengajuan_tunggu' => Pengajuan::where('status', 'menunggu')->count(),
            'total_kegiatan' => Kegiatan::count(),
        ];

        $pengajuanTerbaru = Pengajuan::with('ormas')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pengajuanTerbaru'));
    }

    // ── ORMAS ──────────────────────────────────────────────────────────────────

    public function ormasList(Request $request)
    {
        $query = Ormas::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_ormas', 'like', "%{$search}%")
                    ->orWhere('singkatan', 'like', "%{$search}%")
                    ->orWhere('nomor_skt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $ormasList = $query->paginate(15);

        $availableYears = Ormas::pluck('created_at')
            ->map(fn ($d) => $d?->format('Y'))
            ->concat([date('Y')])
            ->unique()
            ->filter()
            ->sortDesc()
            ->values();

        return view('admin.ormas.index', compact('ormasList', 'availableYears'));
    }

    public function ormasCreate()
    {
        return view('admin.ormas.form', ['ormas' => new Ormas]);
    }

    public function ormasStore(Request $request)
    {
        $data = $request->validate([
            'nama_ormas' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'nomor_skt' => 'nullable|string|max:100',
            'tanggal_berdiri' => 'nullable|date',
            'bidang_kegiatan' => 'required|string|max:100',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat_sekretariat' => 'required|string',
            'rt_rw' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'status' => 'required|in:aktif,tidak_aktif,menunggu',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Ormas::create($data);

        return redirect()->route('admin.ormas')->with('success', 'Ormas berhasil ditambahkan.');
    }

    public function ormasEdit(Ormas $ormas)
    {
        return view('admin.ormas.form', compact('ormas'));
    }

    public function ormasUpdate(Request $request, Ormas $ormas)
    {
        $data = $request->validate([
            'nama_ormas' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'nomor_skt' => 'nullable|string|max:100',
            'tanggal_berdiri' => 'nullable|date',
            'bidang_kegiatan' => 'required|string|max:100',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat_sekretariat' => 'required|string',
            'rt_rw' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'status' => 'required|in:aktif,tidak_aktif,menunggu',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $ormas->update($data);

        return redirect()->route('admin.ormas')->with('success', 'Data ormas berhasil diperbarui.');
    }

    public function ormasDestroy(Ormas $ormas)
    {
        $ormas->delete();

        return redirect()->route('admin.ormas')->with('success', 'Ormas berhasil dihapus.');
    }

    // ── PENGAJUAN ──────────────────────────────────────────────────────────────

    public function pengajuanList(Request $request)
    {
        $query = Pengajuan::with('ormas');
        $jenisLayanan = $request->input('jenis_layanan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($jenisLayanan) {
            $query->where('jenis_layanan', $jenisLayanan);
        }
        $pengajuanList = $query->orderBy('created_at', 'desc')->paginate(15);

        $pageTitle = match ($jenisLayanan) {
            'pendaftaran_ormas' => 'Pendaftaran Ormas Baru',
            'perubahan_data' => 'Perubahan Data Ormas',
            default => 'Semua Pengajuan',
        };

        return view('admin.pengajuan.index', compact('pengajuanList', 'pageTitle', 'jenisLayanan'));
    }

    public function pengajuanShow(Pengajuan $pengajuan)
    {
        $pengajuan->load('ormas');
        $ormasList = Ormas::where('status', 'aktif')->orderBy('nama_ormas')->get();

        return view('admin.pengajuan.show', compact('pengajuan', 'ormasList'));
    }

    public function pengajuanUpdate(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $statusLama = $pengajuan->status;

        $pengajuan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        // ── Saat disetujui: otomatis buat / update data ormas ────────────────
        if ($request->status === 'disetujui' && ($statusLama !== 'disetujui' || ! $pengajuan->ormas_id)) {
            $dp = $pengajuan->data_perubahan ?? [];

            // ── Pendaftaran Ormas Baru ────────────────────────────────────────
            if ($pengajuan->jenis_layanan === 'pendaftaran_ormas') {
                $org = $dp['organisasi'] ?? [];
                $bidang = is_array($org['bidang'] ?? null)
                    ? implode(', ', $org['bidang'])
                    : ($org['bidang'] ?? '');

                $ormasData = [
                    'user_id' => $pengajuan->user_id,
                    'nama_ormas' => $org['nama_organisasi'] ?? ($dp['nama_ormas'] ?? null),
                    'singkatan' => $org['singkatan'] ?? null,
                    'bidang_kegiatan' => $bidang ?: ($org['bidang_kegiatan'] ?? null),
                    'alamat_sekretariat' => $org['alamat'] ?? ($org['alamat_sekretariat'] ?? null),
                    'latitude' => $org['latitude'] ?? null,
                    'longitude' => $org['longitude'] ?? null,
                    'kelurahan' => $org['kelurahan'] ?? null,
                    'kecamatan' => $org['kecamatan'] ?? null,
                    'kota' => $org['kota'] ?? 'Kabupaten Grobogan',
                    'provinsi' => $org['provinsi'] ?? 'Jawa Tengah',
                    'telepon' => $pengajuan->telepon,
                    'email' => $pengajuan->email,
                    'status' => 'aktif',
                ];

                // Buat ormas baru dan hubungkan ke pengajuan
                $ormas = Ormas::create(array_filter($ormasData, fn ($v) => $v !== null));
                $pengajuan->update(['ormas_id' => $ormas->id]);
            }

            // ── Perubahan Data Ormas ──────────────────────────────────────────
            elseif ($pengajuan->jenis_layanan === 'perubahan_data') {
                $ormas = $pengajuan->ormas;
                $detail = $dp['detail'] ?? [];
                $jenis = $dp['jenis'] ?? [];
                // nama_ormas bisa dari field baru (nama_ormas_pemohon) atau field lama
                $namaOrmasDiajukan = $dp['nama_ormas'] ?? $dp['nama_ormas_pemohon'] ?? null;
                $bidangDiajukan = $dp['bidang_kegiatan'] ?? null;
                $alamatDiajukan = $detail['alamat']['alamat_baru'] ?? 'Kabupaten Grobogan';
                $kotaDiajukan = $detail['alamat']['kota_baru'] ?? 'Kabupaten Grobogan';
                $provinsiDiajukan = $detail['alamat']['provinsi_baru'] ?? 'Jawa Tengah';

                // Jika ormas belum ada, buat baru dari data pengajuan
                if (! $ormas) {
                    $namaUntukOrmas = $namaOrmasDiajukan ?? 'Ormas '.$pengajuan->nama_pemohon;

                    $ormasBaru = array_filter([
                        'user_id' => $pengajuan->user_id,
                        'nama_ormas' => $namaUntukOrmas,
                        'bidang_kegiatan' => $bidangDiajukan ?? 'Umum',
                        'alamat_sekretariat' => $alamatDiajukan,
                        'kota' => $kotaDiajukan,
                        'provinsi' => $provinsiDiajukan,
                        'telepon' => $pengajuan->telepon,
                        'email' => $pengajuan->email,
                        'status' => 'aktif',
                    ], fn ($v) => $v !== null);

                    $ormas = Ormas::create($ormasBaru);
                    $pengajuan->update(['ormas_id' => $ormas->id]);
                }

                $updateData = [];

                if (in_array('nama', $jenis) && ! empty($detail['nama']['nama_baru'])) {
                    $updateData['nama_ormas'] = $detail['nama']['nama_baru'];
                    if (! empty($detail['nama']['singkatan_baru'])) {
                        $updateData['singkatan'] = $detail['nama']['singkatan_baru'];
                    }
                }

                if (in_array('alamat', $jenis) && ! empty($detail['alamat'])) {
                    $al = $detail['alamat'];
                    if (! empty($al['alamat_baru'])) {
                        $updateData['alamat_sekretariat'] = $al['alamat_baru'];
                    }
                    if (! empty($al['kelurahan_baru'])) {
                        $updateData['kelurahan'] = $al['kelurahan_baru'];
                    }
                    if (! empty($al['kecamatan_baru'])) {
                        $updateData['kecamatan'] = $al['kecamatan_baru'];
                    }
                    if (! empty($al['kota_baru'])) {
                        $updateData['kota'] = $al['kota_baru'];
                    }
                    if (! empty($al['provinsi_baru'])) {
                        $updateData['provinsi'] = $al['provinsi_baru'];
                    }
                    if (! empty($al['latitude_baru'])) {
                        $updateData['latitude'] = (float) $al['latitude_baru'];
                    }
                    if (! empty($al['longitude_baru'])) {
                        $updateData['longitude'] = (float) $al['longitude_baru'];
                    }
                }

                if (! empty($updateData)) {
                    $ormas->update($updateData);
                }
            }
        }

        $statusLabel = match ($request->status) {
            'disetujui' => 'DISETUJUI',
            'ditolak' => 'DITOLAK',
            'diproses' => 'DIPROSES',
            default => 'MENUNGGU',
        };

        // ── Kirim email notifikasi ke pemohon ────────────────────────────────
        $statusYangDikirimi = ['disetujui', 'ditolak', 'diproses'];
        $emailTerkirim = false;
        if (in_array($request->status, $statusYangDikirimi) && $request->status !== $statusLama) {
            try {
                $pengajuanFresh = $pengajuan->fresh();
                $tujuanEmail = $pengajuanFresh->email;

                // Resend free plan hanya bisa kirim ke email pemilik akun
                // Kirim ke email pemohon langsung (butuh domain verified di Resend)
                // Fallback ke adminsiporas@gmail.com jika gagal
                try {
                    Mail::to($tujuanEmail)->send(new PengajuanStatusMail($pengajuanFresh));
                    $emailTerkirim = true;
                } catch (\Throwable) {
                    // Fallback: kirim ke admin sebagai notifikasi
                    Mail::to('adminsiporas@gmail.com')->send(new PengajuanStatusMail($pengajuanFresh));
                    $emailTerkirim = true;
                    $tujuanEmail = 'adminsiporas@gmail.com (domain belum verified)';
                }
            } catch (\Throwable $e) {
                logger()->error('Gagal kirim email pengajuan #'.$pengajuan->id.': '.$e->getMessage());
            }
        }

        $infoEmail = $emailTerkirim ? " · Email notifikasi telah dikirim ke {$tujuanEmail}." : '';

        return redirect()->route('admin.pengajuan', ['jenis_layanan' => $pengajuan->jenis_layanan])
            ->with('success', 'Status pengajuan #'.str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT)." berhasil diperbarui menjadi {$statusLabel}.{$infoEmail}");
    }

    public function pengajuanDownload(Pengajuan $pengajuan): BinaryFileResponse|RedirectResponse
    {
        $dp = $pengajuan->data_perubahan ?? [];

        // Kumpulkan semua path file dari semua kemungkinan key
        $allFiles = [];

        // Dari kolom dokumen tunggal
        if ($pengajuan->dokumen) {
            $allFiles['dokumen'] = [$pengajuan->dokumen];
        }

        // Dari data_perubahan['lampiran'] (pendaftaran baru / laporan keberadaan)
        if (! empty($dp['lampiran'])) {
            foreach ($dp['lampiran'] as $key => $val) {
                if (! empty($val)) {
                    $allFiles[$key] = is_array($val) ? $val : [$val];
                }
            }
        }

        // Dari data_perubahan['dokumen'] (laporan perubahan biodata)
        if (! empty($dp['dokumen'])) {
            foreach ($dp['dokumen'] as $key => $val) {
                if (! empty($val)) {
                    $allFiles[$key] = is_array($val) ? $val : [$val];
                }
            }
        }

        if (empty($allFiles)) {
            return redirect()->back()->with('error', 'Tidak ada file lampiran untuk diunduh.');
        }

        // Nama ormas untuk penamaan file ZIP
        $namaOrmas = $pengajuan->ormas?->nama_ormas
            ?? ($dp['organisasi']['nama_organisasi'] ?? null)
            ?? ($dp['nama_ormas'] ?? null)
            ?? 'Pengajuan_'.$pengajuan->id;

        $namaOrmasBersih = preg_replace('/[^A-Za-z0-9_\-]/', '_', $namaOrmas);
        $namaOrmasBersih = trim($namaOrmasBersih, '_');
        $jenisLabel = match ($pengajuan->jenis_layanan) {
            'pendaftaran_ormas' => 'Pendaftaran',
            'perubahan_data' => 'Perubahan_Data',
            default => 'Dokumen',
        };

        $zipFileName = $namaOrmasBersih.'_'.$jenisLabel.'_Dokumen.zip';
        $zipPath = storage_path('app/temp/'.$zipFileName);

        // Pastikan direktori temp ada
        if (! is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
        }

        $labelMap = [
            'dokumen' => 'Dokumen_Utama',
            'berkas_nama' => 'Berkas_Perubahan_Nama',
            'berkas_alamat' => 'Surat_Domisili_Baru',
            'berkas_pengurus' => 'SK_Kepengurusan_Baru',
            'lambang_baru' => 'Lambang_Logo_Baru',
            'stempel_baru' => 'Cap_Stempel_Baru',
            'berkas_lainnya' => 'Berkas_Pendukung',
            'surat_pengantar' => 'Surat_Pengantar',
            'lamp_surat_pengantar' => 'Surat_Pengantar',
            'akta_pendirian' => 'Akta_Pendirian',
            'lamp_akta_pendirian' => 'Akta_Pendirian',
            'sk_kemenkumham' => 'SK_Kemenkumham',
            'lamp_sk_kemenkumham' => 'SK_Kemenkumham',
            'program_kerja' => 'Program_Kerja',
            'lamp_program_kerja' => 'Program_Kerja',
            'sk_kepengurusan' => 'SK_Susunan_Pengurus',
            'lamp_sk_pengurus' => 'SK_Susunan_Pengurus',
            'domisili' => 'Surat_Domisili',
            'lamp_domisili' => 'Surat_Domisili',
            'npwp' => 'NPWP_Ormas',
            'lamp_npwp' => 'NPWP_Ormas',
            'biodata_pengurus' => 'Biodata_Pengurus',
            'lamp_biodata_ketua' => 'Biodata_Ketua',
            'lamp_biodata_sekretaris' => 'Biodata_Sekretaris',
            'lamp_biodata_bendahara' => 'Biodata_Bendahara',
            'ktp_pengurus' => 'EKTP_Pengurus',
            'lamp_ktp_ketua' => 'EKTP_Ketua',
            'lamp_ktp_sekretaris' => 'EKTP_Sekretaris',
            'lamp_ktp_bendahara' => 'EKTP_Bendahara',
            'dokumen_pelengkap' => 'Dokumen_Pelengkap',
            'lamp_dokumen_pelengkap' => 'Dokumen_Pelengkap',
            'f02_logo' => 'Logo_Lambang',
            'f02_cap' => 'Cap_Stempel',
            'f03_bendera' => 'Foto_Bendera',
            'f03_foto_kantor' => 'Foto_Kantor',
            'surat_pernyataan' => 'Surat_Pernyataan',
        ];

        foreach ($allFiles as $key => $paths) {
            foreach ($paths as $i => $relativePath) {
                if (empty($relativePath)) {
                    continue;
                }

                $absolutePath = storage_path('app/public/'.ltrim($relativePath, '/'));
                if (! file_exists($absolutePath)) {
                    continue;
                }

                $ext = pathinfo($absolutePath, PATHINFO_EXTENSION);
                $label = $labelMap[$key] ?? $key;
                $suffix = count($paths) > 1 ? '_'.($i + 1) : '';
                $entryName = $namaOrmasBersih.'_'.$label.$suffix.'.'.$ext;

                $zip->addFile($absolutePath, $entryName);
            }
        }

        $zip->close();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    // ── LAPORAN KEGIATAN ───────────────────────────────────────────────────────

    public function kegiatanList(Request $request)
    {
        $query = Pengajuan::with(['ormas', 'user'])
            ->where('jenis_layanan', 'laporan_kegiatan');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatanList = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.kegiatan.index', compact('kegiatanList'));
    }

    public function kegiatanUpdate(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $pengajuan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->back()->with('success', 'Status laporan kegiatan berhasil diperbarui.');
    }

    // ── SLIDER ─────────────────────────────────────────────────────────────────

    public function sliderIndex()
    {
        $sliders = Slider::orderBy('urutan')->orderBy('id')->get();

        return view('admin.slider.index', compact('sliders'));
    }

    public function sliderStore(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'judul' => 'nullable|string|max:200',
            'deskripsi' => 'nullable|string|max:500',
            'link' => 'nullable|url|max:255',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $path = $request->file('gambar')->store('sliders', 'public');

        Slider::create([
            'gambar' => $path,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'urutan' => $request->urutan ?? 0,
            'aktif' => true,
        ]);

        return redirect()->route('admin.slider')->with('success', 'Foto slider berhasil ditambahkan.');
    }

    public function sliderUpdate(Request $request, Slider $slider)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'judul' => 'nullable|string|max:200',
            'deskripsi' => 'nullable|string|max:500',
            'link' => 'nullable|url|max:255',
            'urutan' => 'nullable|integer|min:0',
            'aktif' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'urutan' => $request->urutan ?? 0,
            'aktif' => $request->has('aktif') ? (bool) $request->aktif : $slider->aktif,
        ];

        if ($request->hasFile('gambar')) {
            // hapus foto lama
            Storage::disk('public')->delete($slider->gambar);
            $data['gambar'] = $request->file('gambar')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.slider')->with('success', 'Slider berhasil diperbarui.');
    }

    public function sliderToggle(Slider $slider)
    {
        $slider->update(['aktif' => ! $slider->aktif]);

        return redirect()->route('admin.slider')->with('success', 'Status slider diperbarui.');
    }

    public function sliderDestroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->gambar);
        $slider->delete();

        return redirect()->route('admin.slider')->with('success', 'Slider berhasil dihapus.');
    }

    // ── TICKER / RUNNING TEXT ──────────────────────────────────────────────────

    public function tickerIndex()
    {
        $runningText = Setting::get('running_text', 'GERAKAN INDONESIA SADAR ADMINISTRASI KEPENDUDUKAN');

        return view('admin.ticker.index', compact('runningText'));
    }

    public function tickerUpdate(Request $request)
    {
        $request->validate([
            'running_text' => 'required|string|max:1000',
        ]);

        Setting::set('running_text', $request->running_text);

        return redirect()->route('admin.ticker')->with('success', 'Running text ticker bar berhasil diperbarui.');
    }
}
