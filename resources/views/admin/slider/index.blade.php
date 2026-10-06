@extends('layouts.admin')

@section('title', 'Kelola Slider')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Kelola Slider Beranda</h1>
            <p class="text-sm text-gray-500 mt-0.5">Atur foto yang tampil di hero slider halaman utama</p>
        </div>
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
                class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg transition-colors">
            <i class="fas fa-plus text-xs"></i> Tambah Foto
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3 mb-5 flex items-center gap-2">
        <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Tabel Slider --}}
    @if($sliders->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
        <i class="fas fa-images text-5xl text-gray-200 mb-4 block"></i>
        <p class="text-gray-500 font-medium">Belum ada foto slider.</p>
        <p class="text-gray-400 text-sm mt-1">Klik "Tambah Foto" untuk mengunggah foto pertama.</p>
    </div>
    @else
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-700 text-gray-600 uppercase text-xs tracking-wider">Foto</th>
                    <th class="text-left px-4 py-3 font-700 text-gray-600 uppercase text-xs tracking-wider">Judul</th>
                    <th class="text-left px-4 py-3 font-700 text-gray-600 uppercase text-xs tracking-wider w-16">Urutan</th>
                    <th class="text-left px-4 py-3 font-700 text-gray-600 uppercase text-xs tracking-wider w-24">Status</th>
                    <th class="text-right px-4 py-3 font-700 text-gray-600 uppercase text-xs tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($sliders as $slider)
                <tr class="hover:bg-gray-50 transition-colors">
                    {{-- Foto preview --}}
                    <td class="px-4 py-3">
                        <div class="w-28 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                            <img src="{{ Storage::url($slider->gambar) }}"
                                 alt="{{ $slider->judul }}"
                                 class="w-full h-full object-cover">
                        </div>
                    </td>
                    {{-- Judul & deskripsi --}}
                    <td class="px-4 py-3">
                        <div class="font-600 text-gray-900">{{ $slider->judul ?: '—' }}</div>
                        @if($slider->deskripsi)
                        <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $slider->deskripsi }}</div>
                        @endif
                        @if($slider->link)
                        <div class="text-xs text-blue-500 mt-0.5 truncate max-w-xs">{{ $slider->link }}</div>
                        @endif
                    </td>
                    {{-- Urutan --}}
                    <td class="px-4 py-3 text-gray-600 font-600">{{ $slider->urutan }}</td>
                    {{-- Status --}}
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.slider.toggle', $slider) }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 text-xs font-700 px-3 py-1.5 rounded-full border transition-colors
                                           {{ $slider->aktif
                                              ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100'
                                              : 'bg-gray-100 text-gray-500 border-gray-200 hover:bg-gray-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $slider->aktif ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $slider->aktif ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    {{-- Aksi --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Edit --}}
                            <button onclick="openEdit({{ $slider->id }}, '{{ addslashes($slider->judul) }}', '{{ addslashes($slider->deskripsi) }}', '{{ $slider->link }}', {{ $slider->urutan }})"
                                    class="text-xs font-600 text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                <i class="fas fa-pen text-xs mr-1"></i> Edit
                            </button>
                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('admin.slider.destroy', $slider) }}"
                                  onsubmit="return confirm('Hapus foto ini dari slider?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs font-600 text-gray-500 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                                    <i class="fas fa-trash text-xs mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="text-xs text-gray-400 mt-3">
        <i class="fas fa-info-circle mr-1"></i>
        Slider akan tampil sesuai urutan (angka terkecil tampil pertama). Klik status untuk mengaktifkan / menonaktifkan.
    </p>
    @endif
</div>

{{-- ════ MODAL TAMBAH ════ --}}
<div id="modal-tambah" onclick="if(event.target===this) this.classList.add('hidden')" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-800 text-gray-900 text-base">Tambah Foto Slider</h2>
            <button onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.slider.store') }}" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            @csrf
            {{-- Upload foto --}}
            <div>
                <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">
                    Foto <span class="text-gray-900">*</span>
                </label>
                <label id="drop-zone" class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl h-36 cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-gray-400 transition-colors relative overflow-hidden">
                    <input type="file" name="gambar" accept="image/*" required class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImg(this)">
                    <div id="drop-placeholder">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block text-center"></i>
                        <p class="text-sm text-gray-400 text-center">Klik atau seret foto ke sini</p>
                        <p class="text-xs text-gray-300 text-center mt-1">JPG, PNG, WEBP — maks. 4 MB</p>
                    </div>
                    <img id="drop-preview" src="" alt="" class="hidden absolute inset-0 w-full h-full object-cover">
                </label>
            </div>
            {{-- Judul --}}
            <div>
                <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Judul <span class="text-gray-400 font-400 normal-case">(opsional)</span></label>
                <input type="text" name="judul" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400" placeholder="Judul slide">
            </div>
            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Deskripsi <span class="text-gray-400 font-400 normal-case">(opsional)</span></label>
                <textarea name="deskripsi" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 resize-none" placeholder="Keterangan singkat"></textarea>
            </div>
            {{-- Link & Urutan --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Link URL <span class="text-gray-400 font-400 normal-case">(opsional)</span></label>
                    <input type="url" name="link" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Urutan</label>
                    <input type="number" name="urutan" value="0" min="0" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400">
                </div>
            </div>
            {{-- Tombol --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                        class="text-sm font-600 text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="text-sm font-700 bg-gray-900 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-upload mr-1.5"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ════ MODAL EDIT ════ --}}
<div id="modal-edit" onclick="if(event.target===this) this.classList.add('hidden')" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-800 text-gray-900 text-base">Edit Slider</h2>
            <button onclick="document.getElementById('modal-edit').classList.add('hidden')" class="text-gray-400 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="edit-form" method="POST" action="" enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            @csrf
            {{-- Ganti foto --}}
            <div>
                <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">
                    Ganti Foto <span class="text-gray-400 font-400 normal-case">(kosongkan jika tidak diganti)</span>
                </label>
                <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl h-28 cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors relative overflow-hidden">
                    <input type="file" name="gambar" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewEditImg(this)">
                    <div id="edit-placeholder">
                        <i class="fas fa-camera text-2xl text-gray-300 mb-1 block text-center"></i>
                        <p class="text-xs text-gray-400 text-center">Klik untuk pilih foto baru</p>
                    </div>
                    <img id="edit-preview" src="" alt="" class="hidden absolute inset-0 w-full h-full object-cover">
                </label>
            </div>
            <div>
                <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Judul</label>
                <input type="text" name="judul" id="edit-judul" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400" placeholder="Judul slide">
            </div>
            <div>
                <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" id="edit-deskripsi" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400 resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Link URL</label>
                    <input type="url" name="link" id="edit-link" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-xs font-700 text-gray-600 uppercase tracking-wider mb-1.5">Urutan</label>
                    <input type="number" name="urutan" id="edit-urutan" min="0" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-gray-400">
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')"
                        class="text-sm font-600 text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                        class="text-sm font-700 bg-gray-900 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-1.5"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImg(input) {
        if (!input.files || !input.files[0]) return;
        const url = URL.createObjectURL(input.files[0]);
        document.getElementById('drop-placeholder').classList.add('hidden');
        const img = document.getElementById('drop-preview');
        img.src = url;
        img.classList.remove('hidden');
    }

    function previewEditImg(input) {
        if (!input.files || !input.files[0]) return;
        const url = URL.createObjectURL(input.files[0]);
        document.getElementById('edit-placeholder').classList.add('hidden');
        const img = document.getElementById('edit-preview');
        img.src = url;
        img.classList.remove('hidden');
    }

    function openEdit(id, judul, deskripsi, link, urutan) {
        document.getElementById('edit-form').action = '{{ url("admin/slider") }}/' + id;
        document.getElementById('edit-judul').value    = judul;
        document.getElementById('edit-deskripsi').value = deskripsi;
        document.getElementById('edit-link').value    = link;
        document.getElementById('edit-urutan').value  = urutan;
        // reset preview
        document.getElementById('edit-placeholder').classList.remove('hidden');
        document.getElementById('edit-preview').classList.add('hidden');
        document.getElementById('modal-edit').classList.remove('hidden');
    }
</script>
@endsection
