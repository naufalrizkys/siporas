@extends('layouts.app')

@section('title', 'Status Pengajuan Saya')

@push('styles')
<style>
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50%       { opacity: .35; }
    }
    .pulse { animation: pulse-dot 1.5s infinite; }
</style>
@endpush

@section('content')

{{-- ── Page Header ── --}}
<div style="background:linear-gradient(135deg,#991b1b,#7f1d1d);padding:32px 24px 28px;text-align:center;">
    <i class="fas fa-clipboard-list" style="font-size:32px;color:rgba(255,255,255,.3);margin-bottom:10px;display:block;"></i>
    <h1 style="font-size:20px;font-weight:900;color:#fff;margin-bottom:5px;letter-spacing:.02em;">Status Pengajuan Saya</h1>
    <p style="font-size:13px;color:rgba(255,255,255,.75);max-width:480px;margin:0 auto;">
        Seluruh pengajuan yang telah Anda kirimkan beserta status terbarunya.
    </p>
</div>

<div style="max-width:760px;margin:0 auto;padding:28px 20px 56px;">

    @auth

    @if($riwayatPengajuan->isEmpty())

    {{-- ── Kosong ── --}}
    <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:16px;border:1.5px dashed #e5e7eb;margin-top:8px;">
        <i class="fas fa-inbox" style="font-size:48px;color:#d1d5db;margin-bottom:16px;display:block;"></i>
        <p style="font-size:15px;font-weight:700;color:#374151;margin-bottom:6px;">Belum Ada Pengajuan</p>
        <p style="font-size:13px;color:#9ca3af;margin-bottom:20px;">Anda belum pernah mengirimkan pengajuan apapun.</p>
        <a href="{{ route('laporan.pendaftaran-baru') }}"
           style="display:inline-flex;align-items:center;gap:8px;background:#991b1b;color:#fff;font-weight:700;font-size:13px;padding:11px 26px;border-radius:9px;text-decoration:none;">
            <i class="fas fa-plus"></i> Buat Pengajuan Baru
        </a>
    </div>

    @else

    {{-- ── Ringkasan Statistik ── --}}
    @php
        $total     = $riwayatPengajuan->count();
        $diproses  = $riwayatPengajuan->whereIn('status', ['menunggu','diproses'])->count();
        $disetujui = $riwayatPengajuan->where('status', 'disetujui')->count();
        $ditolak   = $riwayatPengajuan->where('status', 'ditolak')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:20px;">
        @foreach([
            ['label'=>'Total',       'val'=>$total,     'bg'=>'#f8fafc', 'border'=>'#e2e8f0', 'text'=>'#374151', 'icon'=>'list-alt',      'ic'=>'#6b7280'],
            ['label'=>'Diproses',    'val'=>$diproses,  'bg'=>'#fffbeb', 'border'=>'#fde68a', 'text'=>'#92400e', 'icon'=>'hourglass-half','ic'=>'#f59e0b'],
            ['label'=>'Disetujui',   'val'=>$disetujui, 'bg'=>'#f0fdf4', 'border'=>'#86efac', 'text'=>'#166534', 'icon'=>'check-circle',  'ic'=>'#16a34a'],
            ['label'=>'Ditolak',     'val'=>$ditolak,   'bg'=>'#fff1f2', 'border'=>'#fda4af', 'text'=>'#9f1239', 'icon'=>'times-circle',  'ic'=>'#e11d48'],
        ] as $s)
        <div style="background:{{ $s['bg'] }};border:1.5px solid {{ $s['border'] }};border-radius:12px;padding:14px 16px;text-align:center;">
            <i class="fas fa-{{ $s['icon'] }}" style="font-size:18px;color:{{ $s['ic'] }};margin-bottom:6px;display:block;"></i>
            <div style="font-size:22px;font-weight:900;color:{{ $s['text'] }};line-height:1;">{{ $s['val'] }}</div>
            <div style="font-size:11px;color:{{ $s['text'] }};font-weight:600;margin-top:3px;opacity:.8;">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ── Daftar Pengajuan ── --}}
    <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($riwayatPengajuan as $rp)
        @php
            $statusCfg = [
                'menunggu'  => ['label'=>'Menunggu Verifikasi', 'bg'=>'#fef2f2', 'border'=>'#fca5a5', 'text'=>'#991b1b', 'dot'=>'#dc2626', 'icon'=>'hourglass-half',  'pulse'=>true,  'bar'=>33,  'barColor'=>'#dc2626'],
                'diproses'  => ['label'=>'Sedang Diproses',     'bg'=>'#eff6ff', 'border'=>'#bfdbfe', 'text'=>'#1e40af', 'dot'=>'#3b82f6', 'icon'=>'sync-alt',        'pulse'=>true,  'bar'=>66,  'barColor'=>'#3b82f6'],
                'disetujui' => ['label'=>'Disetujui ✓',         'bg'=>'#f0fdf4', 'border'=>'#86efac', 'text'=>'#166534', 'dot'=>'#16a34a', 'icon'=>'check-circle',    'pulse'=>false, 'bar'=>100, 'barColor'=>'#16a34a'],
                'ditolak'   => ['label'=>'Ditolak',             'bg'=>'#fff1f2', 'border'=>'#fda4af', 'text'=>'#9f1239', 'dot'=>'#e11d48', 'icon'=>'times-circle',    'pulse'=>false, 'bar'=>100, 'barColor'=>'#e11d48'],
            ];
            $st = $statusCfg[$rp->status] ?? ['label'=>ucfirst($rp->status),'bg'=>'#f9fafb','border'=>'#e5e7eb','text'=>'#374151','dot'=>'#9ca3af','icon'=>'circle','pulse'=>false,'bar'=>33,'barColor'=>'#9ca3af'];
        @endphp

        <a href="{{ route('pengajuan.status', $rp->id) }}"
           style="display:block;text-decoration:none;background:#fff;border:1.5px solid {{ $rp->status === 'disetujui' ? '#86efac' : ($rp->status === 'ditolak' ? '#fda4af' : ($rp->status === 'menunggu' ? '#fca5a5' : '#bfdbfe')) }};border-radius:14px;padding:18px 20px;transition:box-shadow .15s,transform .15s;"
           onmouseover="this.style.boxShadow='0 6px 24px rgba(0,0,0,.09)';this.style.transform='translateY(-1px)';"
           onmouseout="this.style.boxShadow='none';this.style.transform='none';">

            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">

                {{-- Kiri --}}
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:5px;flex-wrap:wrap;">
                        <span style="font-size:16px;font-weight:900;color:#111827;">
                            #{{ str_pad($rp->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        <span style="font-size:11px;font-weight:700;color:#991b1b;background:#fef2f2;border:1px solid #fca5a5;padding:2px 9px;border-radius:20px;white-space:nowrap;">
                            {{ $rp->jenis_layanan_label }}
                        </span>
                    </div>

                    {{-- Nama ormas jika ada --}}
                    @if(!empty($rp->data_perubahan['organisasi']['nama_organisasi']))
                    <p style="font-size:13px;font-weight:700;color:#1f2937;margin-bottom:2px;">
                        <i class="fas fa-building" style="color:#991b1b;font-size:11px;margin-right:4px;"></i>
                        {{ $rp->data_perubahan['organisasi']['nama_organisasi'] }}
                    </p>
                    @endif

                    <p style="font-size:12px;color:#9ca3af;margin-bottom:2px;">
                        <i class="fas fa-clock" style="margin-right:4px;font-size:10px;"></i>
                        {{ $rp->created_at->format('d M Y, H:i') }}
                    </p>

                    {{-- Catatan admin --}}
                    @if($rp->catatan_admin)
                    <div style="margin-top:9px;background:{{ $rp->status === 'disetujui' ? '#f0fdf4' : ($rp->status === 'ditolak' ? '#fff1f2' : '#f8fafc') }};border:1px solid {{ $rp->status === 'disetujui' ? '#86efac' : ($rp->status === 'ditolak' ? '#fda4af' : '#e2e8f0') }};border-radius:8px;padding:8px 12px;font-size:12px;color:#374151;">
                        <i class="fas fa-comment-dots" style="margin-right:4px;color:{{ $rp->status === 'disetujui' ? '#16a34a' : ($rp->status === 'ditolak' ? '#e11d48' : '#6b7280') }};"></i>
                        <strong>Catatan Admin:</strong> {{ $rp->catatan_admin }}
                    </div>
                    @endif
                </div>

                {{-- Kanan: badge status --}}
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0;">
                    <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;padding:7px 14px;border-radius:20px;border:1.5px solid {{ $st['border'] }};background:{{ $st['bg'] }};color:{{ $st['text'] }};white-space:nowrap;">
                        <span class="{{ $st['pulse'] ? 'pulse' : '' }}" style="width:7px;height:7px;border-radius:50%;background:{{ $st['dot'] }};flex-shrink:0;display:inline-block;"></span>
                        <i class="fas fa-{{ $st['icon'] }}" style="font-size:11px;"></i>
                        {{ $st['label'] }}
                    </span>
                    <i class="fas fa-chevron-right" style="font-size:11px;color:#d1d5db;"></i>
                </div>

            </div>

            {{-- Progress bar --}}
            <div style="margin-top:14px;">
                <div style="height:4px;background:#f3f4f6;border-radius:4px;overflow:hidden;">
                    <div style="height:100%;width:{{ $st['bar'] }}%;background:{{ $st['barColor'] }};border-radius:4px;transition:width .5s;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:5px;">
                    <span style="font-size:10px;color:#374151;font-weight:600;">✓ Dikirim</span>
                    <span style="font-size:10px;color:{{ $st['bar'] >= 66 ? '#374151' : '#d1d5db' }};font-weight:600;">{{ $st['bar'] >= 66 ? '✓' : '○' }} Diproses</span>
                    <span style="font-size:10px;font-weight:700;color:{{ $rp->status === 'disetujui' ? '#16a34a' : ($rp->status === 'ditolak' ? '#e11d48' : '#d1d5db') }};">
                        @if($rp->status === 'disetujui') ✓ Disetujui
                        @elseif($rp->status === 'ditolak') ✗ Ditolak
                        @else ○ Selesai
                        @endif
                    </span>
                </div>
            </div>

        </a>
        @endforeach
    </div>

    {{-- ── Tombol buat pengajuan baru ── --}}
    <div style="text-align:center;margin-top:28px;">
        <a href="{{ route('laporan.pendaftaran-baru') }}"
           style="display:inline-flex;align-items:center;gap:8px;background:#991b1b;color:#fff;font-weight:700;font-size:13px;padding:11px 26px;border-radius:9px;text-decoration:none;">
            <i class="fas fa-plus"></i> Buat Pengajuan Baru
        </a>
    </div>

    @endif

    @else
    {{-- ── Belum login ── --}}
    <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:16px;border:1.5px dashed #e5e7eb;">
        <i class="fas fa-lock" style="font-size:48px;color:#d1d5db;margin-bottom:16px;display:block;"></i>
        <p style="font-size:15px;font-weight:700;color:#374151;margin-bottom:6px;">Login Diperlukan</p>
        <p style="font-size:13px;color:#9ca3af;margin-bottom:20px;">Silahkan login untuk melihat status pengajuan Anda.</p>
        <a href="{{ route('login') }}"
           style="display:inline-flex;align-items:center;gap:8px;background:#991b1b;color:#fff;font-weight:700;font-size:13px;padding:11px 26px;border-radius:9px;text-decoration:none;">
            <i class="fas fa-sign-in-alt"></i> Login Sekarang
        </a>
    </div>
    @endauth

</div>

@endsection
