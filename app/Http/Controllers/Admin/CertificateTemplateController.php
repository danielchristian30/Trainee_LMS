<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = CertificateTemplate::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.certificate_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.certificate_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'background_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $path = null;
            // Simpan file ke storage/app/public/certificates
            if ($request->hasFile('background_image')){
                $path = $request->file('background_image')->store('certificates', 'public');
            }

            $template = CertificateTemplate::create([
                'title' => $request->title,
                'background_path' => $path,
                // agar kolom koordinat terisi otomatis dengan nilai default dari database
            ]);

            return redirect()->route('admin.certificate-templates.edit', $template)
                ->with('success', 'Template berhasil diunggah. Silahkan sesuaikan posisi teks dan QR Code pada desain ini.');
        } catch (\Exception $error) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan template: ' . $error->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan Inteface Visual Positioner (Drag & Drop)
     */
    public function edit(CertificateTemplate $certificateTemplate)
    {
        return view('admin.certificate_templates.edit', compact('certificateTemplate'));
    }

    /**
     * Menyimpan pembaruan koordinat dari halaman Edit
     */
    public function update(Request $request, CertificateTemplate $certificateTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificateTemplate $certificateTemplate)
    {
        try {
            // Hapus file fisik gambar dari storage
            if ($certificateTemplate->background_path && Storage::disk('public')->exists($certificateTemplate->background_path)) {
                Storage::disk('public')->delete($certificateTemplate->background_path);
            }

            $certificateTemplate->delete();

            return redirect()->route('admin.certificate-templates.index')
                ->with('success', 'Template sertifikat berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus template.');
        }
    }
}
