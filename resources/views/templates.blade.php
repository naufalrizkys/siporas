@extends('layouts.app')

@section('title', 'Template Formulir')

@section('content')

{{-- Hero --}}
<div class="bg-red-700 py-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8">
        <div class="flex items-center gap-2 text-red-200 text-xs mb-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fas fa-chevron-right text-xs opacity-75"></i>
            <span class="text-white font-semibold">Template Formulir</span>
        </div>
        <h1 class="text-2xl font-black text-white mb-1">Template Formulir Pengajuan</h1>
        <p class="text-red-200 text-sm">Unduh template resmi Kesbangpol Kab. Grobogan untuk melengkapi berkas pengajuan.</p>
    </div>
</div>

{{-- Content --}}
<div class="py-10 bg-gray-50">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8">

        @if($templates->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm text-center py-16 text-gray-400">
            <i class="fas fa-folder-open text-5xl mb-4 block opacity-30"></i>
            <p class="font-bold text-gray-500 mb-1">Belum Ada Template</p>
            <p class="text-sm">Template belum tersedia. Silakan hubungi admin.</p>
        </div>
        @else

        {{-- Toolbar --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="select-all" onchange="toggleAll(this)"
                           class="w-4 h-4 rounded accent-red-700 cursor-pointer">
                    <label for="select-all" class="text-sm font-bold text-gray-700 cursor-pointer">Pilih Semua</label>
                    <span id="selected-count" class="text-xs text-gray-400 ml-1">0 dipilih</span>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="downloadSelected()"
                            class="inline-flex items-center gap-1.5 bg-gray-800 hover:bg-gray-700 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-colors">
                        <i class="fas fa-check-square"></i> Unduh Terpilih
                    </button>
                    <a href="{{ route('templates.download') }}"
                       class="inline-flex items-center gap-1.5 bg-red-700 hover:bg-red-800 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-colors">
                        <i class="fas fa-download"></i> Unduh Semua (.zip)
                    </a>
                </div>
            </div>

            {{-- List --}}
            <div class="divide-y divide-gray-100" id="template-list">
                @foreach($templates as $tpl)
                @php
                    $isPdf     = str_ends_with(strtolower($tpl->file_name), '.pdf');
                    $iconClass = $isPdf ? 'fas fa-file-pdf' : 'fas fa-file-word';
                    $iconColor = $isPdf ? '#b91c1c' : '#1d4ed8';
                    $iconBg    = $isPdf ? '#fef2f2' : '#eff6ff';
                @endphp
                <div class="flex items-center gap-4 px-6 py-5 hover:bg-gray-50 transition-colors">
                    <input type="checkbox" name="templates[]" value="{{ $tpl->id }}"
                           id="tpl-{{ $tpl->id }}" onchange="updateCount()"
                           class="w-4 h-4 rounded accent-red-700 cursor-pointer flex-shrink-0">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $iconBg }}">
                        <i class="{{ $iconClass }} text-lg" style="color:{{ $iconColor }}"></i>
                    </div>
                    <label for="tpl-{{ $tpl->id }}" class="flex-1 min-w-0 cursor-pointer">
                        <p class="font-bold text-gray-900">{{ $tpl->judul }}</p>
                        @if($tpl->deskripsi)
                        <p class="text-sm text-gray-500 mt-0.5">{{ $tpl->deskripsi }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-0.5">{{ $tpl->file_name }} &bull; {{ $tpl->file_size_formatted }}</p>
                    </label>
                </div>
                @endforeach
            </div>

            {{-- Footer --}}
            <div class="bg-yellow-50 border-t border-yellow-100 px-6 py-3 flex items-start gap-2 text-sm text-yellow-800">
                <i class="fas fa-info-circle text-yellow-500 mt-0.5 flex-shrink-0"></i>
                <span>Isi formulir, tanda tangani, beri cap stempel, lalu scan/foto dan upload saat mengajukan laporan keberadaan ormas.</span>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateCount() {
        const total   = document.querySelectorAll('#template-list input[type=checkbox]').length;
        const checked = document.querySelectorAll('#template-list input[type=checkbox]:checked').length;
        document.getElementById('selected-count').textContent = checked + ' dipilih';
        const selAll = document.getElementById('select-all');
        if (selAll) {
            selAll.indeterminate = checked > 0 && checked < total;
            selAll.checked = total > 0 && checked === total;
        }
    }
    function toggleAll(cb) {
        document.querySelectorAll('#template-list input[type=checkbox]').forEach(c => c.checked = cb.checked);
        updateCount();
    }
    function downloadSelected() {
        const checked = [...document.querySelectorAll('#template-list input[type=checkbox]:checked')];
        if (checked.length === 0) { alert('Pilih minimal satu template.'); return; }
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("templates.download.selected") }}';
        const csrf = document.createElement('input');
        csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden'; input.name = 'files[]'; input.value = cb.value;
            form.appendChild(input);
        });
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>
@endpush
