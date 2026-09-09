<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelola Soal: <span class="text-amber-600">{{ $quiz->title }}</span>
            </h2>
            <a href="{{ route('admin.modules.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">&larr; Kembali ke Daftar Modul</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg text-xs font-bold space-y-1">
                    <p class="font-bold">Terjadi kesalahan input:</p>
                    <ul class="list-disc pl-5 font-normal">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-2">+ Tambah Soal Baru</h3>
                
                <form action="{{ route('admin.quizzes.questions.store', $quiz->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pertanyaan Soal</label>
                        <textarea name="question" rows="2" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500" placeholder="Tuliskan pertanyaan di sini...">{{ old('question') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan A</label>
                            <input type="text" name="option_a" value="{{ old('option_a') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan B</label>
                            <input type="text" name="option_b" value="{{ old('option_b') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan C</label>
                            <input type="text" name="option_c" value="{{ old('option_c') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan D</label>
                            <input type="text" name="option_d" value="{{ old('option_d') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kunci Jawaban Benar</label>
                        <select name="correct_answer" required class="w-full md:w-1/3 text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="a" {{ old('correct_answer') === 'a' ? 'selected' : '' }}>Opsi A</option>
                            <option value="b" {{ old('correct_answer') === 'b' ? 'selected' : '' }}>Opsi B</option>
                            <option value="c" {{ old('correct_answer') === 'c' ? 'selected' : '' }}>Opsi C</option>
                            <option value="d" {{ old('correct_answer') === 'd' ? 'selected' : '' }}>Opsi D</option>
                        </select>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-slate-800">+ Simpan Soal Baru</button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-100 pb-2">Daftar Soal Tersimpan ({{ $quiz->questions->count() }})</h3>

                <div class="space-y-4">
                    @forelse($quiz->questions as $index => $item)
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex justify-between items-start">
                            <div class="space-y-2">
                                <p class="text-sm font-bold text-gray-900">{{ $index + 1 }}. {{ $item->question }}</p>
                                <div class="grid grid-cols-2 gap-x-6 gap-y-1 text-xs text-gray-600">
                                    <p class="{{ $item->correct_answer === 'a' ? 'font-bold text-green-600' : '' }}">A. {{ $item->option_a }}</p>
                                    <p class="{{ $item->correct_answer === 'b' ? 'font-bold text-green-600' : '' }}">B. {{ $item->option_b }}</p>
                                    <p class="{{ $item->correct_answer === 'c' ? 'font-bold text-green-600' : '' }}">C. {{ $item->option_c }}</p>
                                    <p class="{{ $item->correct_answer === 'd' ? 'font-bold text-green-600' : '' }}">D. {{ $item->option_d }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.questions.edit', $item->id) }}" class="text-xs text-amber-600 hover:underline font-bold">Edit</a>
                                <form action="{{ route('admin.questions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:underline font-bold">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada soal untuk kuis ini.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>