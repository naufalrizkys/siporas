@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
{{-- Page Header --}}
<div style="background: #1e293b;" class="text-white py-10">
    <div class="max-w-screen-xl mx-auto px-8">
        <div class="flex items-center gap-2 text-white/70 text-xs mb-2">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-white">Kontak</span>
        </div>
        <h1 class="text-3xl font-bold">Hubungi Kami</h1>
        <p class="text-white/80 mt-1">Tim kami siap membantu pertanyaan dan kebutuhan Anda</p>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-8 sm:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kontak Info --}}
        <div class="space-y-4">
            @foreach([
                ['fas fa-map-marker-alt','red','Alamat','Jl. Gatot Subroto No. 6, Purwodadi<br>Kabupaten Grobogan, Jawa Tengah'],
                ['fab fa-whatsapp','green','Hotline / WA','+62 897-7976-105<br>Senin-Jumat, 08:00-16:00 WIB'],
                ['fas fa-envelope','blue','Email Resmi','adminsiporas@gmail.com'],
                ['fas fa-clock','yellow','Jam Pelayanan','Senin – Jumat<br>08:00 – 16:00 WIB'],
            ] as $k)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-start gap-4">
                <div class="w-10 h-10 bg-{{ $k[1] }}-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="{{ $k[0] }} text-{{ $k[1] }}-600"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm mb-0.5">{{ $k[2] }}</div>
                    <p class="text-gray-500 text-sm">{!! $k[3] !!}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Form Kontak --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-5 text-lg">Kirim Pesan</h2>
                <form class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="email@contoh.com">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                        <input type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" placeholder="Subjek pesan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                        <textarea rows="5" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none" placeholder="Tuliskan pesan Anda..."></textarea>
                    </div>
                    <button type="submit" style="background:#1e293b;" class="hover:opacity-90 text-white font-semibold w-full py-2.5 rounded-lg transition inline-flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
