<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizResult;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik ringkas
        $totalInterns = User::where('role', 'intern')->count();
        $totalModules = Module::count();
        $totalQuizzes = Quiz::count();

        // Ambil aktivitas pengerjaan kuis terbaru
        $recentResults = QuizResult::with(['user', 'quiz'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalInterns', 'totalModules', 'totalQuizzes', 'recentResults'));
    }
}