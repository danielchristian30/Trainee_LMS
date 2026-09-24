<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Soal Kuis : <span class="text-amber-600">{{ $question->quiz->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.modules.index') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg text-xs transition">
                    kembali ke Daftar Modul
                 </a>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-2">Perbarui Soal</h3>

                <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pertanyaan Soal</label>
                        <textarea name="question" rows="3" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('question', $question->question) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan A</label>
                            <input type="text" name="option_a" value="{{ old('option_a', $question->option_a) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan B</label>
                            <input type="text" name="option_b" value="{{ old('option_b', $question->option_b) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan C</label>
                            <input type="text" name="option_c" value="{{ old('option_c', $question->option_c) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan D</label>
                            <input type="text" name="option_d" value="{{ old('option_d', $question->option_d) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kunci Jawaban Benar</label>
                        <select name="correct_answer" required class="w-full md:w-1/3 text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="a" {{ old('correct_answer', $question->correct_answer) === 'a' ? 'selected' : '' }}>Opsi A</option>
                            <option value="b" {{ old('correct_answer', $question->correct_answer) === 'b' ? 'selected' : '' }}>Opsi B</option>
                            <option value="c" {{ old('correct_answer', $question->correct_answer) === 'c' ? 'selected' : '' }}>Opsi C</option>
                            <option value="d" {{ old('correct_answer', $question->correct_answer) === 'd' ? 'selected' : '' }}>Opsi D</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('admin.quizzes.questions.index', $question->quiz_id) }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>