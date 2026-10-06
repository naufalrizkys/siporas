<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Baru Ormas – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        /* ── End Success Popup ── */
        *{box-sizing:border-box;margin:0;padding:0;}
        html,body{font-family:'Inter',sans-serif;background:#ffffff;min-height:100vh;}

        @media (max-width: 639px) {
            input, select, textarea { font-size: 16px !important; }
        }
        /* ── Header ── */
        .site-header{background:#b91c1c;height:78px;display:flex;align-items:center;justify-content:space-between;max-width:1280px;margin:0 auto;padding:0 2rem;}
        @media (max-width: 639px) {
            .site-header { height: 68px; padding: 0 1rem; }
        }

        /* ── Navbar ── */
        .navbar{background:#b91c1c;position:sticky;top:0;z-index:50;}
        .navbar-inner{display:flex;align-items:center;width:100%;max-width:1280px;margin:0 auto;padding:0 2rem;}
        .nav-tab{display:flex;align-items:center;gap:6px;padding:0 16px;height:44px;font-size:13px;font-weight:600;color:rgba(255,255,255,0.75);background:transparent;border:none;border-bottom:3px solid transparent;cursor:pointer;white-space:nowrap;text-decoration:none;transition:.15s;}
        .nav-tab:hover{color:#ffffff;}
        .nav-tab.active{color:#ffffff;border-bottom-color:#ffffff;font-weight:700;}
        .nav-spacer{flex:1;}
        .nav-action{display:flex;align-items:center;gap:6px;padding:0 12px;height:44px;font-size:13px;font-weight:600;text-decoration:none;color:rgba(255,255,255,0.75);transition:.15s;}
        .nav-action:hover{color:#ffffff;}

        /* ── Mobile nav ── */
        .nav-brand-mobile{display:none;}
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
        @media (max-width:767px){
            .navbar-inner .nav-tab,.navbar-inner .nav-spacer,.navbar-inner .nav-action{display:none!important;}
            .navbar-inner{justify-content:space-between;height:44px;padding:0 1rem;}
            .nav-brand-mobile{display:flex;align-items:center;gap:6px;font-size:13px;font-weight:700;color:#111827;}
            #hamburger-pb{display:flex!important;}
        }

        /* ── Layout ── */
        .main-wrap{padding:0 0 28px 0;}
        .content-card{background:#fff;padding:28px 2rem 48px;max-width:1280px;margin:0 auto;min-height:calc(100vh - 130px);}

        /* ── Responsive ── */
        @media (max-width:639px) {
            .site-header{padding-left:1rem;padding-right:1rem;}
            .navbar-inner{padding:0 1rem;}
            .content-card{padding:16px 1rem 32px;}
            .ul-row{flex-wrap:wrap;}
            .ul-btn{width:100%;justify-content:center;margin-top:6px;}
        }

        /* ── Section heading ── */
        .sec-head{display:flex;align-items:center;gap:10px;background:#991b1b;color:#fff;border-radius:8px;padding:10px 16px;margin-bottom:16px;}
        .sec-head span{font-size:12.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;}

        /* ── Persyaratan ── */
        .req-wrap{background:#f8fffe;border:1px solid #c7eef2;border-radius:10px;padding:16px 20px;margin-bottom:28px;}
        .req-row{display:flex;align-items:flex-start;gap:10px;padding:7px 0;border-bottom:1px solid #e8f6f8;font-size:13px;color:#374151;line-height:1.6;}
        .req-row:last-child{border-bottom:none;padding-bottom:0;}
        .req-num{min-width:22px;height:22px;background:#991b1b;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10.5px;font-weight:800;flex-shrink:0;margin-top:2px;}

        /* ── Upload form ── */
        .upload-list{display:flex;flex-direction:column;gap:8px;margin-bottom:24px;}

        /* Setiap baris upload — compact */
        .ul-row{
            display:flex;align-items:center;gap:12px;
            border:1.5px solid #e2e8f0;border-radius:10px;
            padding:12px 16px;background:#fff;
            transition:border-color .15s, background .15s;
        }
        .ul-row:hover{border-color:#cbd5e1;background:#fafafa;}
        .ul-row.done{border-color:#86efac;background:#f0fff4;}

        .ul-num{
            min-width:24px;height:24px;background:#fce7e7;color:#991b1b;
            border-radius:50%;display:flex;align-items:center;justify-content:center;
            font-size:10.5px;font-weight:800;flex-shrink:0;transition:.2s;
        }
        .ul-row.done .ul-num{background:#16a34a;color:#fff;}

        .ul-label{flex:1;font-size:13px;font-weight:600;color:#1f2937;line-height:1.4;}
        .ul-label small{display:block;font-size:11px;font-weight:400;color:#9ca3af;margin-top:1px;}

        /* Upload trigger button — kecil */
        .ul-btn{
            display:inline-flex;align-items:center;gap:6px;
            background:#f1f5f9;color:#374151;font-size:12px;font-weight:700;
            padding:6px 14px;border-radius:6px;border:1.5px solid #e2e8f0;
            cursor:pointer;white-space:nowrap;transition:.15s;flex-shrink:0;
            font-family:'Open Sans',sans-serif;
        }
        .ul-btn:hover{background:#fce7e7;border-color:#991b1b;color:#991b1b;}
        .ul-row.done .ul-btn{background:#dcfce7;border-color:#86efac;color:#16a34a;}

        /* File chips */
        .file-chips{display:flex;flex-wrap:wrap;gap:5px;margin-top:6px;padding-left:36px;}
        .chip{
            display:inline-flex;align-items:center;gap:5px;
            background:#f1f5f9;border:1px solid #e2e8f0;border-radius:20px;
            padding:3px 10px 3px 8px;font-size:11px;color:#374151;
        }
        .chip i{font-size:11px;color:#991b1b;}
        .chip .chip-rm{
            background:none;border:none;cursor:pointer;color:#9ca3af;
            font-size:10px;padding:0;margin-left:2px;line-height:1;transition:.15s;
        }
        .chip .chip-rm:hover{color:#ef4444;}

        /* ── Submit row ── */
        .submit-row{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding-top:20px;border-top:1px solid #f0f0f0;}
        .btn-back2{background:#fff;color:#6b7280;font-weight:700;font-size:13px;padding:10px 22px;border-radius:7px;border:1.5px solid #e5e7eb;cursor:pointer;font-family:'Open Sans',sans-serif;display:inline-flex;align-items:center;gap:7px;transition:.15s;}
        .btn-back2:hover{background:#f9fafb;}
        .btn-send{background:#111827;color:#fff;font-weight:800;font-size:13px;padding:10px 28px;border-radius:7px;border:none;cursor:pointer;font-family:'Open Sans',sans-serif;display:inline-flex;align-items:center;gap:7px;transition:.15s;}
        .btn-send:hover{background:#374151;}
        .user-avatar-btn{display:none;}
        @media (min-width:768px){.user-avatar-btn{display:block;}}
        .hidden-mobile{display:none;}
        @media (min-width:768px){.hidden-mobile{display:flex!important;}}
        @media (max-width:767px){.hidden-mobile{display:none!important;}}
        .mob-hamburger{display:flex;}
        @media (min-width:768px){.mob-hamburger{display:none!important;}}
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
                <a href="{{ route('laporan.pendaftaran-baru') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:#991b1b;text-decoration:none;background:#fef2f2;">
                    <i class="fas fa-file-alt" style="font-size:12px;color:#991b1b;"></i> Pendaftaran Baru
                </a>
                <a href="{{ route('laporan.perubahan') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;background:transparent;transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                    <i class="fas fa-edit" style="font-size:12px;color:#9ca3af;"></i> Perubahan Data
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

    <div style="display:flex;align-items:center;gap:10px;">
        {{-- Avatar desktop --}}
        <div class="user-avatar-btn" id="user-av-wrap" style="position:relative;">
            <button onclick="toggleUserAv()" style="background:none;border:none;padding:0;cursor:pointer;">
                @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
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
        {{-- Hamburger mobile di header --}}
        <button class="mob-hamburger" onclick="openMobModal('pb')" aria-label="Menu"
                style="display:flex;align-items:center;justify-content:center;width:36px;height:36px;border:none;background:none;cursor:pointer;flex-direction:column;gap:5px;padding:0;flex-shrink:0;">
            <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
            <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
            <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
        </button>
    </div>
</div>
</div>


<div class="mob-modal" id="mob-modal-pb">
    <div class="mob-modal__backdrop" onclick="closeMobModal('pb')"></div>
    <div class="mob-modal__panel">
        <button class="mob-modal__close" onclick="closeMobModal('pb')" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
        <div class="mob-modal__body">
            <a href="{{ route('home') }}" class="mob-modal__item">Beranda</a>
            <a href="#" class="mob-modal__item active-mob">Pendaftaran Baru</a>
            <a href="{{ route('laporan.perubahan') }}" class="mob-modal__item">Perubahan Data</a>
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

    <form id="pb-laporan-form" action="{{ route('laporan.pendaftaran-baru.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Error dari server --}}
        @if($errors->any())
        <div style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:8px;padding:12px 16px;font-size:13px;color:#991b1b;margin-bottom:16px;">
            <div style="font-weight:700;margin-bottom:6px;display:flex;align-items:center;gap:7px;">
                <i class="fas fa-exclamation-triangle"></i> Pengajuan gagal. Periksa kembali:
            </div>
            <ul style="list-style:disc;padding-left:20px;line-height:1.8;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Progress Stepper --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;padding:16px 20px;background:#ffffff;border-radius:12px;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#b91c1c;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:13px;flex-shrink:0;box-shadow:0 2px 8px rgba(185,28,28,0.3);">1</div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#111827;">Identitas & Lokasi</div>
                    <div style="font-size:11px;color:#6b7280;">Biodata & titik koordinat</div>
                </div>
            </div>
            <div style="flex:1;height:2px;background:#e2e8f0;margin:0 12px;"></div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#f1f5f9;color:#6b7280;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;border:1px solid #cbd5e1;flex-shrink:0;">2</div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#374151;">Lampiran Berkas</div>
                    <div style="font-size:11px;color:#6b7280;">10 Dokumen wajib</div>
                </div>
            </div>
            <div style="flex:1;height:2px;background:#e2e8f0;margin:0 12px;"></div>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:50%;background:#f1f5f9;color:#6b7280;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;border:1px solid #cbd5e1;flex-shrink:0;">3</div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#374151;">Kirim Laporan</div>
                    <div style="font-size:11px;color:#6b7280;">Verifikasi Kesbangpol</div>
                </div>
            </div>
        </div>

        {{-- ══ SECTION 1: BIODATA ORGANISASI & TITIK LOKASI KOORDINAT ══ --}}
        <div style="display:flex;align-items:center;gap:10px;border-left:4px solid #b91c1c;padding-left:14px;margin-bottom:20px;">
            <h3 style="font-size:16px;font-weight:700;color:#111827;margin:0;">Biodata Organisasi & Titik Koordinat Alamat</h3>
        </div>

        <div style="margin-bottom:36px;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        Nama Organisasi / Ormas <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="nama_ormas" value="{{ old('nama_ormas') }}" required
                           placeholder="Contoh: Ormas Pemuda Grobogan"
                           style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;transition:border-color .15s, box-shadow .15s;">
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        Nama Pemohon <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required
                           placeholder="Nama lengkap pengurus yang mengajukan"
                           style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;transition:border-color .15s, box-shadow .15s;">
                </div>

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        Bidang Kegiatan <span style="color:#dc2626;">*</span>
                    </label>
                    <select name="bidang_kegiatan" required style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;transition:border-color .15s, box-shadow .15s;">
                        <option value="">— Pilih Bidang Kegiatan —</option>
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

                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        Email Ormas <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="contoh@email.com"
                           style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;transition:border-color .15s, box-shadow .15s;">
                </div>

                <div class="md:col-span-2">
                    <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                        No. Telepon / WhatsApp Ormas <span style="color:#dc2626;">*</span>
                    </label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" required
                           placeholder="08xx-xxxx-xxxx"
                           style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;transition:border-color .15s, box-shadow .15s;">
                </div>
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;">
                    Alamat Kantor / Sekretariat <span style="color:#dc2626;">*</span>
                </label>
                <textarea name="alamat_sekretariat" id="pb_laporan_alamat" rows="2" required
                          placeholder="Jl. ... No. ..., Desa/Kelurahan, Kecamatan, Kab. Grobogan"
                          style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 14px;font-size:14px;font-family:'Inter',sans-serif;color:#111827;outline:none;background:#fff;resize:vertical;transition:border-color .15s, box-shadow .15s;"></textarea>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#4b5563;margin-bottom:4px;">RT/RW</label>
                    <input type="text" name="rt_rw" id="pb_laporan_rt" placeholder="RT/RW" style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;font-size:13px;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#4b5563;margin-bottom:4px;">Kelurahan</label>
                    <input type="text" name="kelurahan" id="pb_laporan_kelurahan" placeholder="Kelurahan" style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;font-size:13px;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#4b5563;margin-bottom:4px;">Kecamatan</label>
                    <input type="text" name="kecamatan" id="pb_laporan_kecamatan" placeholder="Kecamatan" style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;font-size:13px;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#4b5563;margin-bottom:4px;">Kota / Kab.</label>
                    <input type="text" name="kota" id="pb_laporan_kota" value="Kabupaten Grobogan" placeholder="Kab. Grobogan" style="width:100%;border:1px solid #d1d5db;border-radius:8px;padding:8px 12px;font-size:13px;">
                </div>
            </div>

            {{-- Shopee Style Address Pinpoint Picker --}}
            <x-address-pinpoint-picker 
                :latitude="old('latitude')" 
                :longitude="old('longitude')" 
                latName="latitude" 
                lngName="longitude"
                alamatId="pb_laporan_alamat"
                rtId="pb_laporan_rt"
                kelurahanId="pb_laporan_kelurahan"
                kecamatanId="pb_laporan_kecamatan"
                kotaId="pb_laporan_kota"
                provinsiId="pb_laporan_provinsi"
                mapId="pb_laporan_map_picker"
                title="Pin Point Penempatan Alamat Kantor"
                subtitle="Klik pada peta atau geser penanda merah untuk menyimpan titik lokasi presisi"
            />
        </div>

        {{-- ══ SECTION 2: LAMPIRAN BERKAS ══ --}}
        <div style="display:flex;align-items:center;gap:10px;border-left:4px solid #b91c1c;padding-left:14px;margin-bottom:20px;">
            <h3 style="font-size:16px;font-weight:700;color:#111827;margin:0;">Lampiran Berkas (10 Dokumen Requirements)</h3>
        </div>

        @php
        $lampiran = [
            ['name'=>'surat_pengantar',  'no'=>1,  'label'=>'Surat Pengantar dari Ormas',                         'hint'=>'PDF/JPG/PNG',          'multi'=>false],
            ['name'=>'akta_pendirian',   'no'=>2,  'label'=>'Fotocopy Akte Pendirian / Akta Notaris',             'hint'=>'PDF/JPG/PNG',          'multi'=>false],
            ['name'=>'sk_kemenkumham',   'no'=>3,  'label'=>'Fotocopy Surat Pengesahan Kemenkumham',              'hint'=>'PDF/JPG/PNG',          'multi'=>false],
            ['name'=>'program_kerja',    'no'=>4,  'label'=>'Program Kerja Organisasi',                           'hint'=>'PDF/JPG/PNG',          'multi'=>false],
            ['name'=>'sk_kepengurusan',  'no'=>5,  'label'=>'Fotocopy SK Susunan Kepengurusan',                   'hint'=>'PDF/JPG/PNG',          'multi'=>false],
            ['name'=>'domisili',         'no'=>6,  'label'=>'Surat Domisili + Bukti Kepemilikan + Foto Kantor',   'hint'=>'Multi file OK',        'multi'=>true],
            ['name'=>'npwp',             'no'=>7,  'label'=>'Foto Copy NPWP Ormas',                               'hint'=>'PDF/JPG/PNG',          'multi'=>false],
            ['name'=>'biodata_pengurus', 'no'=>8,  'label'=>'Biodata Pengurus + Pas Foto 4×6',                    'hint'=>'Multi file — 3 orang', 'multi'=>true],
            ['name'=>'ktp_pengurus',     'no'=>9,  'label'=>'Foto Copy E-KTP Pengurus',                           'hint'=>'Multi file — 3 orang', 'multi'=>true],
            ['name'=>'dokumen_pelengkap', 'no'=>10, 'label'=>'Formulir Data Ormas + Lambang, Bendera & Cap Stempel + Surat Pernyataan', 'hint'=>'Multi file OK', 'multi'=>true],
        ];
        @endphp

        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-bottom:32px;">
            <div style="padding:12px 18px;background:#f8fafc;border-bottom:1px solid #e5e7eb;font-size:12.5px;color:#6b7280;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-info-circle" style="color:#b91c1c;"></i> Tanda bintang merah (<span style="color:#dc2626;font-weight:bold;">*</span>) menandakan dokumen wajib diunggah.
            </div>
            <div style="display:flex;flex-direction:column;">
                @foreach($lampiran as $item)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #f1f5f9;transition:background .15s;" onmouseover="this.style.background='#fdfaf9'" onmouseout="this.style.background='transparent'" id="row-{{ $item['name'] }}">
                    <div style="display:flex;align-items:center;gap:14px;flex:1;min-width:0;">
                        <div id="num-{{ $item['name'] }}" style="width:28px;height:28px;border-radius:50%;background:#fef2f2;color:#b91c1c;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                            {{ $item['no'] }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:14px;font-weight:600;color:#1f2937;">
                                {{ $item['label'] }} <span style="color:#dc2626;">*</span>
                            </div>
                            <div style="font-size:12px;color:#9ca3af;margin-top:2px;">Format: {{ $item['hint'] }}</div>
                            <div class="file-chips" id="chips-{{ $item['name'] }}"></div>
                        </div>
                    </div>
                    <label class="ul-btn" for="file-{{ $item['name'] }}" id="btn-{{ $item['name'] }}" style="display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#374151;font-size:12.5px;font-weight:600;padding:8px 16px;border-radius:8px;border:1px solid #d1d5db;cursor:pointer;white-space:nowrap;transition:all .15s;flex-shrink:0;">
                        <i class="fas fa-upload" style="font-size:11px;color:#6b7280;"></i> Pilih File
                        <input type="file"
                               id="file-{{ $item['name'] }}"
                               name="{{ $item['name'] }}{{ $item['multi'] ? '[]' : '' }}"
                               accept=".pdf,.jpg,.jpeg,.png"
                               {{ $item['multi'] ? 'multiple' : '' }}
                               style="display:none;"
                               onchange="handleFile(this,'{{ $item['name'] }}')">
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="submit-row">
            <div style="display:flex;align-items:center;justify-content:flex-end;">
                <button type="button" id="pb-btn-kirim" class="btn-send" onclick="submitPendaftaranBaru()" disabled>
                    <i class="fas fa-paper-plane"></i> Kirim
                </button>
            </div>
        </div>
    </form>

  </div>
</div>

    {{-- Tambah disabled style untuk btn-send --}}
    <style>
        .btn-send:disabled { background: #9ca3af; cursor: not-allowed; }
        .btn-send:disabled:hover { background: #9ca3af; }
    </style>

<script>
/* ── Nama field lampiran wajib ── */
const PB_WAJIB = ['surat_pengantar','akta_pendirian','sk_kemenkumham','program_kerja','sk_kepengurusan','domisili','npwp','biodata_pengurus','ktp_pengurus','dokumen_pelengkap'];

/* ── Field biodata wajib ── */
const PB_FIELD_WAJIB = ['nama_ormas','nama_pemohon','bidang_kegiatan','email','telepon','alamat_sekretariat'];

function pbValidate() {
    const form = document.getElementById('pb-laporan-form');
    const btn  = document.getElementById('pb-btn-kirim');

    // Cek field teks wajib
    for (const name of PB_FIELD_WAJIB) {
        const el = form.querySelector('[name="' + name + '"]');
        if (!el || !el.value.trim()) {
            btn.disabled = true;
            return;
        }
    }

    // Cek semua lampiran wajib sudah diupload
    for (const name of PB_WAJIB) {
        const fileEl = document.getElementById('file-' + name);
        if (!fileEl || !fileEl.files || fileEl.files.length === 0) {
            btn.disabled = true;
            return;
        }
    }

    btn.disabled = false;
}

function handleFile(input, name) {
    const files = Array.from(input.files);
    if (!files.length) { return; }

    const row   = document.getElementById('row-'   + name);
    const chips = document.getElementById('chips-' + name);
    const btn   = document.getElementById('btn-'   + name);

    // Tandai baris sebagai done
    row.classList.add('done');

    // Update tampilan tombol tanpa mengganti input (input tetap di tempatnya)
    const labelEl = btn.querySelector('label') || btn;
    const iconEl  = btn.querySelector('i.fas');
    if (iconEl) {
        iconEl.className = 'fas fa-check';
        iconEl.style.color = '#16a34a';
    }
    // Ganti teks tombol tapi pertahankan input file
    const existingInput = btn.querySelector('input[type=file]');
    btn.innerHTML = '';
    const checkIcon = document.createElement('i');
    checkIcon.className = 'fas fa-check';
    checkIcon.style.cssText = 'font-size:11px;color:#16a34a;';
    btn.appendChild(checkIcon);
    btn.appendChild(document.createTextNode(' Ditambahkan'));
    if (existingInput) {
        btn.appendChild(existingInput);
    }

    // Tampilkan chips nama file
    chips.innerHTML = '';
    files.forEach(function (file) {
        const ext  = file.name.split('.').pop().toUpperCase();
        const size = file.size < 1048576 ? (file.size / 1024).toFixed(0) + ' KB' : (file.size / 1048576).toFixed(1) + ' MB';
        const iconMap = { PDF: 'fa-file-pdf', JPG: 'fa-file-image', JPEG: 'fa-file-image', PNG: 'fa-file-image' };
        const icon = iconMap[ext] || 'fa-file';
        const chip = document.createElement('div');
        chip.className = 'chip';
        chip.innerHTML = '<i class="fas ' + icon + '"></i><span title="' + file.name + '">' + (file.name.length > 28 ? file.name.slice(0, 26) + '…' : file.name) + '</span><span style="color:#9ca3af;">' + size + '</span>';
        chips.appendChild(chip);
    });

    pbValidate();
}

function submitPendaftaranBaru() {
    document.getElementById('pb-laporan-form').submit();
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('pb-laporan-form').addEventListener('input', pbValidate);
    pbValidate();
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
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMobModal('pb'); });
window.addEventListener('resize', function() { if (window.innerWidth >= 768) closeMobModal('pb'); });
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
        <div class="success-msg" id="success-popup-msg">Laporan keberadaan ormas Anda berhasil dikirim. Silakan pantau status di menu Cek Status.</div>
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
// ── Autofill alamat saat RT/RW, Kelurahan, Kecamatan, atau Kota diubah manual ──
(function() {
    function buildAlamat() {
        var rt  = (document.getElementById('pb_laporan_rt')        || {}).value || '';
        var kel = (document.getElementById('pb_laporan_kelurahan') || {}).value || '';
        var kec = (document.getElementById('pb_laporan_kecamatan') || {}).value || '';
        var kot = (document.getElementById('pb_laporan_kota')      || {}).value || '';
        var parts = [rt ? 'RT/RW ' + rt : '', kel, kec ? 'Kec. ' + kec : '', kot].filter(Boolean);
        var alamatEl = document.getElementById('pb_laporan_alamat');
        if (alamatEl) { alamatEl.value = parts.join(', '); }
    }
    ['pb_laporan_rt','pb_laporan_kelurahan','pb_laporan_kecamatan','pb_laporan_kota'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) { el.addEventListener('input', buildAlamat); }
    });
})();
</script>
</body>
</html>
