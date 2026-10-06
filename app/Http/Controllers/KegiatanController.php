<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::with('ormas');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatanList = $query->orderBy('tanggal_mulai', 'desc')->paginate(9);

        return view('kegiatan.index', compact('kegiatanList'));
    }

    public function show(Kegiatan $kegiatan)
    {
        $kegiatan->load('ormas');
        $kegiatanLain = Kegiatan::with('ormas')
            ->where('id', '!=', $kegiatan->id)
            ->orderBy('tanggal_mulai', 'desc')
            ->take(3)
            ->get();

        return view('kegiatan.show', compact('kegiatan', 'kegiatanLain'));
    }
}
