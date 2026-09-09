<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Total modul yang dipublikasikan
        $totalModules = Module::where('is_published', true)->count();
        
        // Ambil hasil kuis milik intern dari model QuizResult
        $userResults = QuizResult::where('user_id', $userId)->get();
        
        // Filter ID modul yang sudah LULUS (menggunakan atribut 'passed')
        $passedModuleIds = $userResults->where('passed', true)
            ->map(fn($result) => $result->quiz->module_id ?? null)
            ->filter()
            ->unique();

        $completedModulesCount = $passedModuleIds->count();
        $averageScore = $userResults->count() > 0 ? round($userResults->avg('score')) : 0;

        // Ambil modul berikutnya yang belum diselesaikan
        $currentModule = Module::where('is_published', true)
            ->when($passedModuleIds->isNotEmpty(), function ($query) use ($passedModuleIds) {
                return $query->whereNotIn('id', $passedModuleIds);
            })
            ->orderBy('order', 'asc')
            ->first();

        return view('intern.dashboard', compact(
            'totalModules',
            'completedModulesCount',
            'averageScore',
            'currentModule'
        ));
    }
}