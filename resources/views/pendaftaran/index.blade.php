<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Online – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { min-height: 100vh; font-family: 'Inter', sans-serif; background: #ffffff; }

        /* ── Header ── */
        .site-header { background: #b91c1c; height: 78px; max-width: 1280px; margin: 0 auto; padding: 0 2rem; display: flex; align-items: center; justify-content: space-between; }
        @media (max-width: 639px) {
            .site-header { height: 68px; padding: 0 1rem; }
        }
        .header-avatar:hover { background: rgba(255,255,255,.25); }

        /* ── Navbar ── */
        .navbar { background: #991b1b; display: flex; align-items: flex-end; padding: 0 20px; overflow-x: auto; gap: 0; }
        .nav-item { display: flex; align-items: center; gap: 7px; padding: 0 18px; height: 46px; font-size: 13px; font-weight: 600; color: rgba(255,255,255,.85); background: transparent; border: none; border-radius: 10px 10px 0 0; cursor: pointer; white-space: nowrap; text-decoration: none; transition: color .15s, background .15s; margin-top: 6px; font-family: 'Open Sans', sans-serif; }
        .nav-item:hover { color: #fff; background: rgba(255,255,255,.15); }
        .nav-item.active { color: #991b1b; background: #ffffff; font-weight: 700; }
        .nav-spacer { flex: 1; }
        .nav-action { display: flex; align-items: center; gap: 6px; padding: 0 14px; height: 46px; font-size: 13px; font-weight: 700; text-decoration: none; color: rgba(255,255,255,.85); margin-top: 6px; transition: color .15s; }
        .nav-action:hover { color: #fff; }
        .nav-divider { color: rgba(255,255,255,.3); font-size: 18px; line-height: 46px; margin-top: 6px; }

        /* ── Main ── */
        .main-wrap { padding: 0 0 16px 0; }
        .content-card { background: #fff; border-radius: 0 0 14px 14px; padding: 0 0 36px; min-height: calc(100vh - 160px); max-width: 1280px; margin: 0 auto; }

        /* ── Tab pane ── */
        .tab-pane { display: none; padding: 28px 28px 0; }
        .tab-pane.active { display: block; }

        /* ── Section heading ── */
        .sec-head { display: flex; align-items: center; gap: 9px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f3f4f6; }
        .sec-head-icon { width: 32px; height: 32px; border-radius: 8px; background: #991b1b; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sec-head-icon i { font-size: 13px; color: #fff; }
        .sec-head-title { font-size: 14px; font-weight: 800; color: #111; text-transform: uppercase; letter-spacing: .04em; }
        .sec-head-sub { font-size: 11px; color: #6b7280; font-weight: 400; text-transform: none; letter-spacing: 0; }

        /* ── Info box ── */
        .info-box { background: #fff7f7; border: 1.5px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px; color: #374151; display: flex; align-items: flex-start; gap: 8px; line-height: 1.6; }
        .info-box i { color: #991b1b; margin-top: 1px; flex-shrink: 0; }
        .kop-info { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 8px; padding: 11px 16px; margin-bottom: 16px; font-size: 12.5px; color: #78350f; display: flex; align-items: flex-start; gap: 8px; }
        .kop-info i { color: #d97706; margin-top: 1px; flex-shrink: 0; }

        /* ── Req list ── */
        .req-list { list-style: none; display: flex; flex-direction: column; gap: 10px; margin-bottom: 22px; }
        .req-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: #374151; line-height: 1.6; }
        .req-num { width: 22px; height: 22px; background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: #991b1b; flex-shrink: 0; margin-top: 2px; }
        .req-icon { width: 22px; height: 22px; background: #eff6ff; border: 1.5px solid #93c5fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
        .req-icon i { font-size: 9px; color: #2563eb; }

        /* ── Form ── */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 20px; }
        .form-grid.col-3 { grid-template-columns: 1fr 1fr 1fr; }
        @media (max-width: 580px) { .form-grid, .form-grid.col-3 { grid-template-columns: 1fr; } }
        .form-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
        .form-label { font-size: 11.5px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .04em; }
        .form-label .req { color: #dc2626; margin-left: 2px; }
        .form-control { border: 1.5px solid #d1d5db; border-radius: 7px; padding: 8px 11px; font-size: 13px; font-family: 'Open Sans', sans-serif; color: #111; outline: none; transition: border-color .15s; background: #fff; width: 100%; }
        .form-control:focus { border-color: #991b1b; box-shadow: 0 0 0 3px rgba(153,27,27,.09); }
        textarea.form-control { resize: vertical; }

        /* ── Checkbox bidang ── */
        .check-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }
        @media (max-width: 480px) { .check-grid { grid-template-columns: 1fr; } }
        .check-item { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1.5px solid #e5e7eb; border-radius: 7px; cursor: pointer; font-size: 13px; color: #374151; transition: .15s; }
        .check-item:hover { border-color: #991b1b; background: #fff7f7; }
        .check-item input[type=checkbox] { accent-color: #991b1b; width: 15px; height: 15px; flex-shrink: 0; }
        .check-item.checked { border-color: #991b1b; background: #fff7f7; color: #991b1b; font-weight: 600; }

        /* ── Upload area ── */
        .upload-area { border: 2px dashed #d1d5db; border-radius: 8px; padding: 16px; text-align: center; cursor: pointer; transition: .15s; background: #f9fafb; position: relative; }
        .upload-area:hover { border-color: #991b1b; background: #fff7f7; }
        .upload-area.has-file { border-color: #86efac; background: #f0fff4; }
        .upload-area input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .upload-area i { font-size: 20px; color: #9ca3af; margin-bottom: 5px; display: block; }
        .upload-area.has-file i { color: #16a34a; }
        .upload-area .ua-label { font-size: 11.5px; color: #6b7280; line-height: 1.5; }
        .upload-area .ua-label strong { color: #991b1b; }
        .upload-area.has-file .ua-label { color: #166534; }

        /* ── Cek status tracker ── */
        .status-track { display: flex; gap: 0; overflow-x: auto; margin: 22px 0 8px; }
        .status-step { flex: 1; min-width: 90px; display: flex; flex-direction: column; align-items: center; gap: 6px; position: relative; }
        .status-step:not(:last-child)::after { content: ''; position: absolute; top: 17px; left: 50%; width: 100%; height: 2px; background: #e5e7eb; z-index: 0; }
        .status-step .step-dot { width: 34px; height: 34px; border-radius: 50%; background: #f3f4f6; border: 2.5px solid #d1d5db; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #9ca3af; position: relative; z-index: 1; }
        .status-step.done .step-dot { background: #dcfce7; border-color: #16a34a; color: #16a34a; }
        .status-step.current .step-dot { background: #fef3c7; border-color: #d97706; color: #d97706; }
        .status-step .step-label { font-size: 10.5px; font-weight: 700; color: #6b7280; text-align: center; line-height: 1.3; }
        .status-step.done .step-label { color: #16a34a; }
        .status-step.current .step-label { color: #d97706; }

        /* ── Divider ── */
        .sec-divider { border: none; border-top: 1.5px solid #f3f4f6; margin: 20px 0; }

        /* ── Buttons ── */
        .btn-submit { display: inline-flex; align-items: center; gap: 8px; background: #991b1b; color: #fff; font-size: 13px; font-weight: 700; border: none; border-radius: 8px; padding: 10px 26px; cursor: pointer; font-family: 'Open Sans', sans-serif; transition: .15s; }
        .btn-submit:hover { background: #7f1d1d; }

        /* ── Output note ── */
        .output-note { display: flex; align-items: flex-start; gap: 8px; background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 7px; padding: 11px 16px; font-size: 12.5px; color: #166534; margin-top: 16px; }
        .output-note i { color: #16a34a; font-size: 14px; flex-shrink: 0; margin-top: 1px; }

        /* ── Pernyataan list ── */
        .pernyataan-list { list-style: none; display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
        .pernyataan-list li { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: #374151; line-height: 1.6; }
        .poin-num { width: 20px; height: 20px; background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: #991b1b; flex-shrink: 0; margin-top: 2px; }

        /* ── Step tabs ── */
        .steps-bar { display: flex; overflow-x: auto; border-bottom: 2px solid #f3f4f6; background: #fff; padding: 0 28px; }
        .step-btn { display: flex; align-items: center; gap: 7px; padding: 0 16px; height: 48px; font-size: 12.5px; font-weight: 600; color: #6b7280; background: transparent; border: none; border-bottom: 3px solid transparent; cursor: pointer; white-space: nowrap; font-family: 'Open Sans', sans-serif; transition: .15s; }
        .step-btn:hover { color: #374151; }
        .step-btn.active { color: #991b1b; border-bottom-color: #991b1b; font-weight: 700; }
        .step-btn .step-num { width: 20px; height: 20px; border-radius: 50%; background: #e5e7eb; color: #6b7280; font-size: 10.5px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .step-btn.active .step-num { background: #991b1b; color: #fff; }
        .step-btn.done .step-num { background: #16a34a; color: #fff; }
        .step-btn.done { color: #374151; }

        /* ── Step pane (nested, inside form tab) ── */
        .step-pane { display: none; }
        .step-pane.active { display: block; }

        /* ── Nav btns ── */
        .nav-btns { display: flex; align-items: center; justify-content: space-between; padding-top: 22px; border-top: 1.5px solid #f3f4f6; margin-top: 10px; }
        .btn-prev { background: #fff; color: #374151; font-weight: 700; font-size: 13px; padding: 10px 22px; border-radius: 7px; border: 1.5px solid #e5e7eb; cursor: pointer; font-family: 'Open Sans', sans-serif; display: inline-flex; align-items: center; gap: 7px; transition: .15s; }
        .btn-prev:hover { background: #f9fafb; }
        .btn-next { display: inline-flex; align-items: center; gap: 7px; background: #991b1b; color: #fff; font-weight: 800; font-size: 13px; padding: 10px 24px; border-radius: 7px; border: none; cursor: pointer; font-family: 'Open Sans', sans-serif; transition: .15s; }
        .btn-next:hover { background: #7f1d1d; }
        .btn-next:disabled { background: #d1d5db; color: #9ca3af; cursor: not-allowed; }

        /* ── Biodata card ── */
        .bio-card { border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 16px 18px; margin-bottom: 16px; }
        .bio-badge { background: #991b1b; color: #fff; font-size: 11px; font-weight: 800; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: .05em; }
        .photo-box { width: 86px; height: 107px; border: 2px dashed #d1d5db; border-radius: 6px; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: .15s; position: relative; flex-shrink: 0; overflow: hidden; background: #f9fafb; }
        .photo-box:hover { border-color: #991b1b; background: #fff7f7; }
        .photo-box input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
        .photo-box i { font-size: 18px; color: #9ca3af; margin-bottom: 4px; }
        .photo-box span { font-size: 9px; color: #9ca3af; text-align: center; line-height: 1.3; }
        .photo-box img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

        /* ── Lampiran row ── */
        .ul-row { display: flex; align-items: center; gap: 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 10px 14px; background: #fff; transition: .15s; }
        .ul-row.done { border-color: #86efac; background: #f0fff4; }
        .ul-num { min-width: 24px; height: 24px; background: #fee2e2; color: #991b1b; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10.5px; font-weight: 800; flex-shrink: 0; transition: .2s; }
        .ul-row.done .ul-num { background: #16a34a; color: #fff; }
    </style>
</head>
<body>

<div style="background:#b91c1c;width:100%;">
<div class="site-header">
    <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:14px;text-decoration:none;">
        <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Grobogan" style="width:52px;height:52px;object-fit:contain;flex-shrink:0;">
        <div>
            <div style="color:#ffffff;font-size:17px;font-weight:900;text-transform:uppercase;line-height:1.1;letter-spacing:.08em;">SIPORAS</div>
            <div style="color:rgba(255,255,255,0.85);font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.12em;">Kesbangpol Kab. Grobogan</div>
        </div>
    </a>
    <div class="header-avatar">
        @auth
        @if(Auth::user()->avatar)
        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
        @else
        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#1d4ed8);display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
            <span style="color:#fff;font-size:15px;font-weight:700;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
        </div>
        @endif
        @else
        <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-user" style="color:#fff;font-size:14px;"></i>
        </div>
        @endauth
    </div>
</div>
</div>

{{-- ═══ NAVBAR ═══ --}}
<nav class="navbar">
    <button class="nav-item active" id="tab-beranda" onclick="switchTab('beranda')">
        <i class="fas fa-home" style="font-size:12px;"></i> Beranda
    </button>
    <button class="nav-item" id="tab-pendaftaran" onclick="switchTab('pendaftaran')">
        <i class="fas fa-file-alt" style="font-size:12px;"></i> Pendaftaran Baru
    </button>
    <a href="{{ route('laporan.perubahan') }}" class="nav-item">
        <i class="fas fa-edit" style="font-size:12px;"></i> Perubahan Data
    </a>
    <button class="nav-item" id="tab-cek" onclick="switchTab('cek')">
        <i class="fas fa-search" style="font-size:12px;"></i> Cek Status
    </button>
    <div class="nav-spacer"></div>
    <a href="{{ route('admin.dashboard') }}" class="nav-action">
        <i class="fas fa-sign-in-alt" style="font-size:12px;"></i> Login Admin
    </a>
</nav>

{{-- ═══ KONTEN ═══ --}}
<div class="main-wrap">
  <div class="content-card">

    {{-- ════════════════════════════════════════
         TAB: BERANDA
    ════════════════════════════════════════ --}}
    <div id="content-beranda" class="tab-pane active">

        <div class="sec-head">
            <div class="sec-head-icon"><i class="fas fa-info-circle"></i></div>
            <div>
                <div class="sec-head-title">Informasi Umum</div>
                <div class="sec-head-sub">Badan Kesatuan Bangsa dan Politik Kabupaten Grobogan</div>
            </div>
        </div>

        <div class="info-box">
            <i class="fas fa-building"></i>
            <span><strong>SIPORAS</strong> adalah platform digital pelayanan administrasi Organisasi Masyarakat (Ormas)
            di Kabupaten Grobogan. Melalui sistem ini Anda dapat melakukan pendaftaran baru, pengajuan perubahan data,
            dan pemantauan status pengajuan secara online — cepat, transparan, dan akuntabel.</span>
        </div>

        <div class="sec-head" style="margin-top:20px;">
            <div class="sec-head-icon"><i class="fas fa-list-ul"></i></div>
            <div><div class="sec-head-title">Persyaratan Umum</div></div>
        </div>
        <ul class="req-list">
            <li><span class="req-num">1</span>Organisasi berbadan hukum atau terdaftar secara resmi di instansi berwenang.</li>
            <li><span class="req-num">2</span>Memiliki Akta Pendirian yang disahkan oleh Notaris.</li>
            <li><span class="req-num">3</span>Memiliki Surat Keterangan Terdaftar (SKT) dari Kesbangpol atau Kemenkumham.</li>
            <li><span class="req-num">4</span>Memiliki NPWP atas nama organisasi.</li>
            <li><span class="req-num">5</span>Memiliki SK Susunan Pengurus yang masih berlaku.</li>
        </ul>

        <div class="sec-head" style="margin-top:4px;">
            <div class="sec-head-icon"><i class="fas fa-tasks"></i></div>
            <div><div class="sec-head-title">Tata Cara</div></div>
        </div>
        <ul class="req-list">
            <li><span class="req-icon"><i class="fas fa-pencil-alt"></i></span>Pilih menu <strong>Pendaftaran Baru</strong> dan isi formulir data organisasi secara lengkap.</li>
            <li><span class="req-icon"><i class="fas fa-upload"></i></span>Unggah dokumen persyaratan (PDF/JPG, maks. 2 MB per file).</li>
            <li><span class="req-icon"><i class="fas fa-paper-plane"></i></span>Kirim pengajuan. Sistem akan memberikan <strong>Nomor Registrasi / ID Pengajuan</strong>.</li>
            <li><span class="req-icon"><i class="fas fa-search"></i></span>Pantau status melalui menu <strong>Cek Status</strong> menggunakan ID Pengajuan.</li>
        </ul>

        <hr class="sec-divider">

        <div class="sec-head">
            <div class="sec-head-icon"><i class="fas fa-phone-alt"></i></div>
            <div><div class="sec-head-title">Kontak</div></div>
        </div>
        <ul class="req-list">
            <li><span class="req-icon"><i class="fas fa-map-marker-alt"></i></span>Kantor Kesbangpol Kabupaten Grobogan</li>
            <li><span class="req-icon"><i class="fab fa-whatsapp" style="color:#16a34a;"></i></span>Hotline WA: <strong>+62 897-7976-105</strong> &nbsp;|&nbsp; Senin–Jumat, 08.00–16.00 WIB</li>
            <li><span class="req-icon"><i class="fas fa-envelope"></i></span>Email: <strong>adminsiporas@gmail.com</strong></li>
        </ul>

    </div>

    {{-- ════════════════════════════════════════
         TAB: PENDAFTARAN BARU (step-by-step)
    ════════════════════════════════════════ --}}
    <div id="content-pendaftaran" class="tab-pane" style="padding:0;">

        {{-- Step bar --}}
        <div class="steps-bar">
            <button class="step-btn active" id="pb-stepbtn-1" onclick="goStep('pb',1)">
                <span class="step-num">1</span> Data Organisasi
            </button>
            <button class="step-btn" id="pb-stepbtn-2" onclick="goStep('pb',2)">
                <span class="step-num">2</span> Pengurus &amp; Biodata
            </button>
            <button class="step-btn" id="pb-stepbtn-3" onclick="goStep('pb',3)">
                <span class="step-num">3</span> Logo, Bendera &amp; Cap
            </button>
            <button class="step-btn" id="pb-stepbtn-4" onclick="goStep('pb',4)">
                <span class="step-num">4</span> Surat Pernyataan
            </button>
            <button class="step-btn" id="pb-stepbtn-5" onclick="goStep('pb',5)">
                <span class="step-num">5</span> Lampiran Berkas
            </button>
        </div>

        <form id="pb-form" action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Error dari server --}}
        @if($errors->any())
        <div style="margin:16px 28px 0;background:#fef2f2;border:1.5px solid #fca5a5;border-radius:8px;padding:12px 16px;font-size:13px;color:#991b1b;">
            <div style="font-weight:700;margin-bottom:6px;display:flex;align-items:center;gap:7px;">
                <i class="fas fa-exclamation-triangle"></i> Pengajuan gagal dikirim. Periksa kembali:
            </div>
            <ul style="list-style:disc;padding-left:20px;line-height:1.8;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Step 1: Data Organisasi --}}
        <div class="step-pane active" id="pb-step-1" style="padding:24px 28px 0;">

            <div class="info-box"><i class="fas fa-info-circle"></i>
                <span>Isi formulir sesuai dokumen resmi organisasi. Setelah berhasil dikirim, sistem akan
                menerbitkan <strong>Nomor Registrasi / ID Pengajuan</strong> sebagai tanda bukti.</span>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Organisasi <span class="req">*</span></label>
                    <input type="text" name="nama_organisasi" class="form-control" placeholder="Nama lengkap ormas" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Singkatan / Akronim</label>
                    <input type="text" name="singkatan" class="form-control" placeholder="Contoh: KNPI">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Bidang Kegiatan <span class="req">*</span></label>
                <div class="check-grid">
                    @foreach(['1) Sosial','2) Keagamaan','3) Profesi','4) Kontrol Sosial dan Politik','5) Kemanusiaan dan Bencana','6) Kepemudaan dan Olahraga','7) Pendidikan dan Lingkungan','8) Keamanan dan Ketertiban'] as $b)
                    <label class="check-item" onclick="toggleCheck(this)">
                        <input type="checkbox" name="bidang[]" value="{{ $b }}"> {{ $b }}
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat Kantor / Sekretariat <span class="req">*</span></label>
                <textarea name="alamat" id="pb_alamat" class="form-control" rows="2" placeholder="Jl. ... No. ..., Desa/Kelurahan, Kecamatan, Kab. Grobogan" required></textarea>
            </div>
            <div class="form-grid" style="grid-template-columns:1fr 1fr 1fr 1fr;gap:10px 14px;margin-bottom:4px;">
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;">RT/RW</label>
                    <input type="text" name="rt_rw" id="pb_rt" class="form-control" placeholder="RT/RW">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;">Kelurahan / Desa</label>
                    <input type="text" name="kelurahan" id="pb_kelurahan" class="form-control" placeholder="Kelurahan">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;">Kecamatan</label>
                    <input type="text" name="kecamatan" id="pb_kecamatan" class="form-control" placeholder="Kecamatan">
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;">Kota / Kab.</label>
                    <input type="text" name="kota" id="pb_kota" class="form-control" value="Kabupaten Grobogan" placeholder="Kab. Grobogan">
                </div>
            </div>
            {{-- Shopee Pinpoint Map Component --}}
            <x-address-pinpoint-picker 
                latName="latitude" 
                lngName="longitude"
                alamatId="pb_alamat"
                rtId="pb_rt"
                kelurahanId="pb_kelurahan"
                kecamatanId="pb_kecamatan"
                kotaId="pb_kota"
                mapId="pb_online_map_picker"
                title="Pin Point Penempatan Alamat Kantor"
                subtitle="Tandai letak presisi sekretariat Ormas pada peta interaktif"
            />
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Contact Person – Nama <span class="req">*</span></label>
                    <input type="text" name="cp_nama" class="form-control" placeholder="Nama" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Person – HP <span class="req">*</span></label>
                    <input type="text" name="cp_hp" class="form-control" placeholder="08xx-xxxx-xxxx" required>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">No. SK Kemenkumham / SKT Kemendagri</label>
                    <input type="text" name="no_sk" class="form-control" placeholder="Nomor SK / SKT">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal SK</label>
                    <input type="date" name="tgl_sk" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Asas / Ciri Organisasi <span class="req">*</span></label>
                <input type="text" name="asas" class="form-control" placeholder="Contoh: Pancasila" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tujuan Organisasi <span class="req">*</span></label>
                <textarea name="tujuan" class="form-control" rows="2" required placeholder="Tuliskan tujuan organisasi..."></textarea>
            </div>
            <div class="form-grid col-3">
                <div class="form-group">
                    <label class="form-label">Nama Pendiri</label>
                    <textarea name="nama_pendiri" class="form-control" rows="2" placeholder="Nama pendiri"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pembina</label>
                    <textarea name="nama_pembina" class="form-control" rows="2" placeholder="Nama pembina"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Penasehat</label>
                    <textarea name="nama_penasehat" class="form-control" rows="2" placeholder="Nama penasehat"></textarea>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Masa Bhakti Kepengurusan</label>
                    <input type="text" name="masa_bhakti" class="form-control" placeholder="Contoh: 2023 – 2026">
                </div>
                <div class="form-group">
                    <label class="form-label">Keputusan Tertinggi Organisasi</label>
                    <input type="text" name="keputusan_tertinggi" class="form-control" placeholder="Contoh: Musyawarah Nasional">
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Unit / Cabang / Sayap Otonom</label>
                    <input type="text" name="unit_cabang" class="form-control" placeholder="Sebutkan atau: —">
                </div>
                <div class="form-group">
                    <label class="form-label">Sumber Keuangan</label>
                    <input type="text" name="sumber_keuangan" class="form-control" placeholder="Iuran anggota, donasi, hibah...">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Usaha Organisasi</label>
                <textarea name="usaha" class="form-control" rows="2" placeholder="Tuliskan usaha / kegiatan organisasi..."></textarea>
            </div>

            <div class="nav-btns" style="padding-bottom:28px;">
                <span></span>
                <button type="button" class="btn-next" onclick="goStep('pb',2)">Lanjut <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        {{-- Step 2: Pengurus & Biodata --}}
        <div class="step-pane" id="pb-step-2" style="padding:24px 28px 0;">
            <div class="sec-head">
                <div class="sec-head-icon"><i class="fas fa-id-card"></i></div>
                <div><div class="sec-head-title">Data Pengurus &amp; Biodata</div>
                <div class="sec-head-sub">Ketua, Sekretaris, Bendahara – lengkap sesuai KTP, pas foto berwarna 4×6</div></div>
            </div>
            @foreach([['key'=>'ketua','label'=>'Ketua'],['key'=>'sekretaris','label'=>'Sekretaris'],['key'=>'bendahara','label'=>'Bendahara']] as $idx => $jab)
            <div class="bio-card">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <span class="bio-badge">{{ $idx+1 }}. {{ $jab['label'] }}</span>
                </div>
                <div style="display:flex;gap:16px;align-items:flex-start;">
                    <div>
                        <label class="form-label" style="margin-bottom:5px;display:block;">Pas Foto 4×6</label>
                        <label class="photo-box" id="photo-pb-{{ $jab['key'] }}">
                            <input type="file" name="foto_{{ $jab['key'] }}" accept=".jpg,.jpeg,.png" onchange="previewPhoto(this,'photo-pb-{{ $jab['key'] }}')">
                            <i class="fas fa-camera"></i><span>Berwarna<br>4×6 cm</span>
                        </label>
                    </div>
                    <div style="flex:1;">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap (KTP) <span class="req">*</span></label>
                                <input type="text" name="bio_{{ $jab['key'] }}_nama" class="form-control" placeholder="Nama lengkap">
                            </div>
                            <div class="form-group">
                                <label class="form-label">NIK <span class="req">*</span></label>
                                <input type="text" name="bio_{{ $jab['key'] }}_nik" class="form-control" placeholder="16 digit NIK" maxlength="16">
                            </div>
                        </div>
                        <div class="form-grid col-3">
                            <div class="form-group">
                                <label class="form-label">Agama</label>
                                <select name="bio_{{ $jab['key'] }}_agama" class="form-control">
                                    <option value="">— Pilih —</option>
                                    <option>Islam</option><option>Kristen Protestan</option><option>Kristen Katolik</option>
                                    <option>Hindu</option><option>Budha</option><option>Konghucu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="bio_{{ $jab['key'] }}_jk" class="form-control">
                                    <option value="">— Pilih —</option>
                                    <option>Laki-laki</option><option>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status Kawin</label>
                                <select name="bio_{{ $jab['key'] }}_status" class="form-control">
                                    <option value="">— Pilih —</option>
                                    <option>Belum Kawin</option><option>Kawin</option><option>Cerai Hidup</option><option>Cerai Mati</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="bio_{{ $jab['key'] }}_ttl_kota" class="form-control" placeholder="Kota">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="bio_{{ $jab['key'] }}_ttl_tgl" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat (KTP)</label>
                            <textarea name="bio_{{ $jab['key'] }}_alamat" class="form-control" rows="2" placeholder="Alamat lengkap"></textarea>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">No. HP</label>
                                <input type="text" name="bio_{{ $jab['key'] }}_hp" class="form-control" placeholder="08xx-xxxx-xxxx">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="bio_{{ $jab['key'] }}_pekerjaan" class="form-control" placeholder="Pekerjaan saat ini">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Upload E-KTP <span class="req">*</span></label>
                            <label class="upload-area" id="ua-pb-ktp-{{ $jab['key'] }}">
                                <input type="file" name="ktp_{{ $jab['key'] }}" accept=".jpg,.jpeg,.png,.pdf" onchange="previewUpload(this,'ua-pb-ktp-{{ $jab['key'] }}','E-KTP {{ $jab['label'] }}')">
                                <i class="fas fa-id-card"></i>
                                <div class="ua-label">Klik untuk unggah E-KTP<br><strong>JPG / PNG / PDF</strong>, maks. 2 MB</div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="nav-btns" style="padding-bottom:28px;">
                <button type="button" class="btn-prev" onclick="goStep('pb',1)"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                <button type="button" class="btn-next" onclick="goStep('pb',3)">Lanjut <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        {{-- Step 3: Logo, Bendera & Cap --}}
        <div class="step-pane" id="pb-step-3" style="padding:24px 28px 0;">
            <div class="sec-head">
                <div class="sec-head-icon"><i class="fas fa-star"></i></div>
                <div><div class="sec-head-title">Lambang / Logo, Bendera &amp; Cap Stempel</div>
                <div class="sec-head-sub">Unggah file berwarna (Form 02 &amp; Form 03)</div></div>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Organisasi</label>
                <input type="text" name="f02_nama" class="form-control" placeholder="Nama ormas">
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="f02_alamat" class="form-control" placeholder="Alamat sekretariat">
                </div>
                <div class="form-group">
                    <label class="form-label">Telp / HP</label>
                    <input type="text" name="f02_telp" class="form-control" placeholder="Nomor telepon">
                </div>
            </div>
            <div class="form-grid" style="grid-template-columns:1fr 1fr;gap:14px;">
                <div class="form-group">
                    <label class="form-label">Lambang / Logo (berwarna) <span class="req">*</span></label>
                    <label class="upload-area" id="ua-pb-logo">
                        <input type="file" name="f02_logo" accept=".jpg,.jpeg,.png,.pdf" onchange="previewUpload(this,'ua-pb-logo','Logo')">
                        <i class="fas fa-image"></i>
                        <div class="ua-label">Klik untuk unggah<br><strong>JPG / PNG / PDF</strong>, maks. 2 MB</div>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Cap Stempel (berwarna) <span class="req">*</span></label>
                    <label class="upload-area" id="ua-pb-cap">
                        <input type="file" name="f02_cap" accept=".jpg,.jpeg,.png,.pdf" onchange="previewUpload(this,'ua-pb-cap','Cap Stempel')">
                        <i class="fas fa-stamp"></i>
                        <div class="ua-label">Klik untuk unggah<br><strong>JPG / PNG / PDF</strong>, maks. 2 MB</div>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Bendera (berwarna) <span class="req">*</span></label>
                    <label class="upload-area" id="ua-pb-bendera">
                        <input type="file" name="f03_bendera" accept=".jpg,.jpeg,.png,.pdf" onchange="previewUpload(this,'ua-pb-bendera','Bendera')">
                        <i class="fas fa-flag"></i>
                        <div class="ua-label">Klik untuk unggah<br><strong>JPG / PNG / PDF</strong>, maks. 2 MB</div>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto Kantor (tampak depan) <span class="req">*</span></label>
                    <label class="upload-area" id="ua-pb-kantor">
                        <input type="file" name="f03_foto_kantor" accept=".jpg,.jpeg,.png,.pdf" onchange="previewUpload(this,'ua-pb-kantor','Foto Kantor')">
                        <i class="fas fa-building"></i>
                        <div class="ua-label">Papan nama harus terlihat<br><strong>JPG / PNG / PDF</strong>, maks. 2 MB</div>
                    </label>
                </div>
            </div>
            <div class="nav-btns" style="padding-bottom:28px;">
                <button type="button" class="btn-prev" onclick="goStep('pb',2)"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                <button type="button" class="btn-next" onclick="goStep('pb',4)">Lanjut <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        {{-- Step 4: Surat Pernyataan --}}
        <div class="step-pane" id="pb-step-4" style="padding:24px 28px 0;">
            <div class="sec-head">
                <div class="sec-head-icon"><i class="fas fa-file-signature"></i></div>
                <div><div class="sec-head-title">Surat Pernyataan</div>
                <div class="sec-head-sub">Ditandatangani Ketua &amp; Sekretaris, bermaterai Rp. 10.000,-</div></div>
            </div>
            <div class="kop-info"><i class="fas fa-info-circle"></i>
                <span>Gunakan <strong>kop surat organisasi</strong>. Tandatangani dan bubuhkan cap stempel organisasi serta materai Rp. 10.000,-</span>
            </div>
            <div class="form-grid">
                <div>
                    <div style="font-size:12px;font-weight:700;color:#374151;margin-bottom:8px;">Ketua / Sederajat</div>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="sp_ketua_nama" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. KTP / Identitas</label>
                        <input type="text" name="sp_ketua_ktp" class="form-control" placeholder="Nomor identitas">
                    </div>
                </div>
                <div>
                    <div style="font-size:12px;font-weight:700;color:#374151;margin-bottom:8px;">Sekretaris / Sederajat</div>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                        <input type="text" name="sp_sek_nama" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. KTP / Identitas</label>
                        <input type="text" name="sp_sek_ktp" class="form-control" placeholder="Nomor identitas">
                    </div>
                </div>
            </div>
            <hr class="sec-divider">
            <div class="form-group"><label class="form-label">Centang Pernyataan Berikut <span class="req">*</span></label></div>
            @php
            $poin = [
                'a'=>'Tidak berafiliasi secara kelembagaan dengan partai politik tertentu.',
                'b'=>'Tidak terjadi konflik kepengurusan atau tidak dalam perkara di pengadilan.',
                'c'=>'Nama, lambang, bendera, simbol, dan cap stempel belum menjadi hak paten/hak cipta pihak lain.',
                'd'=>'Bersedia menertibkan kegiatan, pengurus dan/atau anggota organisasi.',
                'e'=>'Bersedia menyampaikan laporan kegiatan ormas setiap 6 (enam) bulan sekali.',
                'f'=>'Bersedia menyampaikan laporan perkembangan organisasi setiap tahun.',
                'g'=>'Bertanggungjawab terhadap keabsahan isi, data dan informasi dokumen yang diserahkan.',
                'h'=>'Tidak akan melakukan penyalahgunaan Laporan Keberadaan Ormas (LKO).',
            ];
            @endphp
            <ul class="pernyataan-list">
                @foreach($poin as $k => $v)
                <li>
                    <span class="poin-num">{{ strtoupper($k) }}</span>
                    <label style="cursor:pointer;display:flex;align-items:flex-start;gap:8px;flex:1;">
                        <input type="checkbox" name="sp_poin[]" value="{{ $k }}" required style="accent-color:#ffffff;width:15px;height:15px;flex-shrink:0;margin-top:2px;">
                        {{ $v }}
                    </label>
                </li>
                @endforeach
            </ul>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tempat Pembuatan</label>
                    <input type="text" name="sp_tempat" class="form-control" value="Grobogan">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="sp_tgl" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Upload Surat Pernyataan Bertandatangan <span class="req">*</span></label>
                <label class="upload-area" id="ua-pb-sp">
                    <input type="file" name="surat_pernyataan" accept=".pdf,application/pdf" onchange="previewUpload(this,'ua-pb-sp','Surat Pernyataan')">
                    <i class="fas fa-file-pdf"></i>
                    <div class="ua-label">Klik untuk unggah surat pernyataan bermaterai<br><strong>Format PDF</strong>, maks. 2 MB</div>
                </label>
            </div>
            <div class="nav-btns" style="padding-bottom:28px;">
                <button type="button" class="btn-prev" onclick="goStep('pb',3)"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                <button type="button" class="btn-next" onclick="goStep('pb',5)">Lanjut <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        {{-- Step 5: Lampiran Berkas (Ceklis Resmi 12 Poin) --}}
        <div class="step-pane" id="pb-step-5" style="padding:24px 28px 0;">
            <div class="sec-head">
                <div class="sec-head-icon" style="background:#3d6b3d;"><i class="fas fa-clipboard-check"></i></div>
                <div>
                    <div class="sec-head-title">Ceklis Kelengkapan Persyaratan LKO</div>
                    <div class="sec-head-sub">Pemerintah Kab. Grobogan – Badan Kesatuan Bangsa dan Politik | Jl. DI. Panjaitan No. 06 Purwodadi</div>
                </div>
            </div>

            {{-- Identitas Ormas untuk ceklis --}}
            <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:8px;padding:14px 18px;margin-bottom:20px;">
                <div class="form-grid">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Nama Ormas <span class="req">*</span></label>
                        <input type="text" name="ceklist_nama_ormas" class="form-control" placeholder="Nama lengkap organisasi" required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="ceklist_alamat" class="form-control" placeholder="Alamat sekretariat">
                    </div>
                </div>
            </div>

            {{-- 12 item ceklis --}}
            @php
            $lampiran = [
                [
                    'no'    => '1',
                    'name'  => 'lamp_surat_pengantar',
                    'label' => 'Surat Pengantar dari Ormas',
                    'hint'  => 'Ditandatangani Ketua & Sekretaris, ditujukan kepada Bupati Grobogan U.p. Kepala Badan Kesbangpol Kab. Grobogan — perihal: Laporan Keberadaan Ormas di Kab. Grobogan. Harus menggunakan KOP Surat Ormas, mencantumkan Nomor Surat dan Tanggal, serta di-cap dan ditandatangani Pengurus.',
                    'multi' => false,
                ],
                [
                    'no'    => '2',
                    'name'  => 'lamp_akta_pendirian',
                    'label' => 'Fotocopy Akte Pendirian / Akta Notaris',
                    'hint'  => 'Format PDF, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '3',
                    'name'  => 'lamp_sk_kemenkumham',
                    'label' => 'Fotocopy Surat Pengesahan dari Kemenkumham',
                    'hint'  => 'Format PDF, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '4',
                    'name'  => 'lamp_program_kerja',
                    'label' => 'Program Kerja Organisasi',
                    'hint'  => 'Ditandatangani Ketua dan Sekretaris — Format PDF, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '5',
                    'name'  => 'lamp_sk_pengurus',
                    'label' => 'Fotocopy Surat Keputusan (SK) Susunan Kepengurusan Organisasi Tingkat Kabupaten Grobogan',
                    'hint'  => 'Format PDF, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '6',
                    'name'  => 'lamp_domisili',
                    'label' => 'Surat Keterangan Domisili Kantor / Sekretariat Ormas',
                    'hint'  => 'Ditandatangani Lurah / Kepala Desa. Lampirkan: (a) Bukti kepemilikan, surat perjanjian kontrak, atau izin pakai; (b) Foto kantor / sekretariat tampak depan yang memuat papan nama. — Multi file diperbolehkan.',
                    'multi' => true,
                ],
                [
                    'no'    => '7',
                    'name'  => 'lamp_npwp',
                    'label' => 'Foto Copy Nomor Pokok Wajib Pajak (NPWP) atas Nama Ormas',
                    'hint'  => 'PDF / JPG / PNG, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '8a',
                    'name'  => 'lamp_biodata_ketua',
                    'label' => 'Biodata Pengurus + Pas Foto Berwarna 4×6 — Ketua',
                    'hint'  => 'Pas foto berwarna terbaru, ukuran 4×6 cm, dalam 3 (tiga) bulan terakhir — JPG / PNG / PDF',
                    'multi' => false,
                ],
                [
                    'no'    => '8b',
                    'name'  => 'lamp_biodata_sekretaris',
                    'label' => 'Biodata Pengurus + Pas Foto Berwarna 4×6 — Sekretaris',
                    'hint'  => 'Pas foto berwarna terbaru, ukuran 4×6 cm, dalam 3 (tiga) bulan terakhir — JPG / PNG / PDF',
                    'multi' => false,
                ],
                [
                    'no'    => '8c',
                    'name'  => 'lamp_biodata_bendahara',
                    'label' => 'Biodata Pengurus + Pas Foto Berwarna 4×6 — Bendahara',
                    'hint'  => 'Pas foto berwarna terbaru, ukuran 4×6 cm, dalam 3 (tiga) bulan terakhir — JPG / PNG / PDF',
                    'multi' => false,
                ],
                [
                    'no'    => '9a',
                    'name'  => 'lamp_ktp_ketua',
                    'label' => 'Foto Copy E-KTP Pengurus — Ketua',
                    'hint'  => 'JPG / PNG / PDF, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '9b',
                    'name'  => 'lamp_ktp_sekretaris',
                    'label' => 'Foto Copy E-KTP Pengurus — Sekretaris',
                    'hint'  => 'JPG / PNG / PDF, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '9c',
                    'name'  => 'lamp_ktp_bendahara',
                    'label' => 'Foto Copy E-KTP Pengurus — Bendahara',
                    'hint'  => 'JPG / PNG / PDF, maks. 2 MB',
                    'multi' => false,
                ],
                [
                    'no'    => '10',
                    'name'  => 'lamp_dokumen_pelengkap',
                    'label' => 'Dokumen Pelengkap (Formulir Data Ormas, Lambang/Bendera/Cap Stempel, Surat Pernyataan)',
                    'hint'  => 'Gabungkan dalam 1 pengumpulan: Scan Formulir Data Ormas/LSM, Foto Lambang/Bendera/Cap Stempel, dan Surat Pernyataan bermaterai Rp.10.000 — Multi file diperbolehkan.',
                    'multi' => true,
                ],
            ];
            @endphp

            <div style="display:flex;flex-direction:column;gap:6px;margin-bottom:24px;">
                @foreach($lampiran as $item)
                @php
                    $isGroup = in_array($item['no'], ['8a','8b','8c','9a','9b','9c']);
                    $groupLabel = '';
                    if ($item['no'] === '8a') $groupLabel = '8. Biodata Pengurus + Pas Foto 4×6';
                    if ($item['no'] === '9a') $groupLabel = '9. Foto Copy E-KTP Pengurus';
                @endphp

                {{-- Group header --}}
                @if($groupLabel)
                <div style="margin-top:6px;margin-bottom:2px;padding:6px 14px;background:#f1f5f9;border-radius:6px;font-size:11.5px;font-weight:800;color:#374151;text-transform:uppercase;letter-spacing:.04em;">
                    {{ $groupLabel }}
                </div>
                @endif

                <div>
                    <div class="ul-row" id="pb-ulrow-{{ $item['name'] }}"
                         style="{{ $isGroup ? 'margin-left:20px;border-left:3px solid #e2e8f0;border-radius:0 8px 8px 0;padding-left:12px;' : '' }}">
                        {{-- Nomor --}}
                        <div style="min-width:28px;height:28px;background:#fee2e2;color:#ffffff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;flex-shrink:0;transition:.2s;"
                             id="pb-ulnum-{{ $item['name'] }}">{{ $item['no'] }}</div>
                        {{-- Label & hint --}}
                        <div style="flex:1;">
                            <div style="font-size:13px;font-weight:600;color:#1f2937;line-height:1.45;">
                                {{ $item['label'] }} <span style="color:#dc2626;font-weight:bold;margin-left:2px;">*</span>
                            </div>
                            <div style="font-size:11px;color:#9ca3af;margin-top:2px;line-height:1.5;">{{ $item['hint'] }}</div>
                        </div>
                        {{-- Upload button --}}
                        <label style="display:inline-flex;align-items:center;gap:6px;background:#991b1b;color:#fff;font-size:12px;font-weight:700;padding:6px 13px;border-radius:6px;border:1.5px solid #991b1b;cursor:pointer;white-space:nowrap;font-family:'Open Sans',sans-serif;flex-shrink:0;transition:.15s;"
                               id="pb-ulbtn-{{ $item['name'] }}"
                               onmouseover="this.style.background='#7f1d1d';this.style.borderColor='#7f1d1d';"
                               onmouseout="this.style.background='#991b1b';this.style.borderColor='#991b1b';">
                            <i class="fas fa-upload" style="font-size:11px;"></i> Pilih File
                            <input type="file"
                                   name="{{ $item['name'] }}{{ $item['multi'] ? '[]' : '' }}"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   {{ $item['multi'] ? 'multiple' : '' }}
                                   style="display:none;"
                                   onchange="pbHandleFile(this, '{{ $item['name'] }}')">
                        </label>
                    </div>
                    {{-- File chips --}}
                    <div id="pb-ulchips-{{ $item['name'] }}"
                         style="display:flex;flex-wrap:wrap;gap:5px;margin-top:4px;padding-left:{{ $isGroup ? '56px' : '42px' }};"></div>
                </div>
                @endforeach
            </div>

            {{-- Mengetahui --}}
            <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:8px;padding:14px 18px;margin-bottom:20px;font-size:12.5px;color:#374151;">
                <div style="font-weight:800;font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#6b7280;margin-bottom:8px;">Mengetahui</div>
                <div style="font-weight:700;color:#111;">KABID POLDAGRI DAN ORMAS</div>
                <div style="color:#6b7280;">BAKESBANGPOL KABUPATEN GROBOGAN</div>
                <div style="margin-top:10px;font-weight:700;color:#111;">SUDARTA KISWARA, SP</div>
                <div style="color:#6b7280;font-size:11.5px;">NIP. 19700115 199803 1 006</div>
            </div>

            <div class="nav-btns" style="padding-bottom:28px;">
                <button type="button" class="btn-prev" onclick="goStep('pb',4)"><i class="fas fa-arrow-left"></i> Sebelumnya</button>
                <div style="display:flex;align-items:center;justify-content:flex-end;">
                    <button type="submit" id="pb-btn-submit" class="btn-next">
                        <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                    </button>
                </div>
            </div>
            <div class="output-note">
                <i class="fas fa-info-circle"></i>
                <span>Setelah berhasil dikirim, sistem akan menerbitkan <strong>Nomor Registrasi / ID Pengajuan</strong> sebagai tanda bukti. Simpan nomor tersebut untuk memantau status di menu Cek Status.</span>
            </div>
            <div style="padding-bottom:4px;"></div>
        </div>

        </form>
    </div>

    {{-- ════════════════════════════════════════
         TAB: CEK STATUS
    ════════════════════════════════════════ --}}
    <div id="content-cek" class="tab-pane">

        <div class="sec-head" style="padding:28px 28px 0;">
            <div class="sec-head-icon"><i class="fas fa-clipboard-list"></i></div>
            <div>
                <div class="sec-head-title">Status Pengajuan Saya</div>
                <div class="sec-head-sub">Lihat status seluruh pengajuan yang telah Anda kirimkan</div>
            </div>
        </div>

        <div style="text-align:center;padding:36px 28px 48px;">
            <i class="fas fa-clipboard-check" style="font-size:52px;color:#fca5a5;margin-bottom:16px;display:block;"></i>
            <p style="font-size:15px;font-weight:700;color:#374151;margin-bottom:8px;">Pantau Status Pengajuan Anda</p>
            <p style="font-size:13px;color:#6b7280;margin-bottom:24px;line-height:1.7;">
                Klik tombol di bawah untuk melihat daftar pengajuan beserta status<br>
                <strong>Sedang Diproses</strong>, <strong>Disetujui</strong>, atau <strong>Ditolak</strong>.
            </p>
            <a href="{{ route('pengajuan.cek') }}"
               class="btn-submit"
               style="text-decoration:none;font-size:14px;padding:13px 32px;">
                <i class="fas fa-list-alt"></i> Lihat Status Pengajuan Saya
            </a>
        </div>

    </div>

  </div>{{-- end content-card --}}
</div>{{-- end main-wrap --}}

<script>
    /* ── Tab switching ── */
    function switchTab(name) {
        if (name === 'cek') {
            window.location.href = '{{ route('pengajuan.cek') }}';
            return;
        }
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.nav-item[id^="tab-"]').forEach(btn => btn.classList.remove('active'));
        document.getElementById('content-' + name).classList.add('active');
        document.getElementById('tab-' + name).classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /* ── Step navigation ── */
    const stepCurrent = { pb: 1 };
    function goStep(prefix, n) {
        const cur = stepCurrent[prefix];
        document.getElementById(prefix + '-step-' + cur).classList.remove('active');
        document.getElementById(prefix + '-stepbtn-' + cur).classList.remove('active');
        if (n > cur) document.getElementById(prefix + '-stepbtn-' + cur).classList.add('done');
        else document.getElementById(prefix + '-stepbtn-' + cur).classList.remove('done');
        stepCurrent[prefix] = n;
        document.getElementById(prefix + '-step-' + n).classList.add('active');
        document.getElementById(prefix + '-stepbtn-' + n).classList.add('active');
        document.getElementById(prefix + '-stepbtn-' + n).classList.remove('done');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /* ── Checkbox style ── */
    function toggleCheck(label) {
        const cb = label.querySelector('input[type=checkbox]');
        setTimeout(() => {
            if (cb.checked) label.classList.add('checked');
            else label.classList.remove('checked');
        }, 0);
    }

    /* ── Upload area preview ── */
    function previewUpload(input, areaId, label) {
        const area = document.getElementById(areaId);
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const size = file.size < 1048576
            ? (file.size / 1024).toFixed(0) + ' KB'
            : (file.size / 1048576).toFixed(1) + ' MB';
        area.classList.add('has-file');
        area.querySelector('i').className = 'fas fa-check-circle';
        area.querySelector('.ua-label').innerHTML = `<strong>${label} berhasil dipilih</strong><br>${file.name} (${size})`;
    }

    /* ── Pas foto preview ── */
    function previewPhoto(input, boxId) {
        const box = document.getElementById(boxId);
        if (!input.files || !input.files[0]) return;
        const url = URL.createObjectURL(input.files[0]);
        const existing = box.querySelector('img');
        if (existing) existing.remove();
        const img = document.createElement('img');
        img.src = url;
        box.appendChild(img);
    }

    /* ── Lampiran chips ── */
    function handleLampiran(input, rowKey) {
        const files = Array.from(input.files);
        if (!files.length) return;
        const row   = document.getElementById(rowKey.replace('pb-lamp_', 'pb-ulrow-pb-lamp_').replace('ub-ub_', 'ub-ulrow-ub_'));
        const chips = document.getElementById(rowKey.replace('pb-lamp_', 'pb-ulchips-pb-lamp_').replace('ub-ub_', 'ub-ulchips-ub_'));
        // simpler: derive ids from data attributes
        const rowEl   = input.closest('[id^="pb-ulrow"], [id^="ub-ulrow"]') ||
                        input.closest('div').parentElement.querySelector('[class="ul-row"]');
        if (rowEl) { rowEl.style.borderColor = '#86efac'; rowEl.style.background = '#f0fff4'; }
        const numId = rowKey.includes('pb-') ? 'pb-ulnum-pb-' + rowKey.split('pb-')[1] : 'ub-ulnum-ub-' + rowKey.split('ub-')[1];
        const numEl = document.getElementById(numId);
        if (numEl) { numEl.style.background = '#16a34a'; numEl.style.color = '#fff'; }
        const chipsId = rowKey.includes('pb-') ? 'pb-ulchips-pb-' + rowKey.split('pb-')[1] : 'ub-ulchips-ub-' + rowKey.split('ub-')[1];
        const chipsEl = document.getElementById(chipsId);
        if (!chipsEl) return;
        files.forEach(file => {
            const size = file.size < 1048576 ? (file.size / 1024).toFixed(0) + ' KB' : (file.size / 1048576).toFixed(1) + ' MB';
            const ext  = file.name.split('.').pop().toUpperCase();
            const iMap = { PDF: 'fa-file-pdf', JPG: 'fa-file-image', JPEG: 'fa-file-image', PNG: 'fa-file-image' };
            const ic   = iMap[ext] || 'fa-file';
            const chip = document.createElement('div');
            chip.style.cssText = 'display:inline-flex;align-items:center;gap:5px;background:#f0fff4;border:1px solid #86efac;border-radius:20px;padding:3px 10px 3px 8px;font-size:11px;color:#166534;';
            chip.innerHTML = `<i class="fas ${ic}" style="color:#16a34a;font-size:11px;"></i>
                <span title="${file.name}">${file.name.length > 30 ? file.name.slice(0, 28) + '…' : file.name}</span>
                <span style="color:#9ca3af;">${size}</span>`;
            chipsEl.appendChild(chip);
        });
    }

    /* ── Upload handler Step 5 (ceklis) ── */
    function pbHandleFile(input, name) {
        const files = Array.from(input.files);
        if (!files.length) return;
        const row   = document.getElementById('pb-ulrow-' + name);
        const num   = document.getElementById('pb-ulnum-' + name);
        const chips = document.getElementById('pb-ulchips-' + name);
        if (row)  { row.style.borderColor = '#86efac'; row.style.background = '#f0fff4'; }
        if (num)  { num.style.background = '#16a34a'; num.style.color = '#fff'; }
        if (!chips) return;
        chips.innerHTML = '';
        files.forEach(file => {
            const size = file.size < 1048576
                ? (file.size / 1024).toFixed(0) + ' KB'
                : (file.size / 1048576).toFixed(1) + ' MB';
            const ext  = file.name.split('.').pop().toUpperCase();
            const iMap = { PDF: 'fa-file-pdf', JPG: 'fa-file-image', JPEG: 'fa-file-image', PNG: 'fa-file-image' };
            const ic   = iMap[ext] || 'fa-file';
            const chip = document.createElement('div');
            chip.style.cssText = 'display:inline-flex;align-items:center;gap:5px;background:#f0fff4;border:1px solid #86efac;border-radius:20px;padding:3px 10px 3px 8px;font-size:11px;color:#166534;';
            chip.innerHTML = `<i class="fas ${ic}" style="color:#16a34a;font-size:11px;"></i>
                <span title="${file.name}">${file.name.length > 34 ? file.name.slice(0, 32) + '…' : file.name}</span>
                <span style="color:#9ca3af;">${size}</span>`;
            chips.appendChild(chip);
        });
        pbValidateStep5();
    }

    /* ── Validasi Step 5: semua lampiran wajib ── */
    const PB_LAMP_NAMES = [
        'lamp_surat_pengantar','lamp_akta_pendirian','lamp_sk_kemenkumham','lamp_program_kerja',
        'lamp_sk_pengurus','lamp_domisili','lamp_npwp',
        'lamp_biodata_ketua','lamp_biodata_sekretaris','lamp_biodata_bendahara',
        'lamp_ktp_ketua','lamp_ktp_sekretaris','lamp_ktp_bendahara','lamp_dokumen_pelengkap'
    ];

    function pbValidateStep5() {
        // hanya update visual, tombol selalu bisa diklik
    }

    function pbSubmitFinal() {
        document.getElementById('pb-form').submit();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Validasi saat submit form
        document.getElementById('pb-form').addEventListener('submit', function (e) {
            const missing = [];
            PB_LAMP_NAMES.forEach(function (name) {
                const chips = document.getElementById('pb-ulchips-' + name);
                // juga cek input file langsung
                const inputs = document.querySelectorAll('#pb-step-5 input[name="' + name + '"], #pb-step-5 input[name="' + name + '[]"]');
                let hasFile = (chips && chips.children.length > 0);
                if (!hasFile) {
                    inputs.forEach(function (inp) {
                        if (inp.files && inp.files.length > 0) hasFile = true;
                    });
                }
                if (!hasFile) missing.push(name);
            });

            if (missing.length > 0) {
                e.preventDefault();
                // Sorot item yang belum diisi
                missing.forEach(function (name) {
                    const row = document.getElementById('pb-ulrow-' + name);
                    if (row) {
                        row.style.borderColor = '#f87171';
                        row.style.background  = '#fff1f2';
                        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
                alert('Harap lengkapi semua lampiran berkas yang bertanda * sebelum mengirim.');
                // Arahkan ke step 5 jika belum di sana
                goStep('pb', 5);
                return false;
            }
        });
        pbValidateStep5();
    });

    /* ── Cek Status ── */
    function cekStatus(e) {
        e.preventDefault();
    }
</script>

<script>
// ── Autofill alamat saat field diubah manual ──
(function() {
    function buildAlamat() {
        var rt  = (document.getElementById('pb_rt')        || {}).value || '';
        var kel = (document.getElementById('pb_kelurahan') || {}).value || '';
        var kec = (document.getElementById('pb_kecamatan') || {}).value || '';
        var kot = (document.getElementById('pb_kota')      || {}).value || '';
        var parts = [rt ? 'RT/RW ' + rt : '', kel, kec ? 'Kec. ' + kec : '', kot].filter(Boolean);
        var alamatEl = document.getElementById('pb_alamat');
        if (alamatEl) { alamatEl.value = parts.join(', '); }
    }
    ['pb_rt','pb_kelurahan','pb_kecamatan','pb_kota'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) { el.addEventListener('input', buildAlamat); }
    });
})();
</script>
</body>
</html>
