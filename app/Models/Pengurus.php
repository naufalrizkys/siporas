<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';

    protected $fillable = [
        'ormas_id', 'nama', 'jabatan', 'nik', 'telepon', 'email', 'foto',
    ];

    public function ormas()
    {
        return $this->belongsTo(Ormas::class);
    }
}
