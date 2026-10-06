<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Saya – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        html,body{font-family:'Open Sans',sans-serif;background:#3d6b3d;min-height:100vh;}
        .site-header{background:#3d6b3d;padding:12px 24px;display:flex;align-items:center;justify-content:space-between;}
        .logo-circle{width:50px;height:50px;background:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 8px rgba(0,0,0,.2);}
        .header-avatar{width:36px;height:36px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid rgba(255,255,255,.3);}
        .navbar{background:#3d6b3d;display:flex;align-items:flex-end;padding:0 20px;}
        .nav-tab{display:flex;align-items:center;gap:6px;padding:0 18px;height:44px;font-size:13px;font-weight:600;color:rgba(255,255,255,.8);background:transparent;border:none;border-radius:10px 10px 0 0;cursor:pointer;white-space:nowrap;text-decoration:none;transition:.15s;margin-top:6px;}
        .nav-tab:hover{color:#fff;background:rgba(255,255,255,.15);}
        .nav-tab.active{color:#3d6b3d;background:#fff;font-weight:700;}
        .nav-spacer{flex:1;}
        .nav-action{display:flex;align-items:center;gap:6px;padding:0 14px;height:44px;font-size:13px;font-weight:700;text-decoration:none;color:rgba(255,255,255,.8);margin-top:6px;transition:.15s;}
        .nav-action:hover{color:#fff;}
        .nav-divider{color:rgba(255,255,255,.3);font-size:18px;line-height:44px;margin-top:6px;}
        .main-wrap{padding:0 0 28px 0;}
        .content-card{background:#fff;border-radius:0 0 14px 14px;padding:28px 32px 36px;min-height:calc(100vh - 155px);}
        .sec-head{display:flex;align-items:center;gap:10px;background:#3d6b3d;color:#fff;border-radius:8px;padding:10px 16px;margin-bottom:20px;}
        .sec-head span{font-size:12.5px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;}
        .empty-state{text-align:center;padding:60px 0;}
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
        <i class="fas fa-folder-open" style="font-size:11px;"></i> Laporan Saya
    </div>
    <div class="nav-spacer"></div>
    <a href="{{ route('laporan.kegiatan-input') }}" class="nav-action" style="color:#fff;">
        <i class="fas fa-plus" style="font-size:11px;"></i> Input Kegiatan
    </a>
</nav>

<div class="main-wrap">
  <div class="content-card">

    <div class="sec-head">
        <i class="fas fa-folder-open" style="font-size:13px;"></i>
        <span>Laporan Kegiatan Saya</span>
    </div>

    <div class="empty-state">
        <i class="fas fa-inbox" style="font-size:52px;color:#e5e7eb;display:block;margin-bottom:16px;"></i>
        <div style="font-size:15px;font-weight:700;color:#6b7280;margin-bottom:6px;">Belum ada laporan kegiatan</div>
        <div style="font-size:13px;color:#9ca3af;margin-bottom:24px;">Silakan input kegiatan terlebih dahulu untuk melihat riwayat laporan Anda.</div>
        <a href="{{ route('laporan.kegiatan-input') }}"
           style="background:#3d6b3d;color:#fff;font-weight:700;font-size:13px;padding:10px 24px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
            <i class="fas fa-plus"></i> Input Kegiatan Baru
        </a>
    </div>

  </div>
</div>
</body>
</html>
