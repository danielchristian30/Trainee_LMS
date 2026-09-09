<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Helper Logika Menentukan Modul mana saja yang Terbuka (Unlocked)
     */
    private function getModuleAccessData($userId)
    {
        $modules = Module::where('is_published', true)
            ->orderBy('order', 'asc')
            ->get();

        // Ambil ID modul yang kuisnya sudah LULUS oleh user ini
        $passedModuleIds = QuizResult::where('user_id', $userId)
            ->where('passed', true)
            ->with('quiz')
            ->get()
            ->pluck('quiz.module_id')
            ->filter()
            ->unique()
            ->toArray();

        $unlockedModuleIds = [];
        $canUnlockNext = true; // Modul pertama selalu terbuka

        foreach ($modules as $module) {
            if ($canUnlockNext) {
                $unlockedModuleIds[] = $module->id;
            }

            // Jika modul ini sudah lulus, maka modul BERIKUTNYA terbuka
            if (in_array($module->id, $passedModuleIds)) {
                $canUnlockNext = true;
            } else {
                $canUnlockNext = false; // Hentikan pembukaan modul setelah modul pertama yang belum lulus
            }
        }

        return [$modules, $unlockedModuleIds, $passedModuleIds];
    }

    /**
     * Halaman Daftar Modul
     */
    public function index()
    {
        $userId = Auth::id();
        [$modules, $unlockedModuleIds, $passedModuleIds] = $this->getModuleAccessData($userId);

        return view('intern.modules.index', compact('modules', 'unlockedModuleIds', 'passedModuleIds'));
    }

    /**
     * Halaman Detail Baca Materi Modul
     */
    public function show($id)
    {
        $userId = Auth::id();
        [$modules, $unlockedModuleIds, $passedModuleIds] = $this->getModuleAccessData($userId);

        // Cek Apakah Modul Terkunci
        if (!in_array($id, $unlockedModuleIds)) {
            return redirect()->route('intern.modules.index')
                ->with('error', 'Akses ditolak! Anda harus menyelesaikan dan lulus kuis pada modul sebelumnya terlebih dahulu.');
        }

        $module = Module::where('is_published', true)->findOrFail($id);
        
        // Cek status pengerjaan kuis modul ini
        $quizResult = null;
        if ($module->quiz) {
            $quizResult = QuizResult::where('user_id', $userId)
                ->where('quiz_id', $module->quiz->id)
                ->orderBy('score', 'desc')
                ->first();
        }

        $embedVideoUrl = $this->formatYoutubeEmbedUrl($module->video_url ?? null);

        return view('intern.modules.show', compact('module', 'quizResult', 'embedVideoUrl'));
    }

    /**
     * Download PDF Modul
     */
    public function downloadPdf($id)
    {
        $userId = Auth::id();
        [,$unlockedModuleIds,] = $this->getModuleAccessData($userId);

        if (!in_array($id, $unlockedModuleIds)) {
            return back()->with('error', 'Anda tidak memiliki akses mengunduh modul yang masih terkunci.');
        }

        $module = Module::findOrFail($id);
        $pdfPath = $module->pdf_file ?? $module->file_path ?? null;

        if ($pdfPath && Storage::disk('public')->exists($pdfPath)) {
            $fullPath = Storage::disk('public')->path($pdfPath);
            return response()->download($fullPath, $module->title . '.pdf');
        }

        return back()->with('error', 'Berkas PDF untuk modul ini tidak ditemukan.');
    }

    private function formatYoutubeEmbedUrl($url)
    {
        if (!$url) return null;

        if (str_contains($url, 'youtu.be/')) {
            $videoId = explode('youtu.be/', $url)[1];
            $videoId = explode('?', $videoId)[0];
            return "https://www.youtube.com/embed/" . $videoId;
        }

        if (str_contains($url, 'watch?v=')) {
            $videoId = explode('watch?v=', $url)[1];
            $videoId = explode('&', $videoId)[0];
            return "https://www.youtube.com/embed/" . $videoId;
        }

        return $url;
    }
}