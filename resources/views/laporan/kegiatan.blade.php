<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kegiatan Ormas – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { min-height: 100vh; font-family: 'Inter', sans-serif; background: #fff; color: #111827; }
        @media (max-width: 639px) {
            input, select, textarea { font-size: 16px !important; }
        }

        /* ── Header ── */
        .site-header {
            background: #b91c1c;
            height: 78px; display: flex; align-items: center; justify-content: space-between;
            max-width: 1280px; margin: 0 auto; padding: 0 2rem;
        }
        @media (max-width: 639px) {
            .site-header { height: 68px; padding: 0 1rem; }
        }

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
        .main-wrap { padding: 0 0 48px; }
        .content-card { background: #fff; padding: 28px 2rem 48px; max-width: 1280px; margin: 0 auto; min-height: calc(100vh - 130px); }

        /* ── Responsive ── */
        @media (max-width: 639px) {
            .site-header { padding-left: 1rem; padding-right: 1rem; }
            .content-card { padding: 16px 1rem 32px; }
            .form-control { font-size: 16px; }
            .submit-row { flex-direction: column-reverse; gap: 10px; }
            .btn-send, .btn-back { width: 100%; justify-content: center; }
        }

        /* ── Section ── */
        .sec-head { display: flex; align-items: center; gap: 9px; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f3f4f6; }
        .sec-head-icon { width: 32px; height: 32px; border-radius: 8px; background: #111827; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sec-head-icon i { font-size: 13px; color: #fff; }
        .sec-head-title { font-size: 14px; font-weight: 800; color: #111; text-transform: uppercase; letter-spacing: .04em; }
        .sec-head-sub { font-size: 11px; color: #6b7280; font-weight: 400; text-transform: none; letter-spacing: 0; }

        /* ── Form ── */
        .form-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
        .form-label { font-size: 11.5px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .04em; }
        .form-label .req { color: #dc2626; margin-left: 2px; }
        .form-control {
            border: 1.5px solid #d1d5db; border-radius: 7px; padding: 8px 11px;
            font-size: 13px; font-family: 'Open Sans', sans-serif; color: #111827;
            outline: none; transition: border-color .15s; background: #fff; width: 100%;
        }
        .form-control:focus { border-color: #374151; box-shadow: 0 0 0 3px rgba(55,65,81,.08); }
        textarea.form-control { resize: vertical; min-height: 90px; }

        /* ── Foto upload grid ── */
        .foto-grid { display: flex; flex-direction: column; gap: 12px; margin-bottom: 8px; }
        .foto-item {
            border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 14px 16px;
            background: #fff; transition: border-color .15s;
        }
        .foto-item.has-file { border-color: #86efac; background: #f0fff4; }
        .foto-item-header { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .foto-num {
            min-width: 24px; height: 24px; background: #f3f4f6; color: #374151;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 10.5px; font-weight: 800; flex-shrink: 0; transition: .2s;
        }
        .foto-item.has-file .foto-num { background: #16a34a; color: #fff; }
        .foto-item-title { font-size: 13px; font-weight: 700; color: #1f2937; flex: 1; }

        /* Upload area */
        .upload-area {
            border: 2px dashed #d1d5db; border-radius: 8px; padding: 20px;
            text-align: center; cursor: pointer; transition: .15s; background: #f9fafb;
            position: relative; margin-bottom: 10px;
        }
        .upload-area:hover { border-color: #374151; background: #f3f4f6; }
        .upload-area.has-file { border-color: #86efac; background: #f0fff4; }
        .upload-area input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .upload-area i { font-size: 24px; color: #9ca3af; margin-bottom: 6px; display: block; }
        .upload-area.has-file i { color: #16a34a; }
        .upload-area p { font-size: 12px; color: #6b7280; line-height: 1.5; }
        .upload-area.has-file p { color: #166534; font-weight: 600; }

        /* Preview chips */
        .preview-chips { display: flex; flex-wrap: wrap; gap: 6px; }
        .chip {
            display: inline-flex; align-items: center; gap: 5px;
            background: #f1f5f9; border: 1px solid #e2e8f0;
            border-radius: 20px; padding: 3px 10px 3px 8px; font-size: 11px; color: #374151;
        }
        .chip i { font-size: 11px; color: #6b7280; }
        .chip .chip-rm { background: none; border: none; cursor: pointer; color: #9ca3af; font-size: 10px; padding: 0; margin-left: 2px; transition: .15s; line-height: 1; }
        .chip .chip-rm:hover { color: #ef4444; }

        /* ── Tambah foto btn ── */
        .btn-add-foto {
            display: inline-flex; align-items: center; gap: 7px;
            background: #f9fafb; color: #374151; font-size: 13px; font-weight: 700;
            padding: 9px 18px; border-radius: 7px; border: 1.5px dashed #d1d5db;
            cursor: pointer; font-family: 'Open Sans', sans-serif; transition: .15s; margin-top: 4px;
        }
        .btn-add-foto:hover { background: #f3f4f6; border-color: #9ca3af; }

        /* ── Submit row ── */
        .submit-row { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding-top: 20px; border-top: 1.5px solid #f3f4f6; margin-top: 10px; }
        .btn-back { background: #fff; color: #374151; font-weight: 700; font-size: 13px; padding: 10px 22px; border-radius: 7px; border: 1.5px solid #e5e7eb; cursor: pointer; font-family: 'Open Sans', sans-serif; display: inline-flex; align-items: center; gap: 7px; transition: .15s; }
        .btn-back:hover { background: #f9fafb; }
        .btn-send {
            background: #111827; color: #fff; font-weight: 800; font-size: 13px;
            padding: 10px 28px; border-radius: 7px; border: none; cursor: pointer;
            font-family: 'Open Sans', sans-serif; display: inline-flex; align-items: center; gap: 7px; transition: .15s;
        }
        .btn-send:hover { background: #374151; }
        .btn-send:disabled { background: #d1d5db; color: #9ca3af; cursor: not-allowed; }
        .user-avatar-btn{display:none;}
        @media (min-width:768px){.user-avatar-btn{display:block;}}
        @media (max-width:767px){#hamburger-kg{display:flex!important;}}
        #user-av-dd{display:none;position:absolute;right:0;top:46px;width:220px;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:100;}
        .nav-dropdown-wrap { position: relative; }
        .nav-dropdown-wrap:hover .nav-dropdown-menu { display: block !important; }
    </style>
</head>
<body>

{{-- ═══ HEADER ═══ --}}
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
        <a href="{{ route('laporan.kegiatan') }}" style="color:#ffffff;font-size:14px;font-weight:700;text-decoration:none;display:flex;align-items:center;padding:4px 0;">
            Laporan Kegiatan
        </a>
        <a href="{{ route('cek.status') }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
            Cek Status
        </a>
    </div>

    <div style="display:flex;align-items:center;gap:10px;">
        {{-- Desktop: avatar --}}        <div class="hidden-mobile" id="user-av-wrap" style="position:relative;">
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
        <button onclick="openMobModal('kg')" aria-label="Menu" id="hamburger-kg"
                style="display:none;align-items:center;justify-content:center;width:36px;height:36px;border:none;background:none;cursor:pointer;flex-direction:column;gap:5px;padding:0;flex-shrink:0;">
            <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
            <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
            <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
        </button>
    </div>
</div>
</div>

{{-- Mobile Modal --}}
<div class="mob-modal" id="mob-modal-kg">
    <div class="mob-modal__backdrop" onclick="closeMobModal('kg')"></div>
    <div class="mob-modal__panel">
        <button class="mob-modal__close" onclick="closeMobModal('kg')" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
        <div class="mob-modal__body">
            <a href="{{ route('home') }}" class="mob-modal__item">Beranda</a>
            <a href="{{ route('laporan.kegiatan') }}" class="mob-modal__item active-mob">Laporan Kegiatan</a>
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


{{-- ═══ KONTEN ═══ --}}
<div class="main-wrap">
  <div class="content-card">

    <x-toast />

    @if($errors->any())
    <div style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:8px;padding:12px 16px;font-size:13px;color:#991b1b;margin-bottom:16px;">
        <div style="font-weight:700;margin-bottom:6px;display:flex;align-items:center;gap:7px;">
            <i class="fas fa-exclamation-triangle"></i> Periksa kembali:
        </div>
        <ul style="list-style:disc;padding-left:20px;line-height:1.8;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Progress Stepper --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;padding:16px 20px;background:#ffffff;border-radius:12px;border:1px solid #e2e8f0;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:50%;background:#b91c1c;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:13px;flex-shrink:0;box-shadow:0 2px 8px rgba(185,28,28,0.3);">1</div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#111827;">Dokumentasi Kegiatan</div>
                <div style="font-size:11px;color:#6b7280;">Foto & Deskripsi</div>
            </div>
        </div>
        <div style="flex:1;height:2px;background:#e2e8f0;margin:0 12px;"></div>
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:50%;background:#f1f5f9;color:#6b7280;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;border:1px solid #cbd5e1;flex-shrink:0;">2</div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#374151;">Kirim Laporan</div>
                <div style="font-size:11px;color:#6b7280;">Verifikasi Kesbangpol</div>
            </div>
        </div>
    </div>

    <form id="kegiatan-form" action="{{ route('laporan.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Section: Foto Kegiatan --}}
        <div style="display:flex;align-items:center;gap:10px;border-left:4px solid #b91c1c;padding-left:14px;margin-bottom:20px;">
            <div>
                <h3 style="font-size:16px;font-weight:700;color:#111827;margin:0;">Foto & Deskripsi Kegiatan Ormas</h3>
                <p style="font-size:12.5px;color:#6b7280;margin:2px 0 0;">Upload foto kegiatan terbaru dan isi keterangan ringkasnya</p>
            </div>
        </div>

        <div class="foto-grid" id="foto-grid">

            {{-- Item foto pertama (statis) --}}
            <div class="foto-item" id="foto-item-1">
                <div class="foto-item-header">
                    <div class="foto-num">1</div>
                    <div class="foto-item-title">Foto Kegiatan</div>
                </div>
                <div class="upload-area" id="upload-area-1">
                    <input type="file" name="foto[]" accept=".jpg,.jpeg,.png,.webp"
                           onchange="handleFoto(this, 1)">
                    <i class="fas fa-image"></i>
                    <p>Klik untuk pilih foto<br><span style="font-size:11px;color:#9ca3af;">JPG / PNG / WEBP, maks. 5MB</span></p>
                </div>
                <div class="preview-chips" id="chips-1"></div>
                <div class="form-group" style="margin-top:10px;margin-bottom:0;">
                    <label class="form-label">Deskripsi Foto <span class="req">*</span></label>
                    <textarea name="deskripsi_foto[]" class="form-control" rows="2"
                              placeholder="Tuliskan keterangan foto ini..."></textarea>
                </div>
            </div>

        </div>

        <div class="submit-row">
            <a href="{{ route('home') }}" class="btn-back" style="text-decoration:none;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn-send" id="btn-kirim">
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
        </div>

    </form>

  </div>
</div>

<script>
let fotoCount = 1;

function handleFoto(input, idx) {
    const area  = document.getElementById('upload-area-' + idx);
    const chips = document.getElementById('chips-' + idx);
    const item  = document.getElementById('foto-item-' + idx);
    chips.innerHTML = '';

    if (!input.files.length) return;

    area.classList.add('has-file');
    item.classList.add('has-file');

    Array.from(input.files).forEach(file => {
        const size = file.size < 1048576
            ? (file.size / 1024).toFixed(0) + ' KB'
            : (file.size / 1048576).toFixed(1) + ' MB';
        const short = file.name.length > 32 ? file.name.slice(0, 30) + '…' : file.name;
        const chip  = document.createElement('div');
        chip.className = 'chip';
        chip.innerHTML = `<i class="fas fa-image"></i><span title="${file.name}">${short}</span><span style="color:#9ca3af;">${size}</span>`;
        chips.appendChild(chip);
    });

    area.querySelector('p').innerHTML =
        `<span style="font-weight:700;color:#166534;">${input.files.length} foto dipilih</span>`;
}

function addFotoItem() {
    fotoCount++;
    const idx  = fotoCount;
    const grid = document.getElementById('foto-grid');

    const div = document.createElement('div');
    div.className = 'foto-item';
    div.id = 'foto-item-' + idx;
    div.innerHTML = `
        <div class="foto-item-header">
            <div class="foto-num">${idx}</div>
            <div class="foto-item-title">Foto Kegiatan</div>
            <button type="button" onclick="removeFotoItem(${idx})"
                style="background:none;border:none;cursor:pointer;color:#9ca3af;font-size:14px;padding:0;margin-left:auto;transition:.15s;"
                onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#9ca3af'">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="upload-area" id="upload-area-${idx}">
            <input type="file" name="foto[]" accept=".jpg,.jpeg,.png,.webp"
                   onchange="handleFoto(this, ${idx})">
            <i class="fas fa-image"></i>
            <p>Klik untuk pilih foto<br><span style="font-size:11px;color:#9ca3af;">JPG / PNG / WEBP, maks. 5MB</span></p>
        </div>
        <div class="preview-chips" id="chips-${idx}"></div>
        <div class="form-group" style="margin-top:10px;margin-bottom:0;">
            <label class="form-label">Deskripsi Foto <span class="req">*</span></label>
            <textarea name="deskripsi_foto[]" class="form-control" rows="2"
                      placeholder="Tuliskan keterangan foto ini..."></textarea>
        </div>
    `;
    grid.appendChild(div);
    div.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function removeFotoItem(idx) {
    const item = document.getElementById('foto-item-' + idx);
    if (item) { item.remove(); }
}

function openMobModal(id) {
    document.getElementById('mob-modal-' + id).classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMobModal(id) {
    document.getElementById('mob-modal-' + id).classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMobModal('kg'); });
window.addEventListener('resize', function() { if (window.innerWidth >= 768) closeMobModal('kg'); });
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
