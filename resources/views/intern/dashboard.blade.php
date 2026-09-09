@extends('layouts.intern')

@section('title', 'Dashboard Intern')

@section('content')
<div class="space-y-8">

    <div class="relative overflow-hidden bg-navy-luxury rounded-2xl p-8 border border-gold-subtle shadow-xl text-white">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl">
            <span class="inline-block px-3 py-1 rounded-full bg-gold-accent/10 border border-gold-subtle text-gold-accent text-[10px] font-semibold tracking-widest uppercase mb-3">
                Welcome To Gold Standards
            </span>
            <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-amber-50 tracking-wide mb-2">
                Selamat Datang, {{ Auth::user()->name }}
            </h1>
            <p class="text-xs text-slate-300 leading-relaxed font-light">
                Mari tingkatkan keterampilan dan standar pelayanan terbaik bersama program pelatihan intern The Ritz-Carlton. Pelajari materi dan selesaikan kuis untuk menyelesaikan program.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">Modul Diselesaikan</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-2xl font-bold font-serif-luxury text-slate-900">{{ $completedModulesCount }}</span>
                    <span class="text-xs text-slate-400">/ {{ $totalModules }} Modul</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">Rata-Rata Nilai</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold font-serif-luxury text-slate-900">{{ $averageScore }}</span>
                    <span class="text-xs text-slate-400">%</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200/60 flex items-center justify-center text-emerald-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-1">Status Keaktifan</p>
                <span class="inline-block px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-wider">
                    Aktif Intern
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>

    </div>

    @if($currentModule)
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest block mb-1">
                    Lanjutkan Pembelajaran
                </span>
                <h3 class="font-serif-luxury text-lg font-bold text-slate-900">
                    Modul {{ $currentModule->order }}: {{ $currentModule->title }}
                </h3>
                <p class="text-xs text-slate-500 mt-1 max-w-xl line-clamp-2">
                    {{ $currentModule->description ?? 'Pelajari modul ini untuk memahami standar operasional dan kebijakan magang.' }}
                </p>
            </div>

            <a href="{{ route('intern.modules.show', $currentModule->id) }}" 
               class="px-6 py-3 bg-navy-luxury hover:bg-gold-accent text-white hover:text-slate-950 text-xs font-bold rounded-xl transition-all duration-200 whitespace-nowrap shadow-md text-center">
                Mulai Pelajari &rarr;
            </a>
        </div>
    </div>
    @endif

</div>
@endsection