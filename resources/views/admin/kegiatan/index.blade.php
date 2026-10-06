@extends('layouts.admin')

@section('title', 'Laporan Kegiatan')
@section('page-title', 'Laporan Kegiatan Ormas')

@section('content')
<div class="space-y-5">

    {{-- Filter Status --}}
    <div class="flex flex-wrap items-center justify-between gap-3 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex flex-wrap gap-2">
            @foreach([''=>'Semua', 'menunggu'=>'Menunggu', 'diproses'=>'Diproses', 'disetujui'=>'Disetujui', 'ditolak'=>'Ditolak'] as $val => $label)
            <a href="{{ route('admin.kegiatan', $val ? ['status' => $val] : []) }}"
               class="text-xs font-medium px-3.5 py-1.5 rounded-full border transition-colors
               {{ request('status') == $val ? 'bg-green-700 text-white border-green-700' : 'bg-white text-gray-600 border-gray-200 hover:border-green-400 hover:text-green-700' }}">
                {{ $label }}
                @if($val === 'menunggu')
                    @php $c = \App\Models\Pengajuan::where('jenis_layanan','laporan_kegiatan')->where('status','menunggu')->count(); @endphp
                    @if($c > 0)<span class="ml-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $c }}</span>@endif
                @endif
            </a>
            @endforeach
        </div>
        <span class="text-xs text-gray-500 font-medium">Total {{ $kegiatanList->total() }} laporan</span>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-5 py-3">No</th>
                        <th class="text-left px-5 py-3">Pengirim</th>
                        <th class="text-left px-5 py-3">Foto</th>
                        <th class="text-left px-5 py-3">Tanggal</th>
                        <th class="text-left px-5 py-3">Status</th>
                        <th class="text-center px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kegiatanList as $i => $item)
                    @php
                        $fotos = $item->data_perubahan['foto_kegiatan'] ?? [];
                        $statusCfg = [
                            'menunggu'  => ['label'=>'Menunggu',  'bg'=>'bg-yellow-50', 'text'=>'text-yellow-700', 'border'=>'border-yellow-200'],
                            'diproses'  => ['label'=>'Diproses',  'bg'=>'bg-blue-50',   'text'=>'text-blue-700',   'border'=>'border-blue-200'],
                            'disetujui' => ['label'=>'Disetujui', 'bg'=>'bg-green-50',  'text'=>'text-green-700',  'border'=>'border-green-200'],
                            'ditolak'   => ['label'=>'Ditolak',   'bg'=>'bg-red-50',    'text'=>'text-red-700',    'border'=>'border-red-200'],
                        ];
                        $st = $statusCfg[$item->status] ?? ['label'=>$item->status,'bg'=>'bg-gray-50','text'=>'text-gray-600','border'=>'border-gray-200'];
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 text-gray-400 font-medium">{{ $kegiatanList->firstItem() + $i }}</td>
                        <td class="px-5 py-4">
                            <div class="font-semibold text-gray-900">{{ $item->nama_pemohon }}</div>
                            <div class="text-xs text-gray-400">{{ $item->email }}</div>
                        </td>
                        <td class="px-5 py-4">
                            @if(count($fotos) > 0)
                            <div class="flex gap-1.5 flex-wrap">
                                @foreach(array_slice($fotos, 0, 3) as $foto)
                                <a href="{{ Storage::url($foto['path']) }}" target="_blank">
                                    <img src="{{ Storage::url($foto['path']) }}"
                                         class="w-12 h-12 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity"
                                         title="{{ $foto['deskripsi'] ?? '' }}">
                                </a>
                                @endforeach
                                @if(count($fotos) > 3)
                                <div class="w-12 h-12 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                    +{{ count($fotos) - 3 }}
                                </div>
                                @endif
                            </div>
                            <div class="text-xs text-gray-400 mt-1">{{ count($fotos) }} foto</div>
                            @else
                            <span class="text-gray-400 text-xs">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $item->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $st['bg'] }} {{ $st['text'] }} {{ $st['border'] }}">
                                {{ $st['label'] }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <button onclick="openModal({{ $item->id }})"
                                class="text-xs font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                Lihat &amp; Update
                            </button>
                        </td>
                    </tr>

                    {{-- Modal detail per item --}}
                    <div id="modal-{{ $item->id }}"
                         class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4"
                         onclick="if(event.target===this) closeModal({{ $item->id }})">
                        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                                <h3 class="font-bold text-gray-900">Detail Laporan Kegiatan</h3>
                                <button onclick="closeModal({{ $item->id }})" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                            </div>

                            <div class="px-6 py-5 space-y-5">
                                {{-- Info pengirim --}}
                                <div class="bg-gray-50 rounded-xl p-4 text-sm space-y-1">
                                    <div><span class="text-gray-500">Pengirim:</span> <span class="font-semibold text-gray-900">{{ $item->nama_pemohon }}</span></div>
                                    <div><span class="text-gray-500">Email:</span> {{ $item->email }}</div>
                                    <div><span class="text-gray-500">Tanggal Kirim:</span> {{ $item->created_at->format('d M Y, H:i') }}</div>
                                </div>

                                {{-- Foto + deskripsi --}}
                                @if(count($fotos) > 0)
                                <div>
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Foto Kegiatan ({{ count($fotos) }})</h4>
                                    <div class="space-y-4">
                                        @foreach($fotos as $idx => $foto)
                                        <div class="border border-gray-100 rounded-xl overflow-hidden">
                                            <a href="{{ Storage::url($foto['path']) }}" target="_blank">
                                                <img src="{{ Storage::url($foto['path']) }}"
                                                     class="w-full object-cover max-h-56 hover:opacity-95 transition-opacity">
                                            </a>
                                            @if(!empty($foto['deskripsi']))
                                            <div class="px-4 py-3 bg-gray-50 text-sm text-gray-700 border-t border-gray-100">
                                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide block mb-1">Foto {{ $idx + 1 }}</span>
                                                {{ $foto['deskripsi'] }}
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                {{-- Update status --}}
                                <form action="{{ route('admin.kegiatan.update', $item) }}" method="POST">
                                    @csrf @method('PUT')
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Update Status</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                                            <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                                                @foreach(['menunggu'=>'Menunggu','diproses'=>'Diproses','disetujui'=>'Disetujui','ditolak'=>'Ditolak'] as $val => $label)
                                                <option value="{{ $val }}" {{ $item->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Admin</label>
                                        <textarea name="catatan_admin" rows="2"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none"
                                            placeholder="Opsional...">{{ $item->catatan_admin }}</textarea>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="closeModal({{ $item->id }})"
                                            class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                            Tutup
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2 text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 rounded-lg transition-colors">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <i class="fas fa-camera text-4xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 font-medium">Belum ada laporan kegiatan masuk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kegiatanList->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $kegiatanList->links() }}
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
function openModal(id) {
    const m = document.getElementById('modal-' + id);
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    const m = document.getElementById('modal-' + id);
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}
</script>
@endpush
@endsection
