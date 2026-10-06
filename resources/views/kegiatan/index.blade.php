@extends('layouts.app')

@section('title', 'Kegiatan Ormas')

@section('content')
<div style="background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);" class="text-white py-10">
    <div class="max-w-screen-xl mx-auto px-8">
        <div class="flex items-center gap-2 text-red-100 text-xs mb-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fas fa-chevron-right text-xs opacity-75"></i>
            <span class="text-white font-semibold">Kegiatan</span>
        </div>
        <h1 class="text-3xl font-bold">Kegiatan Ormas</h1>
        <p class="text-red-100 mt-1">Aktivitas dan program dari organisasi masyarakat</p>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-8 py-8">
    {{-- Filter --}}
    <div class="flex flex-wrap gap-2 mb-8">
        @foreach([''=>'Semua', 'akan_datang'=>'Akan Datang', 'berlangsung'=>'Berlangsung', 'selesai'=>'Selesai'] as $val => $label)
        <a href="{{ route('kegiatan.index', array_filter(['status' => $val])) }}"
            class="text-sm font-medium px-4 py-2 rounded-full border transition-colors
            {{ request('status') == $val ? 'text-white border-red-700' : 'bg-white text-gray-600 border-gray-200 hover:border-red-300 hover:text-red-700' }}"
            style="{{ request('status') == $val ? 'background:#ffffff;border-color:#ffffff;' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    @if($kegiatanList->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($kegiatanList as $kegiatan)
        <a href="{{ route('kegiatan.show', $kegiatan) }}" class="card group">
            <div class="h-44 bg-gradient-to-br from-green-50 to-teal-50 flex items-center justify-center overflow-hidden">
                @if($kegiatan->foto)
                    <img src="{{ Storage::url($kegiatan->foto) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <i class="fas fa-calendar-star text-green-200 text-6xl"></i>
                @endif
            </div>
            <div class="p-5">
                @php
                    $st = $kegiatan->status;
                    $stClass = $st === 'berlangsung' ? 'bg-green-100 text-green-700' : ($st === 'akan_datang' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500');
                    $stLabel = $st === 'berlangsung' ? 'Berlangsung' : ($st === 'akan_datang' ? 'Akan Datang' : 'Selesai');
                @endphp
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $stClass }}">{{ $stLabel }}</span>
                    <span class="text-xs text-gray-400">{{ $kegiatan->tanggal_mulai->format('d M Y') }}</span>
                </div>
                <h3 class="font-semibold text-gray-900 leading-snug group-hover:text-blue-700 transition-colors line-clamp-2 mb-2">{{ $kegiatan->judul }}</h3>
                <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $kegiatan->deskripsi }}</p>
                <div class="flex items-center gap-3 text-xs text-gray-400 border-t border-gray-50 pt-3">
                    <span><i class="fas fa-users mr-1"></i>{{ $kegiatan->ormas->nama_ormas ?? '-' }}</span>
                    <span class="ml-auto"><i class="fas fa-map-marker-alt mr-1"></i>{{ Str::limit($kegiatan->lokasi, 20) }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $kegiatanList->withQueryString()->links() }}
    </div>
    @else
    <div class="text-center py-20 text-gray-400">
        <i class="fas fa-calendar-times text-5xl mb-4"></i>
        <p class="text-lg">Belum ada kegiatan.</p>
    </div>
    @endif
</div>
@endsection
