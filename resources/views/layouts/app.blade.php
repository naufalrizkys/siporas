<!DOCTYPE html>
<html lang="id" style="margin:0;padding:0;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPORAS') – Sistem Informasi Pelayanan Ormas</title>
    <meta name="description" content="Sistem Informasi Pelayanan Organisasi Masyarakat – Pendaftaran, perpanjangan SKT, dan informasi ormas.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth !important; }
        html, body { margin: 0 !important; padding: 0 !important; width: 100%; overflow-x: hidden; }
        body { font-family: 'Inter', sans-serif; color: #111827; }
        @media (max-width: 639px) {
            input, select, textarea { font-size: 16px !important; }
        }

        /* ── Ticker ── */
        .ticker-wrap { overflow: hidden; white-space: nowrap; }
        .ticker-move { display: inline-block; animation: ticker 20s linear infinite; }
        @keyframes ticker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

        /* ── Navbar ── */
        .nav-item-gov {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: rgba(255,255,255,0.85);
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.4rem 0;
            white-space: nowrap;
            transition: color 0.15s;
            text-decoration: none;
        }
        .nav-item-gov:hover { color: #ffffff; }
        .nav-item-gov.active { color: #ffffff; font-weight: 700; }
        .nav-dropdown-wrap { position: relative; }
        .nav-dropdown-wrap:hover .nav-dropdown-menu { display: block !important; }

        /* ── Badge status ── */
        .badge-aktif { background:#dcfce7; color:#166534; font-size:0.7rem; font-weight:700; padding:2px 8px; border-radius:9999px; }
        .badge-menunggu { background:#fef9c3; color:#854d0e; font-size:0.7rem; font-weight:700; padding:2px 8px; border-radius:9999px; }
        .badge-tidak_aktif { background:#f1f5f9; color:#475569; font-size:0.7rem; font-weight:700; padding:2px 8px; border-radius:9999px; }

        /* ── Ormas Card ── */
        .ormas-card { border-left: 3px solid #e5e7eb; transition: box-shadow 0.2s; }
        .ormas-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }

        /* ── Mobile Nav Modal ── */
        .mobile-nav-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
        }
        .mobile-nav-modal.open { display: block; }
        .mobile-nav-modal__backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.55);
        }
        .mobile-nav-modal__panel {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: calc(100% - 40px);
            max-width: 360px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,.25);
        }
        .mobile-nav-modal__close {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 30px;
            height: 30px;
            border: none;
            background: #f3f4f6;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 14px;
            transition: background .15s;
        }
        .mobile-nav-modal__close:hover { background: #e5e7eb; }
        .mobile-nav-modal__body { padding: 16px 0 8px; }
        .mobile-nav-modal__item {
            display: flex;
            align-items: center;
            padding: 13px 24px;
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .12s;
        }
        .mobile-nav-modal__item:hover { background: #f9fafb; }
        .mobile-nav-modal__item.active-mob { color: #b91c1c; font-weight: 700; }
        .mobile-nav-modal__divider { height: 1px; background: #f3f4f6; margin: 6px 0; }
        .mobile-nav-modal__item.logout { color: #dc2626; }
    </style>

    @stack('styles')
</head>
<body class="bg-white text-gray-900" style="margin:0;padding:0;">

<style>
    /* ── Scroll Animation ── */
    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity .55s ease, transform .55s ease;
    }
    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal-left {
        opacity: 0;
        transform: translateX(-28px);
        transition: opacity .55s ease, transform .55s ease;
    }
    .reveal-left.visible {
        opacity: 1;
        transform: translateX(0);
    }
    .reveal-right {
        opacity: 0;
        transform: translateX(28px);
        transition: opacity .55s ease, transform .55s ease;
    }
    .reveal-right.visible {
        opacity: 1;
        transform: translateX(0);
    }
</style>

<!-- ═══ HEADER ═══ -->
<header style="background:#b91c1c;width:100%;">
    <div style="display:flex;align-items:center;justify-content:space-between;max-width:1280px;height:78px;margin:0 auto;padding:0 2rem;">
        {{-- Logo + Nama --}}
        <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:14px;text-decoration:none;">
            @if(file_exists(public_path('images/logo-grobogan.png')))
            <img src="{{ asset('images/logo-grobogan.png') }}"
                 alt="Lambang Kabupaten Grobogan"
                 style="width:52px;height:52px;object-fit:contain;flex-shrink:0;">
            @else
            <div style="width:52px;height:52px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fas fa-landmark" style="color:white;font-size:1.2rem;"></i>
            </div>
            @endif
            <div>
                <div style="color:#ffffff;font-size:17px;font-weight:900;text-transform:uppercase;line-height:1.1;letter-spacing:.08em;">SIPORAS</div>
                <div style="color:rgba(255,255,255,0.85);font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.12em;">Kesbangpol Kab. Grobogan</div>
            </div>
        </a>

        {{-- Tengah: menu navigasi desktop --}}
        <div id="hdr-nav-links" style="display:none;align-items:center;gap:1.5rem;">
            <a href="{{ route('home') }}"
               style="color:{{ request()->routeIs('home') ? '#ffffff' : 'rgba(255,255,255,0.85)' }};font-size:14px;font-weight:{{ request()->routeIs('home') ? '700' : '600' }};text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
                Beranda
            </a>
            @auth
            <div class="nav-dropdown-wrap" style="position:relative;">
                <a href="{{ route('laporan.pendaftaran-baru') }}"
                   style="color:{{ request()->routeIs('laporan.*') ? '#ffffff' : 'rgba(255,255,255,0.85)' }};font-size:14px;font-weight:{{ request()->routeIs('laporan.*') ? '700' : '600' }};text-decoration:none;display:flex;align-items:center;gap:4px;padding:4px 0;transition:color .15s;">
                    Laporan Keberadaan <i class="fas fa-chevron-down" style="font-size:10px;opacity:0.8;margin-left:2px;"></i>
                </a>
                <div class="nav-dropdown-menu" style="display:none;position:absolute;top:100%;left:0;width:200px;background:#ffffff;border-radius:10px;padding:6px 0;box-shadow:0 10px 30px rgba(0,0,0,0.18);z-index:999;margin-top:4px;border:1px solid #f3f4f6;">
                    <a href="{{ route('laporan.pendaftaran-baru') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:{{ request()->routeIs('laporan.pendaftaran-baru*') ? '#b91c1c' : '#374151' }};text-decoration:none;background:{{ request()->routeIs('laporan.pendaftaran-baru*') ? '#fef2f2' : 'transparent' }};transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='{{ request()->routeIs('laporan.pendaftaran-baru*') ? '#fef2f2' : 'transparent' }}'">
                        <i class="fas fa-file-alt" style="font-size:12px;color:{{ request()->routeIs('laporan.pendaftaran-baru*') ? '#b91c1c' : '#9ca3af' }};"></i> Pendaftaran Baru
                    </a>
                    <a href="{{ route('laporan.perubahan') }}" style="display:flex;align-items:center;gap:8px;padding:10px 16px;font-size:13px;font-weight:600;color:{{ request()->routeIs('laporan.perubahan*') ? '#b91c1c' : '#374151' }};text-decoration:none;background:{{ request()->routeIs('laporan.perubahan*') ? '#fef2f2' : 'transparent' }};transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='{{ request()->routeIs('laporan.perubahan*') ? '#fef2f2' : 'transparent' }}'">
                        <i class="fas fa-edit" style="font-size:12px;color:{{ request()->routeIs('laporan.perubahan*') ? '#b91c1c' : '#9ca3af' }};"></i> Perubahan Data
                    </a>
                </div>
            </div>
            <a href="{{ route('laporan.kegiatan') }}"
               style="color:{{ request()->routeIs('laporan.kegiatan*') ? '#ffffff' : 'rgba(255,255,255,0.85)' }};font-size:14px;font-weight:{{ request()->routeIs('laporan.kegiatan*') ? '700' : '600' }};text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
                Laporan Kegiatan
            </a>
            @else
            <a href="{{ route('login', ['redirect' => route('laporan.pendaftaran-baru')]) }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
                Laporan Keberadaan
            </a>
            <a href="{{ route('login', ['redirect' => route('laporan.kegiatan')]) }}" style="color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
                Laporan Kegiatan
            </a>
            @endauth
            <a href="{{ route('cek.status') }}"
               style="color:{{ request()->routeIs('cek.status') ? '#ffffff' : 'rgba(255,255,255,0.85)' }};font-size:14px;font-weight:{{ request()->routeIs('cek.status') ? '700' : '600' }};text-decoration:none;display:flex;align-items:center;padding:4px 0;transition:color .15s;">
                Cek Status
            </a>
        </div>

        {{-- Kanan: avatar desktop + hamburger mobile --}}
        <div style="display:flex;align-items:center;gap:10px;">
            <div id="hdr-avatar" style="position:relative;display:none;">
                <button onclick="toggleHdrMenu()" style="background:none;border:none;padding:0;cursor:pointer;" aria-label="Menu akun">
                    @auth
                    @if(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                         style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                    @else
                    <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                        <span style="color:#fff;font-size:14px;font-weight:700;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    @endif
                    @else
                    <div style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);">
                        <i class="fas fa-user" style="color:white;font-size:13px;"></i>
                    </div>
                    @endauth
                </button>
                <div id="hdr-dropdown"
                     style="display:none;position:absolute;right:0;top:46px;width:220px;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.12);z-index:200;">
                    @auth
                    <div style="padding:14px 16px;display:flex;align-items:center;gap:10px;border-bottom:1px solid #f3f4f6;">
                        @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                        @else
                        <div style="width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                            <span style="color:#fff;font-size:14px;font-weight:700;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        @endif
                        <div style="min-width:0;">
                            <div style="font-weight:700;color:#111827;font-size:13px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->name }}</div>
                            <div style="color:#9ca3af;font-size:11px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       style="display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;">
                        <i class="fas fa-tachometer-alt" style="color:#9ca3af;"></i> Dashboard Admin
                    </a>
                    <div style="height:1px;background:#f3f4f6;"></div>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="width:100%;display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13px;font-weight:600;color:#dc2626;background:none;border:none;cursor:pointer;font-family:inherit;text-align:left;">
                            <i class="fas fa-sign-out-alt" style="color:#f87171;"></i> Logout
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}"
                       style="display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13px;font-weight:700;color:#111827;text-decoration:none;">
                        <i class="fas fa-sign-in-alt" style="color:#9ca3af;"></i> Login
                    </a>
                    @endauth
                </div>
            </div>

            {{-- Hamburger mobile --}}
            <button onclick="openMobileModal()"
                    id="hamburger-btn"
                    style="background:none;border:none;cursor:pointer;width:36px;height:36px;padding:0;display:none;flex-direction:column;align-items:center;justify-content:center;gap:5px;flex-shrink:0;"
                    aria-label="Buka menu navigasi">
                <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
                <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
                <span style="display:block;width:20px;height:2px;background:#ffffff;border-radius:2px;"></span>
            </button>
        </div>
    </div>
</header>

        <style>
            @media (min-width: 768px) {
                #hdr-avatar { display: block !important; }
                #hdr-nav-links { display: flex !important; }
            }
            @media (max-width: 767px) {
                #hamburger-btn { display: flex !important; }
            }
        </style>
    </div>
</header>

{{-- Mobile Nav Modal --}}
<div class="mobile-nav-modal" id="mobile-nav-modal" aria-modal="true" role="dialog">
    <div class="mobile-nav-modal__backdrop" onclick="closeMobileModal()"></div>
    <div class="mobile-nav-modal__panel">
        <button class="mobile-nav-modal__close" onclick="closeMobileModal()" aria-label="Tutup menu">
            <i class="fas fa-times"></i>
        </button>
        <div class="mobile-nav-modal__body">
            @auth
            <div style="display:flex;align-items:center;gap:12px;padding:16px 24px 12px;">
                @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                     style="width:44px;height:44px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                @else
                <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <span style="color:#fff;font-size:16px;font-weight:700;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                @endif
                <div style="min-width:0;">
                    <div style="font-size:15px;font-weight:700;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</div>
                    <div style="font-size:12px;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mobile-nav-modal__divider"></div>
            @endauth
            <a href="{{ route('home') }}" class="mobile-nav-modal__item {{ request()->routeIs('home') ? 'active-mob' : '' }}">
                Beranda
            </a>
            @auth
            <a href="{{ route('laporan.pendaftaran-baru') }}"
               class="mobile-nav-modal__item {{ request()->routeIs('laporan.pendaftaran-baru*') || request()->routeIs('laporan.perubahan*') ? 'active-mob' : '' }}">
                Laporan Keberadaan
            </a>
            <a href="{{ route('laporan.kegiatan') }}"
               class="mobile-nav-modal__item {{ request()->routeIs('laporan.kegiatan*') ? 'active-mob' : '' }}">
                Laporan Kegiatan
            </a>
            @else
            <a href="{{ route('login', ['redirect' => route('laporan.pendaftaran-baru')]) }}" class="mobile-nav-modal__item">Laporan Keberadaan</a>
            <a href="{{ route('login', ['redirect' => route('laporan.kegiatan')]) }}" class="mobile-nav-modal__item">Laporan Kegiatan</a>
            @endauth
            <a href="{{ route('cek.status') }}"
               class="mobile-nav-modal__item {{ request()->routeIs('cek.status') ? 'active-mob' : '' }}">
                Cek Status
            </a>
            <div class="mobile-nav-modal__divider"></div>
            @auth
            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-modal__item">Dashboard Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mobile-nav-modal__item logout">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="mobile-nav-modal__item">Login</a>
            @endauth
        </div>
    </div>
</div>

<!-- Flash messages -->
<x-toast />

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/628977976105?text=Halo%20Admin%20SIPORAS%2C%20saya%20ingin%20bertanya%20mengenai%20layanan%20Ormas."
   target="_blank" rel="noopener"
   title="Hubungi via WhatsApp"
   style="
        position:fixed;
        bottom:24px;
        right:24px;
        z-index:9998;
        width:54px;
        height:54px;
        background:#25d366;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        box-shadow:0 4px 16px rgba(37,211,102,.45);
        transition:transform .2s, box-shadow .2s;
        text-decoration:none;
   "
   onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 6px 24px rgba(37,211,102,.6)'"
   onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 16px rgba(37,211,102,.45)'">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="#fff">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>

<!-- Page Content -->
@yield('content')

<!-- ═══ FOOTER ═══ -->
<footer class="bg-gray-900 text-white mt-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8 py-10">
        <div class="flex flex-col md:flex-row items-start justify-between gap-8">
            {{-- Kiri --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Grobogan" class="w-10 h-10 object-contain">
                    <div class="font-black text-white text-base uppercase leading-tight">Badan Kesatuan Bangsa dan Politik</div>
                </div>
                <p class="text-gray-400 text-sm"><span class="font-semibold text-white">Hotline Pelayanan Ormas:</span> <a href="https://wa.me/628977976105" target="_blank" class="text-green-400 hover:underline font-medium"><i class="fab fa-whatsapp text-green-500 mr-1"></i>+62 897-7976-105</a></p>
                <p class="text-gray-400 text-sm mt-1"><span class="font-semibold text-white">Email Resmi:</span> <a href="mailto:adminsiporas@gmail.com" class="text-gray-300 hover:text-white">adminsiporas@gmail.com</a></p>
            </div>
            {{-- Kanan --}}
            <div class="text-sm md:text-right">
                <div class="font-bold text-white text-sm uppercase tracking-wide mb-2">Jam Operasional Layanan</div>
                <p class="text-gray-400">Senin – Kamis: 07.30 – 16.00 WIB</p>
                <p class="text-gray-400">Jumat: 07.30 – 14.30 WIB</p>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-800 py-4">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-8 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-gray-500">
            <span>© {{ date('Y') }} SIPORAS – Badan Kesatuan Bangsa dan Politik Kabupaten Grobogan</span>
            <span>Dikelola untuk kemudahan pelayanan organisasi kemasyarakatan</span>
        </div>
    </div>
</footer>

<script>
    function toggleHdrMenu() {
        var dd = document.getElementById('hdr-dropdown');
        dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
    }
    document.addEventListener('click', function(e) {
        var wrapper = document.getElementById('hdr-avatar');
        if (wrapper && !wrapper.contains(e.target)) {
            var dd = document.getElementById('hdr-dropdown');
            if (dd) { dd.style.display = 'none'; }
        }
    });

    function openMobileModal() {
        const modal = document.getElementById('mobile-nav-modal');
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileModal() {
        const modal = document.getElementById('mobile-nav-modal');
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMobileModal();
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) closeMobileModal();
    });
</script>

@stack('scripts')

<script>
// ── Scroll Reveal Animation ───────────────────────────────────────────────────
(function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    // Otomatis tambahkan class reveal ke elemen-elemen utama di halaman
    const selectors = [
        'section > div > div',        // konten dalam section
        '.bg-white.rounded-xl',        // card-card
        '.bg-white.rounded-2xl',
        '.grid > div',                 // item grid
        'footer > div > div',          // footer content
    ];

    document.querySelectorAll(selectors.join(',')).forEach((el, i) => {
        // Skip elemen yang sudah visible di viewport awal
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.85) return;

        el.classList.add('reveal');
        // Delay bertahap untuk elemen dalam grid
        el.style.transitionDelay = (i % 4) * 0.08 + 's';
        observer.observe(el);
    });
})();
</script>

@auth
<script>
(function () {
    const TIMEOUT_MS  = 30 * 60 * 1000; // 30 menit
    const WARNING_MS  =  2 * 60 * 1000; // warning 2 menit sebelum logout
    const LOGOUT_URL  = '{{ route("auto.logout") }}';

    let warnTimer, logoutTimer, warningShown = false;

    // Buat overlay warning
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

@if(Auth::user()->isAdmin())
<script>
// ── Auto logout Admin jika tidak aktif / meninggalkan web > 5 menit ─────────
(function () {
    const TIMEOUT_MS = 5 * 60 * 1000; // 5 menit
    const LOGOUT_URL = '{{ route("auto.logout") }}';
    const LAST_SEEN_KEY = 'admin_last_activity_ts';

    function updateActivity() {
        localStorage.setItem(LAST_SEEN_KEY, Date.now().toString());
    }

    function checkInactivity() {
        const lastSeen = parseInt(localStorage.getItem(LAST_SEEN_KEY) || '0', 10);
        if (lastSeen > 0 && (Date.now() - lastSeen >= TIMEOUT_MS)) {
            localStorage.removeItem(LAST_SEEN_KEY);
            window.location.href = LOGOUT_URL;
        }
    }

    if (!localStorage.getItem(LAST_SEEN_KEY)) {
        updateActivity();
    }

    ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'].forEach(evt => {
        window.addEventListener(evt, updateActivity, { passive: true });
    });

    setInterval(checkInactivity, 5000);

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') {
            checkInactivity();
            updateActivity();
        }
    });

    window.addEventListener('focus', function () {
        checkInactivity();
        updateActivity();
    });
})();
</script>
@else
<script>
// ── Auto logout saat tab/browser ditutup (khusus user non-admin) ─────────────
(function () {
    const BEACON_URL = '{{ route("beacon.logout") }}';
    function sendLogoutBeacon() {
        navigator.sendBeacon(BEACON_URL);
    }
    window.addEventListener('pagehide', function (e) {
        if (!e.persisted) {
            sendLogoutBeacon();
        }
    });
})();
</script>
@endif
@endauth
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 700,
                easing: 'cubic-bezier(0.16, 1, 0.3, 1)',
                once: true,
                offset: 50,
            });
        }
    });
</script>
</body>
</html>
