@extends('layouts.intern')

@section('title', 'Hasil Kuis: ' . $quiz->title)

@section('content')
<div class="max-w-2xl mx-auto space-y-6 pb-12">

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-lg overflow-hidden text-center p-8 sm:p-10 space-y-6">
        
        <div class="inline-flex items-center justify-center p-4 rounded-full {{ $result->passed ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
            @if($result->passed)
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @else
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
        </div>

        <div>
            <span class="text-[10px] font-bold tracking-widest uppercase text-slate-400 block mb-1">
                HASIL EVALUASI KUIS
            </span>
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-slate-900">
                {{ $result->passed ? 'Selamat, Anda LULUS!' : 'Belum Mencapai KKM' }}
            </h1>
            <p class="text-xs text-slate-500 mt-2 max-w-md mx-auto">
                {{ $result->passed 
                    ? 'Anda telah berhasil menguasai materi pada modul ini dan modul berikutnya telah terbuka.' 
                    : 'Silakan pelajari kembali materi pada modul ini lalu ulangi pengerjaan kuis.' }}
            </p>
        </div>

        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-6 grid grid-cols-2 gap-4 max-w-sm mx-auto">
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Nilai Anda</span>
                <span class="font-serif-luxury text-3xl font-bold {{ $result->passed ? 'text-emerald-600' : 'text-rose-600' }}">
                    {{ $result->score }}
                </span>
            </div>
            <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase block">Jawaban Benar</span>
                <span class="font-serif-luxury text-3xl font-bold text-slate-800">
                    {{ $result->correct_answers }}/{{ $result->total_questions }}
                </span>
            </div>
        </div>

        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('intern.modules.show', $quiz->module_id) }}" 
               class="w-full sm:w-auto px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                &larr; Baca Ulang Modul
            </a>

            @if(!$result->passed)
                <a href="{{ route('intern.quizzes.show', $quiz->id) }}" 
                   class="w-full sm:w-auto px-6 py-3 bg-navy-luxury hover:bg-gold-accent text-white hover:text-slate-950 text-xs font-bold rounded-xl transition shadow-md">
                    Ulangi Kuis
                </a>
            @elseif($nextModule)
                <a href="{{ route('intern.modules.show', $nextModule->id) }}" 
                   class="w-full sm:w-auto px-6 py-3 bg-gold-accent hover:bg-amber-400 text-slate-950 font-bold text-xs rounded-xl transition shadow-md">
                    Lanjut ke Modul {{ $nextModule->order }} &rarr;
                </a>
            @else
                <a href="{{ route('intern.modules.index') }}" 
                   class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-md">
                    Semua Modul Selesai &rarr;
                </a>
            @endif
        </div>

    </div>

</div>
@endsection