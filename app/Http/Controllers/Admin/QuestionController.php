<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $quiz->load(['module', 'questions']);
        return view('admin.questions.index', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question'       => 'required|string',
            'option_a'       => 'required|string',
            'option_b'       => 'required|string',
            'option_c'       => 'required|string',
            'option_d'       => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        Question::create([
            'quiz_id'        => $quiz->id,
            'question'       => $request->input('question'),
            'option_a'       => $request->input('option_a'),
            'option_b'       => $request->input('option_b'),
            'option_c'       => $request->input('option_c'),
            'option_d'       => $request->input('option_d'),
            'correct_answer' => strtolower($request->input('correct_answer')),
        ]);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit(Question $question)
    {
        $question->load('quiz');
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question'       => 'required|string',
            'option_a'       => 'required|string',
            'option_b'       => 'required|string',
            'option_c'       => 'required|string',
            'option_d'       => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        $question->update([
            'question'       => $request->input('question'),
            'option_a'       => $request->input('option_a'),
            'option_b'       => $request->input('option_b'),
            'option_c'       => $request->input('option_c'),
            'option_d'       => $request->input('option_d'),
            'correct_answer' => strtolower($request->input('correct_answer')),
        ]);

        return redirect()->route('admin.quizzes.questions.index', $question->quiz_id)
            ->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }
}