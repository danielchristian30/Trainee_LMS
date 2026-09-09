<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Tampilkan daftar seluruh modul pelatihan.
     */
    public function index()
    {
        $modules = Module::with('quizzes')
            ->orderBy('order', 'asc')
            ->get();

        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Tampilkan form untuk membuat modul baru.
     */
    public function create()
    {
         $nextOrder = (Module::max('order') ?? 0) + 1; //untuk mengisi value order module dengan value terbaru
        return view('admin.modules.create', compact('nextOrder'));
    }

    /**
     * Simpan modul baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'content'      => 'nullable|string',
            'file_path'    => 'nullable|file|mimes:pdf|max:10240',
            'video_url'    => 'nullable|url',
            'order'        => 'required|integer',
            'passing_score' => 'required|integer|min:0|max:100',
            'Thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            
            // PESAN ERROR
            'file_path.mimes' => 'Berkas materi harus berformat PDF.',
            'file_path.max'   => 'Ukuran berkas PDF tidak boleh lebih dari 5 MB.',
            'thumbnail.image' => 'Thumbnail harus berupa berkas gambar.',
            'thumbnail.mimes' => 'Format gambar yang diperbolehkan hanya JPG, JPEG, PNG, dan WEBP.',
            'thumbnail.max'   => 'Ukuran gambar thumbnail tidak boleh lebih dari 5 MB.',
        ]);

        // Upload PDF
        $filePath = null;

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')
                ->store('modules/files', 'public');
        }

        // Upload thumbnail
        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')
                ->store('modules/thumbnails', 'public');
        }

        // Simpan Modul
        $module = Module::create([
            'title'        => $request->input('title'),
            'slug'         => Str::slug($request->input('title')),
            'Description'  => $request->input('description'),
            'Thumbnail'    => $thumbnailPath,
            'is_published' => $request->has('is_published'),
            'file_path'    => $filePath,
            'video_url'    => $request->input('video_url'),
            'order'        => $request->input('order'),
            'content'      => $request->input('content'),
        ]);

        // Otomatis buat 1 kuis untuk modul
        Quiz::create([
            'module_id'    => $module->id,
            'title'        => 'Kuis Evaluasi: ' . $module->title,
            'passing_score' => $request->input('passing_score'),
        ]);

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Modul dan Kuis berhasil dibuat.');
    }

    /**
     * Tampilkan form untuk mengedit modul.
     */
    public function edit(Module $module)
    {
        $module->load('quizzes');

        return view('admin.modules.edit', compact('module'));
    }

    /**
     * Perbarui data modul.
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'content'       => 'nullable|string',
            'file_path'     => 'nullable|file|mimes:pdf|max:10240',
            'video_url'     => 'nullable|url',
            'order'         => 'required|integer',
            'passing_score' => 'required|integer|min:0|max:100',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // PESAN ERROR
            'file_path.mimes' => 'Berkas materi harus berformat PDF.',
            'file_path.max'   => 'Ukuran berkas PDF tidak boleh lebih dari 5 MB.',
            'thumbnail.image' => 'Thumbnail harus berupa berkas gambar.',
            'thumbnail.mimes' => 'Format gambar yang diperbolehkan hanya JPG, JPEG, PNG, dan WEBP.',
            'thumbnail.max'   => 'Ukuran gambar thumbnail tidak boleh lebih dari 5 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update PDF
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file_path')) {

            if ($module->file_path) {
                Storage::disk('public')->delete($module->file_path);
            }

            $module->file_path = $request->file('file_path')
                ->store('modules/files', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Thumbnail
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {   

            if ($module->thumbnail) {
                Storage::disk('public')->delete($module->thumbnail);
            }

            $module->thumbnail = $request->file('thumbnail')
                ->store('modules/thumbnails', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Data Modul
        |--------------------------------------------------------------------------
        */

        $module->update([
            'title'        => $request->input('title'),
            'Description'  => $request->input('description'),
            'order'        => $request->input('order'),
            'is_published' => $request->has('is_published'),
            'video_url'    => $request->input('video_url'),
            'content'      => $request->input('content'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Passing Score Quiz
        |--------------------------------------------------------------------------
        */

        $quiz = $module->quizzes()->first();

        if ($quiz) {
            $quiz->update([
                'passing_score' => $request->input('passing_score'),
            ]);
        }

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Modul berhasil diperbarui.');
    }

    /**
     * Hapus modul dan file terkait.
     */
    public function destroy(Module $module)
    {
        // Hapus PDF
        if ($module->file_path) {
            Storage::disk('public')->delete($module->file_path);
        }

        // Hapus thumbnail
        if ($module->thumbnail) {
            Storage::disk('public')->delete($module->thumbnail);
        }

        $module->delete();

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Modul dan Kuis terkait berhasil dihapus.');
    }
}