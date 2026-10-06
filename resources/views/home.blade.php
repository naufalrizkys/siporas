@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- ═══ HERO SLIDER SECTION ═══ --}}
<section class="relative bg-gray-900 overflow-hidden">
    <div class="relative w-full slide-height">
        @forelse($sliders as $index => $slide)
        <div class="hero-slide-item absolute inset-0 {{ $index === 0 ? 'active-slide' : 'hidden-slide' }} transition-opacity duration-500">
            <img src="{{ Storage::url($slide->gambar) }}" alt="{{ $slide->judul ?? 'SIPORAS Grobogan' }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end">
                <div class="max-w-screen-xl mx-auto px-4 sm:px-8 pb-10 w-full">
                    @if($slide->judul)
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-white mb-2 drop-shadow-md">{{ $slide->judul }}</h2>
                    @endif
                    @if($slide->deskripsi)
                    <p class="text-sm sm:text-base text-gray-200 max-w-2xl drop-shadow">{{ $slide->deskripsi }}</p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="hero-slide-item absolute inset-0 active-slide bg-gradient-to-r from-red-900 via-red-800 to-red-900 flex items-center justify-center text-center p-6">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-8 py-12">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full text-white/90 text-xs font-semibold uppercase tracking-wider mb-4 border border-white/20">
                    <i class="fas fa-landmark"></i> Kesbangpol Kab. Grobogan
                </div>
                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight mb-4 drop-shadow-md">
                    SIPORAS GROBOGAN
                </h1>
                <p class="text-base sm:text-xl text-red-100 max-w-2xl mx-auto font-medium leading-relaxed drop-shadow">
                    Sistem Informasi Pelayanan & Laporan Keberadaan Organisasi Masyarakat Kab. Grobogan
                </p>
            </div>
        </div>
        @endforelse
    </div>

    @if($sliders->count() > 1)
    <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white hover:bg-black/60 flex items-center justify-center transition-all z-20">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white hover:bg-black/60 flex items-center justify-center transition-all z-20">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-20">
        @foreach($sliders as $index => $slide)
        <button class="slide-dot h-2 rounded-full transition-all" data-index="{{ $index }}" style="width: {{ $index === 0 ? '24px' : '8px' }}; background: {{ $index === 0 ? '#b91c1c' : 'rgba(255,255,255,0.5)' }}"></button>
        @endforeach
    </div>
    @endif
</section>

{{-- ═══ PERSYARATAN & TEMPLATE (CARD + MODAL) ═══ --}}
<section class="py-12 bg-white" data-aos="fade-up">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8">

        {{-- Judul --}}
        <div class="text-center mb-10" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 bg-red-50 border border-red-100 text-red-700 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-3">
                <i class="fas fa-folder-open"></i> Dokumen Pengajuan
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-2">Persyaratan & Template Formulir</h2>
            <p class="text-gray-500 text-sm max-w-lg mx-auto">Klik kartu di bawah untuk melihat detail persyaratan atau mengunduh template formulir yang dibutuhkan.</p>
        </div>

        {{-- 2 Card sejajar --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Card 1: Persyaratan --}}
            <button type="button" onclick="openModal('modal-persyaratan')" data-aos="fade-up" data-aos-delay="100"
                    class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 hover:border-red-600/30 transition-all duration-300 group cursor-pointer">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-5 transition-transform group-hover:scale-110" style="background:#fef2f2;">
                    <i class="fas fa-clipboard-list text-3xl" style="color:#b91c1c;"></i>
                </div>
                <h3 class="font-extrabold text-gray-900 text-lg mb-2 group-hover:text-red-700 transition-colors">Persyaratan Dokumen</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">10 berkas wajib untuk Laporan Keberadaan Ormas ke Kesbangpol Kab. Grobogan.</p>
                <span class="inline-flex items-center gap-2 text-sm font-extrabold text-red-700 bg-red-50 px-5 py-2.5 rounded-full border border-red-200 group-hover:bg-red-700 group-hover:text-white transition-all">
                    <i class="fas fa-eye"></i> Lihat Persyaratan
                </span>
            </button>

            {{-- Card 2: Template --}}
            <button type="button" onclick="openModal('modal-template')" data-aos="fade-up" data-aos-delay="200"
                    class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 hover:border-red-600/30 transition-all duration-300 group cursor-pointer">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-5 transition-transform group-hover:scale-110" style="background:#fef2f2;">
                    <i class="fas fa-file-download text-3xl" style="color:#b91c1c;"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-red-700 transition-colors">Template Formulir</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">Unduh template formulir resmi — pilih satu, beberapa, atau semua sekaligus.</p>
                <span class="inline-flex items-center gap-2 text-sm font-extrabold text-red-700 bg-red-50 px-5 py-2.5 rounded-full border border-red-200 group-hover:bg-red-700 group-hover:text-white transition-all">
                    <i class="fas fa-download"></i> Unduh Template
                </span>
            </button>

        </div>
    </div>
</section>

{{-- ═══ MODAL: Persyaratan ═══ --}}
<div id="modal-persyaratan" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display:none;" onclick="if(event.target===this)closeModal('modal-persyaratan')">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[85vh] flex flex-col overflow-hidden">
        <div class="flex items-center justify-between gap-3 px-6 py-4 flex-shrink-0" style="background:#b91c1c;">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-white text-sm"></i>
                </div>
                <div>
                    <div class="font-black text-white text-sm uppercase tracking-wide">Persyaratan Dokumen</div>
                    <div class="text-red-100 text-xs">Laporan Keberadaan Ormas — Kesbangpol Grobogan</div>
                </div>
            </div>
            <button onclick="closeModal('modal-persyaratan')"
                    class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center text-white transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <div class="overflow-y-auto flex-1 divide-y divide-gray-100">
            @foreach([
                'Surat Pengantar dari Ormas yang ditandatangani Ketua & Sekretaris, ditujukan kepada Bupati Grobogan U.p. Kepala Badan Kesbangpol Kab. Grobogan, perihal: Laporan Keberadaan Ormas. (KOP Surat Ormas, Nomor, Tanggal, Cap & Tanda Tangan Pengurus)',
                'Fotocopy Akte Pendirian / Akta Notaris',
                'Fotocopy Surat Pengesahan dari Kemenkumham',
                'Program Kerja Organisasi (ditandatangani Ketua dan Sekretaris)',
                'Fotocopy SK Susunan Kepengurusan Organisasi Tingkat Kabupaten Grobogan',
                'Surat Keterangan Domisili Kantor/Sekretariat Ormas (TTD Lurah/Kepala Desa) + Bukti Kepemilikan/Kontrak/Izin Pakai + Foto kantor tampak depan memuat papan nama',
                'Foto Copy NPWP atas Nama Ormas',
                'Biodata Pengurus + Pas Foto Berwarna 4x6 cm (3 bulan terakhir) - Ketua, Sekretaris, Bendahara',
                'Foto Copy E-KTP Pengurus - Ketua, Sekretaris, Bendahara',
                'Formulir Data Ormas / LSM + Lambang, Bendera & Cap Stempel Ormas + Surat Pernyataan Tidak dalam Sengketa / Perkara',
            ] as $i => $req)
            <div class="flex items-start gap-3 px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 text-white text-xs font-black" style="background:#b91c1c;">{{ $i+1 }}</div>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $req }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-gray-50 border-t border-gray-100 px-6 py-3 text-center text-sm text-gray-500 font-semibold flex-shrink-0">
            <i class="fab fa-whatsapp mr-1.5 text-green-600"></i> Hotline WA: <strong class="text-gray-800">+62 897-7976-105</strong>
        </div>
    </div>
</div>

{{-- ═══ MODAL: Template ═══ --}}
<div id="modal-template" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display:none;" onclick="if(event.target===this)closeModal('modal-template')">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[85vh] flex flex-col overflow-hidden">
        <div class="flex items-center justify-between gap-3 px-6 py-4 flex-shrink-0" style="background:#b91c1c;">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-folder-open text-white text-sm"></i>
                </div>
                <div>
                    <div class="font-black text-white text-sm uppercase tracking-wide">Template Formulir</div>
                    <div class="text-red-100 text-xs">Centang yang dibutuhkan, lalu unduh</div>
                </div>
            </div>
            <button onclick="closeModal('modal-template')"
                    class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center text-white transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>"fas fa-times text-sm"></i>
            </button>
        </div>
        @if($templates->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <i class="fas fa-folder-open text-4xl mb-3 block opacity-30"></i>
            <p class="text-sm">Template belum tersedia. Hubungi admin.</p>
        </div>
        @else
        <div class="flex items-center gap-3 px-6 py-3 bg-gray-50 border-b border-gray-100 flex-shrink-0">
            <input type="checkbox" id="select-all" onchange="toggleAll(this)" class="w-4 h-4 rounded accent-red-700 cursor-pointer">
            <label for="select-all" class="text-xs font-bold text-gray-600 cursor-pointer">Pilih Semua</label>
            <span id="selected-count" class="ml-auto text-xs text-gray-400">0 dipilih</span>
        </div>
        <div class="overflow-y-auto flex-1 divide-y divide-gray-100" id="template-list">
            @foreach($templates as $tpl)
            @php
                $isPdf     = str_ends_with(strtolower($tpl->file_name), '.pdf');
                $iconClass = $isPdf ? 'fas fa-file-pdf' : 'fas fa-file-word';
                $iconColor = $isPdf ? '#b91c1c' : '#1d4ed8';
                $iconBg    = $isPdf ? '#fef2f2' : '#eff6ff';
            @endphp
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors">
                <input type="checkbox" name="templates[]" value="{{ $tpl->id }}" id="tpl-{{ $tpl->id }}" onchange="updateCount()" class="w-4 h-4 rounded accent-red-700 cursor-pointer flex-shrink-0">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:{{ $iconBg }}">
                    <i class="{{ $iconClass }}" style="color:{{ $iconColor }}"></i>
                </div>
                <label for="tpl-{{ $tpl->id }}" class="flex-1 min-w-0 cursor-pointer">
                    <p class="text-sm font-bold text-gray-900">{{ $tpl->judul }}</p>
                    @if($tpl->deskripsi)<p class="text-xs text-gray-500 truncate">{{ $tpl->deskripsi }}</p>@endif
                </label>
                <span class="text-xs text-gray-300 font-mono flex-shrink-0">{{ $tpl->file_size_formatted }}</span>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex-shrink-0">
            <button type="button" onclick="downloadSmart()" id="btn-unduh"
                    class="w-full inline-flex items-center justify-center gap-2 bg-red-700 hover:bg-red-800 text-white font-bold text-sm px-4 py-3 rounded-xl transition-colors">
                <i class="fas fa-download"></i>
                <span id="btn-unduh-label">Unduh Semua</span>
            </button>
        </div>
        @endif
        <div class="bg-yellow-50 border-t border-yellow-100 px-6 py-3 flex items-start gap-2 text-xs text-yellow-800 flex-shrink-0">
            <i class="fas fa-info-circle text-yellow-500 mt-0.5 flex-shrink-0"></i>
            <span>Isi, tanda tangani, cap stempel, lalu scan dan upload saat mengajukan laporan.</span>
        </div>
    </div>
</div>


{{-- ═══ PANDUAN PENGAJUAN ═══ --}}
<section class="pb-14 bg-gray-50 border-t border-gray-100" data-aos="fade-up">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-8">

        {{-- Judul Section --}}
        <div class="text-center py-10" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 bg-red-50 border border-red-100 text-red-700 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-3">
                <i class="fas fa-info-circle"></i> Panduan Pengajuan
            </div>
            <h2 class="text-xl font-black text-gray-900 mb-2">Cara Mengajukan Laporan Keberadaan Ormas</h2>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">Ikuti langkah-langkah berikut untuk mengajukan laporan keberadaan organisasi masyarakat Anda secara online melalui SIPORAS.</p>
        </div>

        {{-- Langkah-langkah (Alur Pendaftaran Flow Continuous) --}}
        <div class="relative bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 p-6 sm:p-10 mb-10 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            
            {{-- Background Accent Glow --}}
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-red-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

            {{-- Line Connector untuk Desktop --}}
            <div class="hidden lg:block absolute top-[92px] left-[12%] right-[12%] h-[3px] bg-gradient-to-r from-blue-500 via-cyan-500 via-purple-500 to-green-500 rounded-full z-0 opacity-30"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                @foreach([
                    [
                        'step'       => '01',
                        'title'      => 'Daftar / Login Akun',
                        'desc'       => 'Buat akun pengguna atau login jika sudah punya akun. Gunakan email aktif yang bisa dihubungi.',
                        'icon'       => 'fas fa-user-plus',
                        'badge'      => 'Tahap 1',
                        'gradient'   => 'from-blue-600 to-indigo-600',
                        'shadow'     => 'shadow-blue-500/25',
                        'border'     => 'border-blue-100',
                        'bg_soft'    => 'bg-blue-50/70',
                        'text_color' => 'text-blue-700',
                    ],
                    [
                        'step'       => '02',
                        'title'      => 'Isi Formulir Pengajuan',
                        'desc'       => 'Lengkapi formulir laporan keberadaan ormas dengan data yang benar dan lengkap sesuai dokumen resmi.',
                        'icon'       => 'fas fa-file-signature',
                        'badge'      => 'Tahap 2',
                        'gradient'   => 'from-cyan-600 to-teal-600',
                        'shadow'     => 'shadow-cyan-500/25',
                        'border'     => 'border-cyan-100',
                        'bg_soft'    => 'bg-cyan-50/70',
                        'text_color' => 'text-cyan-700',
                    ],
                    [
                        'step'       => '03',
                        'title'      => 'Upload Dokumen',
                        'desc'       => 'Unggah semua berkas persyaratan dalam format PDF/JPG. Pastikan file jelas dan terbaca.',
                        'icon'       => 'fas fa-cloud-upload-alt',
                        'badge'      => 'Tahap 3',
                        'gradient'   => 'from-purple-600 to-pink-600',
                        'shadow'     => 'shadow-purple-500/25',
                        'border'     => 'border-purple-100',
                        'bg_soft'    => 'bg-purple-50/70',
                        'text_color' => 'text-purple-700',
                    ],
                    [
                        'step'       => '04',
                        'title'      => 'Tunggu Verifikasi',
                        'desc'       => 'Admin Kesbangpol akan memverifikasi berkas. Pantau status pengajuan di menu Cek Status.',
                        'icon'       => 'fas fa-user-check',
                        'badge'      => 'Tahap 4 (Selesai)',
                        'gradient'   => 'from-emerald-600 to-green-600',
                        'shadow'     => 'shadow-green-500/25',
                        'border'     => 'border-green-100',
                        'bg_soft'    => 'bg-green-50/70',
                        'text_color' => 'text-green-700',
                    ],
                ] as $i => $step)
                <div class="flex flex-col items-center text-center group relative">
                    
                    {{-- Icon Node Wrapper --}}
                    <div class="relative mb-5">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br {{ $step['gradient'] }} text-white flex items-center justify-center shadow-lg {{ $step['shadow'] }} transform group-hover:scale-110 group-hover:-translate-y-1 transition-all duration-300 relative z-10">
                            <i class="{{ $step['icon'] }} text-2xl"></i>
                        </div>
                        {{-- Number Badge floating --}}
                        <span class="absolute -top-2 -right-2 bg-gray-900 text-white font-black text-xs px-2.5 py-0.5 rounded-full border-2 border-white shadow-md z-20">
                            {{ $step['step'] }}
                        </span>
                    </div>

                    {{-- Panah Penunjuk Antar Step (Desktop) --}}
                    @if($i < 3)
                    <div class="hidden lg:flex absolute -right-6 top-[36px] z-20 w-8 h-8 rounded-full bg-white border border-gray-200 shadow-sm items-center justify-center text-gray-400 group-hover:text-red-600 group-hover:border-red-200 group-hover:translate-x-1 transition-all duration-300">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </div>
                    @endif

                    {{-- Badge Chip --}}
                    <span class="inline-block text-[11px] font-extrabold uppercase tracking-wider px-3 py-0.5 rounded-full mb-2 {{ $step['bg_soft'] }} {{ $step['text_color'] }} border {{ $step['border'] }}">
                        {{ $step['badge'] }}
                    </span>

                    {{-- Title & Description --}}
                    <h3 class="font-extrabold text-gray-900 text-base mb-2 group-hover:text-red-700 transition-colors">
                        {{ $step['title'] }}
                    </h3>
                    <p class="text-gray-500 text-xs leading-relaxed max-w-xs">
                        {{ $step['desc'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CTA Pengajuan --}}
        <div class="bg-red-700 rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-lg hover:shadow-xl transition-all duration-300" data-aos="zoom-in" data-aos-delay="150">
            <div>
                <h3 class="font-black text-white text-lg mb-1">Siap Mengajukan?</h3>
                <p class="text-red-200 text-sm">Login dan isi formulir laporan keberadaan ormas sekarang.</p>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                @auth
                <a href="{{ route('laporan.pendaftaran-baru') }}"
                   class="inline-flex items-center gap-2 bg-white text-red-700 font-bold text-sm px-6 py-3 rounded-xl hover:bg-red-50 transition-colors">
                    <i class="fas fa-paper-plane"></i> Ajukan Sekarang
                </a>
                @else
                <a href="{{ route('login', ['redirect' => route('laporan.pendaftaran-baru')]) }}"
                   class="inline-flex items-center gap-2 bg-white text-red-700 font-bold text-sm px-6 py-3 rounded-xl hover:bg-red-50 transition-colors">
                    <i class="fas fa-sign-in-alt"></i> Login & Ajukan
                </a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 bg-red-800 border border-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl hover:bg-red-900 transition-colors">
                    <i class="fas fa-user-plus"></i> Daftar Akun
                </a>
                @endauth
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // ── Modal ─────────────────────────────────────────────────────────────────
    function openModal(id) {
        const el = document.getElementById(id);
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            ['modal-persyaratan','modal-template'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
            document.body.style.overflow = '';
        }
    });
    function updateCount() {
        const total   = document.querySelectorAll('#template-list input[type=checkbox]').length;
        const checked = document.querySelectorAll('#template-list input[type=checkbox]:checked').length;
        document.getElementById('selected-count').textContent = checked + ' dipilih';
        const selAll = document.getElementById('select-all');
        if (selAll) {
            selAll.indeterminate = checked > 0 && checked < total;
            selAll.checked = total > 0 && checked === total;
        }
        // Update label tombol
        const btn = document.getElementById('btn-unduh-label');
        if (btn) btn.textContent = checked > 0 ? 'Unduh ' + checked + ' File Terpilih' : 'Unduh Semua';
    }

    function downloadSmart() {
        const checked = [...document.querySelectorAll('#template-list input[type=checkbox]:checked')];
        if (checked.length === 0) {
            // Tidak ada dipilih → unduh semua
            window.location.href = '{{ route("templates.download") }}';
            return;
        }
        // Ada yang dipilih → unduh terpilih
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

    function toggleAll(cb) {
        document.querySelectorAll('#template-list input[type=checkbox]').forEach(c => c.checked = cb.checked);
        updateCount();
    }

    function downloadSelected() {
        const checked = [...document.querySelectorAll('#template-list input[type=checkbox]:checked')];
        if (checked.length === 0) {
            alert('Pilih minimal satu template terlebih dahulu.');
            return;
        }
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("templates.download.selected") }}';

        const csrf = document.createElement('input');
        csrf.type  = 'hidden';
        csrf.name  = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);

        checked.forEach(cb => {
            const input  = document.createElement('input');
            input.type   = 'hidden';
            input.name   = 'files[]';
            input.value  = cb.value;  // nilai = ID template
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }

    // ── Hero Slider ───────────────────────────────────────────────────────────
    const slides = document.querySelectorAll('.hero-slide-item');
    const dots   = document.querySelectorAll('.slide-dot');
    let current  = 0, timer;

    if (slides.length > 1) {
        function goTo(idx) {
            slides[current].classList.add('hidden-slide');
            slides[current].classList.remove('active-slide');
            if (dots[current]) { dots[current].style.background = 'rgba(185,28,28,0.3)'; dots[current].style.width = '8px'; }
            current = (idx + slides.length) % slides.length;
            slides[current].classList.remove('hidden-slide');
            slides[current].classList.add('active-slide');
            if (dots[current]) { dots[current].style.background = '#b91c1c'; dots[current].style.width = '24px'; }
        }

        function startAuto() { timer = setInterval(() => goTo(current + 1), 5000); }
        function stopAuto()  { clearInterval(timer); }

        document.getElementById('next-slide')?.addEventListener('click', () => { stopAuto(); goTo(current+1); startAuto(); });
        document.getElementById('prev-slide')?.addEventListener('click', () => { stopAuto(); goTo(current-1); startAuto(); });
        dots.forEach(d => d.addEventListener('click', () => { stopAuto(); goTo(+d.dataset.index); startAuto(); }));

        startAuto();
    }
</script>
<style>
    .active-slide { display: block; }
    .hidden-slide  { display: none; }
    .slide-height  { height: 360px; }
    @media (min-width: 640px) { .slide-height { height: 540px; } }
    @media (min-width: 1024px) { .slide-height { height: 650px; } }
</style>
@endpush
