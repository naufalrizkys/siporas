<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pengajuan – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { font-family: 'Inter', sans-serif; background: #ffffff; min-height: 100vh; }
        @media (max-width: 639px) {
            input, select, textarea { font-size: 16px !important; }
        }        /* ── Header ── */
        .site-header { width: 100%; background: #b91c1c; box-shadow: 0 1px 0 rgba(0,0,0,.06), 0 2px 8px rgba(127,29,29,.18); position: relative; z-index: 50; }
        .site-header__inner { max-width: 1280px; margin: 0 auto; padding: 0 2rem; height: 78px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .brand { display: flex; align-items: center; gap: 14px; text-decoration: none; min-width: 0; }
        .brand__logo { width: 52px; height: 52px; object-fit: contain; flex-shrink: 0; }
        .brand__text { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
        .brand__title { color: #fff; font-size: 17px; font-weight: 900; line-height: 1.1; letter-spacing: .08em; text-transform: uppercase; }
        .brand__subtitle { color: rgba(255,255,255,.85); font-size: 11.5px; font-weight: 600; line-height: 1.2; letter-spacing: .12em; text-transform: uppercase; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .header-actions { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
        .menu-btn { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px; width: 36px; height: 36px; padding: 0; border: none; background: none; cursor: pointer; flex-shrink: 0; }
        .menu-btn span { display: block; width: 20px; height: 2px; background: #fff; border-radius: 2px; }
        @media (min-width: 768px) { .menu-btn { display: none; } }

        /* ── Mobile nav modal ── */
        .mob-modal{display:none;position:fixed;inset:0;z-index:9999;}
        .mob-modal.open{display:block;}
        .mob-modal__backdrop{position:absolute;inset:0;background:rgba(0,0,0,.55);}
        .mob-modal__panel{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:calc(100% - 40px);max-width:360px;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.25);}
        .mob-modal__close{position:absolute;top:14px;right:14px;width:30px;height:30px;border:none;background:#f3f4f6;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;font-size:14px;transition:background .15s;}
        .mob-modal__close:hover{background:#e5e7eb;}
        .mob-modal__body{padding:16px 0 8px;}
        .mob-modal__item{display:flex;align-items:center;padding:13px 24px;font-size:15px;font-weight:600;color:#111827;text-decoration:none;border:none;background:transparent;width:100%;text-align:left;cursor:pointer;font-family:'Open Sans',sans-serif;transition:background .12s;}
        .mob-modal__item:hover{background:#f9fafb;}
        .mob-modal__item.active-mob{color:#991b1b;font-weight:700;}
        .mob-modal__divider{height:1px;background:#f3f4f6;margin:6px 0;}
        .mob-modal__item.logout{color:#dc2626;}
        .hidden-mobile{display:none;}
        @media (min-width:768px){.hidden-mobile{display:flex!important;}}
        @media (max-width:767px){.hidden-mobile{display:none!important;}}

        /* ── Layout ── */
        .main-wrap { padding: 0 0 28px; }
        .content-card { background: #fff; padding: 28px 2rem 48px; max-width: 1280px; margin: 0 auto; min-height: calc(100vh - 130px); }

        /* ── Section heading ── */
        .sec-head { display: flex; align-items: center; gap: 10px; background: #111827; color: #fff; border-radius: 8px; padding: 10px 16px; margin-bottom: 20px; }
        .sec-head span { font-size: 12.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .07em; }

        /* ── Responsive ── */
        @media (max-width: 639px) {
            .site-header__inner { padding: 0 1rem; height: 68px; }
            .brand__logo { width: 44px; height: 44px; }
            .brand__title { font-size: 15px; }
            .brand__subtitle { font-size: 10.5px; letter-spacing: .08em; }
        }e: 10px; letter-spacing: .08em; }
            .content-card { padding: 16px 1rem 32px; }
        }
        .user-avatar-btn{display:none;}
        @media (min-width:768px){.user-avatar-btn{display:block;}}
        #user-av-dd{display:none;position:absolute;right:0;top:46px;width:220px;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:100;}
        .nav-dropdown-wrap { position: relative; }
        .nav-dropdown-wrap:hover .nav-dropdown-menu { display: block !important; }
    </style>
</head>
<body>

{{-- Header --}}
<header class="site-header">
<div class="site-header__inner">
    <a href="{{ route('home') }}" class="brand">
        <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Grobogan" class="brand__logo">
        <div class="brand__text">
            <span class="brand__title">SIPORAS</span>
            <span class="brand__subtitle">Kesbangpol Kab. Grobogan</span>
        </div>
    </a>

    {{-- Menu Navigasi Tengah (Desktop) --}}
    <div class="hidden-mobile" style="align-items:center;gap:1.5rem;">
        <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
            Beranda
        </a>
        <div class="nav-dropdown-wrap" style="position:relative;">
            <a href="{{ route('laporan.pendaftaran-baru') }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:4px;padding:4px 0;transition:color .15s;">
                Laporan Keberadaan <i class="fas fa-chevron-down" style="font-size:10px;opacity:0.8;margin-left:2px;"></i>
            </a>
            <div class="nav-dropdown-menu" style="display:none;position:absolute;top:100%;left:0;width:200px;background:#ffffff;border-radius:10px;padding:6px 0;box-shadow:0 10px 30px rgba(0,0,0,0.18);z-index:999;margin-top:4px;border:1px solid #f3f4f6;">
                <a href="{{ route('laporan.pendaftaran-baru') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;background:transparent;transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-file-alt" style="font-size:12px;color:#9ca3af;"></i> Pendaftaran Baru
                </a>
                <a href="{{ route('laporan.perubahan') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;background:transparent;transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-edit" style="font-size:12px;color:#9ca3af;"></i> Perubahan Data
                </a>
            </div>
        </div>
        <a href="{{ route('laporan.kegiatan') }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
            Laporan Kegiatan
        </a>
        <a href="{{ route('cek.status') }}" style="color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;display:flex;align-items:center;padding:4px 0;">
            Cek Status
        </a>
    </div>

    <div class="header-actions">
        <div class="hidden-mobile" id="user-av-wrap" style="position:relative;">
            <button onclick="toggleUserAv()" style="background:none;border:none;padding:0;cursor:pointer;">
                @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                     style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                @else
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;">
                    <span style="color:#fff;font-size:14px;font-weight:700;">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</span>
                </div>
                @endif
            </button>
            <div id="user-av-dd">
                <div style="padding:14px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid #f3f4f6;">
                    @if(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                    @else
                    <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="color:#fff;font-size:15px;font-weight:700;">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</span>
                    </div>
                    @endif
                    <div style="min-width:0;">
                        <div style="font-size:13px;font-weight:700;color:#111827;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->name }}</div>
                        <div style="font-size:11px;color:#9ca3af;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="width:100%;display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13px;font-weight:600;color:#dc2626;background:none;border:none;cursor:pointer;font-family:inherit;text-align:left;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        <button onclick="openMobModal('cs')" aria-label="Menu" class="menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</div>
</header>

{{-- Mobile Modal --}}
<div class="mob-modal" id="mob-modal-cs">
    <div class="mob-modal__backdrop" onclick="closeMobModal('cs')"></div>
    <div class="mob-modal__panel">
        <button class="mob-modal__close" onclick="closeMobModal('cs')" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
        <div class="mob-modal__body">
            <a href="{{ route('home') }}" class="mob-modal__item">Beranda</a>
            <a href="{{ route('cek.status') }}" class="mob-modal__item active-mob">Cek Status</a>
            <div class="mob-modal__divider"></div>
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mob-modal__item logout">Logout</button>
            </form>
            @endauth
        </div>
    </div>
</div>

{{-- Konten --}}
<div class="main-wrap">
<div class="content-card">

    <x-toast />

    @if($riwayatPengajuan->isEmpty())

    <div style="text-align:center;padding:56px 24px;background:#ffffff;border-radius:20px;border:1.5px dashed #e2e8f0;box-shadow:0 4px 20px rgba(0,0,0,0.02);">
        <div style="width:72px;height:72px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:#b91c1c;font-size:28px;">
            <i class="fas fa-folder-open"></i>
        </div>
        <h3 style="font-size:16px;font-weight:800;color:#1e293b;margin-bottom:6px;">Belum Ada Pengajuan</h3>
        <p style="font-size:13px;color:#64748b;max-width:400px;margin:0 auto 24px;line-height:1.5;">Anda belum pernah mengirimkan laporan keberadaan atau kegiatan ormas. Silakan buat pengajuan baru melalui tombol di bawah.</p>
        <a href="{{ route('laporan.pendaftaran-baru') }}" style="display:inline-flex;align-items:center;gap:8px;background:#b91c1c;color:#fff;font-size:13px;font-weight:700;padding:11px 24px;border-radius:10px;text-decoration:none;transition:background .2s;" onmouseover="this.style.background='#991b1b'" onmouseout="this.style.background='#b91c1c'">
            <i class="fas fa-paper-plane"></i> Ajukan Sekarang
        </a>
    </div>

    @else

    {{-- Header Section --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:4px;height:20px;background:#b91c1c;border-radius:4px;"></div>
            <h2 style="font-size:16px;font-weight:800;color:#1e293b;margin:0;">Riwayat Pengajuan ({{ $riwayatPengajuan->count() }})</h2>
        </div>
    </div>

    {{-- Modern Cards List --}}
    <div style="display:flex;flex-direction:column;gap:16px;">
        @foreach($riwayatPengajuan as $rp)
        @php
            $statusCfg = [
                'menunggu'  => ['label'=>'Menunggu Verifikasi', 'icon'=>'fas fa-clock',       'bg'=>'#fffbe6', 'border'=>'#ffe58f', 'text'=>'#d46b08', 'bar'=>33,  'barColor'=>'#faad14'],
                'diproses'  => ['label'=>'Sedang Diproses',     'icon'=>'fas fa-spinner fa-spin', 'bg'=>'#e6f7ff', 'border'=>'#91caff', 'text'=>'#0958d9', 'bar'=>66,  'barColor'=>'#1677ff'],
                'disetujui' => ['label'=>'Disetujui',           'icon'=>'fas fa-check-circle', 'bg'=>'#f6ffed', 'border'=>'#b7eb8f', 'text'=>'#389e0d', 'bar'=>100, 'barColor'=>'#52c41a'],
                'ditolak'   => ['label'=>'Ditolak',             'icon'=>'fas fa-times-circle', 'bg'=>'#fff1f0', 'border'=>'#ffccc7', 'text'=>'#cf1322', 'bar'=>100, 'barColor'=>'#ff4d4f'],
            ];
            $st = $statusCfg[$rp->status] ?? ['label'=>ucfirst($rp->status), 'icon'=>'fas fa-info-circle', 'bg'=>'#f5f5f5', 'border'=>'#d9d9d9', 'text'=>'#595959', 'bar'=>33, 'barColor'=>'#8c8c8c'];
        @endphp

        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:16px;padding:20px 24px;box-shadow:0 2px 10px rgba(0,0,0,0.03);transition:all .2s;" class="hover:border-red-200 hover:shadow-md">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                
                {{-- Left: Details --}}
                <div style="flex:1;min-width:240px;">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;flex-wrap:wrap;">
                        <span style="font-size:15px;font-weight:900;color:#0f172a;letter-spacing:-.01em;">#{{ str_pad($rp->id, 4, '0', STR_PAD_LEFT) }}</span>
                        <span style="font-size:11px;font-weight:700;color:#b91c1c;background:#fef2f2;border:1px solid #fecaca;padding:3px 10px;border-radius:9999px;">
                            {{ $rp->jenis_layanan_label }}
                        </span>
                    </div>

                    <p style="font-size:12.5px;color:#64748b;margin:0 0 10px 0;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-calendar-alt" style="font-size:12px;color:#94a3b8;"></i>
                        Dikirim pada {{ $rp->created_at->format('d M Y, H:i') }} WIB
                    </p>

                    @if($rp->catatan_admin)
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:12.5px;color:#334155;display:flex;align-items:flex-start;gap:8px;">
                        <i class="fas fa-comment-dots" style="color:#b91c1c;margin-top:2px;flex-shrink:0;"></i>
                        <div>
                            <strong style="color:#0f172a;">Catatan Petugas:</strong>
                            <span style="display:block;margin-top:2px;color:#475569;">{{ $rp->catatan_admin }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Right: Status Badge & Action Button --}}
                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:12px;flex-shrink:0;">
                    <span style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:800;padding:6px 14px;border-radius:9999px;border:1px solid {{ $st['border'] }};background:{{ $st['bg'] }};color:{{ $st['text'] }};">
                        <i class="{{ $st['icon'] }}" style="font-size:12px;"></i>
                        {{ $st['label'] }}
                    </span>

                    <a href="{{ route('pengajuan.status', $rp->id) }}"
                       style="display:inline-flex;align-items:center;gap:6px;font-size:12.5px;font-weight:700;color:#b91c1c;background:#fef2f2;padding:7px 14px;border-radius:8px;text-decoration:none;transition:all .15s;"
                       onmouseover="this.style.background='#b91c1c';this.style.color='#ffffff';"
                       onmouseout="this.style.background='#fef2f2';this.style.color='#b91c1c';">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>

            </div>

            {{-- Smooth Progress Bar --}}
            <div style="margin-top:16px;">
                <div style="height:5px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                    <div style="height:100%;width:{{ $st['bar'] }}%;background:{{ $st['barColor'] }};border-radius:9999px;transition:width .4s ease;"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @endif

    {{-- Tombol Kembali --}}
    <div style="margin-top:28px;text-align:center;">
        <a href="{{ route('home') }}"
           style="display:inline-flex;align-items:center;gap:8px;background:#991b1b;color:#fff;font-size:13px;font-weight:700;padding:11px 28px;border-radius:8px;text-decoration:none;transition:background .15s;"
           onmouseover="this.style.background='#7f1d1d';"
           onmouseout="this.style.background='#991b1b';">
            <i class="fas fa-arrow-left" style="font-size:11px;"></i> Kembali ke Beranda
        </a>
    </div>

</div>
</div>

@auth
<script>
(function () {
    const TIMEOUT_MS  = 30 * 60 * 1000;
    const WARNING_MS  =  2 * 60 * 1000;
    const LOGOUT_URL  = '{{ route("auto.logout") }}';

    let warnTimer, logoutTimer, warningShown = false;

    const overlay = document.createElement('div');
    overlay.id = 'idle-overlay';
    overlay.style.cssText = `
        display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);
        z-index:9999;align-items:center;justify-content:center;
    `;
    overlay.innerHTML = `
        <div style="background:#fff;border-radius:16px;padding:32px 28px;max-width:360px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.3);">
            <div style="width:52px;height:52px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <h3 style="font-size:16px;font-weight:800;color:#111827;margin-bottom:8px;">Sesi Hampir Berakhir</h3>
            <p style="font-size:13px;color:#6b7280;margin-bottom:6px;">Anda tidak aktif. Sesi akan berakhir dalam</p>
            <div id="idle-countdown" style="font-size:32px;font-weight:900;color:#dc2626;margin:10px 0 20px;font-variant-numeric:tabular-nums;">2:00</div>
            <button id="idle-stay"
                style="background:#111827;color:#fff;font-weight:700;font-size:14px;padding:11px 28px;border-radius:8px;border:none;cursor:pointer;width:100%;font-family:inherit;">
                Tetap Login
            </button>
        </div>
    `;
    document.body.appendChild(overlay);

    let countdownInterval;

    function showWarning() {
        warningShown = true;
        overlay.style.display = 'flex';
        let remaining = Math.floor(WARNING_MS / 1000);
        updateCountdown(remaining);
        countdownInterval = setInterval(() => {
            remaining--;
            updateCountdown(remaining);
            if (remaining <= 0) clearInterval(countdownInterval);
        }, 1000);
    }

    function updateCountdown(sec) {
        const m = String(Math.floor(sec / 60)).padStart(1,'0');
        const s = String(sec % 60).padStart(2,'0');
        const el = document.getElementById('idle-countdown');
        if (el) el.textContent = m + ':' + s;
    }

    function resetTimers() {
        clearTimeout(warnTimer);
        clearTimeout(logoutTimer);
        clearInterval(countdownInterval);
        if (warningShown) {
            overlay.style.display = 'none';
            warningShown = false;
        }
        warnTimer   = setTimeout(showWarning, TIMEOUT_MS - WARNING_MS);
        logoutTimer = setTimeout(() => { window.location.href = LOGOUT_URL; }, TIMEOUT_MS);
    }

    document.getElementById('idle-stay').addEventListener('click', resetTimers);

    ['mousemove','keydown','click','scroll','touchstart'].forEach(ev =>
        document.addEventListener(ev, resetTimers, { passive: true })
    );

    resetTimers();
})();
</script>
@endauth

<script>
function openMobModal(id) {
    document.getElementById('mob-modal-' + id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMobModal(id) {
    document.getElementById('mob-modal-' + id).classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMobModal('cs'); });
window.addEventListener('resize', function() { if (window.innerWidth >= 768) closeMobModal('cs'); });
</script>
<script>
function toggleUserAv() {
    var dd = document.getElementById('user-av-dd');
    dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
    var wrap = document.getElementById('user-av-wrap');
    var dd = document.getElementById('user-av-dd');
    if (wrap && dd && !wrap.contains(e.target)) dd.style.display = 'none';
});
</script>

</body>
</html>
