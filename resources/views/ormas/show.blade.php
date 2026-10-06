@extends('layouts.app')

@section('title', $ormas->nama_ormas . ' – Profil Lengkap & Lokasi Sekretariat')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-popup-content-wrapper { border-radius: 12px; font-family: 'Inter', sans-serif; box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
    .leaflet-container { font-family: 'Inter', sans-serif; z-index: 10; }
</style>
@endpush

@section('content')
{{-- ═══ HERO BANNER PROFIL ORMAS ═══ --}}
<div style="background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);" class="text-white py-10 shadow-md">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8 flex flex-col sm:flex-row items-start sm:items-center gap-6">
        <div class="w-20 h-20 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center flex-shrink-0 border border-white/25 shadow-lg overflow-hidden">
            @if($ormas->logo)
                <img src="{{ Storage::url($ormas->logo) }}" alt="{{ $ormas->nama_ormas }}" class="w-full h-full object-contain p-2">
            @else
                <i class="fas fa-landmark text-white text-3xl"></i>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 text-red-100 text-xs mb-2 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <i class="fas fa-chevron-right text-[10px] opacity-70"></i>
                <a href="{{ route('ormas.index') }}" class="hover:text-white transition-colors">Direktori Ormas</a>
                <i class="fas fa-chevron-right text-[10px] opacity-70"></i>
                <span class="text-white font-semibold truncate">{{ $ormas->singkatan ?? $ormas->nama_ormas }}</span>
            </div>
            <div class="flex items-center gap-3 mb-2 flex-wrap">
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white leading-tight">{{ $ormas->nama_ormas }}</h1>
                @if($ormas->singkatan)
                    <span class="bg-white/20 text-white text-xs font-extrabold px-3 py-1 rounded-full border border-white/30 uppercase tracking-wider">{{ $ormas->singkatan }}</span>
                @endif
                <span class="inline-flex items-center gap-1.5 text-xs font-extrabold px-3 py-1 rounded-full border {{ $ormas->status === 'aktif' ? 'bg-emerald-500/30 text-emerald-100 border-emerald-400/40' : 'bg-amber-500/30 text-amber-100 border-amber-400/40' }}">
                    <span class="w-2 h-2 rounded-full {{ $ormas->status === 'aktif' ? 'bg-emerald-400' : 'bg-amber-400' }}"></span>
                    {{ $ormas->status_label }}
                </span>
            </div>
            <div class="flex flex-wrap gap-4 text-xs sm:text-sm text-red-100 font-medium">
                <span><i class="fas fa-tag mr-1.5 text-red-200"></i>{{ $ormas->bidang_kegiatan }}</span>
                <span><i class="fas fa-map-marker-alt mr-1.5 text-red-200"></i>{{ $ormas->kota }}, {{ $ormas->provinsi }}</span>
                @if($ormas->nomor_skt)
                    <span><i class="fas fa-id-card mr-1.5 text-red-200"></i>SKT: {{ $ormas->nomor_skt }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 sm:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Kolom Utama --}}
        <div class="flex-1 space-y-6">

            {{-- 1. INFORMASI LENGKAP & LEGALITAS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-7">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-700 flex items-center justify-center font-bold">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-gray-900 text-lg">Informasi Lengkap Organisasi</h2>
                        <p class="text-xs text-gray-500">Data identitas dan keabsahan hukum Ormas di Kesbangpol Grobogan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nama Resmi Ormas</span>
                        <span class="font-bold text-gray-900 text-base">{{ $ormas->nama_ormas }}</span>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Singkatan / Akronim</span>
                        <span class="font-bold text-gray-900 text-base">{{ $ormas->singkatan ?: '-' }}</span>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nomor SKT / Register Kesbangpol</span>
                        <span class="font-bold text-red-700 text-base font-mono">{{ $ormas->nomor_skt ?: 'Dalam Proses Verifikasi' }}</span>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Bidang Kegiatan</span>
                        <span class="font-bold text-gray-900 text-base">{{ $ormas->bidang_kegiatan }}</span>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Tanggal Berdiri</span>
                        <span class="font-bold text-gray-900 text-base">{{ $ormas->tanggal_berdiri ? $ormas->tanggal_berdiri->format('d F Y') : '-' }}</span>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Status Keaktifan</span>
                        <span class="inline-flex items-center gap-1.5 font-bold {{ $ormas->status === 'aktif' ? 'text-emerald-700' : 'text-amber-700' }}">
                            <i class="fas {{ $ormas->status === 'aktif' ? 'fa-check-circle text-emerald-600' : 'fa-clock text-amber-600' }}"></i>
                            {{ $ormas->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. VISI & MISI --}}
            @if($ormas->visi || $ormas->misi)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-7">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-700 flex items-center justify-center font-bold">
                        <i class="fas fa-bullseye text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-gray-900 text-lg">Visi & Misi Organisasi</h2>
                        <p class="text-xs text-gray-500">Tujuan dan komitmen pelayanan ormas</p>
                    </div>
                </div>

                @if($ormas->visi)
                <div class="mb-5 p-4 rounded-xl bg-red-50/50 border border-red-100">
                    <h3 class="text-xs font-bold text-red-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-eye"></i> Visi
                    </h3>
                    <p class="text-gray-800 text-sm leading-relaxed font-medium">{{ $ormas->visi }}</p>
                </div>
                @endif

                @if($ormas->misi)
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-tasks"></i> Misi
                    </h3>
                    <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $ormas->misi }}</p>
                </div>
                @endif
            </div>
            @endif

            {{-- 3. SUSUNAN PENGURUS --}}
            @if($ormas->pengurus && $ormas->pengurus->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-7">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-700 flex items-center justify-center font-bold">
                        <i class="fas fa-users-cog text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-gray-900 text-lg">Susunan Pengurus Utama</h2>
                        <p class="text-xs text-gray-500">Pengurus resmi terdaftar di Kesbangpol Kab. Grobogan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($ormas->pengurus as $p)
                    <div class="flex items-center gap-3.5 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-red-200 transition-colors">
                        <div class="w-11 h-11 bg-red-100 text-red-700 rounded-full flex items-center justify-center font-black flex-shrink-0 text-sm">
                            {{ strtoupper(substr($p->nama, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-bold text-gray-900 text-sm truncate">{{ $p->nama }}</div>
                            <div class="text-xs font-semibold text-red-700 uppercase tracking-wider mt-0.5">{{ $p->jabatan }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- 4. KEGIATAN TERAKHIR --}}
            @if($ormas->kegiatan && $ormas->kegiatan->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-7">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-red-50 text-red-700 flex items-center justify-center font-bold">
                        <i class="fas fa-calendar-alt text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-gray-900 text-lg">Dokumentasi Kegiatan Terakhir</h2>
                        <p class="text-xs text-gray-500">Kegiatan kemasyarakatan yang telah dilaporkan</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($ormas->kegiatan as $k)
                    <a href="{{ route('kegiatan.show', $k) }}" class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:bg-red-50/50 hover:border-red-200 transition-colors group">
                        <div class="w-12 h-12 bg-red-100 text-red-700 rounded-xl flex items-center justify-center flex-shrink-0 text-center">
                            <div class="font-black text-xs leading-none">
                                {{ $k->tanggal_mulai ? $k->tanggal_mulai->format('d') : '-' }}<br>
                                <span class="font-medium text-[10px] uppercase text-red-600">{{ $k->tanggal_mulai ? $k->tanggal_mulai->format('M') : '' }}</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-gray-900 group-hover:text-red-700 transition-colors truncate">{{ $k->judul }}</div>
                            <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                <span><i class="fas fa-map-marker-alt text-red-500 mr-1"></i>{{ $k->lokasi }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar Kolom Kanan: Map Pin Point + Kontak --}}
        <div class="w-full lg:w-80 space-y-6">

            {{-- PIN POINT MAP LOKASI SEKRETARIAT --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="font-extrabold text-gray-900 text-sm flex items-center gap-2">
                        <i class="fas fa-map-marked-alt text-red-700"></i> Pin Point Lokasi Sekretariat
                    </h3>
                </div>

                {{-- Leaflet Map Canvas --}}
                <div id="ormas-map" class="w-full h-60 rounded-xl border border-gray-200 shadow-inner overflow-hidden"></div>

                <div class="space-y-2 text-xs">
                    <div class="flex items-center justify-between text-gray-500 font-medium">
                        <span>Koordinat Presisi:</span>
                        <span class="font-mono text-gray-900 font-bold">
                            {{ number_format($ormas->latitude ?? -7.06227, 5) }}, {{ number_format($ormas->longitude ?? 110.72666, 5) }}
                        </span>
                    </div>

                    <a href="https://www.google.com/maps/search/?api=1&query={{ $ormas->latitude ?? -7.06227 }},{{ $ormas->longitude ?? 110.72666 }}" 
                       target="_blank" 
                       class="w-full inline-flex items-center justify-center gap-2 text-xs font-extrabold text-white bg-red-700 hover:bg-red-800 py-2.5 rounded-xl transition-colors shadow-xs">
                        <i class="fas fa-external-link-alt"></i> Buka Google Maps
                    </a>
                </div>
            </div>

            {{-- KONTAK & SEKRETARIAT --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 space-y-4">
                <h3 class="font-extrabold text-gray-900 text-sm flex items-center gap-2 pb-3 border-b border-gray-100">
                    <i class="fas fa-address-book text-red-700"></i> Kontak Sekretariat
                </h3>

                <ul class="space-y-3.5 text-xs sm:text-sm text-gray-700">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-red-600 mt-1 w-4 text-center flex-shrink-0"></i>
                        <div class="leading-relaxed">
                            <span class="font-bold text-gray-900 block">Alamat Sekretariat:</span>
                            <span class="text-gray-600">{{ $ormas->alamat_sekretariat }}</span>
                            @if($ormas->rt_rw)<span class="block text-gray-500 text-xs">RT/RW: {{ $ormas->rt_rw }}</span>@endif
                            <span class="block text-gray-500 text-xs mt-0.5">
                                {{ implode(', ', array_filter([
                                    $ormas->kelurahan ? 'Desa/Kel. ' . $ormas->kelurahan : null,
                                    $ormas->kecamatan ? 'Kec. ' . $ormas->kecamatan : null,
                                    $ormas->kota,
                                    $ormas->provinsi
                                ])) }}
                            </span>
                        </div>
                    </li>

                    @if($ormas->telepon)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-red-600 w-4 text-center flex-shrink-0"></i>
                        <div>
                            <span class="font-bold text-gray-900 block text-xs">Telepon / Whatsapp:</span>
                            <a href="tel:{{ $ormas->telepon }}" class="text-red-700 hover:underline font-bold">{{ $ormas->telepon }}</a>
                        </div>
                    </li>
                    @endif

                    @if($ormas->email)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-red-600 w-4 text-center flex-shrink-0"></i>
                        <div class="min-w-0 flex-1">
                            <span class="font-bold text-gray-900 block text-xs">Email Resmi:</span>
                            <a href="mailto:{{ $ormas->email }}" class="text-red-700 hover:underline font-bold truncate block">{{ $ormas->email }}</a>
                        </div>
                    </li>
                    @endif

                    @if($ormas->website)
                    <li class="flex items-center gap-3">
                        <i class="fas fa-globe text-red-600 w-4 text-center flex-shrink-0"></i>
                        <div class="min-w-0 flex-1">
                            <span class="font-bold text-gray-900 block text-xs">Website Resmi:</span>
                            <a href="{{ $ormas->website }}" target="_blank" class="text-red-700 hover:underline font-bold truncate block">{{ $ormas->website }}</a>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="space-y-2.5">
                <a href="{{ route('laporan.pendaftaran-baru') }}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-red-700 hover:bg-red-800 text-white font-extrabold text-sm py-3 rounded-xl transition-colors shadow-sm">
                    <i class="fas fa-file-alt"></i> Ajukan Layanan
                </a>
                <a href="{{ route('ormas.index') }}" 
                   class="w-full inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-bold text-sm py-3 rounded-xl border border-gray-200 transition-colors shadow-xs">
                    <i class="fas fa-arrow-left"></i> Kembali ke Direktori
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ $ormas->latitude ?? -7.06227 }};
        const lng = {{ $ormas->longitude ?? 110.72666 }};
        
        const map = L.map('ormas-map', {
            center: [lat, lng],
            zoom: 15,
            scrollWheelZoom: false
        });
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Custom Pin Marker
        const pinIcon = L.divIcon({
            className: 'custom-pin-marker',
            html: `<div style="background:#b91c1c;width:34px;height:34px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(185,28,28,0.4);border:2px solid #ffffff;"><i class="fas fa-landmark" style="color:#ffffff;transform:rotate(45deg);font-size:13px;"></i></div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 34],
            popupAnchor: [0, -34]
        });

        const marker = L.marker([lat, lng], { icon: pinIcon }).addTo(map);
        marker.bindPopup(`
            <div style="padding:4px 6px;text-align:center;">
                <strong style="color:#b91c1c;font-size:13px;display:block;margin-bottom:2px;">{{ $ormas->nama_ormas }}</strong>
                <span style="font-size:11px;color:#4b5563;line-height:1.3;display:block;">{{ $ormas->alamat_sekretariat }}</span>
            </div>
        `).openPopup();
    });
</script>
@endpush
