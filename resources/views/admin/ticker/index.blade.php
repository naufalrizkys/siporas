@extends('layouts.admin')

@section('title', 'Kelola Running Text')
@section('page-title', 'Kelola Running Text / Ticker Bar')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Live Preview Card --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-3">
        <h2 class="font-bold text-gray-900 text-sm uppercase tracking-wider flex items-center gap-2">
            <i class="fas fa-eye text-blue-600"></i> Live Preview Ticker Bar
        </h2>
        <p class="text-xs text-gray-500">Pratinjau tampilan teks berjalan yang akan muncul pada beranda utama website:</p>

        <div class="bg-gray-100 border border-gray-200 rounded-lg p-2">
            <div class="bg-white border border-gray-200 rounded px-4 py-2 flex items-center overflow-hidden">
                <div class="ticker-wrap flex-1 overflow-hidden whitespace-nowrap">
                    <span id="ticker-preview-text" class="inline-block text-sm font-medium text-gray-700">
                        {{ $runningText }} &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp; {{ $runningText }} &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Edit Ticker Bar --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-1">Edit Teks Berjalan</h2>
        <p class="text-xs text-gray-500 mb-5">Ubah isi teks informasi running text yang berjalan di bagian atas halaman beranda.</p>

        <form action="{{ route('admin.ticker.update') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                    Isi Teks Berjalan <span class="text-red-500">*</span>
                </label>
                <textarea id="running_text_input" name="running_text" rows="3"
                    class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan teks running text..." required>{{ old('running_text', $runningText) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Tips: Tulis pesan atau pengumuman penting secara singkat dan jelas.</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-lg text-sm transition-colors flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    const input = document.getElementById('running_text_input');
    const preview = document.getElementById('ticker-preview-text');

    input?.addEventListener('input', function() {
        const val = this.value.trim() || 'GERAKAN INDONESIA SADAR ADMINISTRASI KEPENDUDUKAN';
        preview.innerHTML = val + ' &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp; ' + val + ' &nbsp;&nbsp;&nbsp;•&nbsp;&nbsp;&nbsp;';
    });
</script>
@endpush
@endsection
