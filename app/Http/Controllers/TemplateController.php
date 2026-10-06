<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::orderBy('urutan')->orderBy('created_at', 'desc')->get();

        return view('admin.template.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ], [
            'judul.required' => 'Judul template wajib diisi.',
            'file.required' => 'File template wajib diunggah.',
            'file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX.',
            'file.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('templates', 'public');

        Template::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'aktif' => $request->boolean('aktif', true),
            'urutan' => $request->input('urutan', 0),
        ]);

        return redirect()->route('admin.template')->with('success', 'Template berhasil ditambahkan.');
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'aktif' => $request->boolean('aktif', true),
            'urutan' => $request->input('urutan', 0),
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            Storage::disk('public')->delete($template->file_path);

            $file = $request->file('file');
            $data['file_path'] = $file->store('templates', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        $template->update($data);

        return redirect()->route('admin.template')->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy(Template $template)
    {
        Storage::disk('public')->delete($template->file_path);
        $template->delete();

        return redirect()->route('admin.template')->with('success', 'Template berhasil dihapus.');
    }

    public function toggleAktif(Template $template)
    {
        $template->update(['aktif' => ! $template->aktif]);

        return redirect()->route('admin.template')
            ->with('success', 'Status template berhasil diubah.');
    }
}
