<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'deskripsi', 'file_path', 'file_name',
        'mime_type', 'file_size', 'aktif', 'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function getFileSizeFormattedAttribute(): string
    {
        if (! $this->file_size) {
            return '-';
        }
        $kb = $this->file_size / 1024;
        if ($kb < 1024) {
            return round($kb, 1).' KB';
        }

        return round($kb / 1024, 1).' MB';
    }
}
