<?php

namespace App\Mail;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pengajuan $pengajuan) {}

    public function envelope(): Envelope
    {
        $subjek = match ($this->pengajuan->status) {
            'disetujui' => '✅ Pengajuan Anda Telah Disetujui – SIPORAS',
            'ditolak' => '❌ Pengajuan Anda Ditolak – SIPORAS',
            'diproses' => '🔄 Pengajuan Anda Sedang Diproses – SIPORAS',
            default => 'Update Status Pengajuan – SIPORAS',
        };

        return new Envelope(subject: $subjek);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pengajuan-status');
    }
}
