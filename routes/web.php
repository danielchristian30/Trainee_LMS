<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Intern\DashboardController as InternDashboardController;
use App\Http\Controllers\Intern\ModuleController as InternModuleController;
use App\Http\Controllers\Intern\QuizController as InternQuizController;
use App\Http\Controllers\Admin\UserController;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// AUTHENTICATED ROUTES
Route::middleware(['auth'])->group(function () {

    // Main Redirector Berdasarkan Role
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('intern.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // GROUP ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        //CRUD User
        Route::resource('users', UserController::class);

        // CRUD Modul
        Route::resource('modules', ModuleController::class);
        
        // Kelola Soal Kuis
        Route::get('quizzes/{quiz}/questions', [QuestionController::class, 'index'])->name('quizzes.questions.index');
        Route::post('quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('quizzes.questions.store');
        Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    });
    
    // GROUP INTERN
    Route::middleware(['role:intern'])->prefix('intern')->name('intern.')->group(function () {
        Route::get('/dashboard', [InternDashboardController::class, 'index'])->name('dashboard');

        // Modul Pelatihan Intern
        Route::get('/modules', [InternModuleController::class, 'index'])->name('modules.index');
        Route::get('/modules/{id}', [InternModuleController::class, 'show'])->name('modules.show');
        Route::get('/modules/{id}/download-pdf', [InternModuleController::class, 'downloadPdf'])->name('modules.download-pdf');

        // Fitur Kuis Intern
        Route::get('/quizzes/{id}', [InternQuizController::class, 'show'])->name('quizzes.show');
        Route::post('/quizzes/{id}/submit', [InternQuizController::class, 'submit'])->name('quizzes.submit');
        Route::get('/quizzes/{id}/result/{result_id}', [InternQuizController::class, 'result'])->name('quizzes.result');

        Route::get('/grades', function () {
            return view('intern.dashboard');
        })->name('grades.index');   
    });
});

require __DIR__.'/auth.php';