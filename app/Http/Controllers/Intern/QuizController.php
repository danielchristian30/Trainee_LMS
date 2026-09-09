<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Halaman Pengerjaan Kuis
     */
    public function show($id)
    {
        // Hapus .options karena opsi ada langsung di tabel questions
        $quiz = Quiz::with(['module', 'questions'])->findOrFail($id);
        $userId = Auth::id();

        $previousResult = QuizResult::where('user_id', $userId)
            ->where('quiz_id', $quiz->id)
            ->orderBy('score', 'desc')
            ->first();

        return view('intern.quizzes.show', compact('quiz', 'previousResult'));
    }

    /**
     * Proses Koreksi Jawaban Kuis & Hitung Nilai
     */
    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);

        $totalQuestions = $quiz->questions->count();
        if ($totalQuestions === 0) {
            return back()->with('error', 'Kuis ini belum memiliki soal.');
        }

        $correctCount = 0;

        // Hitung jawaban benar berdasarkan kunci di kolom correct_answer ('a', 'b', 'c', atau 'd')
        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;

            if ($userAnswer && strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer))) {
                $correctCount++;
            }
        }

        // Kalkulasi Skor (0 - 100)
        $score = round(($correctCount / $totalQuestions) * 100);
        $passingScore = $quiz->passing_score ?? 70;
        $isPassed = $score >= $passingScore;

        // Simpan Hasil Kuis ke Database (Disesuaikan nama kolomnya)
        $result = QuizResult::create([
            'user_id'        => Auth::id(),
            'quiz_id'        => $quiz->id,
            'score'          => $score,
            'total_correct'  => $correctCount,    // Menyimpan jumlah jawaban benar
            'total_question' => $totalQuestions,  // Menyimpan total soal
            'passed'         => $isPassed,
            'completed_at'   => now(),            // Mengisi Waktu Selesai Kuis
        ]);

        return redirect()->route('intern.quizzes.result', [
            'id'        => $quiz->id,
            'result_id' => $result->id
        ]);
    }

    /**
     * Halaman Hasil & Nilai Kuis
     */
    public function result($quizId, $resultId)
    {
        $quiz = Quiz::with('module')->findOrFail($quizId);
        $result = QuizResult::where('user_id', Auth::id())->findOrFail($resultId);

        $nextModule = null;
        if ($result->passed) {
            $nextModule = \App\Models\Module::where('is_published', true)
                ->where('order', '>', $quiz->module->order)
                ->orderBy('order', 'asc')
                ->first();
        }

        return view('intern.quizzes.result', compact('quiz', 'result', 'nextModule'));
    }
}