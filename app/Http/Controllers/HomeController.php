<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Ormas;
use App\Models\Pengajuan;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $totalOrmas = Ormas::where('status', 'aktif')->count();
        $totalKegiatan = Kegiatan::count();
        $totalPengajuan = Pengajuan::count();
        $kegiatanTerbaru = Kegiatan::with('ormas')->orderBy('tanggal_mulai', 'desc')->take(6)->get();
        $ormasTerbaru = Ormas::where('status', 'aktif')->orderBy('created_at', 'desc')->take(6)->get();
        $sliders = Slider::aktif()->get();
        $runningText = Setting::get('running_text', 'GERAKAN INDONESIA SADAR ADMINISTRASI KEPENDUDUKAN');
        $templates = Template::where('aktif', true)->orderBy('urutan')->orderBy('created_at')->get();

        return view('home', compact(
            'totalOrmas', 'totalKegiatan', 'totalPengajuan',
            'kegiatanTerbaru', 'ormasTerbaru', 'sliders', 'runningText', 'templates'
        ));
    }

    /** Download semua template aktif sebagai ZIP */
    public function downloadTemplates()
    {
        $templates = Template::where('aktif', true)->orderBy('urutan')->get();

        if ($templates->isEmpty()) {
            return back()->with('error', 'File template belum tersedia. Silakan hubungi admin.');
        }

        $zipName = 'Template_Pengajuan_Ormas_Kesbangpol_Grobogan.zip';
        $zipPath = storage_path('app/temp/'.$zipName);

        if (! is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($templates as $tpl) {
                $filePath = Storage::disk('public')->path($tpl->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $tpl->file_name);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    /** Download template terpilih (by ID) sebagai file langsung atau ZIP */
    public function downloadSelectedTemplates(Request $request)
    {
        $ids = array_filter((array) $request->input('files', []), 'is_numeric');

        $templates = Template::where('aktif', true)->whereIn('id', $ids)->get();

        if ($templates->isEmpty()) {
            return back()->with('error', 'File tidak tersedia.');
        }

        if ($templates->count() === 1) {
            $tpl = $templates->first();
            $filePath = Storage::disk('public')->path($tpl->file_path);

            return response()->download($filePath, $tpl->file_name);
        }

        $zipName = 'Template_Terpilih_Ormas_Grobogan.zip';
        $zipPath = storage_path('app/temp/'.$zipName);

        if (! is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($templates as $tpl) {
                $filePath = Storage::disk('public')->path($tpl->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $tpl->file_name);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    public function templates()
    {
        $templates = Template::where('aktif', true)->orderBy('urutan')->orderBy('created_at')->get();

        return view('templates', compact('templates'));
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function kontak()
    {
        return view('kontak');
    }
}
