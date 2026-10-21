@extends('layouts.admin')

@section('title', 'Kelola Ticker Bar')
@section('page-title', 'Kelola Ticker Bar')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Info --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
        <i class="fas fa-info-circle text-blue-500 mt-0.5 flex-shrink-0"></i>
        <div class="text-sm text-blue-800">
            Setiap baris adalah satu info berbeda yang akan ditampilkan berurutan di ticker bar beranda, dipisahkan dengan tanda <strong>•</strong>.
        </div>
    </div>

    {{-- Live Preview --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-3">
        <h2 class="font-bold text-gray-900 text-sm uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-eye text-blue-600"></i> Live Preview
        </h2>
        <div style="background:#991b1b;border-radius:8px;overflow:hidden;height:32px;display:flex;align-items:center;">
            <div style="flex:1;overflow:hidden;display:flex;align-items:center;">
                <div id="ticker-preview" style="display:inline-block;white-space:nowrap;padding-left:100%;animation:ticker 20s linear infinite;font-size:11.5px;font-weight:600;color:rgba(255,255,255,0.9);letter-spacing:.04em;">
                    —
                </div>
            </div>
        </div>
        <style>@keyframes ticker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }</style>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-1">Daftar Info Ticker</h2>
        <p class="text-xs text-gray-500 mb-5">Tambah, edit, atau hapus item. Setiap baris tampil sebagai satu info berbeda.</p>

        <form action="{{ route('admin.ticker.update') }}" method="POST" id="form-ticker" class="space-y-4">
            @csrf
            <div id="ticker-list" class="space-y-2">
                @foreach($items as $i => $item)
                <div class="ticker-item flex gap-2 items-center">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold item-number">
                        {{ $i + 1 }}
                    </div>
                    <input type="text" name="items[]" value="{{ old("items.$i", $item) }}"
                        class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Tulis info ticker..." required>
                    <button type="button" onclick="removeItem(this)"
                        class="flex-shrink-0 w-7 h-7 bg-gray-100 hover:bg-red-100 hover:text-red-600 text-gray-400 rounded-lg flex items-center justify-center transition-colors text-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endforeach
            </div>

            <button type="button" onclick="addItem()"
                class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors px-1 py-1">
                <i class="fas fa-plus-circle"></i> Tambah Info
            </button>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-lg text-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function getValues() {
        return [...document.querySelectorAll('#ticker-list input[name="items[]"]')]
            .map(i => i.value.trim()).filter(v => v);
    }

    function updatePreview() {
        const vals = getValues();
        const text = vals.length ? vals.join(' \u00a0\u2022\u00a0 ') : '—';
        const full = text + ' \u00a0\u2022\u00a0 ' + text + ' \u00a0\u2022\u00a0 ';
        document.getElementById('ticker-preview').textContent = full;
    }

    function updateNumbers() {
        document.querySelectorAll('.ticker-item').forEach((el, i) => {
            el.querySelector('.item-number').textContent = i + 1;
        });
    }

    function addItem() {
        const list = document.getElementById('ticker-list');
        const div = document.createElement('div');
        div.className = 'ticker-item flex gap-2 items-center';
        div.innerHTML = `
            <div class="flex-shrink-0 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold item-number">?</div>
            <input type="text" name="items[]"
                class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Tulis info ticker..." required>
            <button type="button" onclick="removeItem(this)"
                class="flex-shrink-0 w-7 h-7 bg-gray-100 hover:bg-red-100 hover:text-red-600 text-gray-400 rounded-lg flex items-center justify-center transition-colors text-sm">
                <i class="fas fa-times"></i>
            </button>`;
        list.appendChild(div);
        div.querySelector('input').addEventListener('input', updatePreview);
        div.querySelector('input').focus();
        updateNumbers();
        updatePreview();
    }

    function removeItem(btn) {
        const items = document.querySelectorAll('.ticker-item');
        if (items.length <= 1) { alert('Minimal harus ada 1 item.'); return; }
        btn.closest('.ticker-item').remove();
        updateNumbers();
        updatePreview();
    }

    document.querySelectorAll('#ticker-list input').forEach(i => i.addEventListener('input', updatePreview));
    updatePreview();
</script>
@endpush
