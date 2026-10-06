<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kegiatan Ormas – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        html,body{font-family:'Open Sans',sans-serif;background:#ffffff;min-height:100vh;}
        .site-header{background:#ffffff;padding:12px 24px;display:flex;align-items:center;justify-content:space-between;}
        .logo-circle{width:50px;height:50px;background:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 8px rgba(0,0,0,.2);}
        .header-avatar{width:36px;height:36px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid rgba(255,255,255,.3);}
        .navbar{background:#ffffff;display:flex;align-items:flex-end;padding:0 20px;}
        .nav-tab{display:flex;align-items:center;gap:6px;padding:0 18px;height:44px;font-size:13px;font-weight:600;color:rgba(255,255,255,.8);background:transparent;border:none;border-radius:10px 10px 0 0;cursor:pointer;white-space:nowrap;text-decoration:none;transition:.15s;margin-top:6px;}
        .nav-tab:hover{color:#fff;background:rgba(255,255,255,.15);}
        .nav-tab.active{color:#ffffff;background:#fff;font-weight:700;}
        .nav-spacer{flex:1;}
        .nav-action{display:flex;align-items:center;gap:6px;padding:0 14px;height:44px;font-size:13px;font-weight:700;text-decoration:none;color:rgba(255,255,255,.8);margin-top:6px;transition:.15s;}
        .nav-action:hover{color:#fff;}
        .nav-divider{color:rgba(255,255,255,.3);font-size:18px;line-height:44px;margin-top:6px;}
        .main-wrap{padding:0 0 28px 0;}
        .content-card{background:#fff;border-radius:0 0 14px 14px;padding:28px 32px 36px;min-height:calc(100vh - 155px);}
        .sec-head{display:flex;align-items:center;gap:10px;background:#ffffff;color:#fff;border-radius:8px;padding:10px 16px;margin-bottom:20px;}
        .sec-head span{font-size:12.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
        .fg{display:flex;flex-direction:column;gap:5px;}
        .fg label{font-size:11.5px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.04em;}
        .fg label span{color:#ffffff;}
        .fg input,.fg select,.fg textarea{border:1.5px solid #e5e7eb;border-radius:7px;padding:9px 12px;font-size:13px;font-family:'Open Sans',sans-serif;color:#111;outline:none;transition:.15s;background:#fff;}
        .fg input:focus,.fg select:focus,.fg textarea:focus{border-color:#ffffff;box-shadow:0 0 0 3px rgba(185,28,28,.1);}
        .fg textarea{resize:vertical;min-height:80px;}
        .divider{height:1px;background:#f0f0f0;margin:22px 0;}
        .upload-list{display:flex;flex-direction:column;gap:8px;margin-bottom:24px;}
        .ul-row{display:flex;align-items:center;gap:12px;border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;background:#fff;transition:.15s;}
        .ul-row:hover{border-color:#fca5a5;background:#fff8f8;}
        .ul-row.done{border-color:#86efac;background:#f0fff4;}
        .ul-num{min-width:24px;height:24px;background:#fee2e2;color:#ffffff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10.5px;font-weight:800;flex-shrink:0;transition:.2s;}
        .ul-row.done .ul-num{background:#16a34a;color:#fff;}
        .ul-label{flex:1;font-size:13px;font-weight:600;color:#1f2937;line-height:1.4;}
        .ul-label small{display:block;font-size:11px;font-weight:400;color:#9ca3af;margin-top:1px;}
        .ul-btn{display:inline-flex;align-items:center;gap:6px;background:#fff8f8;color:#ffffff;font-size:12px;font-weight:700;padding:6px 14px;border-radius:6px;border:1.5px solid #fecaca;cursor:pointer;white-space:nowrap;transition:.15s;flex-shrink:0;font-family:'Open Sans',sans-serif;}
        .ul-btn:hover{background:#fee2e2;border-color:#ffffff;}
        .ul-row.done .ul-btn{background:#dcfce7;border-color:#86efac;color:#16a34a;}
        .file-chips{display:flex;flex-wrap:wrap;gap:5px;margin-top:6px;padding-left:36px;}
        .chip{display:inline-flex;align-items:center;gap:5px;background:#fff8f8;border:1px solid #fecaca;border-radius:20px;padding:3px 10px 3px 8px;font-size:11px;color:#374151;}
        .chip i{font-size:11px;color:#ffffff;}
        .chip .chip-rm{background:none;border:none;cursor:pointer;color:#9ca3af;font-size:10px;padding:0;margin-left:2px;transition:.15s;}
        .chip .chip-rm:hover{color:#ffffff;}
        .submit-row{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding-top:20px;border-top:1px solid #f0f0f0;}
        .btn-back2{background:#fff;color:#6b7280;font-weight:700;font-size:13px;padding:10px 22px;border-radius:7px;border:1.5px solid #e5e7eb;cursor:pointer;font-family:'Open Sans',sans-serif;display:inline-flex;align-items:center;gap:7px;}
        .btn-back2:hover{background:#f9fafb;}
        .btn-send{background:#ffffff;color:#fff;font-weight:800;font-size:13px;padding:10px 28px;border-radius:7px;border:none;cursor:pointer;font-family:'Open Sans',sans-serif;display:inline-flex;align-items:center;gap:7px;}
        .btn-send:hover{opacity:.88;}
    </style>
</head>
<body>

<div class="site-header">
    <div style="display:flex;align-items:center;gap:12px;">
        <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Grobogan" style="width:44px;height:44px;object-fit:contain;flex-shrink:0;">
        <div>
            <div style="color:#fff;font-size:12.5px;font-weight:800;text-transform:uppercase;line-height:1.4;">Sistem Informasi Pelayanan Ormas Online</div>
            <div style="color:rgba(255,255,255,.65);font-size:10.5px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;">SIPORAS</div>
        </div>
    </div>
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

<nav class="navbar">
    <a href="{{ route('laporan.kegiatan') }}" class="nav-tab">
        <i class="fas fa-arrow-left" style="font-size:10px;"></i> Kembali
    </a>
    <div class="nav-tab active">
        <i class="fas fa-edit" style="font-size:11px;"></i> Input Kegiatan Ormas
    </div>
    <div class="nav-spacer"></div>
    <a href="{{ route('laporan.kegiatan') }}" class="nav-action">
        <i class="fas fa-calendar-alt" style="font-size:11px;"></i> Laporan Kegiatan
    </a>
</nav>

<div class="main-wrap">
  <div class="content-card">

    <div class="sec-head">
        <i class="fas fa-edit" style="font-size:13px;"></i>
        <span>Form Input Kegiatan Ormas</span>
    </div>

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <div class="fg">
                <label>Nama Ormas <span>*</span></label>
                <input type="text" name="nama_ormas" placeholder="Nama organisasi" required>
            </div>
            <div class="fg">
                <label>Jenis Kegiatan <span>*</span></label>
                <select name="jenis_kegiatan" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option>Sosial</option><option>Pendidikan</option><option>Keagamaan</option>
                    <option>Kepemudaan</option><option>Kebudayaan</option><option>Lingkungan Hidup</option>
                    <option>Kesehatan</option><option>Olahraga</option><option>Ekonomi</option><option>Lainnya</option>
                </select>
            </div>
            <div class="fg" style="grid-column:1/-1;">
                <label>Judul Kegiatan <span>*</span></label>
                <input type="text" name="judul_kegiatan" placeholder="Judul lengkap kegiatan" required>
            </div>
            <div class="fg" style="grid-column:1/-1;">
                <label>Deskripsi Kegiatan <span>*</span></label>
                <textarea name="deskripsi" placeholder="Uraian singkat kegiatan..." required></textarea>
            </div>
            <div class="fg">
                <label>Tanggal Mulai <span>*</span></label>
                <input type="date" name="tanggal_mulai" required>
            </div>
            <div class="fg">
                <label>Tanggal Selesai <span>*</span></label>
                <input type="date" name="tanggal_selesai" required>
            </div>
            <div class="fg">
                <label>Lokasi Kegiatan <span>*</span></label>
                <input type="text" name="lokasi" placeholder="Nama gedung / tempat" required>
            </div>
            <div class="fg">
                <label>Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" placeholder="Estimasi jumlah peserta" min="0">
            </div>
            <div class="fg">
                <label>Nama Penanggung Jawab <span>*</span></label>
                <input type="text" name="pic_nama" placeholder="Nama PIC kegiatan" required>
            </div>
            <div class="fg">
                <label>No. Telepon PIC <span>*</span></label>
                <input type="text" name="pic_telepon" placeholder="08xxxxxxxxxx" required>
            </div>
        </div>

        <div class="divider"></div>

        <div class="sec-head">
            <i class="fas fa-paperclip" style="font-size:12px;"></i>
            <span>Lampiran Dokumen Kegiatan</span>
        </div>

        @php
        $lampiran = [
            ['name'=>'surat_pemberitahuan','no'=>1,'label'=>'Surat Pemberitahuan Kegiatan','hint'=>'PDF/JPG/PNG','multi'=>false],
            ['name'=>'proposal_kegiatan',  'no'=>2,'label'=>'Proposal / TOR Kegiatan',      'hint'=>'PDF/JPG/PNG','multi'=>false],
            ['name'=>'foto_kegiatan',      'no'=>3,'label'=>'Foto Dokumentasi Kegiatan',    'hint'=>'Multi file – JPG/PNG','multi'=>true],
            ['name'=>'laporan_kegiatan',   'no'=>4,'label'=>'Laporan Hasil Kegiatan',       'hint'=>'PDF/JPG/PNG','multi'=>false],
            ['name'=>'daftar_hadir',       'no'=>5,'label'=>'Daftar Hadir Peserta',         'hint'=>'PDF/JPG/PNG','multi'=>false],
        ];
        @endphp

        <div class="upload-list">
            @foreach($lampiran as $item)
            <div>
                <div class="ul-row" id="row-{{ $item['name'] }}">
                    <div class="ul-num">{{ $item['no'] }}</div>
                    <div class="ul-label">{{ $item['label'] }}<small>{{ $item['hint'] }}</small></div>
                    <label class="ul-btn" for="file-{{ $item['name'] }}" id="btn-{{ $item['name'] }}">
                        <i class="fas fa-upload" style="font-size:11px;"></i> Pilih File
                        <input type="file" id="file-{{ $item['name'] }}" name="{{ $item['name'] }}{{ $item['multi']?'[]':'' }}"
                               accept=".pdf,.jpg,.jpeg,.png" {{ $item['multi']?'multiple':'' }}
                               style="display:none;" onchange="handleFile(this,'{{ $item['name'] }}')">
                    </label>
                </div>
                <div class="file-chips" id="chips-{{ $item['name'] }}"></div>
            </div>
            @endforeach
        </div>

        <div class="submit-row">
            <button type="button" class="btn-back2"
                    onclick="window.location.href='{{ route('laporan.kegiatan') }}'">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <button type="submit" class="btn-send">
                <i class="fas fa-paper-plane"></i> Kirim Laporan
            </button>
        </div>
    </form>
  </div>
</div>

<script>
function handleFile(input, name) {
    const files = Array.from(input.files);
    if (!files.length) return;
    const row = document.getElementById('row-' + name);
    const chips = document.getElementById('chips-' + name);
    const btn = document.getElementById('btn-' + name);
    row.classList.add('done');
    files.forEach(file => {
        const ext = file.name.split('.').pop().toUpperCase();
        const size = file.size < 1048576 ? (file.size/1024).toFixed(0)+' KB' : (file.size/1048576).toFixed(1)+' MB';
        const iconMap = {PDF:'fa-file-pdf',JPG:'fa-file-image',JPEG:'fa-file-image',PNG:'fa-file-image'};
        const icon = iconMap[ext] || 'fa-file';
        const shortName = file.name.length > 28 ? file.name.slice(0,26)+'…' : file.name;
        const chip = document.createElement('div');
        chip.className = 'chip';
        chip.innerHTML = `<i class="fas ${icon}"></i><span title="${file.name}">${shortName}</span><span style="color:#9ca3af;">${size}</span><button type="button" class="chip-rm" onclick="removeChip(this,'${name}')"><i class="fas fa-times"></i></button>`;
        chips.appendChild(chip);
    });
    btn.innerHTML = `<i class="fas fa-check" style="font-size:11px;color:#16a34a;"></i> Ditambahkan<input type="file" id="file-${name}" name="${name}${input.multiple?'[]':''}" accept=".pdf,.jpg,.jpeg,.png" ${input.multiple?'multiple':''} style="display:none;" onchange="handleFile(this,'${name}')">`;
}
function removeChip(btn, name) {
    btn.closest('.chip').remove();
    if (!document.getElementById('chips-'+name).children.length) {
        document.getElementById('row-'+name).classList.remove('done');
        const fi = document.getElementById('file-'+name);
        document.getElementById('btn-'+name).innerHTML = `<i class="fas fa-upload" style="font-size:11px;"></i> Pilih File<input type="file" id="file-${name}" name="${name}${fi&&fi.multiple?'[]':''}" accept=".pdf,.jpg,.jpeg,.png" ${fi&&fi.multiple?'multiple':''} style="display:none;" onchange="handleFile(this,'${name}')">`;
    }
}
</script>
</body>
</html>
