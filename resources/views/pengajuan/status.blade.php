@extends('layouts.app')

@section('title', 'Status Pengajuan #' . str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT))

@push('styles')
<style>
    /* ── Pop-up notifikasi ── */
    #notif-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,.45);
        z-index: 9999; display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity .3s ease;
    }
    #notif-overlay.show { opacity: 1; }

    #notif-card {
        background: #fff; border-radius: 20px; padding: 40px 36px;
        max-width: 420px; width: 90%; text-align: center;
        transform: scale(.85) translateY(20px);
        transition: transform .35s cubic-bezier(.34,1.56,.64,1);
        box-shadow: 0 24px 64px rgba(0,0,0,.18);
        position: relative;
    }
    #notif-overlay.show #notif-card { transform: scale(1) translateY(0); }

    .notif-icon-ring {
        width: 80px; height: 80px; border-radius: 50%;
        background: #dcfce7; border: 3px solid #86efac;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        animation: popIn .5s cubic-bezier(.34,1.56,.64,1) .2s both;
    }
    @keyframes popIn {
        from { transform: scale(0); opacity: 0; }
        to   { transform: scale(1); opacity: 1; }
    }

    .notif-nomor {
        display: inline-block;
        background: #fef2f2; border: 1.5px solid #fca5a5;
        color: #991b1b; font-size: 22px; font-weight: 900;
        padding: 6px 22px; border-radius: 10px;
        margin: 12px 0 18px; letter-spacing: .04em;
    }

    .notif-close {
        margin-top: 10px; width: 100%;
        background: #991b1b; color: #fff;
        font-weight: 800; font-size: 14px;
        padding: 13px; border-radius: 10px; border: none;
        cursor: pointer; font-family: 'Open Sans', sans-serif;
        transition: background .15s;
    }
    .notif-close:hover { background: #7f1d1d; }
</style>
@endpush

@section('content')

{{-- ══ MODAL NOTIFIKASI SUKSES ══ --}}
@if(session('success'))
<div id="notif-overlay">
    <div id="notif-card">
        <div class="notif-icon-ring">
            <i class="fas fa-check text-green-600" style="font-size:36px;"></i>
        </div>
        <p style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">Pengajuan Berhasil Dikirim</p>
        <p style="font-size:16px;font-weight:800;color:#111827;line-height:1.5;">
            Berkas Anda telah diterima.<br>Silahkan cek status pengajuan secara berkala.
        </p>
        <div class="notif-nomor">#{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}</div>
        <p style="font-size:12px;color:#6b7280;margin-bottom:4px;">Simpan nomor pengajuan di atas sebagai bukti.</p>
        <button class="notif-close" onclick="tutupNotif()">
            <i class="fas fa-arrow-right" style="margin-right:6px;"></i> Lihat Status Pengajuan
        </button>
    </div>
</div>
@endif

<div class="max-w-screen-xl mx-auto px-8 py-12 space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="text-white p-6" style="background:#b91c1c;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-200 text-xs uppercase font-semibold tracking-wider mb-1">Nomor Pengajuan</p>
                    <h1 class="text-2xl font-bold">#{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-red-200 text-xs mt-1">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                </div>
                @php
                    $sc = [
                        'menunggu'  => ['Menunggu Verifikasi', 'hourglass-half', 'bg-blue-600 text-white border-blue-400',    'text-blue-600'],
                        'diproses'  => ['Sedang Diproses',     'spinner',        'bg-blue-600 text-white border-blue-400',    'text-blue-600'],
                        'disetujui' => ['Disetujui',           'check',          'bg-emerald-600 text-white border-emerald-400','text-emerald-600'],
                        'ditolak'   => ['Ditolak',             'times',          'bg-red-600 text-white border-red-400',      'text-red-600'],
                    ];
                    $s = $sc[$pengajuan->status] ?? ['Unknown', 'question', 'bg-gray-600 text-white border-gray-400', 'text-gray-600'];
                @endphp
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-md mb-2">
                        <i class="fas fa-{{ $s[1] }} text-lg {{ $s[3] }} {{ $pengajuan->status === 'diproses' ? 'fa-spin' : '' }}"></i>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-wide border px-4 py-1 rounded-full shadow-sm {{ $s[2] }}">{{ $s[0] }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- Alur Status ── hanya 3 kondisi: Sedang Diproses / Ditolak / Disetujui ── --}}
            <div>
                <h3 class="font-bold text-gray-700 text-xs uppercase tracking-wider mb-4">Alur Status Pengajuan</h3>

                @php
                    $steps = [
                        ['key' => 'menunggu',  'label' => 'Pengajuan Dikirim', 'icon' => 'paper-plane'],
                        ['key' => 'diproses',  'label' => 'Sedang Diproses',   'icon' => 'tasks'],
                        ['key' => 'disetujui', 'label' => 'Disetujui',         'icon' => 'check-circle'],
                    ];
                    $isDitolak = $pengajuan->status === 'ditolak';
                    $currentStatus = $pengajuan->status;
                @endphp

                <div class="flex items-center gap-0">
                    @foreach($steps as $i => $step)
                    @php
                        // Step 1 (Pengajuan Dikirim): always active/done
                        // Step 2 (Sedang Diproses): active when status is 'diproses' or 'disetujui'
                        // Step 3 (Disetujui): active only when status is 'disetujui'
                        $isDone = !$isDitolak && (
                            $i === 0 ||
                            ($i === 1 && in_array($currentStatus, ['diproses', 'disetujui'])) ||
                            ($i === 2 && $currentStatus === 'disetujui')
                        );
                        $isActive = $currentStatus === $step['key'];
                    @endphp

                    {{-- Step bubble --}}
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 border-2
                            {{ $isDone
                                ? 'bg-green-500 border-green-500 text-white'
                                : ($isActive && !$isDitolak
                                    ? 'bg-white border-blue-400 text-blue-600'
                                    : 'bg-gray-100 border-gray-200 text-gray-400') }}">
                            @if($isDone)
                                <i class="fas fa-check text-xs"></i>
                            @else
                                <i class="fas fa-{{ $step['icon'] }} text-xs"></i>
                            @endif
                        </div>
                        <span class="text-xs mt-2 text-center font-semibold leading-tight
                            {{ $isDone ? 'text-green-700' : ($isActive && !$isDitolak ? 'text-blue-700' : 'text-gray-400') }}"
                             style="max-width:72px;">
                            {{ $step['label'] }}
                        </span>
                    </div>

                    {{-- Connector --}}
                    @if(!$loop->last)
                    @php
                        // Connector between step $i and step $i+1 is green when the next step is done
                        $nextIdx = $i + 1;
                        $connectorGreen = !$isDitolak && (
                            $nextIdx === 0 ||
                            ($nextIdx === 1 && in_array($currentStatus, ['diproses', 'disetujui'])) ||
                            ($nextIdx === 2 && $currentStatus === 'disetujui')
                        );
                    @endphp
                    <div class="h-0.5 flex-1 -mt-5 mx-1
                        {{ $connectorGreen ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                    @endif

                    @endforeach
                </div>

                {{-- Ditolak banner --}}
                @if($isDitolak)
                <div class="mt-4 flex items-center gap-3 bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-times text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-red-700 text-sm">Pengajuan Ditolak</p>
                        <p class="text-xs text-red-500 mt-0.5">Periksa catatan admin di bawah untuk informasi lebih lanjut.</p>
                    </div>
                </div>
                @endif
            </div>

            <hr class="border-gray-100">

            {{-- Info Ringkas --}}
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-400 block text-xs mb-0.5">Nama Pemohon</span>
                    <span class="font-semibold text-gray-900">{{ $pengajuan->nama_pemohon }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-xs mb-0.5">Jenis Layanan</span>
                    <span class="font-bold text-red-700">{{ $pengajuan->jenis_layanan_label }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block text-xs mb-0.5">Tanggal Pengajuan</span>
                    <span class="font-semibold text-gray-900">{{ $pengajuan->created_at->format('d M Y, H:i') }}</span>
                </div>
                @if($pengajuan->ormas)
                <div>
                    <span class="text-gray-400 block text-xs mb-0.5">Ormas</span>
                    <span class="font-bold text-gray-900">{{ $pengajuan->ormas->nama_ormas }}</span>
                </div>
                @endif
            </div>

            {{-- Catatan admin --}}
            @if($pengajuan->catatan_admin)
            <div class="p-4 rounded-xl border
                {{ $pengajuan->status === 'disetujui' ? 'bg-green-50 border-green-200 text-green-900'
                 : ($pengajuan->status === 'ditolak'  ? 'bg-red-50 border-red-200 text-red-900'
                 : 'bg-gray-50 border-gray-200 text-gray-800') }}">
                <p class="text-xs font-bold uppercase mb-1">
                    <i class="fas fa-comment-dots mr-1"></i> Catatan Admin Kesbangpol
                </p>
                <p class="text-sm font-medium">{{ $pengajuan->catatan_admin }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Tombol bawah --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('home') }}"
           class="flex-1 border border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-3 rounded-xl transition inline-flex items-center justify-center gap-2 text-sm bg-white shadow-xs">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
        <a href="{{ route('pengajuan.cek') }}"
           class="flex-1 bg-red-700 hover:bg-red-800 text-white font-bold py-3 rounded-xl transition inline-flex items-center justify-center gap-2 text-sm shadow-xs">
            <i class="fas fa-list"></i> Lihat Semua Pengajuan Saya
        </a>
    </div>
</div>

@push('scripts')
<script>
    // Tampilkan modal dengan animasi
    @if(session('success'))
    (function () {
        const overlay = document.getElementById('notif-overlay');
        if (!overlay) { return; }
        // Sedikit delay agar transisi CSS terpicu
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                overlay.classList.add('show');
            });
        });
    })();
    @endif

    function tutupNotif() {
        const overlay = document.getElementById('notif-overlay');
        if (!overlay) { return; }
        overlay.classList.remove('show');
        setTimeout(function () { overlay.remove(); }, 300);
    }

    // Tutup jika klik di luar card
    document.getElementById('notif-overlay')?.addEventListener('click', function (e) {
        if (e.target === this) { tutupNotif(); }
    });
</script>
@endpush

@endsection
