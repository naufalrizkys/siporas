<?php

namespace App\Http\Controllers;

use App\Models\Ormas;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function keberadaan(Request $request)
    {
        // Selalu redirect ke Pendaftaran Baru
        return redirect()->route('laporan.pendaftaran-baru');
    }

    public function cekStatusPage()
    {
        $user = auth()->user();
        $riwayatPengajuan = Pengajuan::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('email', $user->email);
        })->orderBy('created_at', 'desc')->get();

        return view('pengajuan.cek-status', compact('riwayatPengajuan'));
    }

    public function create()
    {
        $ormasList = Ormas::where('status', 'aktif')->orderBy('nama_ormas')->get();

        return view('pengajuan.create', compact('ormasList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jenis_layanan' => 'required|in:pendaftaran_ormas,perpanjangan_skt,perubahan_data,pencabutan_skt,surat_keterangan',
            'ormas_id' => 'nullable|exists:ormas,id',
            'dokumen' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'dokumen.mimes' => 'Dokumen yang diunggah harus berformat PDF.',
            'dokumen.max' => 'Ukuran file dokumen maksimal 10 MB.',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
        }

        $pengajuan = Pengajuan::create($validated);

        return redirect()->route('cek.status')
            ->with('success', 'Pengajuan berhasil dikirim! Nomor pengajuan Anda: #'.str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT));
    }

    public function status($id)
    {
        $pengajuan = Pengajuan::with('ormas')->findOrFail($id);

        return view('pengajuan.status', compact('pengajuan'));
    }

    public function cekStatus(Request $request)
    {
        $riwayatPengajuan = collect();

        if (auth()->check()) {
            $user = auth()->user();
            $riwayatPengajuan = Pengajuan::with('ormas')
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhere('email', $user->email);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pengajuan.cek', compact('riwayatPengajuan'));
    }

    public function storeLaporanPendaftaranBaru(Request $request)
    {
        // Tangkap jika post_max_size terlampaui
        if (empty($_POST) && empty($_FILES) && $request->server('CONTENT_LENGTH') > 0) {
            return back()->withErrors(['upload' => 'Total ukuran file terlalu besar. Kurangi ukuran file (maks. 2 MB per file) dan coba lagi.'])->withInput();
        }

        $request->validate([
            'nama_ormas' => 'required|string|max:255',
            'nama_pemohon' => 'required|string|max:255',
            'bidang_kegiatan' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat_sekretariat' => 'required|string',
            'rt_rw' => 'nullable|string|max:20',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            // Lampiran — nullable agar tidak crash saat upload besar
            'surat_pengantar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_pendirian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sk_kemenkumham' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'program_kerja' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sk_kepengurusan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'domisili' => 'nullable|array',
            'domisili.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'biodata_pengurus' => 'nullable|array',
            'biodata_pengurus.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_pengurus' => 'nullable|array',
            'ktp_pengurus.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dokumen_pelengkap' => 'nullable|array',
            'dokumen_pelengkap.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $lampiranPaths = [];

        // File single
        $singleFields = ['surat_pengantar', 'akta_pendirian', 'sk_kemenkumham', 'program_kerja', 'sk_kepengurusan', 'npwp'];
        foreach ($singleFields as $field) {
            if ($request->hasFile($field)) {
                $lampiranPaths[$field] = $request->file($field)->store('pendaftaran/lampiran', 'public');
            }
        }

        // File multi
        $multiFields = ['domisili', 'biodata_pengurus', 'ktp_pengurus', 'dokumen_pelengkap'];
        foreach ($multiFields as $field) {
            if ($request->hasFile($field)) {
                $lampiranPaths[$field] = [];
                foreach ($request->file($field) as $file) {
                    $lampiranPaths[$field][] = $file->store('pendaftaran/lampiran', 'public');
                }
            }
        }

        $pengajuan = Pengajuan::create([
            'user_id' => auth()->id(),
            'nama_pemohon' => $request->nama_pemohon,
            'nik' => '0000000000000000',
            'telepon' => $request->telepon,
            'email' => auth()->user()->email,
            'jenis_layanan' => 'pendaftaran_ormas',
            'keterangan' => 'Pendaftaran Baru Ormas: '.$request->nama_ormas,
            'data_perubahan' => [
                'organisasi' => [
                    'nama_organisasi' => $request->nama_ormas,
                    'bidang' => $request->bidang_kegiatan,
                    'alamat' => $request->alamat_sekretariat,
                    'rt_rw' => $request->rt_rw,
                    'kelurahan' => $request->kelurahan,
                    'kecamatan' => $request->kecamatan,
                    'kota' => $request->kota,
                    'provinsi' => $request->provinsi,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ],
                'lampiran' => $lampiranPaths,
            ],
            'status' => 'menunggu',
        ]);

        return redirect()->route('cek.status')
            ->with('success', 'Pendaftaran berhasil dikirim ke Admin! Nomor pengajuan Anda: #'.str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT));
    }

    public function storePendaftaranBaru(Request $request)
    {
        // Jika post_max_size terlampaui, PHP membuang semua data — tangkap di sini
        if (empty($_POST) && empty($_FILES) && $request->server('CONTENT_LENGTH') > 0) {
            return back()->withErrors(['upload' => 'Total ukuran file terlalu besar. Harap kurangi ukuran file dan coba lagi.']);
        }

        $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'bidang' => 'required|array|min:1',
            'alamat' => 'required|string',
            'cp_nama' => 'required|string|max:255',
            'cp_hp' => 'required|string|max:20',
            'asas' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'sp_ketua_nama' => 'required|string|max:255',
            'sp_sek_nama' => 'required|string|max:255',
            // file lampiran — nullable supaya validasi tidak crash,
            // frontend JS sudah memastikan semua terisi sebelum submit
            'lamp_surat_pengantar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_akta_pendirian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_sk_kemenkumham' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_program_kerja' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_sk_pengurus' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_domisili' => 'nullable|array',
            'lamp_domisili.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_biodata_ketua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_biodata_sekretaris' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_biodata_bendahara' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_ktp_ketua' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_ktp_sekretaris' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_ktp_bendahara' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'lamp_dokumen_pelengkap' => 'nullable|array',
            'lamp_dokumen_pelengkap.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Simpan semua file lampiran
        $lampiranNames = [
            'lamp_surat_pengantar', 'lamp_akta_pendirian', 'lamp_sk_kemenkumham',
            'lamp_program_kerja', 'lamp_sk_pengurus', 'lamp_npwp',
            'lamp_biodata_ketua', 'lamp_biodata_sekretaris', 'lamp_biodata_bendahara',
            'lamp_ktp_ketua', 'lamp_ktp_sekretaris', 'lamp_ktp_bendahara',
        ];
        $lampiranPaths = [];

        foreach ($lampiranNames as $fieldName) {
            if ($request->hasFile($fieldName)) {
                $lampiranPaths[$fieldName] = $request->file($fieldName)
                    ->store('pendaftaran/lampiran', 'public');
            }
        }

        // File multi (array)
        foreach (['lamp_domisili', 'lamp_dokumen_pelengkap'] as $fieldName) {
            if ($request->hasFile($fieldName)) {
                $lampiranPaths[$fieldName] = [];
                foreach ($request->file($fieldName) as $file) {
                    $lampiranPaths[$fieldName][] = $file->store('pendaftaran/lampiran', 'public');
                }
            }
        }

        // Foto pas pengurus (opsional)
        $fotoPaths = [];
        foreach (['ketua', 'sekretaris', 'bendahara'] as $jab) {
            if ($request->hasFile("foto_{$jab}")) {
                $fotoPaths["foto_{$jab}"] = $request->file("foto_{$jab}")
                    ->store('pendaftaran/foto', 'public');
            }
            if ($request->hasFile("ktp_{$jab}")) {
                $fotoPaths["ktp_{$jab}"] = $request->file("ktp_{$jab}")
                    ->store('pendaftaran/ktp', 'public');
            }
        }

        // File logo, bendera, cap
        foreach (['f02_logo', 'f02_cap', 'f03_bendera', 'f03_foto_kantor'] as $fieldName) {
            if ($request->hasFile($fieldName)) {
                $lampiranPaths[$fieldName] = $request->file($fieldName)
                    ->store('pendaftaran/identitas', 'public');
            }
        }

        // Surat pernyataan
        if ($request->hasFile('surat_pernyataan')) {
            $lampiranPaths['surat_pernyataan'] = $request->file('surat_pernyataan')
                ->store('pendaftaran/surat-pernyataan', 'public');
        }

        // Kumpulkan semua data form ke data_perubahan (digunakan sebagai storage data detail)
        $dataDetail = [
            'organisasi' => [
                'nama_organisasi' => $request->nama_organisasi,
                'singkatan' => $request->singkatan,
                'bidang' => $request->bidang,
                'alamat' => $request->alamat,
                'rt_rw' => $request->rt_rw,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kota' => $request->kota,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'no_sk' => $request->no_sk,
                'tgl_sk' => $request->tgl_sk,
                'asas' => $request->asas,
                'tujuan' => $request->tujuan,
                'nama_pendiri' => $request->nama_pendiri,
                'nama_pembina' => $request->nama_pembina,
                'nama_penasehat' => $request->nama_penasehat,
                'masa_bhakti' => $request->masa_bhakti,
                'keputusan_tertinggi' => $request->keputusan_tertinggi,
                'unit_cabang' => $request->unit_cabang,
                'sumber_keuangan' => $request->sumber_keuangan,
                'usaha' => $request->usaha,
            ],
            'pengurus' => [
                'ketua' => [
                    'nama' => $request->bio_ketua_nama,
                    'nik' => $request->bio_ketua_nik,
                    'agama' => $request->bio_ketua_agama,
                    'jk' => $request->bio_ketua_jk,
                    'status' => $request->bio_ketua_status,
                    'ttl_kota' => $request->bio_ketua_ttl_kota,
                    'ttl_tgl' => $request->bio_ketua_ttl_tgl,
                    'alamat' => $request->bio_ketua_alamat,
                    'hp' => $request->bio_ketua_hp,
                    'pekerjaan' => $request->bio_ketua_pekerjaan,
                ],
                'sekretaris' => [
                    'nama' => $request->bio_sekretaris_nama,
                    'nik' => $request->bio_sekretaris_nik,
                    'agama' => $request->bio_sekretaris_agama,
                    'jk' => $request->bio_sekretaris_jk,
                    'status' => $request->bio_sekretaris_status,
                    'ttl_kota' => $request->bio_sekretaris_ttl_kota,
                    'ttl_tgl' => $request->bio_sekretaris_ttl_tgl,
                    'alamat' => $request->bio_sekretaris_alamat,
                    'hp' => $request->bio_sekretaris_hp,
                    'pekerjaan' => $request->bio_sekretaris_pekerjaan,
                ],
                'bendahara' => [
                    'nama' => $request->bio_bendahara_nama,
                    'nik' => $request->bio_bendahara_nik,
                    'agama' => $request->bio_bendahara_agama,
                    'jk' => $request->bio_bendahara_jk,
                    'status' => $request->bio_bendahara_status,
                    'ttl_kota' => $request->bio_bendahara_ttl_kota,
                    'ttl_tgl' => $request->bio_bendahara_ttl_tgl,
                    'alamat' => $request->bio_bendahara_alamat,
                    'hp' => $request->bio_bendahara_hp,
                    'pekerjaan' => $request->bio_bendahara_pekerjaan,
                ],
            ],
            'surat_pernyataan' => [
                'ketua_nama' => $request->sp_ketua_nama,
                'ketua_ktp' => $request->sp_ketua_ktp,
                'sek_nama' => $request->sp_sek_nama,
                'sek_ktp' => $request->sp_sek_ktp,
                'poin' => $request->sp_poin ?? [],
                'tempat' => $request->sp_tempat,
                'tgl' => $request->sp_tgl,
            ],
            'lampiran' => $lampiranPaths,
            'foto' => $fotoPaths,
        ];

        $pengajuan = Pengajuan::create([
            'user_id' => auth()->id(),
            'nama_pemohon' => $request->sp_ketua_nama ?: $request->cp_nama,
            'nik' => $request->bio_ketua_nik ?? '0000000000000000',
            'telepon' => $request->cp_hp,
            'email' => auth()->user()->email,
            'jenis_layanan' => 'pendaftaran_ormas',
            'keterangan' => 'Pendaftaran Baru Ormas: '.$request->nama_organisasi
                               .($request->singkatan ? ' ('.$request->singkatan.')' : ''),
            'data_perubahan' => $dataDetail,
            'status' => 'menunggu',
        ]);

        return redirect()->route('cek.status')
            ->with('success', 'Pendaftaran berhasil dikirim ke Admin! Simpan nomor pengajuan Anda: #'.str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT));
    }

    public function storePerubahan(Request $request)
    {
        $request->validate([
            'jenis_perubahan' => 'required|array|min:1',
            'jenis_perubahan.*' => 'in:pengurus,alamat,nama,lambang,lainnya',
        ]);

        $jenisSelected = $request->input('jenis_perubahan', []);
        $detailPerubahan = [];
        $dokumenPaths = [];

        // ── Data user & ormas (dibutuhkan di beberapa blok di bawah) ──
        $user = auth()->user();
        $ormas = $user?->ormas;

        // ── Nama ──────────────────────────────────────────────────
        if (in_array('nama', $jenisSelected)) {
            $detailPerubahan['nama'] = [
                'nama_lama' => $request->input('nama_lama'),
                'nama_baru' => $request->input('nama_baru'),
                'singkatan_lama' => $request->input('singkatan_lama'),
                'singkatan_baru' => $request->input('singkatan_baru'),
            ];
            if ($request->hasFile('berkas_nama')) {
                $dokumenPaths['berkas_nama'] = $request->file('berkas_nama')
                    ->store('perubahan/nama', 'public');
            }
        }

        // ── Alamat ────────────────────────────────────────────────
        if (in_array('alamat', $jenisSelected)) {
            $detailPerubahan['alamat'] = [
                'alamat_lama' => $ormas?->alamat_sekretariat,
                'alamat_baru' => $request->input('alamat_baru'),
                'kelurahan_baru' => $request->input('kelurahan_baru'),
                'kecamatan_baru' => $request->input('kecamatan_baru'),
                'kota_baru' => $request->input('kota_baru'),
                'provinsi_baru' => $request->input('provinsi_baru'),
                'latitude_baru' => $request->input('latitude_baru'),
                'longitude_baru' => $request->input('longitude_baru'),
            ];
            if ($request->hasFile('berkas_alamat')) {
                $dokumenPaths['berkas_alamat'] = $request->file('berkas_alamat')
                    ->store('perubahan/alamat', 'public');
            }
        }

        // ── Pengurus ──────────────────────────────────────────────
        if (in_array('pengurus', $jenisSelected)) {
            $detailPerubahan['pengurus'] = [
                'ketua_baru' => $request->input('ketua_baru'),
                'sekretaris_baru' => $request->input('sekretaris_baru'),
                'bendahara_baru' => $request->input('bendahara_baru'),
                'masa_bhakti_baru' => $request->input('masa_bhakti_baru'),
                'sk_pengurus_baru' => $request->input('sk_pengurus_baru'),
            ];
            if ($request->hasFile('berkas_pengurus')) {
                $dokumenPaths['berkas_pengurus'] = $request->file('berkas_pengurus')
                    ->store('perubahan/pengurus', 'public');
            }
        }

        // ── Lambang ───────────────────────────────────────────────
        if (in_array('lambang', $jenisSelected)) {
            if ($request->hasFile('lambang_baru')) {
                $dokumenPaths['lambang_baru'] = $request->file('lambang_baru')
                    ->store('perubahan/lambang', 'public');
            }
            if ($request->hasFile('stempel_baru')) {
                $dokumenPaths['stempel_baru'] = $request->file('stempel_baru')
                    ->store('perubahan/stempel', 'public');
            }
            $detailPerubahan['lambang'] = [
                'lambang_baru' => $dokumenPaths['lambang_baru'] ?? null,
                'stempel_baru' => $dokumenPaths['stempel_baru'] ?? null,
            ];
        }

        // ── Lainnya ───────────────────────────────────────────────
        if (in_array('lainnya', $jenisSelected)) {
            $detailPerubahan['lainnya'] = [
                'uraian' => $request->input('perubahan_lainnya'),
            ];
            if ($request->hasFile('berkas_lainnya')) {
                $dokumenPaths['berkas_lainnya'] = $request->file('berkas_lainnya')
                    ->store('perubahan/lainnya', 'public');
            }
        }

        // ── Snapshot data ormas SEBELUM perubahan ─────────────────
        $dataSebelum = $ormas ? $ormas->only([
            'nama_ormas', 'singkatan', 'alamat_sekretariat',
            'kelurahan', 'kecamatan', 'kota', 'provinsi',
            'latitude', 'longitude', 'telepon', 'email',
        ]) : [];

        $labelsMap = [
            'pengurus' => 'Perubahan Pengurus',
            'alamat' => 'Perubahan Alamat Sekretariat',
            'nama' => 'Perubahan Nama Organisasi',
            'lambang' => 'Perubahan Lambang/Logo/Stempel',
            'lainnya' => 'Lainnya',
        ];
        $labelsStr = implode(', ', array_map(fn ($j) => $labelsMap[$j] ?? $j, $jenisSelected));

        $pengajuan = Pengajuan::create([
            'nama_pemohon' => $user->name ?? 'Pengurus Ormas',
            'nik' => '3315000000000000',
            'telepon' => $user->ormas?->telepon ?? '081234567890',
            'email' => $user->email ?? 'ormas@grobogan.go.id',
            'jenis_layanan' => 'perubahan_data',
            'ormas_id' => $ormas?->id,
            'keterangan' => 'Pengajuan Perubahan Biodata Ormas: '.$labelsStr,
            'data_perubahan' => [
                'jenis' => $jenisSelected,
                'detail' => $detailPerubahan,
                'dokumen' => $dokumenPaths,
                'nama_ormas' => $request->input('nama_ormas_pemohon'),
                'bidang_kegiatan' => $request->input('bidang_kegiatan_pemohon'),
            ],
            'data_sebelum' => $dataSebelum,
            'status' => 'menunggu',
        ]);

        return redirect()->route('cek.status')
            ->with('success', 'Laporan perubahan biodata ormas berhasil dikirim ke Admin Kesbangpol!');
    }

    public function storeKegiatan(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'array', 'min:1'],
            'foto.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'deskripsi_foto' => ['required', 'array', 'min:1'],
            'deskripsi_foto.*' => ['required', 'string', 'max:500'],
        ]);

        $fotoPaths = [];
        foreach ($request->file('foto') as $i => $file) {
            $fotoPaths[] = [
                'path' => $file->store('kegiatan/foto', 'public'),
                'deskripsi' => $request->input('deskripsi_foto')[$i] ?? '',
            ];
        }

        Pengajuan::create([
            'nama_pemohon' => auth()->user()->name,
            'nik' => '3315000000000000',
            'telepon' => auth()->user()->ormas?->telepon ?? '-',
            'email' => auth()->user()->email,
            'jenis_layanan' => 'laporan_kegiatan',
            'keterangan' => 'Laporan foto kegiatan ormas',
            'data_perubahan' => ['foto_kegiatan' => $fotoPaths],
            'status' => 'menunggu',
        ]);

        return redirect()->route('laporan.kegiatan')
            ->with('success', 'Laporan kegiatan berhasil dikirim!');
    }
}
