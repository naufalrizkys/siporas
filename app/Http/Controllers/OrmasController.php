<?php

namespace App\Http\Controllers;

use App\Models\Ormas;
use Illuminate\Http\Request;

class OrmasController extends Controller
{
    public function index(Request $request)
    {
        $query = Ormas::where('status', 'aktif');

        if ($request->filled('search')) {
            $query->where('nama_ormas', 'like', '%'.$request->search.'%')
                ->orWhere('singkatan', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('bidang')) {
            $query->where('bidang_kegiatan', $request->bidang);
        }

        $ormasList = $query->orderBy('nama_ormas')->paginate(12);
        $bidangList = Ormas::where('status', 'aktif')
            ->distinct()
            ->pluck('bidang_kegiatan');

        return view('ormas.index', compact('ormasList', 'bidangList'));
    }

    public function show(Ormas $ormas)
    {
        $ormas->load(['pengurus', 'kegiatan' => function ($q) {
            $q->orderBy('tanggal_mulai', 'desc')->take(5);
        }]);

        return view('ormas.show', compact('ormas'));
    }
}
