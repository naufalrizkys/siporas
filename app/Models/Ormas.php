<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ormas extends Model
{
    use HasFactory;

    protected $table = 'ormas';

    protected $fillable = [
        'user_id', 'nama_ormas', 'singkatan', 'nomor_skt', 'tanggal_berdiri',
        'bidang_kegiatan', 'visi', 'misi', 'alamat_sekretariat', 'rt_rw',
        'latitude', 'longitude',
        'kelurahan', 'kecamatan', 'kota', 'provinsi',
        'telepon', 'email', 'website', 'logo', 'status',
    ];

    protected $casts = [
        'tanggal_berdiri' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif' => 'Aktif',
            'tidak_aktif' => 'Tidak Aktif',
            'menunggu' => 'Menunggu Verifikasi',
            default => $this->status,
        };
    }
}
