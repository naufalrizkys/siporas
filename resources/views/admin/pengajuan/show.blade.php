@extends('layouts.admin')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail & Verifikasi Pengajuan #' . str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-5xl space-y-6">

    {{-- Alert --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 text-lg"></i>
            <span class="text-sm font-semibold text-green-800">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 text-sm font-bold">&times;</button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Detail Konten --}}
        <div class="lg:col-span-2 space-y-5">
            {{-- Header Card --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Nomor Pengajuan</span>
                        <h2 class="text-xl font-bold text-gray-900">#{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}</h2>
                    </div>
                    @php
                        $sc = ['menunggu'=>'bg-yellow-100 text-yellow-800 border-yellow-200','diproses'=>'bg-blue-100 text-blue-800 border-blue-200','disetujui'=>'bg-green-100 text-green-800 border-green-200','ditolak'=>'bg-red-100 text-red-800 border-red-200'];
                    @endphp
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full border {{ $sc[$pengajuan->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $pengajuan->status_label }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-400 block text-xs">Nama Pemohon</span><span class="font-medium text-gray-800">{{ $pengajuan->nama_pemohon }}</span></div>
                    <div><span class="text-gray-400 block text-xs">NIK Pemohon</span><span class="font-medium text-gray-800">{{ $pengajuan->nik }}</span></div>
                    <div><span class="text-gray-400 block text-xs">Telepon</span><span class="font-medium text-gray-800">{{ $pengajuan->telepon }}</span></div>
                    <div><span class="text-gray-400 block text-xs">Email</span><span class="font-medium text-gray-800">{{ $pengajuan->email }}</span></div>
                    <div><span class="text-gray-400 block text-xs">Jenis Layanan</span><span class="font-semibold text-blue-700">{{ $pengajuan->jenis_layanan_label }}</span></div>
                    <div><span class="text-gray-400 block text-xs">Tanggal Pengajuan</span><span class="font-medium text-gray-800">{{ $pengajuan->created_at->format('d M Y, H:i') }}</span></div>
                    @if($pengajuan->ormas)
                    <div class="col-span-2"><span class="text-gray-400 block text-xs">Organisasi (Ormas)</span><span class="font-bold text-gray-900">{{ $pengajuan->ormas->nama_ormas }}</span></div>
                    @endif
                    @if($pengajuan->keterangan)
                    <div class="col-span-2 bg-gray-50 p-3 rounded-lg"><span class="text-gray-400 block text-xs font-medium">Keterangan / Uraian</span><p class="text-gray-800 text-xs mt-1">{{ $pengajuan->keterangan }}</p></div>
                    @endif
                </div>
            </div>

            {{-- Card Cek Dokumen Terlampir --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h2 class="font-bold text-gray-900 mb-3 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <i class="fas fa-folder-open text-blue-600"></i> Cek Dokumen Terlampir
                </h2>

                @php
                    $allLampiran = [];
                    // Dari field dokumen tunggal (pengajuan lama)
                    if ($pengajuan->dokumen) {
                        $allLampiran['dokumen'] = $pengajuan->dokumen;
                    }
                    // Dari data_perubahan['lampiran'] (pendaftaran baru / laporan keberadaan)
                    if (!empty($pengajuan->data_perubahan['lampiran'])) {
                        foreach ($pengajuan->data_perubahan['lampiran'] as $k => $v) {
                            if (!empty($v)) {
                                $allLampiran[$k] = $v;
                            }
                        }
                    }
                    // Dari data_perubahan['dokumen'] (laporan perubahan biodata)
                    if (!empty($pengajuan->data_perubahan['dokumen'])) {
                        foreach ($pengajuan->data_perubahan['dokumen'] as $k => $v) {
                            if (!empty($v)) {
                                $allLampiran[$k] = $v;
                            }
                        }
                    }
                    $lampiranLabelMap = [
                        'dokumen'             => 'Dokumen Utama',
                        // Laporan perubahan biodata
                        'berkas_nama'         => 'Berkas Perubahan Nama',
                        'berkas_alamat'       => 'Surat Domisili Baru',
                        'berkas_pengurus'     => 'SK Kepengurusan Baru',
                        'lambang_baru'        => 'Lambang/Logo Baru',
                        'stempel_baru'        => 'Cap Stempel Baru',
                        'berkas_lainnya'      => 'Berkas Pendukung Lainnya',
                        // Pendaftaran / laporan keberadaan
                        'surat_pengantar'     => 'Surat Pengantar',
                        'lamp_surat_pengantar'=> 'Surat Pengantar',
                        'akta_pendirian'      => 'Akta Pendirian/Notaris',
                        'lamp_akta_pendirian' => 'Akta Pendirian/Notaris',
                        'sk_kemenkumham'      => 'SK Kemenkumham',
                        'lamp_sk_kemenkumham' => 'SK Kemenkumham',
                        'program_kerja'       => 'Program Kerja',
                        'lamp_program_kerja'  => 'Program Kerja',
                        'sk_kepengurusan'     => 'SK Susunan Pengurus',
                        'lamp_sk_pengurus'    => 'SK Susunan Pengurus',
                        'domisili'            => 'Surat Domisili',
                        'lamp_domisili'       => 'Surat Domisili',
                        'npwp'                => 'NPWP Ormas',
                        'lamp_npwp'           => 'NPWP Ormas',
                        'biodata_pengurus'    => 'Biodata Pengurus',
                        'lamp_biodata_ketua'  => 'Biodata Ketua',
                        'lamp_biodata_sekretaris' => 'Biodata Sekretaris',
                        'lamp_biodata_bendahara'  => 'Biodata Bendahara',
                        'ktp_pengurus'        => 'E-KTP Pengurus',
                        'lamp_ktp_ketua'      => 'E-KTP Ketua',
                        'lamp_ktp_sekretaris' => 'E-KTP Sekretaris',
                        'lamp_ktp_bendahara'  => 'E-KTP Bendahara',
                        'dokumen_pelengkap'   => 'Dokumen Pelengkap',
                        'lamp_dokumen_pelengkap' => 'Dokumen Pelengkap',
                        'f02_logo'            => 'Logo/Lambang',
                        'f02_cap'             => 'Cap Stempel',
                        'f03_bendera'         => 'Foto Bendera',
                        'f03_foto_kantor'     => 'Foto Kantor',
                        'surat_pernyataan'    => 'Surat Pernyataan',
                    ];
                @endphp

                @if(!empty($allLampiran))
                <div class="grid grid-cols-1 gap-2">
                    @foreach($allLampiran as $key => $path)
                    @php $paths = is_array($path) ? $path : [$path]; @endphp
                    @foreach($paths as $idx => $p)
                    @if(!empty($p))
                    <div class="flex items-center gap-3 bg-blue-50 border border-blue-100 rounded-xl p-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-alt text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-blue-900">{{ $lampiranLabelMap[$key] ?? $key }}{{ count($paths) > 1 ? ' ('.($idx+1).')' : '' }}</p>
                            <p class="text-xs text-blue-600 truncate">{{ basename($p) }}</p>
                        </div>
                        <a href="{{ Storage::url($p) }}" target="_blank"
                            class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition flex-shrink-0">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                    </div>
                    @endif
                    @endforeach
                    @endforeach
                </div>
                @else
                <div class="text-sm text-gray-500 py-3 bg-gray-50 rounded-lg text-center">
                    <i class="fas fa-info-circle text-gray-400 mr-1"></i> Tidak ada file dokumen terlampir pada pengajuan ini.
                </div>
                @endif
            </div>

            {{-- Detail Perubahan Data (Jika jenis_layanan = perubahan_data) --}}
            @if($pengajuan->data_perubahan)
            @php
                $dp = $pengajuan->data_perubahan;
            @endphp

            {{-- ── Pendaftaran Ormas Baru ── --}}
            @if($pengajuan->jenis_layanan === 'pendaftaran_ormas')
            @php
                $org      = $dp['organisasi'] ?? [];
                $pgrs     = $dp['pengurus'] ?? [];
                $sp       = $dp['surat_pernyataan'] ?? [];
                $foto     = $dp['foto'] ?? [];
                $lat      = $org['latitude'] ?? null;
                $lng      = $org['longitude'] ?? null;
            @endphp
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
                <h2 class="font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-file-alt text-red-700"></i> Detail Pendaftaran Ormas Baru
                </h2>

                {{-- Data Organisasi --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Data Organisasi</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><span class="text-gray-400 block text-xs">Nama Organisasi</span><span class="font-bold text-gray-900">{{ $org['nama_organisasi'] ?? '-' }}</span></div>
                        <div><span class="text-gray-400 block text-xs">Singkatan</span><span class="font-medium">{{ $org['singkatan'] ?? '-' }}</span></div>
                        <div class="col-span-2"><span class="text-gray-400 block text-xs">Bidang Kegiatan</span><span class="font-medium">{{ is_array($org['bidang'] ?? null) ? implode(', ', $org['bidang']) : ($org['bidang'] ?? '-') }}</span></div>
                        <div class="col-span-2"><span class="text-gray-400 block text-xs">Alamat Sekretariat</span><span class="font-medium">{{ $org['alamat'] ?? '-' }}</span></div>
                        @if(!empty($org['kelurahan']) || !empty($org['kecamatan']))
                        <div><span class="text-gray-400 block text-xs">Kelurahan</span><span class="font-medium">{{ $org['kelurahan'] ?? '-' }}</span></div>
                        <div><span class="text-gray-400 block text-xs">Kecamatan</span><span class="font-medium">{{ $org['kecamatan'] ?? '-' }}</span></div>
                        <div><span class="text-gray-400 block text-xs">Kota / Kab.</span><span class="font-medium">{{ $org['kota'] ?? '-' }}</span></div>
                        <div><span class="text-gray-400 block text-xs">Provinsi</span><span class="font-medium">{{ $org['provinsi'] ?? '-' }}</span></div>
                        @endif
                        @if(!empty($org['asas']))
                        <div><span class="text-gray-400 block text-xs">Asas / Ciri</span><span class="font-medium">{{ $org['asas'] }}</span></div>
                        @endif
                        @if(!empty($org['masa_bhakti']))
                        <div><span class="text-gray-400 block text-xs">Masa Bhakti</span><span class="font-medium">{{ $org['masa_bhakti'] }}</span></div>
                        @endif
                        @if(!empty($org['tujuan']))
                        <div class="col-span-2"><span class="text-gray-400 block text-xs">Tujuan Organisasi</span><p class="font-medium">{{ $org['tujuan'] }}</p></div>
                        @endif
                        @if(!empty($org['no_sk']))
                        <div><span class="text-gray-400 block text-xs">No. SK Kemenkumham</span><span class="font-medium">{{ $org['no_sk'] }}</span></div>
                        <div><span class="text-gray-400 block text-xs">Tanggal SK</span><span class="font-medium">{{ $org['tgl_sk'] ?? '-' }}</span></div>
                        @endif
                    </div>
                </div>

                {{-- Pin Poin Lokasi --}}
                @if($lat && $lng)
                <hr class="border-gray-100">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-red-600"></i> Titik Lokasi Sekretariat
                    </h3>
                    <div class="rounded-xl overflow-hidden border border-gray-200" style="height:260px;">
                        <iframe
                            src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=16&output=embed"
                            width="100%" height="260" frameborder="0"
                            style="border:0;display:block;" allowfullscreen loading="lazy">
                        </iframe>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <i class="fas fa-crosshairs text-gray-400 text-xs"></i>
                        <span class="text-xs text-gray-500">Koordinat: {{ $lat }}, {{ $lng }}</span>
                        <a href="https://maps.google.com/?q={{ $lat }},{{ $lng }}" target="_blank"
                           class="ml-auto text-xs text-blue-600 font-semibold hover:underline flex items-center gap-1">
                            <i class="fas fa-external-link-alt"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>
                @endif

                {{-- Data Pengurus --}}
                @if(!empty($pgrs))
                <hr class="border-gray-100">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Data Pengurus</h3>
                    <div class="space-y-3">
                        @foreach(['ketua' => 'Ketua', 'sekretaris' => 'Sekretaris', 'bendahara' => 'Bendahara'] as $key => $label)
                        @if(!empty($pgrs[$key]))
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <div class="text-xs font-bold text-red-700 uppercase mb-2">{{ $label }}</div>
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div><span class="text-gray-400 block text-xs">Nama</span><span class="font-bold">{{ $pgrs[$key]['nama'] ?? '-' }}</span></div>
                                <div><span class="text-gray-400 block text-xs">NIK</span><span class="font-medium">{{ $pgrs[$key]['nik'] ?? '-' }}</span></div>
                                <div><span class="text-gray-400 block text-xs">No. HP</span><span class="font-medium">{{ $pgrs[$key]['hp'] ?? '-' }}</span></div>
                                <div><span class="text-gray-400 block text-xs">Tempat, Tgl Lahir</span><span class="font-medium">{{ ($pgrs[$key]['ttl_kota'] ?? '') }}, {{ ($pgrs[$key]['ttl_tgl'] ?? '-') }}</span></div>
                                <div><span class="text-gray-400 block text-xs">Pekerjaan</span><span class="font-medium">{{ $pgrs[$key]['pekerjaan'] ?? '-' }}</span></div>
                                <div><span class="text-gray-400 block text-xs">Agama</span><span class="font-medium">{{ $pgrs[$key]['agama'] ?? '-' }}</span></div>
                                <div class="col-span-3"><span class="text-gray-400 block text-xs">Alamat (KTP)</span><span class="font-medium">{{ $pgrs[$key]['alamat'] ?? '-' }}</span></div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Surat Pernyataan --}}
                @if(!empty($sp))
                <hr class="border-gray-100">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Surat Pernyataan</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><span class="text-gray-400 block text-xs">Ketua</span><span class="font-bold">{{ $sp['ketua_nama'] ?? '-' }}</span></div>
                        <div><span class="text-gray-400 block text-xs">Sekretaris</span><span class="font-bold">{{ $sp['sek_nama'] ?? '-' }}</span></div>
                        <div><span class="text-gray-400 block text-xs">Tempat & Tanggal</span><span class="font-medium">{{ ($sp['tempat'] ?? '-') }}, {{ ($sp['tgl'] ?? '-') }}</span></div>
                        <div>
                            <span class="text-gray-400 block text-xs">Poin Disetujui</span>
                            <span class="font-medium">{{ !empty($sp['poin']) ? strtoupper(implode(', ', $sp['poin'])) : '-' }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- ── Perubahan Data Ormas ── --}}
            @elseif($pengajuan->jenis_layanan === 'perubahan_data')
            @php
                $jenisList = $dp['jenis'] ?? [];
                $detail = $dp['detail'] ?? [];
                $labelsMap = [
                    'pengurus' => 'Perubahan Pengurus',
                    'alamat' => 'Perubahan Alamat Sekretariat',
                    'nama' => 'Perubahan Nama Organisasi',
                    'lambang' => 'Perubahan Lambang/Logo/Stempel',
                    'lainnya' => 'Lainnya',
                ];
            @endphp
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
                <h2 class="font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-edit text-purple-700"></i> Detail Perubahan Data Ormas
                </h2>

                <div>
                    <span class="text-xs text-gray-400 block mb-2 font-medium">Kategori Perubahan:</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($jenisList as $j)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-800 text-xs font-semibold rounded-full border border-purple-200">
                            <i class="fas fa-check-circle text-purple-600"></i> {{ $labelsMap[$j] ?? $j }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-4 pt-2">
                    @if(in_array('nama', $jenisList) && isset($detail['nama']))
                    <div class="bg-purple-50/50 p-4 rounded-lg border border-purple-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider mb-2 text-purple-900 flex items-center gap-1.5">
                            <i class="fas fa-tag"></i> Perubahan Nama Organisasi
                        </h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="text-gray-400 block text-xs">Nama Lama</span><span class="font-medium text-gray-800">{{ $detail['nama']['nama_lama'] ?? '-' }}</span></div>
                            <div><span class="text-gray-400 block text-xs">Nama Baru</span><span class="font-bold text-purple-900">{{ $detail['nama']['nama_baru'] ?? '-' }}</span></div>
                            <div><span class="text-gray-400 block text-xs">Singkatan Lama</span><span class="font-medium text-gray-800">{{ $detail['nama']['singkatan_lama'] ?? '-' }}</span></div>
                            <div><span class="text-gray-400 block text-xs">Singkatan Baru</span><span class="font-bold text-purple-900">{{ $detail['nama']['singkatan_baru'] ?? '-' }}</span></div>
                        </div>
                    </div>
                    @endif

                    @if(in_array('alamat', $jenisList) && isset($detail['alamat']))
                    <div class="bg-purple-50/50 p-4 rounded-lg border border-purple-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider mb-2 text-purple-900 flex items-center gap-1.5">
                            <i class="fas fa-map-marker-alt"></i> Perubahan Alamat Sekretariat
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div><span class="text-gray-400 block text-xs">Alamat Lama</span><p class="text-gray-800">{{ $detail['alamat']['alamat_lama'] ?? '-' }}</p></div>
                            <div><span class="text-gray-400 block text-xs">Alamat Baru</span><p class="text-purple-900 font-bold">{{ $detail['alamat']['alamat_baru'] ?? '-' }}</p></div>
                        </div>
                    </div>
                    @endif

                    @if(in_array('pengurus', $jenisList) && isset($detail['pengurus']))
                    <div class="bg-purple-50/50 p-4 rounded-lg border border-purple-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider mb-2 text-purple-900 flex items-center gap-1.5">
                            <i class="fas fa-users"></i> Perubahan Pengurus
                        </h3>
                        <div class="grid grid-cols-3 gap-3 text-sm">
                            <div><span class="text-gray-400 block text-xs">Ketua Baru</span><span class="font-bold text-gray-900">{{ $detail['pengurus']['ketua_baru'] ?? '-' }}</span></div>
                            <div><span class="text-gray-400 block text-xs">Sekretaris Baru</span><span class="font-medium text-gray-800">{{ $detail['pengurus']['sekretaris_baru'] ?? '-' }}</span></div>
                            <div><span class="text-gray-400 block text-xs">Bendahara Baru</span><span class="font-medium text-gray-800">{{ $detail['pengurus']['bendahara_baru'] ?? '-' }}</span></div>
                            <div><span class="text-gray-400 block text-xs">Masa Bhakti</span><span class="font-medium text-gray-800">{{ $detail['pengurus']['masa_bhakti_baru'] ?? '-' }}</span></div>
                            <div class="col-span-2"><span class="text-gray-400 block text-xs">Dasar SK</span><span class="font-medium text-gray-800">{{ $detail['pengurus']['sk_pengurus_baru'] ?? '-' }}</span></div>
                        </div>
                    </div>
                    @endif

                    @if(in_array('lambang', $jenisList) && isset($detail['lambang']))
                    <div class="bg-purple-50/50 p-4 rounded-lg border border-purple-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider mb-2 text-purple-900 flex items-center gap-1.5">
                            <i class="fas fa-star"></i> Perubahan Lambang / Logo / Stempel
                        </h3>
                        <div class="flex flex-wrap gap-4 text-sm">
                            @if(!empty($detail['lambang']['lambang_baru']))
                            <div>
                                <span class="text-gray-400 block text-xs mb-1 font-medium">Lambang / Logo Baru</span>
                                <a href="{{ Storage::url($detail['lambang']['lambang_baru']) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-purple-700 font-semibold bg-white border border-purple-200 px-3 py-1.5 rounded-md hover:bg-purple-50">
                                    <i class="fas fa-image"></i> Cek Berkas Lambang
                                </a>
                            </div>
                            @endif
                            @if(!empty($detail['lambang']['stempel_baru']))
                            <div>
                                <span class="text-gray-400 block text-xs mb-1 font-medium">Cap Stempel Baru</span>
                                <a href="{{ Storage::url($detail['lambang']['stempel_baru']) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-purple-700 font-semibold bg-white border border-purple-200 px-3 py-1.5 rounded-md hover:bg-purple-50">
                                    <i class="fas fa-stamp"></i> Cek Berkas Stempel
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            @endif
        </div>

        {{-- Panel Keputusan Admin (Setujui / Tolak) --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
                <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-gavel text-red-700"></i> Keputusan &amp; Status Admin
                </h3>

                {{-- Quick Decision Buttons --}}
                <div class="space-y-2">
                    <span class="text-xs text-gray-400 font-semibold block uppercase">Aksi Cepat Keputusan:</span>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="quickDecision('disetujui')"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-3 rounded-xl text-xs flex items-center justify-center gap-1.5 transition shadow-sm">
                            <i class="fas fa-check-circle text-base"></i> Setujui
                        </button>
                        <button type="button" onclick="quickDecision('ditolak')"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-3 rounded-xl text-xs flex items-center justify-center gap-1.5 transition shadow-sm">
                            <i class="fas fa-times-circle text-base"></i> Tolak
                        </button>
                    </div>
                </div>

                <hr class="border-gray-100">

                <form id="updateForm" action="{{ route('admin.pengajuan.update', $pengajuan) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Status Pengajuan</label>
                        <select name="status" id="statusSelect" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300">
                            <option value="menunggu" {{ $pengajuan->status === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="diproses" {{ $pengajuan->status === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="disetujui" {{ $pengajuan->status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ $pengajuan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Catatan Admin / Alasan</label>
                        <textarea name="catatan_admin" id="catatanInput" rows="8" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 resize-none" placeholder="Tuliskan catatan untuk pemohon (akan muncul di Cek Status)...">{{ $pengajuan->catatan_admin }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-3 rounded-xl text-sm transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <i class="fas fa-save"></i> Simpan Status &amp; Catatan
                    </button>
                </form>
            </div>

            <a href="{{ route('admin.pengajuan.download', $pengajuan) }}"
               class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                <i class="fas fa-download"></i> Download Semua Dokumen (.zip)
            </a>

            {{-- Card Data Ormas Terhubung --}}
            @if($pengajuan->ormas)
            @php $o = $pengajuan->ormas; @endphp
            <div class="bg-white rounded-xl border border-green-200 shadow-sm p-5 space-y-3">
                <h3 class="font-bold text-green-800 flex items-center gap-2 text-sm border-b border-green-100 pb-2">
                    <i class="fas fa-check-circle text-green-600"></i> Data Ormas Terdaftar
                </h3>
                <div class="space-y-2 text-xs">
                    <div>
                        <span class="text-gray-400 block">Nama Ormas</span>
                        <span class="font-bold text-gray-900 text-sm">{{ $o->nama_ormas }}</span>
                        @if($o->singkatan)
                        <span class="text-gray-500"> ({{ $o->singkatan }})</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-gray-400 block">Bidang Kegiatan</span>
                        <span class="font-medium text-gray-800">{{ $o->bidang_kegiatan }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block">Alamat Sekretariat</span>
                        <span class="font-medium text-gray-800">{{ $o->alamat_sekretariat }}</span>
                        @if($o->kelurahan || $o->kecamatan)
                        <span class="text-gray-500 block">{{ implode(', ', array_filter([$o->kelurahan, $o->kecamatan])) }}</span>
                        @endif
                        <span class="text-gray-600">{{ $o->kota }}, {{ $o->provinsi }}</span>
                    </div>
                    @if($o->telepon)
                    <div>
                        <span class="text-gray-400 block">Telepon</span>
                        <span class="font-medium text-gray-800">{{ $o->telepon }}</span>
                    </div>
                    @endif
                    @if($o->email)
                    <div>
                        <span class="text-gray-400 block">Email</span>
                        <span class="font-medium text-gray-800">{{ $o->email }}</span>
                    </div>
                    @endif
                    @if($o->nomor_skt)
                    <div>
                        <span class="text-gray-400 block">Nomor SKT</span>
                        <span class="font-medium text-gray-800">{{ $o->nomor_skt }}</span>
                    </div>
                    @endif
                    <div class="pt-1">
                        @php $sc = ['aktif'=>'bg-green-100 text-green-700','tidak_aktif'=>'bg-red-100 text-red-700','menunggu'=>'bg-yellow-100 text-yellow-700']; @endphp
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $sc[$o->status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $o->status_label }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.ormas.edit', $o) }}"
                   class="flex items-center justify-center gap-1.5 text-xs font-semibold text-green-700 border border-green-200 rounded-lg py-2 hover:bg-green-50 transition mt-1">
                    <i class="fas fa-edit"></i> Edit Data Ormas
                </a>
            </div>
            @endif

            <a href="{{ route('admin.pengajuan') }}" class="flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-sm transition">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengajuan
            </a>        </div>
    </div>
</div>

<script>
    // Data dari server untuk pesan otomatis
    const pemohon      = @json($pengajuan->nama_pemohon);
    const jenisLayanan = @json($pengajuan->jenis_layanan_label);
    const noPengajuan  = '#{{ str_pad($pengajuan->id, 4, "0", STR_PAD_LEFT) }}';
    const namaOrmas    = @json($pengajuan->ormas?->nama_ormas ?? ($pengajuan->data_perubahan['organisasi']['nama_organisasi'] ?? null));
    const tglHariIni   = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

    function quickDecision(statusVal) {
        const select = document.getElementById('statusSelect');
        const catatan = document.getElementById('catatanInput');
        select.value = statusVal;

        // Selalu isi pesan otomatis sesuai status
        if (statusVal === 'disetujui') {
            let msg = `Yth. Bapak/Ibu ${pemohon},\n\n`;
            msg += `Dengan hormat, kami informasikan bahwa pengajuan ${jenisLayanan} `;
            msg += `nomor ${noPengajuan} yang Anda ajukan `;
            if (namaOrmas) msg += `atas nama organisasi "${namaOrmas}" `;
            msg += `telah kami periksa dan dinyatakan DISETUJUI pada tanggal ${tglHariIni}.\n\n`;
            msg += `Dokumen persyaratan telah lengkap dan memenuhi ketentuan yang berlaku. `;
            if (namaOrmas) msg += `Organisasi Anda kini telah terdaftar secara resmi di sistem SIPORAS. `;
            msg += `\n\nDemikian pemberitahuan ini kami sampaikan. Terima kasih atas kepercayaan Anda.\n\n`;
            msg += `Hormat kami,\nBadan Kesatuan Bangsa dan Politik\nKabupaten Grobogan`;
            catatan.value = msg;

        } else if (statusVal === 'ditolak') {
            let msg = `Yth. Bapak/Ibu ${pemohon},\n\n`;
            msg += `Dengan hormat, kami informasikan bahwa pengajuan ${jenisLayanan} `;
            msg += `nomor ${noPengajuan} yang Anda ajukan `;
            if (namaOrmas) msg += `atas nama organisasi "${namaOrmas}" `;
            msg += `pada tanggal ${tglHariIni} tidak dapat kami setujui.\n\n`;
            msg += `Alasan penolakan: Berkas persyaratan belum lengkap atau tidak sesuai dengan ketentuan yang berlaku. `;
            msg += `Anda dapat melengkapi berkas dan mengajukan kembali melalui sistem SIPORAS.\n\n`;
            msg += `Demikian pemberitahuan ini kami sampaikan. Mohon maaf atas ketidaknyamanan ini.\n\n`;
            msg += `Hormat kami,\nBadan Kesatuan Bangsa dan Politik\nKabupaten Grobogan`;
            catatan.value = msg;

        } else if (statusVal === 'diproses') {
            let msg = `Yth. Bapak/Ibu ${pemohon},\n\n`;
            msg += `Dengan hormat, kami informasikan bahwa pengajuan ${jenisLayanan} `;
            msg += `nomor ${noPengajuan} Anda sedang dalam proses verifikasi oleh petugas kami.\n\n`;
            msg += `Harap bersabar dan pantau status pengajuan secara berkala melalui fitur Cek Status di website SIPORAS.\n\n`;
            msg += `Hormat kami,\nBadan Kesatuan Bangsa dan Politik\nKabupaten Grobogan`;
            catatan.value = msg;
        }

        document.getElementById('updateForm').submit();
    }
</script>
@endsection
