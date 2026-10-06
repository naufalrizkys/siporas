@extends('layouts.admin')

@section('title', isset($ormas->id) ? 'Edit Ormas' : 'Tambah Ormas')
@section('page-title', isset($ormas->id) ? 'Edit Ormas' : 'Tambah Ormas')

@section('content')
<div class="max-w-3xl">
    <form action="{{ isset($ormas->id) ? route('admin.ormas.update', $ormas) : route('admin.ormas.store') }}"
          method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($ormas->id)) @method('PUT') @endif

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-red-600 mb-5">Informasi Dasar</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ormas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ormas" value="{{ old('nama_ormas', $ormas->nama_ormas) }}"
                        class="w-full border @error('nama_ormas') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    @error('nama_ormas')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Singkatan</label>
                    <input type="text" name="singkatan" value="{{ old('singkatan', $ormas->singkatan) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bidang Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="bidang_kegiatan" value="{{ old('bidang_kegiatan', $ormas->bidang_kegiatan) }}"
                        class="w-full border @error('bidang_kegiatan') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        placeholder="Contoh: Sosial, Pendidikan, Keagamaan">
                    @error('bidang_kegiatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SKT</label>
                    <input type="text" name="nomor_skt" value="{{ old('nomor_skt', $ormas->nomor_skt) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berdiri</label>
                    <input type="date" name="tanggal_berdiri" value="{{ old('tanggal_berdiri', $ormas->tanggal_berdiri?->format('Y-m-d')) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="aktif" {{ old('status', $ormas->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $ormas->status) === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="menunggu" {{ old('status', $ormas->status) === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-red-600 mb-5">Visi & Misi</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Visi</label>
                    <textarea name="visi" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none">{{ old('visi', $ormas->visi) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Misi</label>
                    <textarea name="misi" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none">{{ old('misi', $ormas->misi) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-red-600 mb-5">Alamat & Pin Point Lokasi</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Sekretariat <span class="text-red-500">*</span></label>
                    <textarea name="alamat_sekretariat" id="admin_alamat_sekretariat" rows="2" class="w-full border @error('alamat_sekretariat') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none">{{ old('alamat_sekretariat', $ormas->alamat_sekretariat) }}</textarea>
                    @error('alamat_sekretariat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">RT/RW</label>
                    <input type="text" name="rt_rw" id="admin_rt"
                        value="{{ old('rt_rw', $ormas->rt_rw ?? '') }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        placeholder="RT/RW">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <input type="text" name="kelurahan" id="admin_kelurahan" value="{{ old('kelurahan', $ormas->kelurahan) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" id="admin_kecamatan" value="{{ old('kecamatan', $ormas->kecamatan) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span class="text-red-500">*</span></label>
                    <input type="text" name="kota" id="admin_kota" value="{{ old('kota', $ormas->kota) }}"
                        class="w-full border @error('kota') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    @error('kota')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                    <input type="text" name="provinsi" id="admin_provinsi" value="{{ old('provinsi', $ormas->provinsi) }}"
                        class="w-full border @error('provinsi') border-red-400 @else border-gray-200 @enderror rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    @error('provinsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Shopee Map Picker --}}
            <x-address-pinpoint-picker 
                :latitude="old('latitude', $ormas->latitude)" 
                :longitude="old('longitude', $ormas->longitude)" 
                latName="latitude" 
                lngName="longitude"
                alamatId="admin_alamat_sekretariat"
                rtId="admin_rt"
                kelurahanId="admin_kelurahan"
                kecamatanId="admin_kecamatan"
                kotaId="admin_kota"
                provinsiId="admin_provinsi"
                mapId="admin_ormas_map_picker"
                title="Penempatan Pin Point Alamat Sekretariat"
                subtitle="Klik pada peta atau geser penanda merah untuk menyimpan titik lokasi presisi"
            />
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $ormas->telepon) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $ormas->email) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="url" name="website" value="{{ old('website', $ormas->website) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo <span class="text-gray-400 font-normal">(maks 2MB)</span></label>
                    <input type="file" name="logo" accept="image/*"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    @if(isset($ormas->logo))
                    <div class="mt-2">
                        <img src="{{ Storage::url($ormas->logo) }}" alt="Logo" class="w-16 h-16 object-contain rounded-lg border border-gray-100">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-end">
            <a href="{{ route('admin.ormas') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium px-5 py-2.5 rounded-lg text-sm transition-colors">Batal</a>
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i> {{ isset($ormas->id) ? 'Perbarui' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
