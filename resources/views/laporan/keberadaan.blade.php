<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keberadaan Ormas – SIPORAS</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { font-family: 'Open Sans', sans-serif; background: #ffffff; min-height: 100vh; }

        /* ── Header ── */
        .site-header { background: #fff; border-bottom: 1px solid #e5e7eb; padding: 12px 0; display: flex; align-items: center; justify-content: space-between; max-width: 1280px; margin: 0 auto; padding-left: 2rem; padding-right: 2rem; }
        .logo-circle { width: 40px; height: 40px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

        /* ── Navbar ── */
        .navbar { background: #fff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; padding: 0; overflow-x: auto; }
        .navbar-inner { display: flex; align-items: center; width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 2rem; }
        .nav-tab { display: flex; align-items: center; gap: 6px; padding: 0 16px; height: 44px; font-size: 13px; font-weight: 600; color: #6b7280; background: transparent; border: none; border-bottom: 2px solid transparent; cursor: pointer; white-space: nowrap; text-decoration: none; transition: .15s; font-family: 'Open Sans', sans-serif; }
        .nav-tab:hover { color: #111827; }
        .nav-tab.active { color: #111827; border-bottom-color: #111827; font-weight: 700; }
        .nav-spacer { flex: 1; }
        .nav-action { display: flex; align-items: center; gap: 6px; padding: 0 12px; height: 44px; font-size: 13px; font-weight: 600; text-decoration: none; color: #6b7280; transition: .15s; }
        .nav-action:hover { color: #111827; }
        .nav-divider { color: #e5e7eb; font-size: 18px; line-height: 44px; }

        /* ── Layout ── */
        .main-wrap { padding: 0 0 28px 0; }
        .content-card { background: #fff; padding: 28px 2rem 48px; max-width: 1280px; margin: 0 auto; min-height: calc(100vh - 130px); }

        /* ── Tab pane ── */
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        /* ── Section heading ── */
        .sec-head { display: flex; align-items: center; gap: 9px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f3f4f6; }
        .sec-head-icon { width: 32px; height: 32px; border-radius: 8px; background: #991b1b; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sec-head-icon i { font-size: 13px; color: #fff; }
        .sec-head-title { font-size: 14px; font-weight: 800; color: #111; text-transform: uppercase; letter-spacing: .04em; }
        .sec-head-sub { font-size: 11px; color: #6b7280; font-weight: 400; text-transform: none; letter-spacing: 0; }

        /* ── Divider ── */
        .divider { border: none; border-top: 1.5px solid #f3f4f6; margin: 24px 0; }

        /* ── Info banner ── */
        .info-banner { background: #f9fafb; border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 12px 18px; margin-bottom: 20px; font-size: 13px; color: #374151; display: flex; align-items: flex-start; gap: 8px; }
        .info-banner i { color: #6b7280; flex-shrink: 0; margin-top: 1px; }

        /* ── Persyaratan ── */
        .req-wrap { background: #f8fffe; border: 1px solid #c7eef2; border-radius: 10px; padding: 16px 20px; margin-bottom: 28px; }
        .req-row { display: flex; align-items: flex-start; gap: 10px; padding: 7px 0; border-bottom: 1px solid #e8f6f8; font-size: 13px; color: #374151; line-height: 1.6; }
        .req-row:last-child { border-bottom: none; padding-bottom: 0; }
        .req-num { min-width: 22px; height: 22px; background: #0e7d8d; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10.5px; font-weight: 800; flex-shrink: 0; margin-top: 2px; }

        /* ── Cek status form ── */
        .cek-input { flex: 1; border: 1.5px solid #d1d5db; border-radius: 7px; padding: 10px 14px; font-size: 13px; outline: none; font-family: 'Open Sans', sans-serif; color: #111827; background: #fff; transition: border-color .15s; }
        .cek-input:focus { border-color: #991b1b; box-shadow: 0 0 0 3px rgba(153,27,27,.1); }
        .cek-btn { background: #111827; color: #fff; font-weight: 700; font-size: 13px; padding: 10px 22px; border-radius: 7px; border: none; cursor: pointer; font-family: 'Open Sans', sans-serif; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; white-space: nowrap; }
        .cek-btn:hover { background: #374151; }

        /* ── Status track ── */
        .status-track { display: flex; gap: 0; overflow-x: auto; margin: 22px 0 8px; }
        .status-step { flex: 1; min-width: 90px; display: flex; flex-direction: column; align-items: center; gap: 6px; position: relative; }
        .status-step:not(:last-child)::after { content: ''; position: absolute; top: 17px; left: 50%; width: 100%; height: 2px; background: #e5e7eb; z-index: 0; }
        .status-step .step-dot { width: 34px; height: 34px; border-radius: 50%; background: #f3f4f6; border: 2.5px solid #d1d5db; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #9ca3af; position: relative; z-index: 1; }
        .status-step.done .step-dot { background: #dcfce7; border-color: #16a34a; color: #16a34a; }
        .status-step.current .step-dot { background: #fef3c7; border-color: #d97706; color: #d97706; }
        .status-step .step-label { font-size: 10.5px; font-weight: 700; color: #6b7280; text-align: center; line-height: 1.3; }
        .status-step.done .step-label { color: #16a34a; }
        .status-step.current .step-label { color: #d97706; }

        /* ── Call center ── */
        .call-center { text-align: center; margin-top: 24px; font-size: 12.5px; color: #64748b; font-weight: 600; }

        /* ── Responsive ── */
        @media (min-width: 640px) { .sm-grid-4 { grid-template-columns: repeat(4,1fr) !important; } }
        @media (max-width: 639px) {
            .content-card { padding: 16px 1rem 32px; }
            .site-header { padding-left: 1rem; padding-right: 1rem; }
            .navbar-inner { padding: 0 1rem; }
        }
    </style>
</head>
<body>

{{-- ═══ HEADER ═══ --}}
<div style="background:#fff;border-bottom:1px solid #e5e7eb;">
<div class="site-header">
    <div style="display:flex;align-items:center;gap:12px;">
        <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Grobogan" style="width:36px;height:36px;object-fit:contain;flex-shrink:0;">
        <div>
            <div style="color:#111827;font-size:12.5px;font-weight:800;text-transform:uppercase;line-height:1.4;">SIPORAS</div>
            <div style="color:#6b7280;font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;">Kesbangpol Kab. Grobogan</div>
        </div>
    </div>
    <div>
        @auth
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;font-size:13px;font-weight:600;color:#374151;display:flex;align-items:center;gap:6px;font-family:'Open Sans',sans-serif;">
                <i class="fas fa-user" style="font-size:12px;color:#9ca3af;"></i>
                {{ Auth::user()->name }}
                <span style="color:#d1d5db;">|</span>
                <span style="color:#6b7280;">Logout</span>
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" style="font-size:13px;font-weight:600;color:#374151;text-decoration:none;display:flex;align-items:center;gap:6px;">
            <i class="fas fa-sign-in-alt" style="font-size:12px;color:#9ca3af;"></i> Login
        </a>
        @endauth
    </div>
</div>

{{-- ═══ NAVBAR ═══ --}}
<nav class="navbar">
    <div class="navbar-inner">
    <a href="{{ route('laporan.pendaftaran-baru') }}" class="nav-tab">
        Pendaftaran Baru
    </a>
    <a href="{{ route('laporan.perubahan') }}" class="nav-tab">
        Perubahan Data
    </a>
    <div class="nav-spacer"></div>
    <a href="{{ route('home') }}" class="nav-action" style="font-weight:700;color:#374151;">
        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Kembali
    </a>
    </div>
</nav>

{{-- ═══ KONTEN ═══ --}}
<div class="main-wrap">
  <div class="content-card">

    <x-toast />

    {{-- ── Cek Status ── --}}
    <div id="content-cek" class="tab-pane active">

        <div class="sec-head">
            <div class="sec-head-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="sec-head-title">Status Pengajuan Saya</div>
                <div class="sec-head-sub">Lihat status seluruh pengajuan yang telah Anda kirimkan</div>
            </div>
        </div>

        @if($riwayatPengajuan->isEmpty())

        <div style="text-align:center;padding:48px 20px;background:#f9fafb;border-radius:12px;border:1.5px dashed #e5e7eb;">
            <i class="fas fa-inbox" style="font-size:40px;color:#d1d5db;margin-bottom:14px;display:block;"></i>
            <p style="font-size:14px;font-weight:700;color:#374151;margin-bottom:6px;">Belum Ada Pengajuan</p>
            <p style="font-size:12px;color:#9ca3af;">Anda belum pernah mengirimkan pengajuan apapun.</p>
        </div>

        @else

        @php
            $total     = $riwayatPengajuan->count();
            $diproses  = $riwayatPengajuan->whereIn('status', ['menunggu','diproses'])->count();
            $disetujui = $riwayatPengajuan->where('status', 'disetujui')->count();
            $ditolak   = $riwayatPengajuan->where('status', 'ditolak')->count();
        @endphp

        {{-- Ringkasan --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:20px;" class="sm-grid-4">
            @foreach([
                ['label'=>'Total',     'val'=>$total,     'bg'=>'#f8fafc','border'=>'#e2e8f0','text'=>'#374151','icon'=>'list-alt',       'ic'=>'#6b7280'],
                ['label'=>'Diproses',  'val'=>$diproses,  'bg'=>'#fffbeb','border'=>'#fde68a','text'=>'#92400e','icon'=>'hourglass-half', 'ic'=>'#f59e0b'],
                ['label'=>'Disetujui', 'val'=>$disetujui, 'bg'=>'#f0fdf4','border'=>'#86efac','text'=>'#166534','icon'=>'check-circle',   'ic'=>'#16a34a'],
                ['label'=>'Ditolak',   'val'=>$ditolak,   'bg'=>'#fff1f2','border'=>'#fda4af','text'=>'#9f1239','icon'=>'times-circle',   'ic'=>'#e11d48'],
            ] as $s)
            <div style="background:{{ $s['bg'] }};border:1.5px solid {{ $s['border'] }};border-radius:10px;padding:12px;text-align:center;">
                <i class="fas fa-{{ $s['icon'] }}" style="font-size:16px;color:{{ $s['ic'] }};margin-bottom:5px;display:block;"></i>
                <div style="font-size:20px;font-weight:900;color:{{ $s['text'] }};line-height:1;">{{ $s['val'] }}</div>
                <div style="font-size:10.5px;color:{{ $s['text'] }};font-weight:600;margin-top:2px;opacity:.8;">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- Daftar Pengajuan --}}
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach($riwayatPengajuan as $rp)
            @php
                $statusCfg = [
                    'menunggu'  => ['label'=>'Menunggu Verifikasi','bg'=>'#fef2f2','border'=>'#fca5a5','text'=>'#991b1b','dot'=>'#dc2626','icon'=>'hourglass-half','pulse'=>true, 'bar'=>33, 'barColor'=>'#dc2626'],
                    'diproses'  => ['label'=>'Sedang Diproses',    'bg'=>'#eff6ff','border'=>'#bfdbfe','text'=>'#1e40af','dot'=>'#3b82f6','icon'=>'sync-alt',      'pulse'=>true, 'bar'=>66, 'barColor'=>'#3b82f6'],
                    'disetujui' => ['label'=>'Disetujui ✓',        'bg'=>'#f0fdf4','border'=>'#86efac','text'=>'#166534','dot'=>'#16a34a','icon'=>'check-circle',  'pulse'=>false,'bar'=>100,'barColor'=>'#16a34a'],
                    'ditolak'   => ['label'=>'Ditolak',            'bg'=>'#fff1f2','border'=>'#fda4af','text'=>'#9f1239','dot'=>'#e11d48','icon'=>'times-circle',  'pulse'=>false,'bar'=>100,'barColor'=>'#e11d48'],
                ];
                $st = $statusCfg[$rp->status] ?? ['label'=>ucfirst($rp->status),'bg'=>'#f9fafb','border'=>'#e5e7eb','text'=>'#374151','dot'=>'#9ca3af','icon'=>'circle','pulse'=>false,'bar'=>33,'barColor'=>'#9ca3af'];
            @endphp

            <a href="{{ route('pengajuan.status', $rp->id) }}"
               style="display:block;text-decoration:none;background:#fff;border:1.5px solid {{ $rp->status === 'disetujui' ? '#86efac' : ($rp->status === 'ditolak' ? '#fda4af' : '#e5e7eb') }};border-radius:12px;padding:16px 18px;transition:box-shadow .15s;"
               onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)';"
               onmouseout="this.style.boxShadow='none';">

                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;flex-wrap:wrap;">
                            <span style="font-size:15px;font-weight:900;color:#111827;">#{{ str_pad($rp->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <span style="font-size:11px;font-weight:700;color:#991b1b;background:#fef2f2;border:1px solid #fca5a5;padding:2px 8px;border-radius:20px;">{{ $rp->jenis_layanan_label }}</span>
                        </div>
                        @if(!empty($rp->data_perubahan['organisasi']['nama_organisasi']))
                        <p style="font-size:12px;font-weight:700;color:#1f2937;margin-bottom:2px;">
                            <i class="fas fa-building" style="color:#991b1b;font-size:10px;margin-right:3px;"></i>
                            {{ $rp->data_perubahan['organisasi']['nama_organisasi'] }}
                        </p>
                        @endif
                        <p style="font-size:11.5px;color:#9ca3af;">
                            <i class="fas fa-clock" style="margin-right:3px;font-size:10px;"></i>
                            {{ $rp->created_at->format('d M Y, H:i') }}
                        </p>
                        @if($rp->catatan_admin)
                        <div style="margin-top:8px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:7px;padding:7px 10px;font-size:12px;color:#374151;">
                            <i class="fas fa-comment-dots" style="margin-right:4px;color:#6b7280;"></i>
                            <strong>Catatan:</strong> {{ $rp->catatan_admin }}
                        </div>
                        @endif
                    </div>
                    <span style="display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:700;padding:6px 12px;border-radius:20px;border:1.5px solid {{ $st['border'] }};background:{{ $st['bg'] }};color:{{ $st['text'] }};white-space:nowrap;flex-shrink:0;">
                        <span class="{{ $st['pulse'] ? 'pulse' : '' }}" style="width:6px;height:6px;border-radius:50%;background:{{ $st['dot'] }};display:inline-block;flex-shrink:0;"></span>
                        {{ $st['label'] }}
                    </span>
                </div>

                {{-- Progress bar --}}
                <div style="margin-top:12px;">
                    <div style="height:3px;background:#f3f4f6;border-radius:3px;overflow:hidden;">
                        <div style="height:100%;width:{{ $st['bar'] }}%;background:{{ $st['barColor'] }};border-radius:3px;"></div>
                    </div>
                </div>

            </a>
            @endforeach
        </div>

        @endif

    </div>

  </div>
</div>

<script>
    // Buka tab Cek Status jika URL mengandung ?tab=cek atau #cek
    const params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'cek' || window.location.hash === '#cek') {
        // sudah aktif by default
    }
</script>
</body>
</html>
