<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
        'user_id', 'nama_pemohon', 'nik', 'telepon', 'email',
        'jenis_layanan', 'ormas_id', 'keterangan', 'data_perubahan', 'data_sebelum',
        'dokumen', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'data_perubahan' => 'array',
        'data_sebelum' => 'array',
    ];

    public function ormas()
    {
        return $this->belongsTo(Ormas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getJenisLayananLabelAttribute(): string
    {
        return match ($this->jenis_layanan) {
            'pendaftaran_ormas' => 'Pendaftaran Ormas Baru',
            'perpanjangan_skt' => 'Perpanjangan SKT',
            'perubahan_data' => 'Perubahan Data Ormas',
            'pencabutan_skt' => 'Pencabutan SKT',
            'surat_keterangan' => 'Surat Keterangan',
            'laporan_kegiatan' => 'Laporan Kegiatan',
            default => $this->jenis_layanan,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => $this->status,
        };
    }
}
