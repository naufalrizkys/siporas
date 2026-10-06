@extends('layouts.admin')

@section('title', 'Data Ormas')
@section('page-title', 'Data Ormas')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Total: <strong>{{ $ormasList->total() }}</strong> ormas</p>
        <a href="{{ route('admin.ormas.create') }}" class="bg-red-700 hover:bg-red-800 text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <i class="fas fa-plus"></i> Tambah Ormas
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 space-y-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            {{-- Search --}}
            <div class="sm:col-span-2 relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, singkatan, SKT..."
                    class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-300">
            </div>

            {{-- Status --}}
            <div>
                <select name="status" class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                </select>
            </div>

            {{-- Bulan --}}
            <div>
                @php
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                @endphp
                <select name="bulan" class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
                    <option value="">Semua Bulan</option>
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun --}}
            <div>
                <select name="tahun" class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-300">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between pt-2 border-t border-gray-50 text-sm">
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500 font-medium">Urutan:</span>
                <select name="sort" class="border border-gray-200 rounded-md text-xs px-2 py-1 focus:outline-none focus:ring-1 focus:ring-red-300">
                    <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru Dulu</option>
                    <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama Dulu</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                @if(request()->anyFilled(['search','status','bulan','tahun','sort']))
                <a href="{{ route('admin.ormas') }}" class="px-3 py-1.5 text-xs text-gray-600 hover:text-gray-900 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-1">
                    <i class="fas fa-undo"></i> Reset Filter
                </a>
                @endif
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 font-semibold uppercase tracking-wider">
                <tr>
                    <th class="text-left px-5 py-3">Nama Ormas</th>
                    <th class="text-left px-5 py-3">Bidang</th>
                    <th class="text-left px-5 py-3">Kota</th>
                    <th class="text-left px-5 py-3">SKT</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-center px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($ormasList as $ormas)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="font-medium text-gray-900">{{ $ormas->nama_ormas }}</div>
                        @if($ormas->singkatan)<div class="text-xs text-gray-400">{{ $ormas->singkatan }}</div>@endif
                    </td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $ormas->bidang_kegiatan }}</td>
                    <td class="px-5 py-3.5 text-gray-600">{{ $ormas->kota }}</td>
                    <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $ormas->nomor_skt ?: '-' }}</td>
                    <td class="px-5 py-3.5">
                        @php $sc = ['aktif'=>'bg-green-100 text-green-700','tidak_aktif'=>'bg-red-100 text-red-700','menunggu'=>'bg-yellow-100 text-yellow-700']; @endphp
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$ormas->status] ?? '' }}">{{ $ormas->status_label }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('ormas.show', $ormas) }}" target="_blank" class="text-gray-400 hover:text-blue-600" title="Lihat"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.ormas.edit', $ormas) }}" class="text-gray-400 hover:text-yellow-600" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.ormas.destroy', $ormas) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ormas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">Tidak ada data ormas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $ormasList->withQueryString()->links() }}</div>
</div>
@endsection
