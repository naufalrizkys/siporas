@extends('layouts.app')

@section('title', 'Ajukan Layanan')

@section('content')
{{-- Page Header --}}
<div style="background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);" class="text-white py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-red-100 text-xs mb-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fas fa-chevron-right text-xs opacity-75"></i>
            <span class="text-white font-semibold">Pendaftaran Online</span>
        </div>
        <h1 class="text-3xl font-bold">Pengajuan Layanan</h1>
        <p class="text-red-100 mt-1">Isi formulir berikut untuk mengajukan layanan ormas secara online</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Step Info --}}
    <div class="grid grid-cols-3 gap-4 mb-8 text-center text-sm">
        <div class="flex flex-col items-center gap-2">
            <div class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center font-bold">1</div>
            <span class="font-semibold text-blue-700">Isi Formulir</span>
        </div>
        <div class="flex flex-col items-center gap-2">
            <div class="w-10 h-10 bg-gray-200 text-gray-400 rounded-full flex items-center justify-center font-bold">2</div>
            <span class="text-gray-400">Verifikasi</span>
        </div>
        <div class="flex flex-col items-center gap-2">
            <div class="w-10 h-10 bg-gray-200 text-gray-400 rounded-full flex items-center justify-center font-bold">3</div>
            <span class="text-gray-400">Selesai</span>
        </div>
    </div>

    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Data Pemohon --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                <i class="fas fa-user text-purple-500"></i> Data Pemohon
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}"
                        class="w-full border @error('nama_pemohon') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        placeholder="Masukkan nama lengkap">
                    @error('nama_pemohon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                        class="w-full border @error('nik') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        placeholder="16 digit NIK">
                    @error('nik')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}"
                        class="w-full border @error('telepon') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        placeholder="08xxxxxxxxxx">
                    @error('telepon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border @error('email') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        placeholder="email@contoh.com">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Jenis Layanan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                <i class="fas fa-clipboard-list text-purple-500"></i> Jenis Layanan
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">
                @php
                $layananList = [
                    'pendaftaran_ormas' => ['icon'=>'fas fa-plus-circle','label'=>'Pendaftaran Ormas Baru','desc'=>'Daftarkan ormas baru dan dapatkan SKT'],
                    'perpanjangan_skt'  => ['icon'=>'fas fa-sync-alt','label'=>'Perpanjangan SKT','desc'=>'Perbarui masa berlaku SKT ormas'],
                    'perubahan_data'    => ['icon'=>'fas fa-edit','label'=>'Perubahan Data','desc'=>'Update data dan informasi ormas'],
                    'pencabutan_skt'    => ['icon'=>'fas fa-times-circle','label'=>'Pencabutan SKT','desc'=>'Ajukan pencabutan SKT ormas'],
                    'surat_keterangan'  => ['icon'=>'fas fa-file-certificate','label'=>'Surat Keterangan','desc'=>'Permintaan surat keterangan'],
                ];
                @endphp
                @foreach($layananList as $val => $item)
                <label class="flex items-start gap-3 p-3 border-2 rounded-xl cursor-pointer transition-all
                    {{ old('jenis_layanan') == $val ? 'border-blue-500 bg-blue-50' : 'border-gray-100 hover:border-blue-200' }}">
                    <input type="radio" name="jenis_layanan" value="{{ $val }}" {{ old('jenis_layanan') == $val ? 'checked' : '' }}
                        class="mt-0.5 accent-blue-600">
                    <div>
                        <div class="flex items-center gap-2 font-medium text-sm text-gray-900">
                            <i class="{{ $item['icon'] }} text-blue-500"></i>
                            {{ $item['label'] }}
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item['desc'] }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            @error('jenis_layanan')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ormas Terkait <span class="text-gray-400 font-normal">(jika ada)</span></label>
                <select name="ormas_id"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="">-- Pilih Ormas --</option>
                    @foreach($ormasList as $o)
                        <option value="{{ $o->id }}" {{ old('ormas_id', request('ormas_id')) == $o->id ? 'selected' : '' }}>
                            {{ $o->nama_ormas }}@if($o->singkatan) ({{ $o->singkatan }})@endif
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Keterangan & Dokumen --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                <i class="fas fa-paperclip text-purple-500"></i> Keterangan & Dokumen
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Catatan</label>
                    <textarea name="keterangan" rows="4"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none"
                        placeholder="Tuliskan keterangan tambahan atau informasi yang diperlukan...">{{ old('keterangan') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Dokumen <span class="text-red-600 font-semibold">(Format PDF, Maks. 10MB)</span></label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-blue-300 transition-colors">
                        <i class="fas fa-file-pdf text-3xl text-red-500 mb-2"></i>
                        <p class="text-sm text-gray-500 mb-3">Pilih file berformat PDF (Maks. 10MB)</p>
                        <label class="inline-flex items-center gap-2 border-2 border-red-700 text-red-700 hover:bg-red-50 font-semibold px-4 py-2 rounded-lg text-sm cursor-pointer transition-colors">
                            <i class="fas fa-folder-open"></i> Pilih File PDF
                            <input type="file" name="dokumen" accept=".pdf,application/pdf" class="hidden" onchange="showFileName(this)">
                        </label>
                        <p id="file-name" class="text-xs text-gray-400 mt-2 hidden"></p>
                    </div>
                    @error('dokumen')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-end">
            <a href="{{ route('home') }}" class="border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold px-5 py-2.5 rounded-lg transition inline-flex items-center gap-2 text-sm">Batal</a>
            <button type="submit" style="background:#ffffff;" class="hover:opacity-90 text-white font-semibold px-5 py-2.5 rounded-lg transition inline-flex items-center gap-2 text-sm">
                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function showFileName(input) {
    const p = document.getElementById('file-name');
    if (input.files[0]) {
        p.textContent = '📎 ' + input.files[0].name;
        p.classList.remove('hidden');
    }
}
// Highlight layanan yang dipilih
document.querySelectorAll('input[name="jenis_layanan"]').forEach(radio => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('input[name="jenis_layanan"]').forEach(r => {
            r.closest('label').classList.remove('border-blue-500', 'bg-blue-50');
            r.closest('label').classList.add('border-gray-100');
        });
        if (radio.checked) {
            radio.closest('label').classList.add('border-blue-500', 'bg-blue-50');
            radio.closest('label').classList.remove('border-gray-100');
        }
    });
});
</script>
@endpush
@endsection
