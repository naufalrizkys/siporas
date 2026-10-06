<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – SIPORAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            width: 100% !important;
            padding: 0.625rem 0.75rem !important;
            color: #d1d5db !important;
            border-radius: 0.5rem !important;
            transition: all 0.15s ease-in-out !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            box-sizing: border-box !important;
        }
        .sidebar-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        .sidebar-link.active {
            color: #ffffff !important;
            background-color: #1d4ed8 !important;
            font-weight: 600 !important;
        }

        /* Mobile sidebar overlay */
        #sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 40;
        }
        #sidebar-overlay.open { display: block; }

        /* Sidebar: fixed di mobile, static di desktop */
        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            #sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800 flex h-screen overflow-hidden">

{{-- Mobile overlay backdrop --}}
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- Sidebar --}}
<aside id="sidebar" class="w-64 bg-gray-900 flex flex-col flex-shrink-0 h-full overflow-y-auto transition-transform duration-300">
    <div class="p-5 border-b border-gray-700">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-grobogan.png') }}" alt="Logo Grobogan" style="width:36px;height:36px;object-fit:contain;">
            <div>
                <div class="font-black text-white text-lg leading-tight">SIPORAS</div>
                <div class="text-xs text-gray-400 font-medium">Panel Admin</div>
            </div>
        </div>
    </div>

    <nav class="flex-1 p-3 space-y-1">
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider px-3 mb-2 mt-2">Menu</p>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt w-4 flex-shrink-0"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.ormas') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request()->routeIs('admin.ormas*') ? 'active' : '' }}">
            <i class="fas fa-users w-4 flex-shrink-0"></i> <span>Data Ormas</span>
        </a>
        <a href="{{ route('admin.pengajuan', ['jenis_layanan' => 'pendaftaran_ormas']) }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request('jenis_layanan') == 'pendaftaran_ormas' ? 'active' : '' }}">
            <i class="fas fa-file-alt w-4 flex-shrink-0"></i> <span>Pendaftaran Ormas Baru</span>
            @php $pendingPendaftaran = \App\Models\Pengajuan::where('jenis_layanan','pendaftaran_ormas')->where('status','menunggu')->count(); @endphp
            @if($pendingPendaftaran > 0)
            <span class="ml-auto bg-blue-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingPendaftaran }}</span>
            @endif
        </a>
        <a href="{{ route('admin.pengajuan', ['jenis_layanan' => 'perubahan_data']) }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request('jenis_layanan') == 'perubahan_data' ? 'active' : '' }}">
            <i class="fas fa-edit w-4 flex-shrink-0"></i> <span>Perubahan Data Ormas</span>
            @php $pendingPerubahan = \App\Models\Pengajuan::where('jenis_layanan','perubahan_data')->where('status','menunggu')->count(); @endphp
            @if($pendingPerubahan > 0)
            <span class="ml-auto bg-purple-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingPerubahan }}</span>
            @endif
        </a>
        <a href="{{ route('admin.kegiatan') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request()->routeIs('admin.kegiatan*') ? 'active' : '' }}">
            <i class="fas fa-camera w-4 flex-shrink-0"></i> <span>Laporan Kegiatan</span>
            @php $pendingKegiatan = \App\Models\Pengajuan::where('jenis_layanan','laporan_kegiatan')->where('status','menunggu')->count(); @endphp
            @if($pendingKegiatan > 0)
            <span class="ml-auto bg-green-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingKegiatan }}</span>
            @endif
        </a>
        <a href="{{ route('admin.slider') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request()->routeIs('admin.slider*') ? 'active' : '' }}">
            <i class="fas fa-images w-4 flex-shrink-0"></i> <span>Slider Beranda</span>
        </a>
        <a href="{{ route('admin.ticker') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request()->routeIs('admin.ticker*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn w-4 flex-shrink-0"></i> <span>Running Text</span>
        </a>
        <a href="{{ route('admin.template') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium {{ request()->routeIs('admin.template*') ? 'active' : '' }}">
            <i class="fas fa-file-download w-4 flex-shrink-0"></i> <span>Template Dokumen</span>
        </a>

        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider px-3 mb-2 mt-4">Aksi</p>
        <a href="{{ route('home') }}" target="_blank" class="sidebar-link flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium">
            <i class="fas fa-external-link-alt w-4 flex-shrink-0"></i> <span>Lihat Website</span>
        </a>
    </nav>

    <div class="p-3 border-t border-gray-700">
        <div class="flex items-center gap-2 px-3 py-2">
            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center font-bold text-white text-xs shadow">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="text-xs font-semibold text-white">{{ Auth::user()->name ?? 'Admin Siporas' }}</div>
                <div class="text-xs text-gray-400">{{ Auth::user()->email ?? 'adminsiporas@gmail.com' }}</div>
            </div>
        </div>
    </div>
</aside>

{{-- Main Content --}}
<div class="flex-1 flex flex-col overflow-hidden">
    {{-- Top Bar --}}
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0 shadow-sm">
        <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="text-gray-600 hover:text-gray-900 transition-colors md:hidden">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="font-bold text-gray-900 text-lg">@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('home') }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1.5 transition-colors">
                <i class="fas fa-external-link-alt text-xs"></i> Website
            </a>
        </div>
    </header>

    {{-- Flash --}}
    <x-toast />

    {{-- Page --}}
    <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
    </main>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggle  = document.getElementById('sidebar-toggle');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    toggle?.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    // Tutup sidebar saat resize ke desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) closeSidebar();
    });
</script>
@stack('scripts')

@auth
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
@endauth
</body>
</html>
