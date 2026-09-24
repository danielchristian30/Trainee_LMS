<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Modul Pelatihan') }}
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
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                
                <form action="{{ route('admin.modules.update', $module->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Judul Modul</label>
                        <input type="text" name="title" required value="{{ old('title', $module->title) }}" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('title')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Urutan Modul (Order)</label>
                            <input type="number" name="order" required value="{{ old('order', $module->order) }}" min="1" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('order')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Passing Score Kuis (%)</label>
                            <input type="number" name="passing_score" required value="{{ old('passing_score', $module->quizzes->first()->passing_score ?? 80) }}" min="0" max="100" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            @error('passing_score')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $module->description) }}</textarea>
                        @error('description')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Isi Materi Lengkap (Content)</label>
                        <textarea name="content" id="content" rows="10" placeholder="Tuliskan materi bacaan lengkap untuk intern di sini..." class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('content', $module->content) }}</textarea>
                        <span class="text-xs text-gray-500">Materi ini yang akan dibaca oleh peserta intern.</span>
                        @error('content')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ganti Berkas PDF Modul (Maks. 10 MB)</label>
                            <input type="file" name="file_path" accept=".pdf,application/pdf" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            @if($module->file_path)
                                <p class="text-[10px] text-green-700 mt-1 font-bold">Berkas tersimpan: {{ basename($module->file_path) }}</p>
                            @endif
                            @error('file_path')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ganti Thumbnail (Maks. 2 MB)</label>
                            <input type="file" name="thumbnail" accept="image/png, image/jpeg, image/jpg, image/webp" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            @error('thumbnail')
                                <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Link Video Pembelajaran (Youtube URL)</label>
                        <input type="url" name="video_url" value="{{ old('video_url', $module->video_url) }}" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('video_url')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_published" id="is_published" value="1" class="rounded border-gray-300 text-amber-600 focus:ring-amber-500" {{ $module->is_published ? 'checked' : '' }}>
                        <label for="is_published" class="text-xs font-bold text-gray-700">Publikasikan Modul Ini</label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.modules.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-slate-950 text-white font-semibold text-xs rounded-xl hover:bg-amber-500 hover:text-slate-950 transition-all">Perbarui Modul</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>