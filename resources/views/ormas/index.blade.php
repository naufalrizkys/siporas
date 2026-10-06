@extends('layouts.app')

@section('title', 'Direktori Ormas')

@section('content')
{{-- Page Header --}}
<div style="background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);" class="text-white py-10">
    <div class="max-w-screen-xl mx-auto px-8">
        <div class="flex items-center gap-2 text-red-100 text-xs mb-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fas fa-chevron-right text-xs opacity-75"></i>
            <span class="text-white font-semibold">Direktori Ormas</span>
        </div>
        <h1 class="text-3xl font-bold">Direktori Ormas</h1>
        <p class="text-red-100 mt-1">Daftar organisasi masyarakat yang terdaftar dan aktif</p>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-8 py-8">

    {{-- Filter --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-8 flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau singkatan ormas..." class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>
        <select name="bidang" class="border border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-300">
            <option value="">Semua Bidang</option>
            @foreach($bidangList as $bidang)
                <option value="{{ $bidang }}" {{ request('bidang') == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
            @endforeach
        </select>
        <button type="submit" style="background:#ffffff;" class="hover:opacity-90 text-white font-semibold text-sm px-5 py-2.5 rounded-lg inline-flex items-center gap-2 transition">
            <i class="fas fa-filter"></i> Filter
        </button>
        @if(request()->anyFilled(['search','bidang']))
        <a href="{{ route('ormas.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 px-2">
            <i class="fas fa-times"></i> Reset
        </a>
        @endif
    </form>

    {{-- Hasil --}}
    @if($ormasList->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($ormasList as $ormas)
        <a href="{{ route('ormas.show', $ormas) }}" class="card p-5 flex flex-col gap-3 group">
            <div class="flex items-start gap-3">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition-colors">
                    @if($ormas->logo)
                        <img src="{{ Storage::url($ormas->logo) }}" alt="" class="w-10 h-10 object-contain rounded-lg">
                    @else
                        <i class="fas fa-users text-blue-400 text-xl"></i>
                    @endif
                </div>
                <div class="min-w-0">
                    <h3 class="font-semibold text-gray-900 text-sm leading-snug group-hover:text-blue-700 transition-colors line-clamp-2">{{ $ormas->nama_ormas }}</h3>
                    @if($ormas->singkatan)
                        <span class="text-xs text-blue-500 font-medium">{{ $ormas->singkatan }}</span>
                    @endif
                </div>
            </div>
            <div class="space-y-1 text-xs text-gray-500 border-t border-gray-50 pt-2">
                <div><i class="fas fa-tag w-4 text-gray-300"></i> {{ $ormas->bidang_kegiatan }}</div>
                <div><i class="fas fa-map-marker-alt w-4 text-gray-300"></i> {{ $ormas->kota }}, {{ $ormas->provinsi }}</div>
                @if($ormas->nomor_skt)
                <div><i class="fas fa-id-card w-4 text-gray-300"></i> {{ $ormas->nomor_skt }}</div>
                @endif
            </div>
            <div>
                <span class="badge-{{ $ormas->status }}">{{ $ormas->status_label }}</span>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $ormasList->withQueryString()->links() }}
    </div>
    @else
    <div class="text-center py-20 text-gray-400">
        <i class="fas fa-search text-5xl mb-4"></i>
        <p class="text-lg">Tidak ada ormas yang ditemukan.</p>
        @if(request()->anyFilled(['search','bidang']))
            <a href="{{ route('ormas.index') }}" class="text-blue-600 hover:underline text-sm mt-2 block">Hapus filter</a>
        @endif
    </div>
    @endif
</div>
@endsection
