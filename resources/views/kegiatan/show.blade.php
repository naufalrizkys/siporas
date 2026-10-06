@extends('layouts.app')

@section('title', $kegiatan->judul)

@section('content')
<div class="max-w-screen-xl mx-auto px-8 py-8">
    <a href="{{ route('kegiatan.index') }}" style="color:#ffffff;" class="hover:opacity-70 text-sm flex items-center gap-1 mb-6 font-medium transition">
        <i class="fas fa-arrow-left text-xs"></i> Kembali ke Daftar Kegiatan
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($kegiatan->foto)
        <div class="h-64 md:h-80">
            <img src="{{ Storage::url($kegiatan->foto) }}" alt="" class="w-full h-full object-cover">
        </div>
        @else
        <div class="h-40 flex items-center justify-center" style="background: linear-gradient(135deg, #fde8e8 0%, #fbd5d5 100%);">
            <i class="fas fa-calendar-alt text-red-200 text-7xl"></i>
        </div>
        @endif

        <div class="p-6 md:p-8">
            @php
                $st = $kegiatan->status;
                $stClass = $st === 'berlangsung' ? 'bg-green-100 text-green-700' : ($st === 'akan_datang' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500');
                $stLabel = $st === 'berlangsung' ? 'Berlangsung' : ($st === 'akan_datang' ? 'Akan Datang' : 'Selesai');
            @endphp
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $stClass }}">{{ $stLabel }}</span>
                <span class="text-sm text-gray-400">{{ $kegiatan->tanggal_mulai->format('d F Y') }}
                    @if($kegiatan->tanggal_selesai && $kegiatan->tanggal_selesai->ne($kegiatan->tanggal_mulai))
                        – {{ $kegiatan->tanggal_selesai->format('d F Y') }}
                    @endif
                </span>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">{{ $kegiatan->judul }}</h1>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50 rounded-xl p-4 mb-6 text-sm">
                <div class="flex items-center gap-2 text-gray-600">
                    <i class="fas fa-users text-blue-400 w-4"></i>
                    <div>
                        <div class="text-xs text-gray-400">Penyelenggara</div>
                        <div class="font-medium">{{ $kegiatan->ormas->nama_ormas ?? '-' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <i class="fas fa-map-marker-alt text-red-400 w-4"></i>
                    <div>
                        <div class="text-xs text-gray-400">Lokasi</div>
                        <div class="font-medium">{{ $kegiatan->lokasi }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <i class="fas fa-calendar text-green-400 w-4"></i>
                    <div>
                        <div class="text-xs text-gray-400">Tanggal</div>
                        <div class="font-medium">{{ $kegiatan->tanggal_mulai->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($kegiatan->deskripsi)) !!}
            </div>
        </div>
    </div>

    {{-- Kegiatan lain --}}
    @if($kegiatanLain->count())
    <div class="mt-10">
        <h2 class="text-lg font-bold text-gray-900 mb-5">Kegiatan Lainnya</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            @foreach($kegiatanLain as $k)
            <a href="{{ route('kegiatan.show', $k) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex gap-3 hover:shadow-md transition-shadow group">
                <div class="w-16 h-16 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar text-red-300 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 group-hover:text-red-700 line-clamp-2 transition-colors">{{ $k->judul }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $k->tanggal_mulai->format('d M Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
