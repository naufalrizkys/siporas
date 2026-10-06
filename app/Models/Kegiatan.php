<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'ormas_id', 'judul', 'deskripsi', 'tanggal_mulai',
        'tanggal_selesai', 'lokasi', 'foto', 'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function ormas()
    {
        return $this->belongsTo(Ormas::class);
    }
}
