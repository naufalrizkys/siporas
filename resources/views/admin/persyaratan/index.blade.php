@extends('layouts.admin')

@section('title', 'Kelola Persyaratan Dokumen')
@section('page-title', 'Kelola Persyaratan Dokumen')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Info Card --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
        <i class="fas fa-info-circle text-blue-500 mt-0.5 flex-shrink-0"></i>
        <div class="text-sm text-blue-800">
            Persyaratan yang diisi di sini akan tampil di modal <strong>"Persyaratan Dokumen"</strong> pada halaman beranda.
            Kamu bisa menambah, mengedit, menghapus, atau mengubah urutan item kapan saja.
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-1">Daftar Persyaratan</h2>
        <p class="text-xs text-gray-500 mb-5">Setiap baris adalah satu item persyaratan. Gunakan tombol <strong>+ Tambah</strong> untuk menambah baris baru, atau <strong>×</strong> untuk menghapus.</p>

        <form action="{{ route('admin.persyaratan.update') }}" method="POST" id="form-persyaratan" class="space-y-4">
            @csrf

            <div id="persyaratan-list" class="space-y-3">
                @foreach($persyaratan as $i => $item)
                <div class="persyaratan-item flex gap-2 items-start" draggable="true">
                    <div class="flex-shrink-0 mt-2.5 cursor-grab text-gray-300 hover:text-gray-500 drag-handle">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    <div class="flex-shrink-0 w-7 h-7 bg-red-600 rounded-full flex items-center justify-center text-white text-xs font-bold mt-1.5 item-number">
                        {{ $i + 1 }}
                    </div>
                    <textarea name="persyaratan[]" rows="2"
                        class="flex-1 border border-gray-200 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"
                        placeholder="Tulis persyaratan..." required>{{ old("persyaratan.$i", $item) }}</textarea>
                    <button type="button" onclick="removeItem(this)"
                        class="flex-shrink-0 w-7 h-7 bg-gray-100 hover:bg-red-100 hover:text-red-600 text-gray-400 rounded-lg flex items-center justify-center transition-colors mt-1.5 text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endforeach
            </div>

            <button type="button" onclick="addItem()"
                class="flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-800 transition-colors px-1 py-1">
                <i class="fas fa-plus-circle"></i> Tambah Persyaratan
            </button>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('home') }}" target="_blank"
                    class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1.5 transition-colors">
                    <i class="fas fa-external-link-alt text-xs"></i> Lihat di Beranda
                </a>
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-2.5 rounded-lg text-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function addItem() {
        const list = document.getElementById('persyaratan-list');
        const div = document.createElement('div');
        div.className = 'persyaratan-item flex gap-2 items-start';
        div.setAttribute('draggable', 'true');
        div.innerHTML = `
            <div class="flex-shrink-0 mt-2.5 cursor-grab text-gray-300 hover:text-gray-500 drag-handle">
                <i class="fas fa-grip-vertical"></i>
            </div>
            <div class="flex-shrink-0 w-7 h-7 bg-red-600 rounded-full flex items-center justify-center text-white text-xs font-bold mt-1.5 item-number">
                ?
            </div>
            <textarea name="persyaratan[]" rows="2"
                class="flex-1 border border-gray-200 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 resize-none"
                placeholder="Tulis persyaratan..." required></textarea>
            <button type="button" onclick="removeItem(this)"
                class="flex-shrink-0 w-7 h-7 bg-gray-100 hover:bg-red-100 hover:text-red-600 text-gray-400 rounded-lg flex items-center justify-center transition-colors mt-1.5 text-sm">
                <i class="fas fa-times"></i>
            </button>
        `;
        list.appendChild(div);
        addDragEvents(div);
        updateNumbers();
        div.querySelector('textarea').focus();
    }

    function removeItem(btn) {
        const items = document.querySelectorAll('.persyaratan-item');
        if (items.length <= 1) {
            alert('Minimal harus ada 1 persyaratan.');
            return;
        }
        btn.closest('.persyaratan-item').remove();
        updateNumbers();
    }

    function updateNumbers() {
        document.querySelectorAll('.persyaratan-item').forEach((el, i) => {
            el.querySelector('.item-number').textContent = i + 1;
        });
    }

    // ── Drag & Drop reorder ─────────────────────────────────────────────────
    let dragSrc = null;

    function addDragEvents(el) {
        el.addEventListener('dragstart', function (e) {
            dragSrc = this;
            this.style.opacity = '0.4';
            e.dataTransfer.effectAllowed = 'move';
        });
        el.addEventListener('dragend', function () {
            this.style.opacity = '1';
            updateNumbers();
        });
        el.addEventListener('dragover', function (e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            this.style.background = '#fef2f2';
        });
        el.addEventListener('dragleave', function () {
            this.style.background = '';
        });
        el.addEventListener('drop', function (e) {
            e.stopPropagation();
            this.style.background = '';
            if (dragSrc !== this) {
                const list = document.getElementById('persyaratan-list');
                const allItems = [...list.querySelectorAll('.persyaratan-item')];
                const srcIdx = allItems.indexOf(dragSrc);
                const tgtIdx = allItems.indexOf(this);
                if (srcIdx < tgtIdx) {
                    this.after(dragSrc);
                } else {
                    this.before(dragSrc);
                }
                updateNumbers();
            }
        });
    }

    document.querySelectorAll('.persyaratan-item').forEach(addDragEvents);
</script>
@endpush
