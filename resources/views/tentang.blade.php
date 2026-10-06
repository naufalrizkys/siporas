@extends('layouts.app')

@section('title', 'Tentang SIPORAS')

@section('content')
{{-- Page Header --}}
<div style="background: #1e293b;" class="text-white py-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="flex items-center gap-2 text-white/70 text-xs mb-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-white">Tentang</span>
        </div>
        <h1 class="text-3xl font-bold">Tentang SIPORAS</h1>
        <p class="text-white/80 mt-1 max-w-2xl">Sistem Informasi Pelayanan Organisasi Masyarakat yang hadir untuk mewujudkan tata kelola ormas yang modern, transparan, dan akuntabel.</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-14 space-y-12">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Apa itu SIPORAS?</h2>
            <p class="text-gray-600 leading-relaxed mb-4">SIPORAS adalah platform digital yang dikembangkan untuk memfasilitasi pelayanan administrasi organisasi masyarakat secara online. Dengan sistem ini, masyarakat dapat mengajukan berbagai layanan terkait ormas tanpa harus datang langsung ke kantor.</p>
            <p class="text-gray-600 leading-relaxed">Platform ini terintegrasi dengan sistem pemerintahan daerah untuk memastikan proses yang cepat, transparan, dan akuntabel.</p>
        </div>
        <div class="bg-red-50 rounded-2xl p-8 grid grid-cols-2 gap-4">
            @foreach([['fas fa-bolt','Cepat','Proses digital tanpa antrean'],['fas fa-shield-alt','Terpercaya','Terverifikasi resmi'],['fas fa-eye','Transparan','Pantau status real-time'],['fas fa-mobile-alt','Mudah','Akses kapan & di mana saja']] as $f)
            <div class="text-center">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="{{ $f[0] }} text-red-600 text-xl"></i>
                </div>
                <div class="font-semibold text-gray-900 text-sm">{{ $f[1] }}</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ $f[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Layanan yang Tersedia</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['fas fa-plus-circle','blue','Pendaftaran Ormas','Daftarkan ormas baru dan dapatkan Surat Keterangan Terdaftar (SKT) dari pemerintah daerah.'],
                ['fas fa-sync-alt','green','Perpanjangan SKT','Perpanjang masa berlaku Surat Keterangan Terdaftar sebelum habis masa berlakunya.'],
                ['fas fa-edit','yellow','Perubahan Data','Laporkan perubahan data ormas seperti kepengurusan, alamat, atau bidang kegiatan.'],
                ['fas fa-times-circle','red','Pencabutan SKT','Ajukan pencabutan Surat Keterangan Terdaftar jika ormas sudah tidak aktif.'],
                ['fas fa-file-certificate','purple','Surat Keterangan','Permintaan surat keterangan untuk keperluan administrasi ormas.'],
                ['fas fa-search-location','teal','Cek Status','Pantau perkembangan proses pengajuan layanan secara real-time.'],
            ] as $l)
            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                <div class="w-10 h-10 bg-{{ $l[1] }}-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="{{ $l[0] }} text-{{ $l[1] }}-600"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">{{ $l[2] }}</div>
                    <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $l[3] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center" style="background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%); border-radius:1rem; padding:2.5rem;">
        <h2 class="text-2xl font-bold text-white mb-3">Mulai Gunakan SIPORAS</h2>
        <p class="text-red-100 mb-6">Layanan tersedia 24 jam, 7 hari seminggu</p>
        <a href="{{ '#' }}" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold px-8 py-3.5 rounded-xl transition-colors inline-flex items-center gap-2">
            <i class="fas fa-file-alt"></i> Ajukan Layanan
        </a>
    </div>
</div>
@endsection
