<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>The Ritz Carlton - Intern Academy</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfbf9; }
        .font-serif-luxury { font-family: 'Playfair Display', serif; }
        .bg-navy-luxury { background-color: #0b1321; }
        .border-gold-subtle { border-color: rgba(197, 160, 89, 0.25); }
        .text-gold-accent { color: #c5a059; }
        .bg-gold-accent { background-color: #c5a059; }
    </style>
</head>
<body class="antialiased text-slate-800">

    <div class="min-h-screen flex">
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-40 md:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="w-64 bg-navy-luxury text-slate-300 flex flex-col fixed inset-y-0 z-50 border-r border-gold-subtle shadow-2xl transition-transform duration-300 ease-in-out">
            
            <button @click="sidebarOpen = false" class="md:hidden absolute top-4 right-4 text-slate-400 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="px-6 py-8 border-b border-gold-subtle text-center">
                <!-- <div class="inline-block p-2 rounded-full border border-gold-subtle mb-3 bg-white/5">
                    <svg class="w-6 h-6 text-gold-accent mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2l2.4 7.4H22l-6 4.5 2.3 7.1L12 16.6l-6.3 4.4 2.3-7.1-6-4.5h7.6z"/></svg>
                </div> -->
                <h1 class="font-serif-luxury text-lg font-bold tracking-widest text-amber-100 uppercase">Ritz-Carlton</h1>
                <p class="text-[10px] tracking-widest uppercase text-gold-accent font-medium mt-0.5">Internship Academy</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <a href="{{ route('intern.dashboard') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-xs font-semibold tracking-wider transition-all duration-200 {{ request()->routeIs('intern.dashboard') ? 'bg-gold-accent text-slate-950 font-bold shadow-lg shadow-amber-500/10' : 'text-slate-400 hover:text-amber-100 hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    DASHBOARD
                </a>

                @php
                    $sidebarUserId = Auth::id();
                    $sidebarModules = \App\Models\Module::where('is_published', true)->orderBy('order', 'asc')->get();
                    $sidebarPassedIds = \App\Models\QuizResult::where('user_id', $sidebarUserId)->where('passed', true)->with('quiz')->get()->pluck('quiz.module_id')->filter()->toArray();
                    
                    // Unlocked logic
                    $sidebarUnlockedIds = [];
                    $canUnlock = true;
                    foreach($sidebarModules as $m) {
                        if ($canUnlock) { $sidebarUnlockedIds[] = $m->id; }
                        $canUnlock = in_array($m->id, $sidebarPassedIds);
                    }
                @endphp

                <div x-data="{ open: {{ request()->routeIs('intern.modules.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" 
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-xs font-semibold tracking-wider transition-all duration-200 {{ request()->routeIs('intern.modules.*') ? 'bg-white/10 text-amber-100' : 'text-slate-400 hover:text-amber-100 hover:bg-white/5' }}">
                        <div class="flex items-center gap-3.5">
                            <svg class="w-4 h-4 text-gold-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            MODUL PELATIHAN
                        </div>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="open" x-cloak x-collapse class="pl-4 pr-1 py-1 space-y-1 border-l-2 border-gold-subtle/40 ml-5">
                        <a href="{{ route('intern.modules.index') }}" 
                           class="block px-3 py-1.5 text-[11px] font-medium rounded-lg text-amber-200/70 hover:text-amber-100 hover:bg-white/5 transition">
                            &rarr; Semua Modul
                        </a>

                        @foreach($sidebarModules as $sModule)
                            @php
                                $isUnlocked = in_array($sModule->id, $sidebarUnlockedIds);
                                $isPassed = in_array($sModule->id, $sidebarPassedIds);
                                $isActive = request()->is('intern/modules/' . $sModule->id);
                            @endphp

                            @if($isUnlocked)
                                <a href="{{ route('intern.modules.show', $sModule->id) }}" 
                                   class="flex items-center justify-between px-3 py-2 text-[11px] font-medium rounded-lg transition {{ $isActive ? 'bg-gold-accent text-slate-950 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                    <span class="truncate">Modul {{ $sModule->order }}: {{ $sModule->title }}</span>
                                    @if($isPassed)
                                        <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </a>
                            @else
                                <div class="flex items-center justify-between px-3 py-2 text-[11px] font-medium rounded-lg text-slate-500 cursor-not-allowed opacity-60">
                                    <span class="truncate">Modul {{ $sModule->order }}: {{ $sModule->title }}</span>
                                    <svg class="w-3.5 h-3.5 text-slate-500 flex-shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('intern.grades.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-xs font-semibold tracking-wider transition-all duration-200 {{ request()->routeIs('intern.grades.*') ? 'bg-gold-accent text-slate-950 font-bold shadow-lg shadow-amber-500/10' : 'text-slate-400 hover:text-amber-100 hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    RIWAYAT & NILAI
                </a>
            </nav>

            <div class="p-4 border-t border-gold-subtle bg-black/20">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-gold-accent text-slate-950 font-bold flex items-center justify-center text-xs shadow-md">
                        {{ strtoupper(substr(Auth::user()->name ?? 'I', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-semibold text-slate-100 truncate">{{ Auth::user()->name ?? 'Intern' }}</p>
                        <p class="text-[10px] text-gold-accent truncate">Peserta Magang</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 text-xs font-semibold text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col min-h-screen w-full transition-all duration-300">
            <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 px-4 sm:px-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 md:hidden focus:outline-none border border-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="font-medium text-slate-400 hidden sm:inline">Portal Intern</span>
                        <span class="hidden sm:inline">/</span>
                        <span class="font-semibold text-slate-800">@yield('title', 'Dashboard')</span>
                    </div>
                </div>
                <div class="text-[10px] sm:text-xs font-serif-luxury tracking-wider text-slate-500 italic truncate">
                    "We Are Ladies and Gentlemen Serving Ladies and Gentlemen"
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 md:p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl flex items-center gap-3">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl flex items-center gap-3">
                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="py-4 px-4 sm:px-8 border-t border-slate-200/60 text-center text-[11px] text-slate-400">
                &copy; {{ date('Y') }} The Ritz-Carlton Academy. All rights reserved.
            </footer>
        </div>
    </div>

</body>
</html>