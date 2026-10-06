@extends('layouts.admin')

@section('title', 'Kelola Template')
@section('page-title', 'Kelola Template Dokumen')

@section('content')
<div class="space-y-6">

    {{-- Form Tambah --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-plus-circle text-red-700"></i> Tambah Template Baru
        </h2>
        <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Judul Template <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                           placeholder="Contoh: Formulir Isian Data Ormas"
                           class="w-full border @error('judul') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" placeholder="Penjelasan singkat isi template..."
                              class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 resize-none">{{ old('deskripsi') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">File <span class="text-red-500">*</span> <span class="text-gray-400 font-normal normal-case">(PDF, DOC, DOCX, XLS, XLSX — maks 10MB)</span></label>
                    <input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx"
                           class="w-full border @error('file') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-300">
                    @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Urutan</label>
                        <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300">
                    </div>
                    <div class="flex items-center gap-2 pb-2.5">
                        <input type="checkbox" name="aktif" id="aktif-new" value="1" checked class="w-4 h-4 accent-red-700">
                        <label for="aktif-new" class="text-sm font-medium text-gray-700">Aktif / Tampil</label>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold px-6 py-2.5 rounded-lg text-sm flex items-center gap-2 transition-colors">
                    <i class="fas fa-upload"></i> Upload Template
                </button>
            </div>
        </form>
    </div>

    {{-- Daftar Template --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-file-alt text-gray-400"></i> Daftar Template
            </h2>
            <span class="text-xs text-gray-400">{{ $templates->count() }} template</span>
        </div>

        @if($templates->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <i class="fas fa-folder-open text-4xl mb-3 block opacity-30"></i>
            <p class="text-sm">Belum ada template. Tambahkan di atas.</p>
        </div>
        @else
        <div class="divide-y divide-gray-50">
            @foreach($templates as $tpl)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors">
                {{-- Icon --}}
                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
                    {{ str_ends_with($tpl->file_name, '.pdf') ? 'bg-red-50' : 'bg-blue-50' }}">
                    <i class="{{ str_ends_with($tpl->file_name, '.pdf') ? 'fas fa-file-pdf text-red-600' : 'fas fa-file-word text-blue-600' }}"></i>
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-bold text-gray-900 text-sm">{{ $tpl->judul }}</span>
                        @if(!$tpl->aktif)
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Nonaktif</span>
                        @else
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Aktif</span>
                        @endif
                    </div>
                    @if($tpl->deskripsi)
                    <p class="text-xs text-gray-500 truncate mt-0.5">{{ $tpl->deskripsi }}</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $tpl->file_name }} &bull; {{ $tpl->file_size_formatted }} &bull; Urutan: {{ $tpl->urutan }}
                    </p>
                </div>

                {{-- Aksi --}}
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ Storage::url($tpl->file_path) }}" target="_blank"
                       class="text-blue-600 hover:text-blue-800 text-xs font-semibold flex items-center gap-1 px-2 py-1 rounded hover:bg-blue-50 transition-colors"
                       title="Preview">
                        <i class="fas fa-eye"></i>
                    </a>

                    {{-- Toggle Aktif --}}
                    <form action="{{ route('admin.template.toggle', $tpl) }}" method="POST">
                        @csrf
                        <button type="submit" title="{{ $tpl->aktif ? 'Nonaktifkan' : 'Aktifkan' }}"
                                class="{{ $tpl->aktif ? 'text-green-600 hover:text-green-800 hover:bg-green-50' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' }} text-xs px-2 py-1 rounded transition-colors">
                            <i class="fas fa-{{ $tpl->aktif ? 'toggle-on' : 'toggle-off' }}"></i>
                        </button>
                    </form>

                    {{-- Edit --}}
                    <button onclick="openEdit({{ $tpl->id }}, '{{ addslashes($tpl->judul) }}', '{{ addslashes($tpl->deskripsi ?? '') }}', {{ $tpl->urutan }}, {{ $tpl->aktif ? 'true' : 'false' }}, '{{ $tpl->file_name }}')"
                            class="text-yellow-600 hover:text-yellow-800 text-xs px-2 py-1 rounded hover:bg-yellow-50 transition-colors" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>

                    {{-- Hapus --}}
                    <form action="{{ route('admin.template.destroy', $tpl) }}" method="POST"
                          onsubmit="return confirm('Hapus template {{ addslashes($tpl->judul) }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs px-2 py-1 rounded hover:bg-red-50 transition-colors" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- Modal Edit --}}
<div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-lg mx-4">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-edit text-yellow-600"></i> Edit Template
        </h3>
        <form id="edit-form" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="edit-judul" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="edit-deskripsi" rows="2"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                    Ganti File <span class="text-gray-400 font-normal normal-case">(kosongkan jika tidak diganti)</span>
                </label>
                <p id="edit-current-file" class="text-xs text-gray-500 mb-1"></p>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-300">
            </div>
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Urutan</label>
                    <input type="number" name="urutan" id="edit-urutan" min="0"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-300">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="aktif" id="edit-aktif" value="1" class="w-4 h-4 accent-red-700">
                    <label for="edit-aktif" class="text-sm font-medium text-gray-700">Aktif</label>
                </div>
            </div>
            <div class="flex gap-3 justify-end pt-2">
                <button type="button" onclick="closeEdit()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="bg-red-700 hover:bg-red-800 text-white font-bold px-5 py-2.5 rounded-lg text-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openEdit(id, judul, deskripsi, urutan, aktif, fileName) {
        document.getElementById('edit-judul').value      = judul;
        document.getElementById('edit-deskripsi').value  = deskripsi;
        document.getElementById('edit-urutan').value     = urutan;
        document.getElementById('edit-aktif').checked    = aktif;
        document.getElementById('edit-current-file').textContent = 'File saat ini: ' + fileName;
        document.getElementById('edit-form').action = '/admin/template/' + id;
        document.getElementById('edit-modal').classList.remove('hidden');
        document.getElementById('edit-modal').classList.add('flex');
    }

    function closeEdit() {
        document.getElementById('edit-modal').classList.add('hidden');
        document.getElementById('edit-modal').classList.remove('flex');
    }

    document.getElementById('edit-modal').addEventListener('click', function(e) {
        if (e.target === this) closeEdit();
    });
</script>
@endpush
