<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizResult;
use App\Models\Module; // <--- 1. Tambahkan Import Model Module ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan data statistik ke seluruh view Blade
        View::composer('*', function ($view) {
            // Hitung total seluruh modul yang ada di database
            $totalModules = Module::count();

            if (Auth::check()) {
                $completedModulesCount = QuizResult::where('user_id', Auth::id())
                    ->where('passed', true)
                    ->distinct('quiz_id')
                    ->count('quiz_id');
            } else {
                $completedModulesCount = 0;
            }

            // Kirim kedua variabel ke view
            $view->with([
                'completedModulesCount' => $completedModulesCount,
                'totalModules'          => $totalModules,
            ]);
        });
    }
}