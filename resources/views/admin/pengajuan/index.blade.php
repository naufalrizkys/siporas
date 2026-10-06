@extends('layouts.admin')

@section('title', $pageTitle ?? 'Data Pengajuan')
@section('page-title', $pageTitle ?? 'Data Pengajuan')

@section('content')
<div class="space-y-5">
    {{-- Session Alert --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 text-lg"></i>
            <span class="text-sm font-semibold text-green-800">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 text-sm font-bold">&times;</button>
    </div>
    @endif

    {{-- Header Actions & Status Filters --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex flex-wrap gap-2">
            @foreach([''=>'Semua Status', 'menunggu'=>'Menunggu', 'diproses'=>'Diproses', 'disetujui'=>'Disetujui', 'ditolak'=>'Ditolak'] as $val => $label)
            <a href="{{ route('admin.pengajuan', array_filter(['status' => $val, 'jenis_layanan' => request('jenis_layanan')])) }}"
                class="text-xs font-medium px-3.5 py-1.5 rounded-full border transition-colors
                {{ request('status') == $val ? 'bg-red-700 text-white border-red-700 font-semibold' : 'bg-white text-gray-600 border-gray-200 hover:border-red-300 hover:text-red-700' }}">
                {{ $label }}
                @if($val === 'menunggu')
                    @php
                        $q = \App\Models\Pengajuan::where('status','menunggu');
                        if (request('jenis_layanan')) {
                            $q->where('jenis_layanan', request('jenis_layanan'));
                        }
                        $c = $q->count();
                    @endphp
                    @if($c > 0)<span class="ml-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $c }}</span>@endif
                @endif
            </a>
            @endforeach
        </div>

        <div class="text-xs text-gray-500 font-medium">
            Total {{ $pengajuanList->total() }} Pengajuan Ditemukan
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-5 py-3">No</th>
                        <th class="text-left px-5 py-3">Pemohon</th>
                        @if(!request('jenis_layanan'))
                        <th class="text-left px-5 py-3">Jenis Layanan</th>
                        @endif
                        <th class="text-left px-5 py-3">Tanggal</th>
                        <th class="text-left px-5 py-3">Status</th>
                        <th class="text-center px-5 py-3">Aksi (Setujui / Tolak)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pengajuanList as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5 font-bold text-gray-700">#{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-5 py-3.5">
                            <div class="font-medium text-gray-900">{{ $p->nama_pemohon }}</div>
                            <div class="text-xs text-gray-500"><i class="fas fa-envelope text-gray-400 mr-1"></i>{{ $p->email }}</div>
                            @if($p->ormas)
                            <div class="text-xs text-blue-600 font-medium mt-0.5"><i class="fas fa-building mr-1"></i>{{ $p->ormas->nama_ormas }}</div>
                            @endif
                        </td>
                        @if(!request('jenis_layanan'))
                        <td class="px-5 py-3.5 text-xs font-semibold">
                            @if($p->jenis_layanan === 'perubahan_data')
                            <span class="text-purple-700 bg-purple-50 border border-purple-200 px-2.5 py-1 rounded-md inline-flex items-center gap-1">
                                <i class="fas fa-edit"></i> {{ $p->jenis_layanan_label }}
                            </span>
                            @else
                            <span class="text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-md inline-flex items-center gap-1">
                                <i class="fas fa-file-alt"></i> {{ $p->jenis_layanan_label }}
                            </span>
                            @endif
                        </td>
                        @endif
                        <td class="px-5 py-3.5 text-gray-500 text-xs whitespace-nowrap">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-3.5">
                            @php $sc = ['menunggu'=>'bg-yellow-100 text-yellow-800','diproses'=>'bg-blue-100 text-blue-800','disetujui'=>'bg-green-100 text-green-800','ditolak'=>'bg-red-100 text-red-800']; @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc[$p->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $p->status_label }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Quick Action Buttons --}}
                                <button type="button"
                                    onclick="openApproveModal('{{ $p->id }}', '{{ addslashes($p->nama_pemohon) }}')"
                                    class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-2.5 py-1 rounded-md transition shadow-xs">
                                    <i class="fas fa-check"></i> Setujui
                                </button>

                                <button type="button"
                                    onclick="openProsesModal('{{ $p->id }}', '{{ addslashes($p->nama_pemohon) }}')"
                                    class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-2.5 py-1 rounded-md transition shadow-xs">
                                    <i class="fas fa-spinner"></i> Diproses
                                </button>

                                <button type="button"
                                    onclick="openRejectModal('{{ $p->id }}', '{{ addslashes($p->nama_pemohon) }}')"
                                    class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-2.5 py-1 rounded-md transition shadow-xs">
                                    <i class="fas fa-times"></i> Tolak
                                </button>

                                <a href="{{ route('admin.pengajuan.show', $p) }}"
                                    class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium px-2 py-1 rounded-md transition">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ request('jenis_layanan') ? 5 : 6 }}" class="px-5 py-12 text-center text-gray-400">
                            <i class="fas fa-inbox text-3xl mb-2 text-gray-300 block"></i>
                            Tidak ada data pengajuan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $pengajuanList->withQueryString()->links() }}</div>
</div>

{{-- Modal Quick Status Update (Setujui / Tolak) --}}
<div id="statusModal" onclick="if(event.target===this) closeStatusModal()" class="fixed inset-0 z-50 hidden overflow-y-auto" style="background: rgba(0,0,0,0.5);">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 relative">
            <button onclick="closeStatusModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>

            <div class="flex items-center gap-3">
                <div id="modalIconBg" class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    <i id="modalIcon" class="fas fa-check"></i>
                </div>
                <div>
                    <h3 id="modalTitle" class="text-base font-bold text-gray-900">Konfirmasi Status</h3>
                    <p id="modalSub" class="text-xs text-gray-500">Pengajuan #<span id="modalId"></span> - <span id="modalNama"></span></p>
                </div>
            </div>

            <form id="modalForm" method="POST" class="space-y-4 pt-2">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" id="modalStatusInput">

                <div>
                    <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Catatan Admin <span id="catatanReqLabel" class="text-red-500 font-normal"></span></label>
                    <textarea name="catatan_admin" id="modalCatatan" rows="3"
                        class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-300"
                        placeholder="Tuliskan catatan verifikasi dokumen / alasan..."></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg">Batal</button>
                    <button type="submit" id="modalSubmitBtn" class="px-5 py-2 text-white text-xs font-bold rounded-lg shadow-sm">Simpan Keputusan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openApproveModal(id, nama) {
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('modalForm').action = '{{ url("admin/pengajuan") }}/' + id;
        document.getElementById('modalStatusInput').value = 'disetujui';
        document.getElementById('modalId').innerText = String(id).padStart(4, '0');
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalTitle').innerText = 'Setujui Pengajuan';
        document.getElementById('modalIconBg').className = 'w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg bg-green-600';
        document.getElementById('modalIcon').className = 'fas fa-check';
        document.getElementById('modalSubmitBtn').className = 'px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg shadow-sm';
        document.getElementById('catatanReqLabel').innerText = '(Opsional)';
        document.getElementById('modalCatatan').placeholder = 'Contoh: Dokumen lengkap dan terverifikasi.';
    }

    function openProsesModal(id, nama) {
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('modalForm').action = '{{ url("admin/pengajuan") }}/' + id;
        document.getElementById('modalStatusInput').value = 'diproses';
        document.getElementById('modalId').innerText = String(id).padStart(4, '0');
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalTitle').innerText = 'Tandai Sedang Diproses';
        document.getElementById('modalIconBg').className = 'w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg bg-blue-600';
        document.getElementById('modalIcon').className = 'fas fa-spinner';
        document.getElementById('modalSubmitBtn').className = 'px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm';
        document.getElementById('catatanReqLabel').innerText = '(Opsional)';
        document.getElementById('modalCatatan').placeholder = 'Contoh: Sedang dalam proses verifikasi dokumen oleh petugas.';
    }

    function openRejectModal(id, nama) {
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('modalForm').action = '{{ url("admin/pengajuan") }}/' + id;
        document.getElementById('modalStatusInput').value = 'ditolak';
        document.getElementById('modalId').innerText = String(id).padStart(4, '0');
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalTitle').innerText = 'Tolak Pengajuan';
        document.getElementById('modalIconBg').className = 'w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg bg-red-600';
        document.getElementById('modalIcon').className = 'fas fa-times';
        document.getElementById('modalSubmitBtn').className = 'px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm';
        document.getElementById('catatanReqLabel').innerText = '(Disarankan)';
        document.getElementById('modalCatatan').placeholder = 'Contoh: Dokumen persyaratan tidak sesuai / belum ditandatangani.';
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }
</script>
@endsection
