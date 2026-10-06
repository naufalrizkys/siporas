@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        @php
        $cards = [
            ['label'=>'Total Ormas','value'=>$stats['total_ormas'],'icon'=>'fas fa-users','color'=>'blue'],
            ['label'=>'Ormas Aktif','value'=>$stats['ormas_aktif'],'icon'=>'fas fa-check-circle','color'=>'green'],
            ['label'=>'Total Pengajuan','value'=>$stats['total_pengajuan'],'icon'=>'fas fa-file-alt','color'=>'purple'],
            ['label'=>'Menunggu','value'=>$stats['pengajuan_tunggu'],'icon'=>'fas fa-hourglass-half','color'=>'yellow'],
            ['label'=>'Diproses','value'=>$stats['pengajuan_proses'],'icon'=>'fas fa-spinner','color'=>'orange'],
            ['label'=>'Kegiatan','value'=>$stats['total_kegiatan'],'icon'=>'fas fa-calendar-check','color'=>'teal'],
        ];
        @endphp
        @foreach($cards as $card)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400 font-medium">{{ $card['label'] }}</span>
                <div class="w-8 h-8 bg-{{ $card['color'] }}-100 rounded-lg flex items-center justify-center">
                    <i class="{{ $card['icon'] }} text-{{ $card['color'] }}-500 text-sm"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($card['value']) }}</div>
        </div>
        @endforeach
    </div>

    {{-- Pengajuan Terbaru --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between p-5 border-b border-gray-50">
            <h2 class="font-bold text-gray-900">Pengajuan Terbaru</h2>
            <a href="{{ route('admin.pengajuan') }}" class="text-blue-600 hover:underline text-sm">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                        <th class="text-left px-5 py-3">No</th>
                        <th class="text-left px-5 py-3">Pemohon</th>
                        <th class="text-left px-5 py-3">Jenis Layanan</th>
                        <th class="text-left px-5 py-3">Tanggal</th>
                        <th class="text-left px-5 py-3">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pengajuanTerbaru as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-500">#{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-5 py-3.5 font-medium text-gray-900">{{ $p->nama_pemohon }}</td>
                        <td class="px-5 py-3.5 text-gray-600">{{ $p->jenis_layanan_label }}</td>
                        <td class="px-5 py-3.5 text-gray-400">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            @php
                                $sc = ['menunggu'=>'bg-yellow-100 text-yellow-700','diproses'=>'bg-blue-100 text-blue-700','disetujui'=>'bg-green-100 text-green-700','ditolak'=>'bg-red-100 text-red-700'];
                            @endphp
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$p->status] ?? 'bg-gray-100 text-gray-500' }}">
                                {{ $p->status_label }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.pengajuan.show', $p) }}" class="text-blue-600 hover:underline text-xs">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Belum ada pengajuan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach([
            ['href'=>route('admin.ormas.create'),'icon'=>'fas fa-plus','color'=>'blue','label'=>'Tambah Ormas'],
            ['href'=>route('admin.pengajuan').'?status=menunggu','icon'=>'fas fa-hourglass-half','color'=>'yellow','label'=>'Pengajuan Menunggu'],
            ['href'=>route('admin.ormas'),'icon'=>'fas fa-list','color'=>'green','label'=>'Direktori Ormas'],
            ['href'=>route('admin.kegiatan'),'icon'=>'fas fa-calendar','color'=>'purple','label'=>'Semua Kegiatan'],
        ] as $qa)
        <a href="{{ $qa['href'] }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex items-center gap-3 hover:shadow-md transition-shadow group">
            <div class="w-10 h-10 bg-{{ $qa['color'] }}-100 rounded-lg flex items-center justify-center group-hover:bg-{{ $qa['color'] }}-200 transition-colors">
                <i class="{{ $qa['icon'] }} text-{{ $qa['color'] }}-600"></i>
            </div>
            <span class="text-sm font-medium text-gray-800">{{ $qa['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>
@endsection
