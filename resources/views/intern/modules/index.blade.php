@extends('layouts.intern')

@section('title', 'Daftar Modul Pelatihan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest block mb-1">
                Learning Curriculum
            </span>
            <h1 class="font-serif-luxury text-2xl font-bold text-slate-900">Modul Pelatihan Ritz-Carlton</h1>
            <p class="text-xs text-slate-500 mt-1">Selesaikan kuis di setiap modul secara berurutan untuk membuka modul berikutnya.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($modules as $module)
            @php
                $isUnlocked = in_array($module->id, $unlockedModuleIds ?? []);
                $isPassed = in_array($module->id, $passedModuleIds ?? []);
            @endphp

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col relative transition duration-300 {{ $isUnlocked ? 'hover:border-amber-400/50' : 'opacity-75 grayscale-[30%]' }}">
                
                <div class="h-36 bg-navy-luxury relative p-5 flex flex-col justify-between overflow-hidden">
                    <div class="flex items-center justify-between relative z-10">
                        <span class="px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-gold-subtle text-amber-200 text-[10px] font-semibold tracking-wider">
                            MODUL {{ $module->order }}
                        </span>

                        @if($isPassed)
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                LULUS
                            </span>
                        @elseif(!$isUnlocked)
                            <span class="px-2.5 py-1 rounded-full bg-slate-800 text-slate-400 border border-slate-700 text-[10px] font-bold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                TERKUNCI
                            </span>
                        @endif
                    </div>

                    <h2 class="font-serif-luxury text-base font-bold text-amber-50 line-clamp-2 relative z-10">
                        {{ $module->title }}
                    </h2>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                        {{ $module->description ?? 'Tidak ada deskripsi modul.' }}
                    </p>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-[11px] text-slate-400">
                            @if($module->pdf_file || $module->file_path)
                                <span class="flex items-center gap-1 text-slate-600 font-medium">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    PDF
                                </span>
                            @endif
                        </div>

                        @if($isUnlocked)
                            <a href="{{ route('intern.modules.show', $module->id) }}" 
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-navy-luxury hover:bg-gold-accent text-white hover:text-slate-950 text-xs font-semibold rounded-xl transition duration-200">
                                Buka Modul &rarr;
                            </a>
                        @else
                            <button disabled class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-200 text-slate-400 text-xs font-semibold rounded-xl cursor-not-allowed">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Terkunci
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                <p class="text-sm font-semibold text-slate-600">Belum Ada Modul Dipublikasikan</p>
            </div>
        @endforelse
    </div>

</div>
@endsection