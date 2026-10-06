<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengajuan SIPORAS</title>
    <style>
        body { margin: 0; padding: 0; background: #f3f4f6; font-family: 'Inter', Arial, sans-serif; color: #111827; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .header { padding: 28px 32px; text-align: center; }
        .header-disetujui { background: linear-gradient(135deg, #15803d, #16a34a); }
        .header-ditolak   { background: linear-gradient(135deg, #b91c1c, #dc2626); }
        .header-diproses  { background: linear-gradient(135deg, #1d4ed8, #2563eb); }
        .header-default   { background: linear-gradient(135deg, #374151, #4b5563); }
        .header h1 { margin: 0; color: #fff; font-size: 22px; font-weight: 800; }
        .header p  { margin: 6px 0 0; color: rgba(255,255,255,.85); font-size: 13px; }
        .icon { font-size: 40px; margin-bottom: 10px; }
        .body { padding: 32px; }
        .greeting { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 8px; }
        .intro { font-size: 14px; color: #4b5563; line-height: 1.7; margin-bottom: 24px; }
        .status-badge { display: inline-block; padding: 6px 18px; border-radius: 999px; font-weight: 800; font-size: 13px; margin-bottom: 24px; }
        .badge-disetujui { background: #dcfce7; color: #15803d; }
        .badge-ditolak   { background: #fee2e2; color: #b91c1c; }
        .badge-diproses  { background: #dbeafe; color: #1d4ed8; }
        .badge-default   { background: #f3f4f6; color: #374151; }
        .info-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 18px 20px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 13px; }
        .info-row:last-child { margin-bottom: 0; }
        .info-label { color: #6b7280; font-weight: 600; }
        .info-value { color: #111827; font-weight: 700; text-align: right; max-width: 60%; }
        .catatan-box { background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 14px 16px; margin-bottom: 24px; }
        .catatan-box.green { background: #f0fdf4; border-color: #22c55e; }
        .catatan-box.red   { background: #fef2f2; border-color: #ef4444; }
        .catatan-title { font-size: 12px; font-weight: 800; text-transform: uppercase; color: #92400e; margin-bottom: 4px; }
        .catatan-title.green { color: #15803d; }
        .catatan-title.red   { color: #b91c1c; }
        .catatan-text { font-size: 13px; color: #374151; line-height: 1.6; }
        .cta-btn { display: block; text-align: center; background: #b91c1c; color: #fff; text-decoration: none; font-weight: 700; font-size: 14px; padding: 14px 24px; border-radius: 8px; margin-bottom: 24px; }
        .cta-btn.green { background: #15803d; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; line-height: 1.7; }
        .footer strong { color: #6b7280; }
    </style>
</head>
<body>
@php
    $status   = $pengajuan->status;
    $isSetuju = $status === 'disetujui';
    $isTolak  = $status === 'ditolak';
    $isProses = $status === 'diproses';

    $headerClass = match($status) {
        'disetujui' => 'header-disetujui',
        'ditolak'   => 'header-ditolak',
        'diproses'  => 'header-diproses',
        default     => 'header-default',
    };
    $iconEmoji = match($status) {
        'disetujui' => '✅',
        'ditolak'   => '❌',
        'diproses'  => '🔄',
        default     => '📋',
    };
    $statusLabel = match($status) {
        'disetujui' => 'DISETUJUI',
        'ditolak'   => 'DITOLAK',
        'diproses'  => 'SEDANG DIPROSES',
        default     => strtoupper($status),
    };
    $badgeClass = match($status) {
        'disetujui' => 'badge-disetujui',
        'ditolak'   => 'badge-ditolak',
        'diproses'  => 'badge-diproses',
        default     => 'badge-default',
    };
    $catatanClass = match($status) {
        'disetujui' => 'green',
        'ditolak'   => 'red',
        default     => '',
    };
@endphp

<div class="wrapper">
    {{-- Header --}}
    <div class="header {{ $headerClass }}">
        <div class="icon">{{ $iconEmoji }}</div>
        <h1>
            @if($isSetuju) Pengajuan Disetujui
            @elseif($isTolak) Pengajuan Ditolak
            @elseif($isProses) Sedang Diproses
            @else Update Status Pengajuan
            @endif
        </h1>
        <p>Sistem Informasi Pelayanan Organisasi Masyarakat</p>
    </div>

    {{-- Body --}}
    <div class="body">
        <div class="greeting">Yth. {{ $pengajuan->nama_pemohon }},</div>
        <p class="intro">
            @if($isSetuju)
                Dengan hormat, kami informasikan bahwa pengajuan Anda telah diperiksa dan
                <strong>dinyatakan DISETUJUI</strong> oleh Badan Kesatuan Bangsa dan Politik Kabupaten Grobogan.
                @if($pengajuan->ormas) Organisasi Anda (<strong>{{ $pengajuan->ormas->nama_ormas }}</strong>) kini telah terdaftar secara resmi di sistem SIPORAS. @endif
            @elseif($isTolak)
                Dengan hormat, kami informasikan bahwa setelah dilakukan pemeriksaan, pengajuan Anda
                <strong>tidak dapat disetujui</strong> pada saat ini. Silakan perbaiki berkas dan ajukan kembali.
            @elseif($isProses)
                Dengan hormat, kami informasikan bahwa pengajuan Anda saat ini <strong>sedang dalam proses verifikasi</strong>
                oleh petugas kami. Harap menunggu konfirmasi selanjutnya.
            @else
                Berikut adalah pembaruan status pengajuan Anda di sistem SIPORAS.
            @endif
        </p>

        <div style="text-align:center;">
            <span class="status-badge {{ $badgeClass }}">{{ $statusLabel }}</span>
        </div>

        {{-- Info Pengajuan --}}
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Nomor Pengajuan</span>
                <span class="info-value">#{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenis Layanan</span>
                <span class="info-value">{{ $pengajuan->jenis_layanan_label }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Pengajuan</span>
                <span class="info-value">{{ $pengajuan->created_at->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Konfirmasi</span>
                <span class="info-value">{{ now()->format('d M Y, H:i') }} WIB</span>
            </div>
            @if($pengajuan->ormas)
            <div class="info-row">
                <span class="info-label">Nama Ormas</span>
                <span class="info-value">{{ $pengajuan->ormas->nama_ormas }}</span>
            </div>
            @endif
        </div>

        {{-- Catatan Admin --}}
        @if($pengajuan->catatan_admin)
        <div class="catatan-box {{ $catatanClass }}">
            <div class="catatan-title {{ $catatanClass }}">
                {{ $isSetuju ? '📝 Catatan dari Admin' : ($isTolak ? '⚠️ Alasan Penolakan' : '📌 Catatan Admin') }}
            </div>
            <div class="catatan-text">{{ $pengajuan->catatan_admin }}</div>
        </div>
        @endif

        {{-- CTA Button --}}
        <a href="{{ route('pengajuan.status', $pengajuan->id) }}" class="cta-btn {{ $isSetuju ? 'green' : '' }}">
            Lihat Detail Status Pengajuan
        </a>

        <p style="font-size:13px;color:#6b7280;line-height:1.7;">
            Jika ada pertanyaan, silakan hubungi kami melalui:<br>
            💬 WhatsApp: <strong>+62 897-7976-105</strong><br>
            ✉️ Email: <strong>adminsiporas@gmail.com</strong>
        </p>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <strong>Badan Kesatuan Bangsa dan Politik</strong><br>
        Kabupaten Grobogan &bull; SIPORAS &bull; {{ date('Y') }}<br>
        <span style="font-size:11px;">Email ini dikirim otomatis, mohon tidak membalas pesan ini.</span>
    </div>
</div>
</body>
</html>
