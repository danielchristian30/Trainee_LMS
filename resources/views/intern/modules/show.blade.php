@extends('layouts.intern')

@section('title', 'Modul: ' . $module->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6 sm:space-y-8 pb-12" x-data="{ hasRead: false }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('intern.modules.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Modul
        </a>

        @if($module->pdf_file || $module->file_path)
            <a href="{{ route('intern.modules.download-pdf', $module->id) }}" 
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300/70 text-xs font-semibold rounded-xl transition w-full sm:w-auto">
                <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh Modul (PDF)
            </a>
        @endif
    </div>

    <div class="bg-navy-luxury p-6 sm:p-8 rounded-2xl border border-gold-subtle text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 space-y-2">
            <span class="px-3 py-1 rounded-full bg-gold-accent/10 border border-gold-subtle text-gold-accent text-[10px] font-semibold tracking-widest uppercase inline-block">
                MODUL {{ $module->order }}
            </span>
            <h1 class="font-serif-luxury text-xl sm:text-2xl md:text-3xl font-bold text-amber-50">
                {{ $module->title }}
            </h1>
            @if($module->description)
                <p class="text-xs text-slate-300 pt-2 border-t border-white/10 font-light leading-relaxed">
                    {{ $module->description }}
                </p>
            @endif
        </div>
    </div>

    @if($embedVideoUrl)
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Video Pembelajaran</span>
            </div>
            <div class="relative w-full rounded-xl overflow-hidden bg-slate-900 aspect-video shadow-md">
                <iframe class="absolute top-0 left-0 w-full h-full" 
                        src="{{ $embedVideoUrl }}" 
                        title="Video Pembelajaran {{ $module->title }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    @endif

    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
        <h2 class="font-serif-luxury text-base sm:text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">
            Materi Pembelajaran
        </h2>

        <div class="prose prose-slate max-w-none text-xs sm:text-sm text-slate-700 leading-relaxed space-y-4">
            {!! $module->content ?? $module->body ?? '<p class="text-slate-400 italic">Materi belum diisi.</p>' !!}
        </div>

        <div class="pt-6 border-t border-slate-200/80 bg-amber-50/50 -mx-6 sm:-mx-8 -mb-6 sm:-mb-8 p-6 sm:p-8 rounded-b-2xl">
            <label class="flex items-start gap-3 cursor-pointer select-none">
                <input type="checkbox" x-model="hasRead" class="mt-0.5 rounded border-amber-300 text-amber-600 focus:ring-amber-500 w-4 h-4 transition">
                <span class="text-xs text-slate-800 font-medium leading-tight">
                    Saya telah membaca, menonton, dan memahami seluruh isi materi pada modul ini dengan sungguh-sungguh.
                </span>
            </label>
        </div>
    </div>

    <div class="bg-gradient-to-r from-amber-500/10 via-amber-100/30 to-amber-500/10 border border-gold-subtle rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-serif-luxury text-base font-bold text-slate-900">Uji Pemahaman Materi</h3>
            <p class="text-xs text-slate-600 mt-1">Selesaikan kuis untuk membuka modul pembelajaran berikutnya.</p>
            
            @if($quizResult)
                <div class="mt-2 text-xs font-semibold {{ $quizResult->passed ? 'text-emerald-700' : 'text-rose-700' }}">
                    Status Kuis: {{ $quizResult->passed ? 'LULUS' : 'BELUM LULUS' }} (Nilai Terbaik: {{ $quizResult->score }})
                </div>
            @endif
        </div>

        @if($module->quiz)
            <div class="flex flex-col items-end gap-1">
                <a href="{{ route('intern.quizzes.show', $module->quiz->id) }}" 
                   :class="hasRead ? 'bg-navy-luxury hover:bg-gold-accent text-white hover:text-slate-950 pointer-events-auto shadow-md' : 'bg-slate-300 text-slate-500 cursor-not-allowed pointer-events-none opacity-70'"
                   class="px-6 py-3 text-xs font-bold rounded-xl transition duration-200 text-center whitespace-nowrap">
                    {{ $quizResult ? 'Ulangi Kuis Modul' : 'Mulai Kuis Modul' }} &rarr;
                </a>
                <span x-show="!hasRead" class="text-[10px] text-amber-800 italic">
                    *Centang konfirmasi membaca di atas untuk mengaktifkan kuis
                </span>
            </div>
        @else
            <span class="px-4 py-2.5 bg-slate-200 text-slate-500 text-xs rounded-xl font-medium text-center">
                Belum ada kuis untuk modul ini
            </span>
        @endif
    </div>

</div>
@endsection