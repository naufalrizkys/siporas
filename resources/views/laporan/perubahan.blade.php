<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perubahan Biodata Ormas – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        /* ── Success Popup ── */
        .success-overlay{display:none;position:fixed;inset:0;background:rgba(0,20,15,0.75);z-index:99999;align-items:center;justify-content:center;}
        .success-overlay.show{display:flex;}
        .success-popup{background:linear-gradient(145deg,#0f3d2e,#1a5c42);border-radius:24px;padding:44px 40px 36px;width:300px;text-align:center;box-shadow:0 32px 80px rgba(0,0,0,.5);animation:popIn .45s cubic-bezier(.21,1.02,.73,1) forwards;}
        @keyframes popIn{from{opacity:0;transform:scale(.75)}to{opacity:1;transform:scale(1)}}
        .check-circle{width:90px;height:90px;margin:0 auto 20px;position:relative;}
        .circle-bg{stroke:rgba(52,211,153,.2);fill:none;stroke-width:4;}
        .circle-progress{stroke:#34d399;fill:none;stroke-width:4;stroke-linecap:round;stroke-dasharray:251;stroke-dashoffset:251;animation:drawCircle .6s ease .2s forwards;}
        @keyframes drawCircle{to{stroke-dashoffset:0}}
        .check-icon{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:44px;height:44px;}
        .check-icon path{stroke:#34d399;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;fill:none;stroke-dasharray:60;stroke-dashoffset:60;animation:drawCheck .4s ease .7s forwards;}
        @keyframes drawCheck{to{stroke-dashoffset:0}}
        .success-title{font-size:20px;font-weight:800;color:#fff;margin-bottom:8px;}
        .success-msg{font-size:13px;color:rgba(255,255,255,.7);line-height:1.6;margin-bottom:24px;}
        .success-btn{width:100%;background:#34d399;color:#0f3d2e;font-weight:800;font-size:14px;padding:12px;border-radius:10px;border:none;cursor:pointer;font-family:'Inter',sans-serif;transition:background .15s;}
        .success-btn:hover{background:#10b981;}
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { font-family: 'Inter', sans-serif; background: #ffffff; min-height: 100vh; }
        @media (max-width: 639px) {
            input, select, textarea { font-size: 16px !important; }
        }

        /* ── Header ── */
        .site-header { background: #b91c1c; height: 78px; display: flex; align-items: center; justify-content: space-between; max-width: 1280px; margin: 0 auto; padding: 0 2rem; }
        @media (max-width: 639px) {
            .site-header { height: 68px; padding: 0 1rem; }
        }

        /* ── Navbar ── */
        .navbar { background: #b91c1c;  position: sticky; top: 0; z-index: 50; }
        .navbar-inner { display: flex; align-items: center; width: 100%; max-width: 1280px; margin: 0 auto; padding: 0 2rem; }
        .nav-tab { display: flex; align-items: center; gap: 6px; padding: 0 16px; height: 44px; font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.75); background: transparent; border: none; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap; text-decoration: none; transition: .15s; margin-top: 0; border-radius: 0; }
        .nav-tab:hover { color: #ffffff; background: transparent; }
        .nav-tab.active { color: #ffffff; background: transparent; border-bottom-color: #ffffff; font-weight: 700; }
        .nav-spacer { flex: 1; }
        .nav-action { display: flex; align-items: center; gap: 6px; padding: 0 12px; height: 44px; font-size: 13px; font-weight: 600; text-decoration: none; color: rgba(255,255,255,0.8); transition: .15s; margin-top: 0; }
        .nav-action:hover { color: #ffffff; }

        /* ── Mobile nav ── */
        .nav-brand-mobile { display: none; }
        .hamburger-nav-btn { display: none; align-items: center; justify-content: center; width: 36px; height: 36px; border: none; background: none; cursor: pointer; flex-direction: column; gap: 5px; padding: 0; flex-shrink: 0; }
        .hamburger-nav-btn span { display: block; width: 20px; height: 2px; background: #ffffff; border-radius: 2px; }
        .mob-modal { display: none; position: fixed; inset: 0; z-index: 9999; }
        .mob-modal.open { display: block; }
        .mob-modal__backdrop { position: absolute; inset: 0; background: rgba(0,0,0,.55); }
        .mob-modal__panel { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: calc(100% - 40px); max-width: 360px; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 24px 64px rgba(0,0,0,.25); }
        .mob-modal__close { position: absolute; top: 14px; right: 14px; width: 30px; height: 30px; border: none; background: #f3f4f6; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #6b7280; font-size: 14px; transition: background .15s; }
        .mob-modal__close:hover { background: #e5e7eb; }
        .mob-modal__body { padding: 16px 0 8px; }
        .mob-modal__item { display: flex; align-items: center; padding: 13px 24px; font-size: 15px; font-weight: 600; color: #111827; text-decoration: none; border: none; background: transparent; width: 100%; text-align: left; cursor: pointer; font-family: 'Open Sans', sans-serif; transition: background .12s; }
        .mob-modal__item:hover { background: #f9fafb; }
        .mob-modal__item.active-mob { color: #991b1b; font-weight: 700; }
        .mob-modal__item.logout { color: #dc2626; }
        .mob-modal__divider { height: 1px; background: #f3f4f6; margin: 6px 0; }
        @media (max-width: 767px) {
            .navbar-inner .nav-tab, .navbar-inner .nav-spacer, .navbar-inner .nav-action { display: none !important; }
            .navbar-inner { justify-content: space-between; height: 44px; padding: 0 1rem; }
            .nav-brand-mobile { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; color: #ffffff; }
            .hamburger-nav-btn { display: flex; }
        }

        /* ── Layout ── */
        .main-wrap { padding: 0 0 28px 0; }
        .content-card { background: #fff; padding: 28px 2rem 48px; max-width: 1280px; margin: 0 auto; min-height: calc(100vh - 130px); }

        /* ── Responsive ── */
        @media (max-width: 639px) {
            .site-header { padding-left: 1rem; padding-right: 1rem; }
            .navbar-inner { padding: 0 1rem; }
            .content-card { padding: 16px 1rem 32px; }
            .form-control { font-size: 16px; } /* prevent iOS zoom */
            .nav-btns { flex-direction: column; gap: 10px; }
            .btn-next, .btn-prev { width: 100%; justify-content: center; }
        }

        /* ── Section heading ── */
        .sec-head { display: flex; align-items: center; gap: 9px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f3f4f6; }
        .sec-head-icon { width: 32px; height: 32px; border-radius: 8px; background: #991b1b; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sec-head-icon i { font-size: 13px; color: #fff; }
        .sec-head-title { font-size: 14px; font-weight: 800; color: #111; text-transform: uppercase; letter-spacing: .04em; }
        .sec-head-sub { font-size: 11px; color: #6b7280; font-weight: 400; text-transform: none; letter-spacing: 0; }

        /* ── Form ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
        .form-grid.col-3 { grid-template-columns: 1fr 1fr 1fr; }
        .form-grid.col-1 { grid-template-columns: 1fr; }
        @media (max-width: 600px) { .form-grid, .form-grid.col-3 { grid-template-columns: 1fr; } }
        .form-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
        .form-label { font-size: 11.5px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .04em; }
        .form-label .req { color: #dc2626; margin-left: 2px; }
        .form-control { border: 1.5px solid #d1d5db; border-radius: 7px; padding: 8px 11px; font-size: 13px; font-family: 'Open Sans', sans-serif; color: #111; outline: none; transition: border-color .15s; background: #fff; width: 100%; }
        .form-control:focus { border-color: #991b1b; box-shadow: 0 0 0 3px rgba(153,27,27,.1); }
        textarea.form-control { resize: vertical; }

        /* ── Checkbox jenis perubahan ── */
        .check-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }
        @media (max-width: 480px) { .check-grid { grid-template-columns: 1fr; } }
        .check-item { display: flex; align-items: center; gap: 8px; padding: 9px 13px; border: 1.5px solid #e5e7eb; border-radius: 7px; cursor: pointer; font-size: 13px; color: #374151; transition: .15s; }
        .check-item:hover { border-color: #991b1b; background: #fff7f7; }
        .check-item input[type=checkbox] { accent-color: #991b1b; width: 15px; height: 15px; flex-shrink: 0; }
        .check-item.checked { border-color: #991b1b; background: #fff7f7; color: #991b1b; font-weight: 600; }

        /* ── Upload area ── */
        .upload-area { border: 2px dashed #d1d5db; border-radius: 8px; padding: 18px 16px; text-align: center; cursor: pointer; transition: .15s; background: #f9fafb; position: relative; }
        .upload-area:hover, .upload-area.dragover { border-color: #991b1b; background: #fff7f7; }
        .upload-area.has-file { border-color: #86efac; background: #f0fff4; }
        .upload-area input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .upload-area i { font-size: 22px; color: #9ca3af; margin-bottom: 6px; display: block; }
        .upload-area.has-file i { color: #16a34a; }
        .upload-area .ua-label { font-size: 12px; color: #6b7280; line-height: 1.5; }
        .upload-area .ua-label strong { color: #991b1b; }
        .upload-area.has-file .ua-label { color: #166534; }

        /* ── Divider ── */
        .sec-divider { border: none; border-top: 1.5px solid #f3f4f6; margin: 20px 0; }

        /* ── Save section bar ── */
        .save-section-bar { display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin: 14px 0 6px; }
        .btn-save-section { background: #991b1b; color: #fff; font-weight: 700; font-size: 12px; padding: 8px 18px; border-radius: 7px; border: none; cursor: pointer; font-family: 'Open Sans', sans-serif; display: inline-flex; align-items: center; gap: 6px; transition: background .15s; }
        .btn-save-section:hover { background: #7f1d1d; }
        .save-status { font-size: 12px; font-weight: 600; color: #16a34a; display: flex; align-items: center; gap: 5px; }
        .save-status.show { animation: fadeIn .3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

        /* ── Nav buttons ── */
        .nav-btns { display: flex; align-items: center; justify-content: space-between; padding-top: 22px; border-top: 1.5px solid #f3f4f6; margin-top: 20px; }
        .btn-prev { background: #fff; color: #374151; font-weight: 700; font-size: 13px; padding: 10px 22px; border-radius: 7px; border: 1.5px solid #e5e7eb; cursor: pointer; font-family: 'Open Sans', sans-serif; display: inline-flex; align-items: center; gap: 7px; transition: .15s; text-decoration: none; }
        .btn-prev:hover { background: #f9fafb; }
        .btn-next { background: #991b1b; color: #fff; font-weight: 800; font-size: 13px; padding: 10px 26px; border-radius: 7px; border: none; cursor: pointer; font-family: 'Open Sans', sans-serif; display: inline-flex; align-items: center; gap: 7px; transition: .15s; }
        .btn-next:hover { background: #7f1d1d; }
        .btn-next:disabled { background: #d1d5db; color: #9ca3af; cursor: not-allowed; }
        .user-avatar-btn{display:none;}
        @media (min-width:768px){.user-avatar-btn{display:block;}}
        .hidden-mobile{display:none;}
        @media (min-width:768px){.hidden-mobile{display:flex!important;}}
        @media (max-width:767px){.hidden-mobile{display:none!important;}}
        #user-av-dd{display:none;position:absolute;right:0;top:46px;width:220px;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:100;}
        .nav-dropdown-wrap { position: relative; }
        .nav-dropdown-wrap:hover .nav-dropdown-menu { display: block !important; }
    </style>
</head>
<body>

{{-- Header --}}
<div style="background:#b91c1c;width:100%;">
<div class="site-header">
    <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:14px;text-decoration:none;">
        <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Grobogan" style="width:52px;height:52px;object-fit:contain;flex-shrink:0;">
        <div>
            <div style="color:#ffffff;font-size:17px;font-weight:900;text-transform:uppercase;line-height:1.1;letter-spacing:.08em;">SIPORAS</div>
            <div style="color:rgba(255,255,255,0.85);font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.12em;">Kesbangpol Kab. Grobogan</div>
        </div>
    </a>

    {{-- Menu Navigasi Tengah (Desktop) --}}
    <div class="hidden-mobile" style="align-items:center;gap:1.5rem;">
        <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
            Beranda
        </a>
        <div class="nav-dropdown-wrap" style="position:relative;">
            <a href="{{ route('laporan.pendaftaran-baru') }}" style="color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:4px;padding:4px 0;">
                Laporan Keberadaan <i class="fas fa-chevron-down" style="font-size:10px;opacity:0.8;margin-left:2px;"></i>
            </a>
            <div class="nav-dropdown-menu" style="display:none;position:absolute;top:100%;left:0;width:200px;background:#ffffff;border-radius:10px;padding:6px 0;box-shadow:0 10px 30px rgba(0,0,0,0.18);z-index:999;margin-top:4px;border:1px solid #f3f4f6;">
                <a href="{{ route('laporan.pendaftaran-baru') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;background:transparent;transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-file-alt" style="font-size:12px;color:#9ca3af;"></i> Pendaftaran Baru
                </a>
                <a href="{{ route('laporan.perubahan') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:#991b1b;text-decoration:none;background:#fef2f2;">
                    <i class="fas fa-edit" style="font-size:12px;color:#991b1b;"></i> Perubahan Data
                </a>
            </div>
        </div>
        <a href="{{ route('laporan.kegiatan') }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
            Laporan Kegiatan
        </a>
        <a href="{{ route('cek.status') }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
            Cek Status
        </a>
    </div>

    <div class="user-avatar-btn" id="user-av-wrap" style="position:relative;">
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
    {{-- Hamburger mobile di header sejajar SIPORAS --}}
    <button class="hamburger-nav-btn" onclick="openMobModal('ub')" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</div>
</div>

{{-- Mobile Modal --}}
<div class="mob-modal" id="mob-modal-ub">
    <div class="mob-modal__backdrop" onclick="closeMobModal('ub')"></div>
    <div class="mob-modal__panel">
        <button class="mob-modal__close" onclick="closeMobModal('ub')" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
        <div class="mob-modal__body">
            <a href="{{ route('home') }}" class="mob-modal__item">Beranda</a>
            <a href="{{ route('laporan.pendaftaran-baru') }}" class="mob-modal__item">Pendaftaran Baru</a>
            <a href="#" class="mob-modal__item active-mob">Perubahan Data</a>
            <a href="{{ route('cek.status') }}" class="mob-modal__item">Cek Status</a>
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

    <form id="ubah-form" action="{{ route('laporan.perubahan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Progress Stepper --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;padding:16px 20px;background:#ffffff;border-radius:12px;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#b91c1c;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:13px;flex-shrink:0;box-shadow:0 2px 8px rgba(185,28,28,0.3);">1</div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#111827;">Identitas & Jenis Perubahan</div>
                    <div style="font-size:11px;color:#6b7280;">Nama ormas & opsi perubahan</div>
                </div>
            </div>
            <div style="flex:1;height:2px;background:#e2e8f0;margin:0 12px;"></div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#f1f5f9;color:#6b7280;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;border:1px solid #cbd5e1;flex-shrink:0;">2</div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#374151;">Detail Data Perubahan</div>
                    <div style="font-size:11px;color:#6b7280;">Form isian data baru</div>
                </div>
            </div>
            <div style="flex:1;height:2px;background:#e2e8f0;margin:0 12px;"></div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#f1f5f9;color:#6b7280;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;border:1px solid #cbd5e1;flex-shrink:0;">3</div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#374151;">Lampiran Berkas & Kirim</div>
                    <div style="font-size:11px;color:#6b7280;">SK & Berkas Pendukung</div>
                </div>
            </div>
        </div>

        {{-- Section Title --}}
        <div style="display:flex;align-items:center;gap:10px;border-left:4px solid #b91c1c;padding-left:14px;margin-bottom:24px;">
            <div>
                <h3 style="font-size:16px;font-weight:700;color:#111827;margin:0;">Jenis & Detail Perubahan Biodata Ormas</h3>
                <p style="font-size:12px;color:#6b7280;margin-top:2px;">Centang jenis perubahan yang diajukan, lalu lengkapi isian data baru</p>
            </div>
        </div>

        {{-- Identitas Ormas Pemohon --}}
        <div style="margin-bottom:24px;">
            <div style="font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;">Identitas Organisasi</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Nama Organisasi / Ormas <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="nama_ormas_pemohon" placeholder="Nama lengkap organisasi" required style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;transition:border-color .15s, box-shadow .15s;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">Bidang Kegiatan</label>
                    <select name="bidang_kegiatan_pemohon" style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;transition:border-color .15s, box-shadow .15s;">
                        <option value="">— Pilih Bidang —</option>
                        <option value="Sosial">Sosial</option>
                        <option value="Keagamaan">Keagamaan</option>
                        <option value="Profesi">Profesi</option>
                        <option value="Kontrol Sosial dan Politik">Kontrol Sosial dan Politik</option>
                        <option value="Kemanusiaan dan Bencana">Kemanusiaan dan Bencana</option>
                        <option value="Kepemudaan dan Olahraga">Kepemudaan dan Olahraga</option>
                        <option value="Pendidikan dan Lingkungan">Pendidikan dan Lingkungan</option>
                        <option value="Keamanan dan Ketertiban">Keamanan dan Ketertiban</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Pilih jenis perubahan --}}
        <div class="form-group">
            <label class="form-label">Jenis Perubahan yang Diajukan <span class="req">*</span></label>
            <div class="check-grid" id="jenis-check-grid">
                @php
                $jenisPerubahan = [
                    ['val'=>'pengurus',   'icon'=>'fas fa-users',        'label'=>'Perubahan Pengurus'],
                    ['val'=>'alamat',     'icon'=>'fas fa-map-marker-alt','label'=>'Perubahan Alamat Sekretariat'],
                    ['val'=>'nama',       'icon'=>'fas fa-tag',           'label'=>'Perubahan Nama Organisasi'],
                    ['val'=>'lambang',    'icon'=>'fas fa-star',          'label'=>'Perubahan Lambang/Logo/Stempel'],
                    ['val'=>'lainnya',    'icon'=>'fas fa-ellipsis-h',    'label'=>'Lainnya'],
                ];
                @endphp
                @foreach($jenisPerubahan as $j)
                <label class="check-item" onclick="toggleCheck(this); toggleSection('{{ $j['val'] }}', this)">
                    <input type="checkbox" name="jenis_perubahan[]" value="{{ $j['val'] }}">
                    <i class="{{ $j['icon'] }}" style="font-size:13px;color:#7b5668;width:16px;text-align:center;"></i>
                    {{ $j['label'] }}
                </label>
                @endforeach
            </div>
        </div>

        <hr class="sec-divider">

        {{-- Perubahan Nama --}}
        <div id="section-nama" style="display:none;">
            <div class="sec-head" style="border-bottom:none;margin-bottom:10px;">
                <div class="sec-head-icon" style="width:26px;height:26px;font-size:11px;"><i class="fas fa-tag"></i></div>
                <div class="sec-head-title" style="font-size:13px;">Perubahan Nama Organisasi</div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Lama <span class="req">*</span></label>
                    <input type="text" name="nama_lama" id="sec_nama_lama" class="form-control" placeholder="Nama sebelumnya">
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Baru <span class="req">*</span></label>
                    <input type="text" name="nama_baru" id="sec_nama_baru" class="form-control" placeholder="Nama yang baru">
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Singkatan Lama</label>
                    <input type="text" name="singkatan_lama" id="sec_singkatan_lama" class="form-control" placeholder="Singkatan sebelumnya">
                </div>
                <div class="form-group">
                    <label class="form-label">Singkatan Baru</label>
                    <input type="text" name="singkatan_baru" id="sec_singkatan_baru" class="form-control" placeholder="Singkatan yang baru">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Lampiran Berkas Pendukung <span class="req">*</span></label>
                <label class="upload-area" id="ua-berkas-nama">
                    <input type="file" name="berkas_nama" accept=".pdf,.jpg,.jpeg,.png" onchange="previewUpload(this,'ua-berkas-nama','Berkas Perubahan Nama')">
                    <i class="fas fa-file-alt"></i>
                    <div class="ua-label">SK/Surat perubahan nama organisasi<br><strong>PDF / JPG / PNG</strong>, maks. 5 MB</div>
                </label>
            </div>
            <div class="save-section-bar" id="save-bar-nama">
                <span id="save-status-nama" class="save-status"></span>
                <button type="button" class="btn-save-section" onclick="saveSection('nama')">
                    <i class="fas fa-save"></i> Simpan Data Bagian Ini
                </button>
            </div>
            <hr class="sec-divider">
        </div>

        {{-- Perubahan Alamat --}}
        <div id="section-alamat" style="display:none;">
            <div class="sec-head" style="border-bottom:none;margin-bottom:10px;">
                <div class="sec-head-icon" style="width:26px;height:26px;font-size:11px;"><i class="fas fa-map-marker-alt"></i></div>
                <div class="sec-head-title" style="font-size:13px;">Perubahan Alamat Sekretariat</div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Baru <span class="req">*</span></label>
                <textarea name="alamat_baru" id="ubah_alamat_baru" class="form-control" rows="2" placeholder="Alamat sekretariat yang baru"></textarea>
            </div>
            <div class="form-grid" style="grid-template-columns:1fr 1fr 1fr 1fr;gap:10px 14px;margin-bottom:14px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#4b5563;margin-bottom:4px;">RT/RW</label>
                    <input type="text" name="rt_rw_baru" id="ubah_rt_baru" class="form-control" placeholder="RT/RW">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#4b5563;margin-bottom:4px;">Kelurahan</label>
                    <input type="text" name="kelurahan_baru" id="ubah_kelurahan_baru" class="form-control" placeholder="Kelurahan">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#4b5563;margin-bottom:4px;">Kecamatan</label>
                    <input type="text" name="kecamatan_baru" id="ubah_kecamatan_baru" class="form-control" placeholder="Kecamatan">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:700;color:#4b5563;margin-bottom:4px;">Kota / Kab.</label>
                    <input type="text" name="kota_baru" id="ubah_kota_baru" class="form-control" value="Kabupaten Grobogan" placeholder="Kab. Grobogan">
                </div>
            </div>
            <x-address-pinpoint-picker
                latName="latitude_baru"
                lngName="longitude_baru"
                alamatId="ubah_alamat_baru"
                rtId="ubah_rt_baru"
                kelurahanId="ubah_kelurahan_baru"
                kecamatanId="ubah_kecamatan_baru"
                kotaId="ubah_kota_baru"
                provinsiId="ubah_provinsi_baru"
                mapId="ubah_alamat_map_picker"
                title="Pin Point Alamat Sekretariat Baru"
                subtitle="Tandai lokasi sekretariat baru pada peta"
            />
            <div class="form-group" style="margin-top:14px;">
                <label class="form-label">Lampiran Surat Domisili Baru <span class="req">*</span></label>
                <label class="upload-area" id="ua-berkas-alamat">
                    <input type="file" name="berkas_alamat" accept=".pdf,.jpg,.jpeg,.png" onchange="previewUpload(this,'ua-berkas-alamat','Berkas Perubahan Alamat')">
                    <i class="fas fa-file-alt"></i>
                    <div class="ua-label">Surat keterangan domisili / bukti kepemilikan sekretariat baru<br><strong>PDF / JPG / PNG</strong>, maks. 5 MB</div>
                </label>
            </div>
            <div class="save-section-bar" id="save-bar-alamat">
                <span id="save-status-alamat" class="save-status"></span>
                <button type="button" class="btn-save-section" onclick="saveSection('alamat')">
                    <i class="fas fa-save"></i> Simpan Data Bagian Ini
                </button>
            </div>
            <hr class="sec-divider">
        </div>

        {{-- Perubahan Pengurus --}}
        <div id="section-pengurus" style="display:none;">
            <div class="sec-head" style="border-bottom:none;margin-bottom:10px;">
                <div class="sec-head-icon" style="width:26px;height:26px;font-size:11px;"><i class="fas fa-users"></i></div>
                <div class="sec-head-title" style="font-size:13px;">Perubahan Pengurus</div>
            </div>
            <div class="form-grid col-3">
                <div class="form-group">
                    <label class="form-label">Ketua Baru <span class="req">*</span></label>
                    <input type="text" name="ketua_baru" id="sec_ketua_baru" class="form-control" placeholder="Nama lengkap ketua baru">
                </div>
                <div class="form-group">
                    <label class="form-label">Sekretaris Baru</label>
                    <input type="text" name="sekretaris_baru" id="sec_sekretaris_baru" class="form-control" placeholder="Nama lengkap">
                </div>
                <div class="form-group">
                    <label class="form-label">Bendahara Baru</label>
                    <input type="text" name="bendahara_baru" id="sec_bendahara_baru" class="form-control" placeholder="Nama lengkap">
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Masa Bhakti Baru</label>
                    <input type="text" name="masa_bhakti_baru" id="sec_masa_bhakti_baru" class="form-control" placeholder="Contoh: 2025 – 2028">
                </div>
                <div class="form-group">
                    <label class="form-label">Dasar SK Perubahan Pengurus</label>
                    <input type="text" name="sk_pengurus_baru" id="sec_sk_pengurus_baru" class="form-control" placeholder="Nomor SK / hasil munas">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Lampiran SK Kepengurusan Baru <span class="req">*</span></label>
                <label class="upload-area" id="ua-berkas-pengurus">
                    <input type="file" name="berkas_pengurus" accept=".pdf,.jpg,.jpeg,.png" onchange="previewUpload(this,'ua-berkas-pengurus','Berkas Perubahan Pengurus')">
                    <i class="fas fa-file-alt"></i>
                    <div class="ua-label">SK susunan kepengurusan baru (hasil munas/rapat)<br><strong>PDF / JPG / PNG</strong>, maks. 5 MB</div>
                </label>
            </div>
            <div class="save-section-bar" id="save-bar-pengurus">
                <span id="save-status-pengurus" class="save-status"></span>
                <button type="button" class="btn-save-section" onclick="saveSection('pengurus')">
                    <i class="fas fa-save"></i> Simpan Data Bagian Ini
                </button>
            </div>
            <hr class="sec-divider">
        </div>

        {{-- Perubahan Lambang --}}
        <div id="section-lambang" style="display:none;">
            <div class="sec-head" style="border-bottom:none;margin-bottom:10px;">
                <div class="sec-head-icon" style="width:26px;height:26px;font-size:11px;"><i class="fas fa-star"></i></div>
                <div class="sec-head-title" style="font-size:13px;">Perubahan Lambang / Logo / Stempel</div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Lambang / Logo Baru (berwarna) <span class="req">*</span></label>
                    <label class="upload-area" id="ua-lambang-baru">
                        <input type="file" name="lambang_baru" accept=".jpg,.jpeg,.png,.pdf" onchange="previewUpload(this,'ua-lambang-baru','Lambang Baru')">
                        <i class="fas fa-image"></i>
                        <div class="ua-label">Klik untuk unggah<br><strong>JPG / PNG / PDF</strong>, maks. 5 MB</div>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Cap Stempel Baru (berwarna)</label>
                    <label class="upload-area" id="ua-stempel-baru">
                        <input type="file" name="stempel_baru" accept=".jpg,.jpeg,.png,.pdf" onchange="previewUpload(this,'ua-stempel-baru','Stempel Baru')">
                        <i class="fas fa-stamp"></i>
                        <div class="ua-label">Klik untuk unggah<br><strong>JPG / PNG / PDF</strong>, maks. 5 MB</div>
                    </label>
                </div>
            </div>
            <div class="save-section-bar" id="save-bar-lambang">
                <span id="save-status-lambang" class="save-status"></span>
                <button type="button" class="btn-save-section" onclick="saveSection('lambang')">
                    <i class="fas fa-save"></i> Simpan Data Bagian Ini
                </button>
            </div>
            <hr class="sec-divider">
        </div>

        {{-- Lainnya --}}
        <div id="section-lainnya" style="display:none;">
            <div class="sec-head" style="border-bottom:none;margin-bottom:10px;">
                <div class="sec-head-icon" style="width:26px;height:26px;font-size:11px;"><i class="fas fa-ellipsis-h"></i></div>
                <div class="sec-head-title" style="font-size:13px;">Perubahan Lainnya</div>
            </div>
            <div class="form-group">
                <label class="form-label">Uraian Perubahan <span class="req">*</span></label>
                <textarea name="perubahan_lainnya" id="sec_perubahan_lainnya" class="form-control" rows="3" placeholder="Jelaskan perubahan yang dimaksud secara detail..."></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Lampiran Berkas Pendukung</label>
                <label class="upload-area" id="ua-berkas-lainnya">
                    <input type="file" name="berkas_lainnya" accept=".pdf,.jpg,.jpeg,.png" onchange="previewUpload(this,'ua-berkas-lainnya','Berkas Pendukung')">
                    <i class="fas fa-paperclip"></i>
                    <div class="ua-label">Dokumen / surat pendukung perubahan lainnya<br><strong>PDF / JPG / PNG</strong>, maks. 5 MB</div>
                </label>
            </div>
            <div class="save-section-bar" id="save-bar-lainnya">
                <span id="save-status-lainnya" class="save-status"></span>
                <button type="button" class="btn-save-section" onclick="saveSection('lainnya')">
                    <i class="fas fa-save"></i> Simpan Data Bagian Ini
                </button>
            </div>
            <hr class="sec-divider">
        </div>

        <div class="nav-btns" style="justify-content:flex-end;">
            <button type="button" id="btn-kirim-perubahan" class="btn-next" onclick="submitPerubahan()" disabled>
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
        </div>
    </form>

  </div>
</div>

<script>
    const STORAGE_KEY = 'siporas_perubahan_draft';

    /* ── Mapping section → field IDs yang disimpan ── */
    const SECTION_FIELDS = {
        nama: ['sec_nama_lama', 'sec_nama_baru', 'sec_singkatan_lama', 'sec_singkatan_baru'],
        alamat: ['ubah_alamat_baru', 'ubah_kelurahan_baru', 'ubah_kecamatan_baru', 'ubah_kota_baru', 'ubah_provinsi_baru'],
        pengurus: ['sec_ketua_baru', 'sec_sekretaris_baru', 'sec_bendahara_baru', 'sec_masa_bhakti_baru', 'sec_sk_pengurus_baru'],
        lainnya: ['sec_perubahan_lainnya'],
    };

    /* ── Validasi section & update status tombol Kirim ── */
    function validateAndRefreshBtn() {
        const checked = Array.from(document.querySelectorAll('#jenis-check-grid input[type=checkbox]:checked'));
        if (checked.length === 0) {
            setKirimDisabled(true, 'Pilih minimal satu jenis perubahan');
            return;
        }

        const errors = [];

        checked.forEach(function (cb) {
            const key = cb.value;
            if (key === 'nama') {
                if (!val('sec_nama_baru')) { errors.push('Nama Baru wajib diisi'); }
                if (!hasFile('berkas_nama'))   { errors.push('Berkas Perubahan Nama wajib diunggah'); }
            }
            if (key === 'alamat') {
                if (!val('ubah_alamat_baru'))  { errors.push('Alamat Baru wajib diisi'); }
                if (!hasFile('berkas_alamat')) { errors.push('Lampiran Surat Domisili wajib diunggah'); }
            }
            if (key === 'pengurus') {
                if (!val('sec_ketua_baru'))    { errors.push('Ketua Baru wajib diisi'); }
                if (!hasFile('berkas_pengurus')) { errors.push('Lampiran SK Kepengurusan wajib diunggah'); }
            }
            if (key === 'lambang') {
                if (!hasFile('lambang_baru')) { errors.push('Lambang/Logo Baru wajib diunggah'); }
            }
            if (key === 'lainnya') {
                if (!val('sec_perubahan_lainnya')) { errors.push('Uraian Perubahan wajib diisi'); }
            }
        });

        if (errors.length > 0) {
            setKirimDisabled(true, errors[0]);
        } else {
            setKirimDisabled(false, '');
        }
    }

    function val(id) {
        const el = document.getElementById(id);
        return el && el.value.trim().length > 0;
    }

    function hasFile(name) {
        const el = document.querySelector('input[type=file][name="' + name + '"]');
        return el && el.files && el.files.length > 0;
    }

    function setKirimDisabled(disabled, hint) {
        const btn = document.getElementById('btn-kirim-perubahan');
        if (!btn) { return; }
        btn.disabled = disabled;
        btn.title = '';
    }

    /* ── Checkbox styling ── */
    function toggleCheck(label) {
        const cb = label.querySelector('input[type=checkbox]');
        setTimeout(function () {
            if (cb.checked) { label.classList.add('checked'); }
            else { label.classList.remove('checked'); }
        }, 0);
    }

    /* ── Toggle detail section + restore data ── */
    function toggleSection(key, label) {
        const cb = label.querySelector('input[type=checkbox]');
        const section = document.getElementById('section-' + key);
        if (!section) { return; }
        setTimeout(function () {
            if (cb.checked) {
                section.style.display = 'block';
                restoreSection(key);
                window.dispatchEvent(new Event('resize'));
            } else {
                section.style.display = 'none';
            }
            validateAndRefreshBtn();
        }, 50);
    }

    /* ── Simpan data section ke localStorage ── */
    function saveSection(key) {
        const fields = SECTION_FIELDS[key];
        const draft = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');

        if (fields) {
            draft[key] = {};
            fields.forEach(function (id) {
                const el = document.getElementById(id);
                if (el) { draft[key][id] = el.value; }
            });
        }

        if (key === 'alamat') {
            const latEl = document.getElementById('input_latitude_baru_ubah_alamat_map_picker');
            const lngEl = document.getElementById('input_longitude_baru_ubah_alamat_map_picker');
            if (!draft[key]) { draft[key] = {}; }
            if (latEl) { draft[key]['_lat'] = latEl.value; }
            if (lngEl) { draft[key]['_lng'] = lngEl.value; }
        }

        localStorage.setItem(STORAGE_KEY, JSON.stringify(draft));

        const statusEl = document.getElementById('save-status-' + key);
        if (statusEl) {
            statusEl.innerHTML = '<i class="fas fa-check-circle"></i> Data tersimpan';
            statusEl.classList.add('show');
            clearTimeout(statusEl._timer);
            statusEl._timer = setTimeout(function () {
                statusEl.innerHTML = '';
                statusEl.classList.remove('show');
            }, 3000);
        }
    }

    /* ── Restore data section dari localStorage ── */
    function restoreSection(key) {
        const draft = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}');
        if (!draft[key]) { return; }

        const fields = SECTION_FIELDS[key];
        if (fields) {
            fields.forEach(function (id) {
                const el = document.getElementById(id);
                if (el && draft[key][id] !== undefined) { el.value = draft[key][id]; }
            });
        }

        if (key === 'alamat') {
            const latEl = document.getElementById('input_latitude_baru_ubah_alamat_map_picker');
            const lngEl = document.getElementById('input_longitude_baru_ubah_alamat_map_picker');
            if (latEl && draft[key]['_lat']) { latEl.value = draft[key]['_lat']; }
            if (lngEl && draft[key]['_lng']) { lngEl.value = draft[key]['_lng']; }
        }
    }

    /* ── Submit dengan validasi final ── */
    function submitPerubahan() {
        const checked = Array.from(document.querySelectorAll('#jenis-check-grid input[type=checkbox]:checked'));
        if (checked.length === 0) {
            alert('Pilih minimal satu jenis perubahan sebelum mengirim.');
            return;
        }
        localStorage.removeItem(STORAGE_KEY);
        document.getElementById('ubah-form').submit();
    }

    /* ── Upload area preview + re-validasi ── */
    function previewUpload(input, areaId, label) {
        const area = document.getElementById(areaId);
        if (!input.files || !input.files[0]) { return; }
        const file = input.files[0];
        const size = file.size < 1048576
            ? (file.size / 1024).toFixed(0) + ' KB'
            : (file.size / 1048576).toFixed(1) + ' MB';
        area.classList.add('has-file');
        area.querySelector('i').className = 'fas fa-check-circle';
        area.querySelector('.ua-label').innerHTML =
            '<strong>' + label + ' berhasil dipilih</strong><br>' + file.name + ' (' + size + ')';
        validateAndRefreshBtn();
    }

    /* ── Pasang listener input text/textarea untuk re-validasi ── */
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('ubah-form').addEventListener('input', validateAndRefreshBtn);
        validateAndRefreshBtn();
    });

    /* ── Mobile nav modal ── */
    function openMobModal(id) {
        document.getElementById('mob-modal-' + id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeMobModal(id) {
        document.getElementById('mob-modal-' + id).classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMobModal('ub'); });
    window.addEventListener('resize', function() { if (window.innerWidth >= 768) closeMobModal('ub'); });
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

{{-- Success Popup --}}
<div class="success-overlay" id="success-overlay">
    <div class="success-popup">
        <div class="check-circle">
            <svg viewBox="0 0 90 90" width="90" height="90">
                <circle class="circle-bg" cx="45" cy="45" r="40"/>
                <circle class="circle-progress" cx="45" cy="45" r="40" transform="rotate(-90 45 45)"/>
            </svg>
            <svg class="check-icon" viewBox="0 0 44 44">
                <path d="M10 22 L19 32 L34 14"/>
            </svg>
        </div>
        <div class="success-title">Pengajuan Terkirim!</div>
        <div class="success-msg" id="success-popup-msg">Perubahan data ormas Anda berhasil dikirim. Silakan pantau status di menu Cek Status.</div>
        <button class="success-btn" onclick="closeSuccessPopup()">Lihat Status Pengajuan</button>
    </div>
</div>

@if(session('success') && str_contains(session('success'), 'dikirim'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var msg = @json(session('success'));
        document.getElementById('success-popup-msg').textContent = msg;
        document.getElementById('success-overlay').classList.add('show');
        document.body.style.overflow = 'hidden';
    });
</script>
@endif

<script>
function closeSuccessPopup() {
    document.getElementById('success-overlay').classList.remove('show');
    document.body.style.overflow = '';
    window.location.href = '{{ route("pengajuan.cek") }}';
}
</script>

<script>
// ── Autofill alamat saat field diubah manual ──
(function() {
    function buildAlamat() {
        var rt  = (document.getElementById('ubah_rt_baru')        || {}).value || '';
        var kel = (document.getElementById('ubah_kelurahan_baru') || {}).value || '';
        var kec = (document.getElementById('ubah_kecamatan_baru') || {}).value || '';
        var kot = (document.getElementById('ubah_kota_baru')      || {}).value || '';
        var parts = [rt ? 'RT/RW ' + rt : '', kel, kec ? 'Kec. ' + kec : '', kot].filter(Boolean);
        var alamatEl = document.getElementById('ubah_alamat_baru');
        if (alamatEl) { alamatEl.value = parts.join(', '); }
    }
    ['ubah_rt_baru','ubah_kelurahan_baru','ubah_kecamatan_baru','ubah_kota_baru'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) { el.addEventListener('input', buildAlamat); }
    });
})();
</script>
</body>
</html>
