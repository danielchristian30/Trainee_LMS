<x-app-layout>
    <x-slot name="header">Buat Modul Baru</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
        <form method="POST" action="{{ route('admin.modules.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Judul Modul</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-amber-500 focus:border-amber-500">
                @error('title')
                    <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Urutan Modul (Order)</label>
                    <input type="number" name="order" value="{{ old('order', $nextOrder) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-amber-500 focus:border-amber-500">
                    @error('order')
                        <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Passing Score Kuis (%)</label>
                    <input type="number" name="passing_score" value="{{ old('passing_score', 80) }}" min="0" max="100" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-amber-500 focus:border-amber-500">
                    @error('passing_score')
                        <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Deskripsi Modul</label>
                <textarea name="description" rows="4" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-amber-500 focus:border-amber-500">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Isi Materi Lengkap (Content)</label>
                <textarea name="content" id="content" rows="10" placeholder="Tuliskan materi bacaan lengkap untuk intern di sini..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-amber-500 focus:border-amber-500">{{ old('content') }}</textarea>
                <span class="text-[10px] text-slate-500">Materi ini yang akan dibaca oleh peserta intern.</span>
                @error('content')
                    <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Berkas PDF Modul (Maks. 10 MB)</label>
                    <input type="file" name="file_path" accept=".pdf,application/pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-amber-500 hover:file:text-slate-950">
                    @error('file_path')
                        <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Thumbnail Gambar (Maks. 2 MB)</label>
                    <input type="file" name="thumbnail" accept="image/png, image/jpeg, image/jpg, image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-amber-500 hover:file:text-slate-950">
                    @error('thumbnail')
                        <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Link Video Pembelajaran (Youtube URL)</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-1 focus:ring-amber-500 focus:border-amber-500">
                @error('video_url')
                    <span class="text-[11px] text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="pub" value="1" checked class="rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                <label for="pub" class="text-xs text-slate-700 font-medium">Publikasikan Modul Ini Segera</label>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <a href="{{ route('admin.modules.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-xl hover:bg-slate-200">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-slate-950 text-white font-semibold text-xs rounded-xl hover:bg-amber-500 hover:text-slate-950 transition-all">Simpan Modul & Kuis</button>
            </div>
        </form>
    </div>
</x-app-layout>